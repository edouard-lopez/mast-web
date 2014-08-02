<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User: ed8
 * Date: 7/27/14
 */

class Service extends CI_Controller {

	public function index()
	{
		$this->load->view('home');
	}

	/**
	 * Start
	 * @return array [description]
	 * @param string _ action to request on the service (start|stop|restart|…)
	 */
	public function action($_, $config = null)
	{
	// @todo: sanitize command's arguments!!
        if (array_key_exists($_, $this->config->item('SERVICE_ACTIONS'))) {
            return $this->shell->run("/etc/init.d/mast $_ $config");
        } else {
            show_error('Invalid action'.basename(__FILE__), 500);
        }
	}
}

	/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */