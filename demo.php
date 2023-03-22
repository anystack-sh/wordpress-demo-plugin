<?php
/*
Plugin Name: Demo
Plugin URI: http://anystack.sh
Description: Example plugin
Author: Philo Hermans
Version: REF
Author URI: https://anystack.sh
*/

require 'wp-guard/src/WpGuard.php';

$guard = new Anystack\WpGuard\V001\WpGuard(
	__FILE__,
	[
		'api_key' => '<API KEY>',
		'product_id' => '<PRODUCT ID>',
		'product_name' => 'Demo',
		'license' => [
			'require_email' => true,
		],
		'updater' => [
			'enabled' => true,
		]
	]
);

$guard->validCallback(function() {
	add_action( 'admin_notices', 'daily_revenue' );
});

function daily_revenue() {
	echo '<p>Hi there! Your revenue for today is $123.45</p>';
}