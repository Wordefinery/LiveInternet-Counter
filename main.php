<?php
/**
 * @package Wordefinery LiveInternet Counter
 */
/*
Plugin Name: Wordefinery LiveInternet Counter
Plugin URI: http://wordefinery.com/plugins/liveinternet-counter/?from=wp&v=0.8.9.1
Description: Displays LiveInternet.ru counter
Version: 0.8.9.1
Author: Wordefinery
Author URI: http://wordefinery.com
License: GPLv2 or later

*/

if ( !function_exists( 'add_action' ) ) {
    echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
    exit;
}

require_once(dirname( __FILE__ ) . '/lib/init.php');
Wordefinery::Register(dirname( __FILE__ ), 'LiveinternetCounter', '0.8.9.1');
