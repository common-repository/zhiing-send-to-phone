<?php

require(ZOS_PLUGIN_DIR . '/address-manager.php');
require(ZOS_PLUGIN_DIR . '/address-form.php');

// create the custom plugin settings menu
if (is_admin()) {
	add_action('admin_menu', 'zos_stp_plugin_menu');
}

add_action('admin_head', 'zos_stp_admin_head');

function zos_stp_admin_head() {
	echo '<link rel="stylesheet" href="'. ZOS_PLUGIN_URL . '/css/admin.css" type="text/css" />';
}

function register_zos_stp_settings() {
	// TODO:
	// this should really be an array that gets stored in one row
	// and exploded/joined into an array/object...
	register_setting('zos-stp-settings-group', 'zos_stp_logo_image');
	register_setting('zos-stp-settings-group', 'zos_stp_logo_href');
	register_setting('zos-stp-settings-group', 'zos_stp_logo_text');
	register_setting('zos-stp-settings-group', 'zos_stp_field_bgcolor');
	register_setting('zos-stp-settings-group', 'zos_stp_page_bgcolor');
}

function zos_stp_plugin_menu() {
	// create a menu item for managing addresses in the top level menu
	add_object_page(__('Page Title'), __('Send-to-Phone'), 'edit_posts', 'zos-stp', 'zos_stp_address_list', ZOS_PLUGIN_URL . "/images/icon.png");
	
	// set the sub-menu item to be the default
	// hackish?
	$zos_stp_address_list = add_submenu_page('zos-stp', __('Addresses'), __('Addresses'), 'edit_posts', 'zos-stp', 'zos_stp_address_list');
	
	$zos_stp_address_form = add_submenu_page('zos-stp', __('Add New'), __('Add New'), 'edit_posts', 'zos-stp-address-form', 'zos_stp_get_address_form');
	
	$zos_stp_options_page = add_options_page(__('Send-to-Phone Options'), __('Send-to-Phone'), 'manage_options', 'zos-stp-options', 'zos_stp_plugin_options');
	
	// call register settings
	add_action('admin_init', 'register_zos_stp_settings');
}

return;