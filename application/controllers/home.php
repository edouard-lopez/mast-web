<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home extends CI_Controller {

	private $configs;

    function __construct() {
        parent::__construct();
        $this->load->helper('download');
		$this->configs = $this->buildConfigs();
    }

   	public function index()
	{
		$this->load->view('home', array('configs' => $this->configs));
	}

	private function buildConfigs()
	{
	    $list = $this->shell->execute("/usr/sbin/mast-utils list-hosts");
	    var_export($list);
	    foreach ($list as $key => $tunnel){
            preg_match(
	            '/^(.*\w)[\s\t]+('.REGEX_IP_ADRESS.'|[\w]+)(\:([0-9]{1,5}))?/',
	            trim(strip_tags($tunnel)),
	            $tunnelConfig
            );
            $channels = $this->shell->list_channels($tunnelConfig[1]);
            var_export($channels );
            $channelsConfigs=array();

            foreach ($channels as $key => $config){
                $channel = array(
                    'cid' => null,
                    'localHost' => null,
                    'localPort' => null,
                    'remoteHost' => null,
                    'remotePort' => null,
                    'comment' => null,
                );

                preg_match(
	                '/^(?P<localHost>.*):(?P<localPort>[0-9]{1,5}):'
                    .'(?P<remoteHost>.*):(?P<remotePort>[0-9]{1,5})'
                    .'[\s]+(?P<cid>\d+)'
                    .'([\s]+#(?P<comment>.*))?$/',
	                trim(strip_tags($config)),
	                $channel
                );
                // var_export($channel );
                // var_export($channelsConfigs );
                $channelsConfigs[$channel['cid']] = array(
                    'localHost' => $channel['localHost'],
	                'localPort' => $channel['localPort'], # listening port
	                'remoteHost' => $channel['remoteHost'],
	                'remotePort' => $channel['remotePort'],
                    'comment' => $channel['comment']
                );
            }

            $configs[$tunnelConfig[1]] = array(
	            // "nameSite" => $ConfSite[1];
	            'remoteHost' => $tunnelConfig[2],
	            'remotePort' => count($tunnelConfig)>=6?$tunnelConfig[6]:22,
	            'channels' => $channelsConfigs
	        );
	    }
	    // echo "<pre>";
	    // var_export($configs);
	    return $configs;
	}

	public function getConfig () {
		@ob_end_clean();
		header_remove();
		force_download('data.json', json_encode($this->configs));
	}

	public function getPS1 ($confNode) {
	$confNode=json_decode(urldecode ($confNode), true);

$install_code = "# Powershell V4+ Windows 2012R2
# Creaton du port
Add-PrinterPort -Name \"GZ_%vps%_%port%\" -PrinterHostAddress \"%vps%\" -PortNumber %port%
# Creaton du port de secour en direct
Add-PrinterPort -Name \"DIRECT_%imp%_%port%\" -PrinterHostAddress \"%imp%\"
# Install du driver
if (Get-PrinterDriver -Name \"MS Publisher Color Printer\") {
    Write-Host \"Pilote Generique deja present\"
} else {
    Write-Host \"Installation du pilote generique : MS Publisher Color Printer\"
    Add-PrinterDriver \"MS Publisher Color Printer\"
}
# Creation de l’objet imprimante
Add-Printer -name \"%name%\" -PortName \"GZ_%vps%_%port%\" -Location \"%site%\" -Comment \"GZ par tunnel SSH (%UTC%)\"  -DriverName \"MS Publisher Color Printer\"
";
		$search=array('%vps%','%imp%','%port%','%site%','%name%','%UTC%');
		$replace=array($confNode['vps'], $confNode['imp'], $confNode['port'], $confNode['site'], $confNode['channelComment'], date("Y-m-d H:i:s")) ;
		@ob_end_clean();
		header_remove();
		force_download($confNode['channelComment'].' ('.$confNode['imp'].'-'.$confNode['port'].').ps1', str_replace($search, $replace, $install_code));
	}


	public function getBAT ($confNode) {
	$confNode=json_decode(urldecode ($confNode), true);

$install_code = "# DOS – Batch XP+
# Creaton du port GZ
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\prnport.vbs -a -o raw -h %vps% -r \"GZ_%vps%_%port%\" -n %port%
# Creaton du port de secour en direct
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\prnport.vbs -a -o raw -h %imp% -r \"DIRECT_%imp%_%port%\"
# Install du driver
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\Prndrvr.vbs -a -m \"MS Publisher Color Printer\"
# Creation de l’objet imprimante
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\Prnmngr.vbs -a -p \"%name%\" -r \"GZ_%vps%_%port%\" -m \"MS Publisher Color Printer\"
# ajout des infos : emplacement et commentaire
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\Prncnfg.vbs -t -p \"%name%\" -l \"%site%\" -m \"GZ par tunnel SSH (%UTC%)`n%imp% par le canal %port%\"
";
		$search=array('%vps%','%imp%','%port%','%site%','%name%','%UTC%');
		$replace=array($confNode['vps'], $confNode['imp'], $confNode['port'], $confNode['site'], $confNode['channelComment'], date("Y-m-d H:i:s")) ;
		@ob_end_clean();
		header_remove();
		force_download($confNode['channelComment'].' ('.$confNode['imp'].'-'.$confNode['port'].').bat', str_replace($search, $replace, $install_code));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */