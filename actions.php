<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('UTC');

session_start();

include("inc/db.php");
include("inc/global_vars.php");
include("inc/functions.php");

$a = $_GET['a'];

switch ($a)
{
	// test
	case "test":
		test();
		break;

	case "add_to_cart":
		add_to_cart();
		break;

// default		
	default:
		home();
		break;
}

function home(){
	die('access denied to function name ' . $_GET['a']);
}

function test(){
	echo exec('whoami');
	echo "<hr>";
	echo '<h3>$_SESSION</h3>';
	echo '<pre>';
	print_r($_SESSION);
	echo '</pre>';
	echo '<hr>';
	echo '<h3>$_POST</h3>';
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	echo '<hr>';
	echo '<h3>$_GET</h3>';
	echo '<pre>';
	print_r($_GET);
	echo '</pre>';
	echo '<hr>';
}

function add_to_cart()
{
	global $conn;

	$product_id 	= post('product_id');
	$quantity 		= post('quantity');
	$rand 			= rand(00000,99999);

	$_SESSION['cart'][$rand]['product_id']		= $product_id;
	$_SESSION['cart'][$rand]['quantity']		= $product_id;

    // log_add("[".$name."] has been updated.");
    status_message('success',"Cart updated.");
    go($_SERVER['HTTP_REFERER']);
}