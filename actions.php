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

	case "delete_cart_item":
		delete_cart_item();
		break;

	case "update_cart_checkout":
		update_cart_checkout();
		break;

	case "checkout":
		checkout();
		break;

	case "set_shipping":
		set_shipping();
		break;

// default		
	default:
		home();
		break;
}

function home()
{
	die('access denied to function name ' . $_GET['a']);
}

function test()
{
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

	$delete = $conn->exec("DELETE FROM `shop_carts` WHERE `key` = '".$_SESSION['cart_key']."' ");

	unset($_SESSION['cart']);
	unset($_SESSION['cart_key']);
	unset($_SESSION['cart_total']);

    // log_add("[".$name."] has been updated.");
    status_message('success',"Your cart is now empty.");
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
		$_SESSION['shipping_id']		= '';
	}

	// check for existing products like this one
	$query 						= $conn->query("SELECT * FROM `shop_carts` WHERE `key` = '".$_SESSION['cart_key']."' AND `product_id` = '".$product_id."' ");
	$existing_item 				= $query->fetch(PDO::FETCH_ASSOC);

	if(isset($existing_item['id'])){
		// this item is already in the cart
		$new_quantity = ($existing_item['quantity'] + $quantity);

		// update the quantity
		$update = $conn->exec("UPDATE `shop_carts` SET `quantity` = '".$new_quantity."' 	WHERE `key` = '".$_SESSION['cart_key']."' AND `product_id` = '".$product_id."' ");
	}else{
		$insert = $conn->exec("INSERT IGNORE INTO `shop_carts` 
	        (`key`,`product_id`,`quantity`,`price`)
	        VALUE
	        ('".$_SESSION['cart_key']."',
	        '".$product_id."',
	        '".$quantity."',
	        '".number_format($price, 2)."'
	    	)"
	    );
	}

	// update cart total
	$query 						= $conn->query("SELECT * FROM `shop_carts` WHERE `key` = '".$_SESSION['cart_key']."' ");
	$cart_items 				= $query->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($cart_items as $cart_item){
		$item_total_price 		= ($cart_item['price'] * $cart_item['quantity']);

		$cart_total				= ($cart_total + $item_total_price);
	}

	$cart_total 				= number_format($cart_total, 2);

	$_SESSION['cart_total']		= $cart_total;

	if($_SESSION['cart_total'] >= '39.90'){
		$_SESSION['shipping_id'] = 'shipping_free';
	}else{
		$_SESSION['shipping_id'] = '';
	}

    // log_add("[".$name."] has been updated.");
    status_message('success',"Item(s) have been added to your cart.");
    go($_SERVER['HTTP_REFERER']);
}

function delete_cart_item()
{
	global $conn;

	$cart_total 		= 0;
	$cart_item_id 		= get('id');

	// delete cart item
	$delete = $conn->exec("DELETE FROM `shop_carts` WHERE `id` = '".$cart_item_id."' AND `key` = '".$_SESSION['cart_key']."' ");

	// update cart total
	$query 						= $conn->query("SELECT * FROM `shop_carts` WHERE `key` = '".$_SESSION['cart_key']."' ");
	$cart_items 				= $query->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($cart_items as $cart_item){
		$item_total_price 		= ($cart_item['price'] * $cart_item['quantity']);

		$cart_total				= ($cart_total + $item_total_price);
	}

	$_SESSION['cart_total']		= $cart_total;

    // log_add("[".$name."] has been updated.");
    status_message('success',"Item(s) have been removed to your cart.");
    go($_SERVER['HTTP_REFERER']);
}

function update_cart_checkout()
{
	global $conn;

	$cart_total 	= 0;
	$count 			= 0;
	$product_ids 	= post('product_ids');
	$quantities 	= post('quantities');
	$prices 		= post('prices');
	
	// loop over each cart item to update quantities
	foreach($product_ids as $product_id){
		$update = $conn->exec("UPDATE `shop_carts` SET `quantity` = '".$quantities[$count]."' 	WHERE `key` = '".$_SESSION['cart_key']."' AND `product_id` = '".$product_id."' ");
		$count++;
	}

	// update cart total
	$query 						= $conn->query("SELECT * FROM `shop_carts` WHERE `key` = '".$_SESSION['cart_key']."' ");
	$cart_items 				= $query->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($cart_items as $cart_item){
		$item_total_price 		= ($cart_item['price'] * $cart_item['quantity']);

		$cart_total				= ($cart_total + $item_total_price);
	}

	$_SESSION['cart_total']		= $cart_total;

	if($_SESSION['cart_total'] >= '39.90'){
		$_SESSION['shipping_id'] = 'shipping_free';
	}else{
		$_SESSION['shipping_id'] = '';
	}

    // log_add("[".$name."] has been updated.");
    status_message('success',"Item(s) have been added to your cart.");
    go($_SERVER['HTTP_REFERER']);
}

function checkout()
{
	global $conn, $global_settings, $whmcs;

	$order_pids 		= array();

	// set account type
	$account_type 		= 'customer';

	// set the mlm_affiliate
	if(isset($_SESSION['mlm_affiliate'])){
		$upline_id 		= $_SESSION['mlm_affiliate'];
	}else{
		$upline_id 		= 1;
	}
	
	// get the client ip address
	$ip_address 						= $_SERVER['REMOTE_ADDR'];

	// get cart for whmcs order
	$query 								= $conn->query("SELECT * FROM `shop_carts` WHERE `key` = '".$_SESSION['cart_key']."' ");
	$cart_items 						= $query->fetchAll(PDO::FETCH_ASSOC);

	foreach($cart_items as $cart_item){
		for($x = 1; $x <= $cart_item['quantity']; $x++) {
			$order_pids[] = $cart_item['product_id'];
		}
	}

	// get shipping id
	if($_SESSION['shipping_id'] == 'shipping_free'){
		$shipping_id = array('57');
	}elseif($_SESSION['shipping_id'] == 'shipping_48'){
		$shipping_id = array('54');
	}elseif($_SESSION['shipping_id'] == 'shipping_24'){
		$shipping_id = array('55');
	}elseif($_SESSION['shipping_id'] == 'shipping_nextday'){
		$shipping_id = array('56');
	}

	array_merge($order_pids,$shipping_id);

	if(get('login') == 'yes'){
		$email 							= post('email');
		$password 						= post('password');

		// lets try whmcs
		$postfields["username"] 		= $whmcs['username']; 
		$postfields["password"] 		= $whmcs['password'];
		$postfields["action"] 			= "validatelogin";
		$postfields["email"] 			= $email;
		$postfields["password2"] 		= $password;
		$postfields["responsetype"] 	= 'json';
		$postfields['accesskey']		= $whmcs['accesskey'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $whmcs['url']);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		$data = curl_exec($ch);
		if (curl_error($ch)) {
		    die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
		}
		curl_close($ch);

		$results = json_decode($data, true);

		// debug($whmcs);

		// debug($results);

		if($results["result"]=="success"){
		    // login confirmed
			$client_id 		= $results['userid'];
		}else{
			// login failed
			status_message('danger',"Login failed, please try again.");
    		go($_SERVER['HTTP_REFERER']);
		}
	}else{
		$company_name 		= post('company_name');
		$company_name 		= preg_replace("/[^a-zA-Z0-9]+/", "", $company_name);

		$first_name 		= post('first_name');
		$first_name 		= preg_replace("/[^a-zA-Z0-9]+/", "", $first_name);

		$last_name 			= post('last_name');
		$last_name 			= preg_replace("/[^a-zA-Z0-9]+/", "", $last_name);

		$email 				= post('email');
		$email 				= trim($email);

		$tel 				= post('tel');
		$tel 				= trim($tel);

		$password 			= post('password');
		$password 			= trim($password);

		$password2 			= post('password2');
		$password2 			= trim($password2);

		$address_1 			= post('address_1');
		$address_1 			= addslashes($address_1);

		$address_2 			= post('address_2');
		$address_2 			= addslashes($address_2);

		$address_city 		= post('address_city');
		$address_city 		= addslashes($address_city);

		$address_state 		= post('address_state');
		$address_state 		= addslashes($address_state);

		$address_country 	= post('address_country');
		$address_country 	= addslashes($address_country);

		$address_zip 		= post('address_zip');
		$address_zip 		= addslashes($address_zip);

		$_SESSION['checkout_details']['company_name']			= $company_name;
		$_SESSION['checkout_details']['email']					= $email;
		$_SESSION['checkout_details']['tel']					= $tel;
		$_SESSION['checkout_details']['first_name']				= $first_name;
		$_SESSION['checkout_details']['last_name']				= $last_name;
		$_SESSION['checkout_details']['address_1']				= $address_1;
		$_SESSION['checkout_details']['address_2']				= $address_2;
		$_SESSION['checkout_details']['address_city']			= $address_city;
		$_SESSION['checkout_details']['address_state']			= $address_state;
		$_SESSION['checkout_details']['address_country']		= $address_country;
		$_SESSION['checkout_details']['address_zip']			= $address_zip;

		if($password != $password2){
			// passwords do not match
			status_message('danger',"Passwords do not match.");
	    	go($_SERVER['HTTP_REFERER']);
		}

		// register account with whmcs
		$postfields["username"] 		= $whmcs['username']; 
		$postfields["password"] 		= $whmcs['password'];
		$postfields['accesskey']		= $whmcs['accesskey'];
		$postfields["action"] 			= "AddClient";
		$postfields["responsetype"] 	= 'json';
		$postfields['noemail']			= true;
		$postfields['skipvalidation']	= true;

		$postfields['firstname'] 		= $first_name;
	    $postfields['lastname'] 		= $last_name;
	    $postfields['email']			= $email;
	    $postfields['address1']			= $address_1;
	    $postfields['address2']			= $address_2;
	    $postfields['city'] 			= $address_city;
	    $postfields['state'] 			= $address_state;
	    $postfields['postcode']			= $address_zip;
	    $postfields['country'] 			= $address_country;
	    $postfields['phonenumber'] 		= $tel;
	    $postfields['password2']		= $password;
	    $postfields['clientip'] 		= $ip_address;

	    # debug($whmcs);
	    # debug($postfields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $whmcs['url']);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
		$data = curl_exec($ch);

		if (curl_error($ch)) {
		    die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
		}

		curl_close($ch);

		$results = json_decode($data, true);

		// debug($data);
		// debug($results);

		// die();

		if($results["result"]=="success"){
			// account registered
			$client_id = $results['clientid'];

			// create record in dashboard
			$insert = $conn->exec("INSERT INTO `users` 
				(`id`,`type`, `added`, `updated`, `status`, `upline_id`) VALUES
				
				('".$client_id."',
				'".$account_type."',
				'".time()."',
				'".time()."',
				'pending',
				'".$upline_id."'
				);
			");
		}else{
			status_message('danger',$results['message'].".");
    		go($_SERVER['HTTP_REFERER']);
		}
	}

	// place order with whmcs
	$postfields["username"] 		= $whmcs['username']; 
	$postfields["password"] 		= $whmcs['password'];
	$postfields['accesskey']		= $whmcs['accesskey'];
	$postfields["action"] 			= "AddOrder";
	$postfields["responsetype"] 	= 'json';
	$postfields['paymentmethod']	= 'worldpayfuturepay';

	$postfields['clientid'] 		= $client_id;
    $postfields['pid'] 				= $order_pids;
    $postfields['affid']			= $_COOKIE['WHMCSAffiliateID'];

    # debug($whmcs);
    # debug($postfields);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $whmcs['url']);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
	$data = curl_exec($ch);

	if (curl_error($ch)) {
	    die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
	}

	curl_close($ch);

	$results = json_decode($data, true);

	# debug($data);
	# debug($results);

	if($results["result"]=="success"){
		// order placed
		$order_id 				= $results['orderid'];
		$invoice_id 			= $results['invoiceid'];

		// redirect to invoice for payment
		$whmcsurl 				= "https://ublo.club/billing/dologin.php";
		$autoauthkey 			= "admin1372";
		$email 					= $email;
		
		$timestamp 				= time(); 
		$goto 					= "viewinvoice.php?id=".$invoice_id;
		
		$hash 					= sha1($email.$timestamp.$autoauthkey);
		
		$url 					= $whmcsurl."?email=$email&timestamp=$timestamp&hash=$hash&goto=".urlencode($goto);

		// empty_cart();

		// echo "URL: ".$url;

		header("Location: $url");
		exit;

		// go($url);
	}else{
		// unable to place order
		status_message('danger',$results['message'].".");
		go($_SERVER['HTTP_REFERER']);
	}
}

function set_shipping()
{
	global $conn;

	$cart_total 	= 0;

	$shipping_id 				= get('shipping_id');
	$_SESSION['shipping_id']	= $shipping_id;
	if($shipping_id == 'shipping_free'){
		$shipping_cost = '0.00';
	}elseif($shipping_id == 'shipping_48'){
		$shipping_cost = '2.99';
	}elseif($shipping_id == 'shipping_24'){
		$shipping_cost = '3.99';
	}elseif($shipping_id == 'shipping_nextday'){
		$shipping_cost = '7.99';
	}else{
		$shipping_cost = '999.99';
	}

	// update cart total
	$query 						= $conn->query("SELECT * FROM `shop_carts` WHERE `key` = '".$_SESSION['cart_key']."' ");
	$cart_items 				= $query->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($cart_items as $cart_item){
		$item_total_price 		= ($cart_item['price'] * $cart_item['quantity']);

		$cart_total				= ($cart_total + $item_total_price);
	}

	if($cart_total >= '39.90'){
		$_SESSION['shipping_id']	= 'shipping_free';
		$cart_total					= $cart_total;
	}else{
		$cart_total					= ($cart_total + $shipping_cost);
	}

	$_SESSION['cart_total']		= number_format($cart_total, 2);

    // log_add("[".$name."] has been updated.");
    status_message('success',"Item(s) have been added to your cart.");
    go($_SERVER['HTTP_REFERER']);
}