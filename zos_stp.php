<?php
/*
Plugin Name: zhiing Send-to-Phone
Plugin URI: http://zoscomm.com/products-and-solutions/web-development-and-send-to-phone
Description: Adds a button next to addresses on your site enabling the location, and point-to-point directions to be sent to a phone
Version: 1.0.1
Author: ZOS Communications
Author URI: http://zoscomm.com/
License: GPL2
*/

/*  Copyright 2010  ZOS Communications, LLC  (email : support@zoscomm.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require(dirname(__FILE__) . '/globals.php');
require(ZOS_PLUGIN_DIR . '/install.php');
require(ZOS_PLUGIN_DIR . '/init_admin.php');
require(ZOS_PLUGIN_DIR . '/options.php');
require(ZOS_PLUGIN_DIR . '/addresses.php');


add_shortcode('send_to_phone', 'send_to_phone_handler');

// handles the shortcode when discovered in a page/post/widget
function send_to_phone_handler($atts, $content=null, $code="") {
	// TODO:
	// we should probably build a STP Window object...
	
	// extract the attributes
	// we're extracting the window options from the database.
	// if they aren't set, we set the default to empty string.
	// these options are then overridable in the shortcode.
	extract(shortcode_atts(array(
		'address_id' => '',
		'name' => '',
		'address' => '',
		'email_from' => 'ZOS Communications',
		'email_subject' => 'Meet at this location',
		'email_message' => '',
		'stp_button' => 'buttonv3',
		'show_address' => true,
		'logo_image' => get_option('zos_stp_logo_image', ''),
		'logo_text' => get_option('zos_stp_logo_text', ''),
		'logo_href' => get_option('zos_stp_logo_href', ''),
		'field_bgcolor' => get_option('zos_stp_field_bgcolor', ''),
		'page_bgcolor' => get_option('zos_stp_page_bgcolor', '')
		), $atts));

	// a bit of a hack!!! for now...
	if ($address_id != '') {
		// we have a shortcode for an address stored in the db
		
		// HACK!!!
		// this is cut-paste from addresses.php
		global $wpdb;
		$sql = $wpdb->prepare("SELECT * FROM " . ZOS_STP_ADDRESSES_TABLE . " WHERE address_id = " . $address_id);
		
		// overrides the defaults AND anything passed in
		// TODO:
		// is this what we really want?
		$db_address = $wpdb->get_row($sql, ARRAY_A);
		extract($db_address);
	}
	
	// set global window options
	$options = "";
	
	$options .= "&logoImg=";
	$options .= urlencode($logo_image);
	$options .= "&logoText=";
	$options .= urlencode($logo_text);
	$options .= "&logoHref=";
	$options .= urlencode($logo_href);
	$options .= "&entryBg=";
	$options .= urlencode($field_bgcolor);
	$options .= "&pageBg=";
	$options .= urlencode($page_bgcolor);
	
	if ($address != '') {
		// we have an address from the shortcode or the db
		$content = (bool)$show_address === true ?
			wpautop($address, $br = 1) :
			'';
	}
	
	// we have an enclosing shortcode
	return $content . "<a onclick=\"javascript:window.open('http://zms.zhiing.com/webclient/zhiingchat/zmschat2.aspx?addrTxt=". urlencode(wp_filter_nohtml_kses($content)) . "&txtFrom=" . urlencode($email_from) . "&txtSubject=" . urlencode($email_subject) . "&txtMessage=" . urlencode($email_message) . $options . "','zhiing','resizable=no,scrollbars=no,height=436,width=568,status=yes');\"><img src='http://images.zoscomm.com/{$stp_button}.png' alt='Send to Phone' style='cursor: pointer' /></a>";
}

?>
