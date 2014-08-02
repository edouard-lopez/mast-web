<?php
/**
#--------------------------------------------------------------------------
    * Remote conexion tester
    * @category AJAX TCP Module
    * @package  MAST-web
    * @author   alban LOPEZ <alban.lopez@gmail.com>
    * @link     http://rcd.coaxis.com/testRmHost.php?hosts=128.0.0.222:80,8.8.8.8:53,88.300.112.16:80,test.com,localhost:22,te@st.com,truc.fr:80,1.123.fr
#--------------------------------------------------------------------------
*/

/**
test TCP connexion over specified TCP Port to a host
   * @
   * @param IP : Hostname or IP Adress
   * @param Port : TCP Port number
   */
   function Test_TCP_IP($IP, $Port){
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
        exec(sprintf('ping -c 1 -W 2 %s', escapeshellarg($host)), $res, $rval);
        // on retourne la valeur d'average de la commande ping
        return ($rval === 0) ? (explode('/', explode(' = ', $res[count($res)-1])[1])[1])*1 : false;
    }

/**
Perform a system ping to a host
    * @
    * @param data structure array()
    */
    function buildArray($host, $port)
    {
        $ping=ping($host);
        $telnet=Test_TCP_IP($host, $port);
        return array(
                    'ping' => $ping,
                    'telnet' => $telnet,
                    'status' => (is_numeric($ping) && is_numeric($telnet))?'green' : (is_numeric($telnet) ? 'LimeGreen' : (is_numeric($ping) ? (empty($port) ? 'green' : 'Orange') : 'red'))
                );
    }

$result=array();
$hosts=explode(',', $_GET['hosts']);

foreach ($hosts as $hostPort) {
    list($host, $port) = explode(':', $hostPort);

        // si ca resemble a une IP
        if ( preg_match('/^([0-9]+\.)+[0-9]+$/', $host)) {
            // si c une IP V4 valide
            if ( preg_match('/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/', $host)) {
                $result[$hostPort] = buildArray($host, $port);
            }
            else $result[$hostPort] = array(
                                        'ping' => "Invalid IP!",
                                        'telnet' => "Invalid IP!",
                                        'status' => 'black'
                                    );
        }
        elseif (preg_match('/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)*[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?$/', $host)) {
                $result[$hostPort] = buildArray($host, $port);
        }
        else $result[$hostPort] = array(
                                        'ping' => "Invalid HostName!",
                                        'telnet' => "Invalid HostName!",
                                        'status' => 'black'
                                    );
}

echo json_encode($result);
?>