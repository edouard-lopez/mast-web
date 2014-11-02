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
     * @param string $_ action to request on the service (start|stop|restart|…) or on mast-utils (list-host|add-channel|…)
     * @param strin $args is arguments for service or mast-utils
     */
    public function invoke($_, $args = null, $redirect=true)
    {
        $this->load->helper('url');

        if ($this->is_valid($_, 'SERVICE_ACTIONS')) {
            $args = $this->prepare_service($args);
            $cmd = sprintf('sudo %s %s %s;', MAST_SERVICE, $_, $args);
        } elseif ($this->is_valid($_, 'SERVICE_HELPERS') or $this->is_valid($_, 'SERVICE_CH_HELPERS')) {
            $args = $this->prepare_makefile($args);
            $cmd = sprintf('sudo %s %s %s;', MAST_UTILS, $_, $args);
        } else {
            show_error(sprintf('<strong>Invalid action:</strong> <em>%s</em> in %s.', $_, basename(__FILE__)), 500);
            exit;
        }

        $cmd .= $this->post_cmd($_, $args);

        log_message('info', "cmd: \t\t$cmd < < < < < < ");
        if ($redirect===true or $redirect=='true') {
            $this->shell->run($cmd);

            redirect($this->config->base_url().$this->config->item('cheat-code').'&'.$_, 301);
            return true;
        } else {
            return $this->shell->run($cmd);
        }
    }

    /**
     * @return post command string
     * @param string $_ action to request on the service (start|stop|restart|…) or on mast-utils (list-host|add-channel|…)
     * @param strin $args is arguments for service or mast-utils
     */
    public function post_cmd($_, $args)
    {
        $post_cmd ='';
        switch ($_) {
            case 'add-channel':
                preg_match(
                    "/NAME='(?P<name>[^']+)/",
                    $args,
                    $tunnel
                );
                $post_cmd .= sprintf("sudo %s restart '%s';", MAST_SERVICE, $tunnel['name']);
                break;
            default:
                # code...
                break;
        }
        return $post_cmd;
    }
    
    /**
     * Prepare arguments for the SERVICE
     * @param $params
     * @return string
     */
    public function prepare_service($param=null)
    {
        $arg = '';
        if (!is_null($param)) {
            list($arg, $value) = explode(':', $param);
            $arg = escapeshellarg($value);
        }

        return $arg;
    }

    /**
     * Prepare arguments for the MAKEFILE
     * @param $params
     * @return string
     */
    public function prepare_makefile($params=null)
    {

        $args = '';
        $params = explode(',', $params);
        if (!empty($_POST)) {
            foreach ($_POST as $arg => $value) {
                if (!empty(trim($value))) {
                    $args .= sprintf('%s=%s ', strtoupper($arg), escapeshellarg($value));
                }
            }
        } elseif (is_array($params)) {
            foreach ($params as $param) {
                list($arg, $value) = explode(':', $param);
                if (strlen(trim($value)) > 0) {
                    $args .= sprintf('%s=%s ', strtoupper($arg), escapeshellarg($value));
                }
            }
        } else {
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
