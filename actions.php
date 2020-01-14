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
	unset($_SESSION['cart_key']);
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

	// setup the cart
	if(!isset($_SESSION['cart_key'])){
		$_SESSION['cart_key'] 			= md5(rand(00000,99999).time());
	}

	$insert = $conn->exec("INSERT IGNORE INTO `shop_carts` 
        (`key`,`product_id`,`quantity`,`price`)
        VALUE
        ('".$_SESSION['cart_key']."',
        '".$product_id."',
        '".$quantity."',
        '".$price."'
    	)"
    );

	// check for existing products like this one
	$query 						= $conn->query("SELECT * FROM `shop_carts` WHERE `key` = '".$_SESSION['cart_key']."' AND `product_id` = '".$product_id."' ");
	$existing_item 				= $query->fetch(PDO::FETCH_ASSOC);

	if(isset($existing_item['id'])){
		// this item is already in the cart
		$new_quantity = ($existing_item['quantity'] + $quantity);

		// update the quantity
		$update = $conn->exec("UPDATE `shop_carts` SET `quantity` = '".$new_quantity."' 	WHERE `key` = '".$_SESSION['cart_key']."' AND `product_id` = '".$product_id."' ");
	}

	// update cart total
	$query 						= $conn->query("SELECT * FROM `shop_carts` WHERE `key` = '".$_SESSION['cart_key']."' ");
	$cart_items 				= $query->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($cart_items as $cart_item){
		$item_total_price 		= ($cart_item['price'] * $cart_item['quantity']);

		$cart_total				= ($cart_total + $item_total_price);
	}

	$_SESSION['cart_total']		= $cart_total;

    // log_add("[".$name."] has been updated.");
    status_message('success',"Cart updated.");
    go($_SERVER['HTTP_REFERER']);
}