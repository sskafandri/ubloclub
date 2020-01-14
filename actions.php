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

	case "empty_cart":
		empty_cart();
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

function empty_cart()
{
	global $conn;

	unset($_SESSION['cart']);
	$_SESSION['cart_total'] = 0;

    // log_add("[".$name."] has been updated.");
    status_message('success',"Cart empty.");
    go($_SERVER['HTTP_REFERER']);
}

function add_to_cart()
{
	global $conn;
	$cart_total 	= 0; 

	$product_id 	= post('product_id');
	$quantity 		= post('quantity');
	$price 			= post('price');
	$rand 			= rand(00000,99999);

	// see if this product is already in the cart, update totals if needed
	/*
	foreach($_SESSION['cart'] as $cart_item){
		if($product_id == $cart_item['product_id']){
			$cart_item['quantity']				= ($cart_item['quantity'] + $quantity);
		}
	}
	*/

	$_SESSION['cart'][$rand]['product_id']		= $product_id;
	$_SESSION['cart'][$rand]['quantity']		= $quantity;
	$_SESSION['cart'][$rand]['price']			= $price;

	// calc cart total
	foreach($_SESSION['cart'] as $cart_item){
		$cart_total = ($cart_total + $price);
	}

	$_SESSION['cart_total'] = $cart_total;

    // log_add("[".$name."] has been updated.");
    status_message('success',"Cart updated.");
    go($_SERVER['HTTP_REFERER']);
}