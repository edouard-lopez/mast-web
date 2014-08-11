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
	    foreach ($list as $key => $tunnel){
            preg_match(
	            '/^(.*\w)[\s\t]+(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3})(\:([0-9]{1,5}))?/',
	            trim(strip_tags($tunnel)),
	            $tunnelConfig
            );
            $channels = $this->shell->list_channels($tunnelConfig[1]);
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */