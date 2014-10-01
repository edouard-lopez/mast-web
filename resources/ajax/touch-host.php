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
    * @version  1.0
#--------------------------------------------------------------------------
*/
$levelClass = array(
        'full-ok'=>'glyphicon glyphicon-print text-muted',
        'ok'=>'glyphicon glyphicon-print text-muted',
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
   function telnet($IP, $Port){
        if (empty($Port)) return "Invalid Port : empty()";
        elseif ($Port>65535 or $Port<1) return "Invalid Port : $Port";
        $start = microtime(true);
        $socket = @fsockopen ($IP, $Port, $errno, $errstr, 2); // timeOut court de 2sec
        $stop = microtime(true);
        if (!$socket) return false;  // Site is down
        else {
            $time = round((($stop - $start) * 1000), 3); 
            @fclose($socket);
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
        exec(sprintf('ping -c1 -W 1 %s', escapeshellarg($host)), $res, $rval);
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
                    'telnet' => $telnet,
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
        @list($host, $port) = explode(':', $hostPort);

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