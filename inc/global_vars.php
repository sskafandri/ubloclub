<?php

$config['base_fir'] 							= '/home/ublu/public_html/';

$config['version']								= '1';

// site vars
$site['copyright']								= 'Written by DeltaColo.';

// get settings table contents
$query = $conn->query("SELECT `config_name`,`config_value` FROM `global_settings` ");
$global_settings_temp = $query->fetchAll(PDO::FETCH_ASSOC);

foreach($global_settings_temp as $bits){
	$global_settings[$bits['config_name']] 		= $bits['config_value'];
}

$site['url']									= $global_settings['shop_site_url'];
$site['title']									= $global_settings['shop_site_title'];
$site['name_long']								= $global_settings['shop_site_name'];
// $site['name_short']								= $global_settings['shop_site_name_short'];

// whmcs vars
$whmcs['url'] 									= "https://ublo.club/billing/includes/api.php"; # URL to WHMCS API file
$whmcs["username"] 								= "api_user"; # Admin username goes here
$whmcs["password"] 								= md5("admin1372"); # Admin password goes here  
$whmcs['accesskey']								= 'admin1372';