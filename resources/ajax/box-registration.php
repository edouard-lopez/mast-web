<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
/**
#--------------------------------------------------------------------------
    * Remote conexion tester
    * @category AJAX TCP Module
    * @package  MAST-web
    * @author   alban LOPEZ <alban.lopez@gmail.com>
    * @link     ./resources/ajax/box-registration.php?MAC=00.11.22.33.44.55&IP=10.48.1.125&interface=eth1
#--------------------------------------------------------------------------
*/

echo '<pre>';
$Box = array(
	$_GET['MAC'] => array(
		'IP' => $_GET['IP'],
		'Interface' => $_GET['interface']
		)
	);
$BoxListFile = './BoxList.json';

if (file_exists($BoxListFile)) {
	$BoxList=json_decode(file_get_contents($BoxListFile), true);
	$BoxList[$_GET['MAC']] = $Box[$_GET['MAC']];
} else {
	$BoxList = $Box;
}
echo file_put_contents($BoxListFile, json_encode($BoxList));

echo file_get_contents($BoxListFile);
?>