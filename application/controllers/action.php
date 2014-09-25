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

    /**
     * Start
     * @return array [description]
     * @param string _ action to request on the service (start|stop|restart|…)
     */
    // @todo: sanitize command's arguments!!
    public function invoke($_, $args = null)
    {
        $args = $this->prepare($args);

        if ($this->is_valid($_, 'SERVICE_ACTIONS')) {
            $cmd = sprintf('%s %s %s', MAST_SERVICE, $_, $args);
        } elseif ($this->is_valid($_, 'SERVICE_HELPERS') or $this->is_valid($_, 'SERVICE_CH_HELPERS')) {
            $cmd = sprintf('%s %s %s', MAST_UTILS, $_, $args);
        } else {
            show_error(sprintf('<strong>Invalid action:</strong> <em>%s</em> in %s.', $_, basename(__FILE__)), 500);
            exit;
        }
        return $this->shell->run($cmd);
    }

    /**
     * @param $args
     * @return string
     */
    public function prepare($args)
    {
        $args = '';
        if (!empty($_POST)) {
            foreach ($_POST as $arg => $value) {
                $args .= sprintf('%s=%s ', $arg, escapeshellarg($value));
            }
        }

        return $args;
    }

    /**
     * Check if an action is valid or not, i.e. belong to one of SERVICE_* config
     * @param $_            requested action
     * @param $check_in     whitelist used
     * @return bool
     */
    public function is_valid($_, $check_in)
    {
        return array_key_exists($_, $this->config->item($check_in));
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
