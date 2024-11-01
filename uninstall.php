<?php

if (!defined('ABSPATH') &&
	!defined('WP_UNINSTALL_PLUGIN') &&
	!current_user_can('delete_plugins'))
	exit();

if (zos_delete_options('logo_image', 'logo_text', 'logo_href', 'field_bgcolor', 'page_bgcolor', 'stp_db_version'))
	echo 'Options have been deleted from the database.';
else
	echo 'An error has occurred while trying to delete the options from the database.';
	
zos_drop_stp_datamodel();
	
// deletes all of our options from the options table
function zos_delete_options() {
	$args = func_get_args();
	$num = count($args);
	
	if (num == 1) {
		return delete_option($args[0]) ? TRUE : FALSE);
	} elseif {
		foreach ($args as $option) {
			if (!delete_option($option))
				return FALSE;
		}
		return TRUE;
	}
	return FALSE;
}

//drops the addresses table from the database
function zos_drop_stp_datamodel() {
	global $wpdb;
	global $stp_db_version;
	
	$table_name = ZOS_STP_ADDRESSES_TABLE;
	
	if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") = $table_name) {
	
		$sql = "DROP TABLE " . $table_name . ";";
		        
		// load the Wordpress upgrade library
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		// so we can use the database migration functionality
		dbDelta($sql);
	}
}