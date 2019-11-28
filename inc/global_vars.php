<?php

$config['base_fir'] 							= '/home2/ukmarketingclub/public_html/';

$config['version']								= '1';

// site vars
$site['url']									= 'http://ukmarketingclub.com';
$site['title']									= 'CMS';
$site['copyright']								= 'Written by DeltaColo.';

// logo name vars
$site['name_long']								= 'CMS Portal';
$site['name_short']								= '<b>CMS</b>';

// get settings table contents
$query = $conn->query("SELECT `config_name`,`config_value` FROM `global_settings` ");
$global_settings_temp = $query->fetchAll(PDO::FETCH_ASSOC);

foreach($global_settings_temp as $bits){
	$global_settings[$bits['config_name']] 		= $bits['config_value'];
}

$site['url']									= $global_settings['shop_site_url'];
$site['title']									= $global_settings['shop_site_title'];
$site['name_long']								= $global_settings['shop_site_name'];
$site['name_short']								= $global_settings['shop_site_name_short'];