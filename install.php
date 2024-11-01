<?php

// hook the installation function to set up our database
register_activation_hook(ZOS_PLUGIN_DIR . '/zos_stp.php', 'zos_stp_install');

function zos_stp_install() {
	global $wpdb;
	
	$table_name = ZOS_STP_ADDRESSES_TABLE;
	
	if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	
		$sql = "CREATE TABLE " . $table_name . " (
		            address_id MEDIUMINT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		            name VARCHAR(128) NOT NULL,
		            address TEXT NOT NULL,
		            email_from VARCHAR(128),
		            email_subject VARCHAR(128),
		            email_message TEXT,
		            stp_button VARCHAR(8),
		            INDEX idx_name (name)
		        );";
		        
		// load the Wordpress upgrade library
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		// so we can use the database migration functionality
		dbDelta($sql);
		
		add_option("zos_stp_db_version", ZOS_DB_VERSION);
	}
}

return;