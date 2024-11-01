<?php

function zos_get_addresses() {
	global $wpdb;
	
	$sql = $wpdb->prepare("SELECT * FROM " . ZOS_STP_ADDRESSES_TABLE . " ORDER BY name");
	
	return $wpdb->get_results($sql);
}

function zos_get_address($id) {
	global $wpdb;
	
	$sql = $wpdb->prepare("SELECT * FROM " . ZOS_STP_ADDRESSES_TABLE . " WHERE address_id = " . $id);
	
	return $wpdb->get_row($sql);
}

function zos_delete_address($id) {
	global $wpdb;
	
	$sql = $wpdb->prepare("DELETE FROM " . ZOS_STP_ADDRESSES_TABLE . " WHERE address_id = " . $id);
	
	$wpdb->query($sql);
}

return;
