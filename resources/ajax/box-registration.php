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
    * @version 0.3
#--------------------------------------------------------------------------
*/
$BoxListFile = './BoxList.json';

if (isset($_GET['MAC'])) {
	$Box = array(
		$_GET['MAC'] => array(
			'LastUp' => time(),
			'IP' => $_GET['IP'],
			'Gateway' => $_GET['gateway'],
			'Interface' => $_GET['interface'],
			'State' => 'Waiting Validation'
			)
		);

	if (file_exists($BoxListFile)) {
		$BoxList=json_decode(file_get_contents($BoxListFile), true);
		if ( !isset($BoxList[$_GET['MAC']]) || $BoxList[$_GET['MAC']]['State']=='Waiting Validation' ) {
			$BoxList[$_GET['MAC']] = $Box[$_GET['MAC']];
		}

	} else {
		$BoxList = $Box;
	}
	file_put_contents($BoxListFile, json_encode($BoxList));
}
echo '<pre>';
echo @file_get_contents($BoxListFile);
?>