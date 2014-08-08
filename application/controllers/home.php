<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home extends CI_Controller {

	private $obj;

    function __construct() {
        parent::__construct();
        $this->load->helper('download');
		$this->obj = $this->buildConfObj();
    }

   	public function index()
	{
		$this->load->view('home', array('obj'=>$this->obj));
	}
	
	private function buildConfObj()
	{
	    $list = $this->shell->execute("/usr/sbin/mast-utils list-hosts");
	    foreach ($list as $key => $tunnel){
	        preg_match(
	            '/^(.*\w)[\s\t]+(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3})(\:([0-9]{1,5}))?/',
	            trim(strip_tags($tunnel)),
	            $ConfSite);
	        $channels = $this->shell->list_channels($ConfSite[1]);
	        $ChannelsSite=array();
	        foreach ($channels as $key => $channel){
	            preg_match(
	                '/^(.*):([0-9]{1,5}):(.*):([0-9]{1,5})$/',
	                trim(strip_tags($channel)),
	                $ChannelSite);
	            $ChannelsSite[]=array(
	                'listenPort'=>$ChannelSite[2],
	                'remoteHost'=>$ChannelSite[3],
	                'remotePort'=>$ChannelSite[4]
	                );
	        }

	        $obj[$ConfSite[1]] = array(
	            // "nameSite" => $ConfSite[1];
	            'remoteHost' => $ConfSite[2],
	            'remotePort' => count($ConfSite)>=6?$ConfSite[6]:22,
	            'channels' => $ChannelsSite
	        );
	    }
	    // echo "<pre>";
	    // var_export($obj);
	    return $obj;
	}
	
	public function getConfig () {
		@ob_end_clean();
		header_remove();
		force_download('data.json', json_encode($this->obj));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */