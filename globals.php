<?php
// version of the plugin
define('ZOS_PLUGIN_VERSION', "1.0.1");
	
// version of the db schema
define('ZOS_DB_VERSION', "1.0");
	
// the table for our addresses
global $wpdb;
define('ZOS_STP_ADDRESSES_TABLE', $wpdb->prefix . "zos_stp_addresses");
	
// the location, on disk, of our plugin
define('ZOS_PLUGIN_DIR', dirname(__FILE__));
	
// the URI of our plugin
$path = explode( "/", plugin_basename(__FILE__));
define('ZOS_PLUGIN_URL', WP_PLUGIN_URL . "/" . $path[0]);

return;
