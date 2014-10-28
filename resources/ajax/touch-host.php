<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
/**
#--------------------------------------------------------------------------
    * Remote conexion tester
    * @category AJAX TCP Module
    * @package  MAST-web
    * @author   alban LOPEZ <alban.lopez@gmail.com>
    * @link     ./resources/ajax/touch-host.php?hosts=128.0.0.222:80,8.8.8.8:53,88.300.112.16:80,test.com,localhost:22,te@st.com,truc.fr:80,1.123.fr
    * @version  1.1
#--------------------------------------------------------------------------
*/
define("TIMEOUT", 1);
$levelClass = array(
        'full-ok'=>'glyphicon glyphicon-ok text-muted',
        'ok'=>'glyphicon glyphicon-ok text-muted',
        'partial'=>'glyphicon glyphicon-exclamation-sign status-danger',
        'mismatch'=>'glyphicon glyphicon-exclamation-sign status-danger',
        'none'=>'glyphicon glyphicon-exclamation-sign'
    );






/**
test TCP connexion over specified TCP Port to a host
   * @
   * @param IP : Hostname or IP Adress
   * @param Port : TCP Port number
   */
   function socket($IP, $Port){
        if (empty($Port)) return "Invalid Port : empty()";
        elseif ($Port>65535 or $Port<1) return "Invalid Port : $Port";
        $socket = @socket_create (AF_INET, SOCK_STREAM, 0);
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => TIMEOUT, 'usec' => 0));

        if ($socket) {
            $start = microtime(true);
            $result = @socket_connect ($socket, $IP, $Port);
            $stop = microtime(true);
            socket_close ($socket);

            if ($result) {
                $time = round((($stop - $start) * 1000), 3); 
                return $time;            } 
            else {
                return false;
            }
        }
        else {
            return false;
        }

   }


/**
test TCP connexion over specified TCP Port to a host
   * @
   * @param IP : Hostname or IP Adress
   * @param Port : TCP Port number
   */
   function telnet($IP, $Port){
        if (empty($Port)) return "Invalid Port : empty()";
        elseif ($Port>65535 or $Port<1) return "Invalid Port : $Port";
        $start = microtime(true);
        $socket = @fsockopen ($IP, $Port, $errno, $errstr, TIMEOUT); // timeOut court de TIMEOUT sec
        $stop = microtime(true);
        if (!$socket) return false;  // Site is down
        else {
            fclose($socket);
            $time = round((($stop - $start) * 1000), 3); 
            return $time;
        }
   }

/**
Perform a system ping to a host
    * @
    * @param data structure array()
    */
    function ping($host)
    {
        exec(sprintf('ping -c1 -W '.TIMEOUT.' %s', escapeshellarg($host)), $res, $rval);
        // on retourne la valeur d'average de la commande ping
        if ($rval === 0) {
            $res=explode(' = ',$res[count($res)-1]);
            $res=explode('/',$res[1]);
            return $res[1]*1;
        }
        return false;
    }



/**
Perform a system ping to a host
    * @
    * @param data structure array()
    */
    // function phpPing($host) {
    //     /* ICMP ping packet with a pre-calculated checksum */
    //     $package = "\x08\x00\x7d\x4b\x00\x00\x00\x00PingHost";
    //     $socket  = socket_create(AF_INET, SOCK_RAW, 1);
    //     socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => TIMEOUT, 'usec' => 0));
    //     socket_connect($socket, $host, null);

    //     $ts = microtime(true);
    //     socket_send($socket, $package, strLen($package), 0);
    //     if (socket_read($socket, 255))
    //         $result = microtime(true) - $ts;
    //     else
    //         $result = false;
    //     socket_close($socket);

    //     return $result;
    // }

/**
Perform a system ping to a host
    * @
    * @param data structure array()
    */
    function buildArray($host, $port, $levelClass)
    {
        $ping = ping($host);
        $telnet = telnet($host, $port);

        if (is_numeric($ping) && is_numeric($telnet)) {
            $status = 'full-ok';
        } elseif (is_numeric($telnet)) {
            $status = 'ok';
        } elseif (is_numeric($ping)) {
            if (empty($port)) {
                $status = 'full-ok';
            } else {
                $status = 'partial';
            }
        } else {
            $status = 'mismatch';
        }

        return array(
                    'ping' => $ping,
                    // 'phpPing' => phpPing($host),
                    'telnet' => $telnet,
                    // 'socket' => socket($host, $port),
                    'status' => $levelClass[$status]
                );
    }


/**
Test each host on the network
    * @
    * @param $_GET[]
    */
    $result=array();
    $hosts=explode(',', $_GET['hosts']);

    foreach ($hosts as $hostPort) {
        @list($host, $port, $channel) = explode(':', $hostPort);

            // si ca resemble a une IP
            if ( preg_match('/^([0-9]+\.)+[0-9]+$/', $host)) {
                // si c une IP V4 valide
                if ( preg_match('/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/', $host)) {
                    $result[$hostPort] = buildArray($host, $port, $levelClass);
                }
                else $result[$hostPort] = array(
                                            'ping' => "Invalid IP!",
                                            'telnet' => "Invalid IP!",
                                            'status' => $levelClass['none']
                                        );
            }
            // s'il s'agit d'un nom DNS ou HOSTS valide
            elseif (preg_match('/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)*[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?$/', $host)) {
                    $result[$hostPort] = buildArray($host, $port, $levelClass);
            }
            else $result[$hostPort] = array(
                                            'ping' => "Invalid Host!",
                                            'telnet' => "Invalid Host!",
                                            'status' => $levelClass['none']
                                        );
    }



echo json_encode($result);
?>