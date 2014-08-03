<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User: ed8
 * Date: 7/27/14
 */

class Action extends CI_Controller {

	public function index()
	{
		$this->load->view('home');
	}

	/**
	 * Start
	 * @return array [description]
	 * @param string _ action to request on the service (start|stop|restart|…)
	 */
	public function invoke($_, $config = null)
	{
        var_dump($_, $config);
	// @todo: sanitize command's arguments!!
        if (array_key_exists($_, $this->config->item('SERVICE_ACTIONS'))) {
            return $this->shell->run(MAST_SERVICE." $_ $config");
        }
        elseif (array_key_exists($_, $this->config->item('SERVICE_HELPERS'))) {
            return $this->shell->run(MAST_UTILS." $_ NAME=$config");
        } else {
            show_error('Invalid action'.basename(__FILE__), 500);
        }
	}
}

	/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */