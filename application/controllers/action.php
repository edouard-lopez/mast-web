<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: ed8
 * Date: 7/27/14
 */
class Action extends CI_Controller
{

    /**
     *
     */
    public function index()
    {
        $this->load->view('home');
    }

	public function invoke($_, $config = null)
    /**
     * Start
     * @return array [description]
     * @param string _ action to request on the service (start|stop|restart|…)
     */
    // @todo: sanitize command's arguments!!
        if (array_key_exists($_, $this->config->item('SERVICE_ACTIONS'))) {
            return $this->shell->run(MAST_SERVICE." $_ $config");
        }
        elseif (array_key_exists($_, $this->config->item('SERVICE_HELPERS'))) {
            $config= ! is_null($config) ? "NAME=$config" : '' ;
            return $this->shell->run(sprintf("%s %s %s", MAST_UTILS, $_, $config));
        }
        elseif (array_key_exists($_, $this->config->item('SERVICE_CH_HELPERS'))) {
            $config= ! is_null($config) ? "NAME=$config" : '' ;
            return $this->shell->run(sprintf("%s %s %s", MAST_UTILS, $_, $config));
        } else {
            show_error(sprintf('<strong>Invalid action:</strong> <em>%s</em> in %s.', $_, basename(__FILE__)), 500);
        }
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
