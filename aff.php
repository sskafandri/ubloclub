<?php

if(isset($_GET['dev']) && $_GET['dev'] == 'yes'){
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
}

date_default_timezone_set('UTC');

session_start();

// includes
include('inc/db.php');
include('inc/global_vars.php');
include('inc/functions.php');

// get affiliate username
$username 									= get('username');

// convert username to userid
$query      								= $conn->query("SELECT `id` FROM `users` WHERE `affiliate_username` = '".$username."' ");
$user      	 								= $query->fetch(PDO::FETCH_ASSOC);
$_SESSION['tracking_id'] 					= $user['id'];

$cookie_name 								= "tracking_id";
$cookie_value 								= $user['id'];
setcookie( $cookie_name, $cookie_value, time() + 3600 * 24 * 365, "/" ); // 86400 = 1 day

// convert userid to affiliateid
/*
$query      					= $conn->query("SELECT `id` FROM `whmcs`.`tblaffiliates` WHERE `clientid` = '".$user['id']."' ");
$affiliate 						= $query->fetch(PDO::FETCH_ASSOC);
$_SESSION['whmcs_affiliate'] 	= $affiliate['id'];

if(!isset($affiliate['id'])){
	$affiliate['id'] = 17;
}
*/

header( "Location: https://ublo.club/" , true, 301 );
?>