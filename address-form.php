<?php
/**
 * Edit address form for including in the WP Administration panels.
 */

// handles the call to the form
function zos_stp_get_address_form() {
	global $wpdb;
	
	if (!current_user_can('edit_posts') )
		wp_die(__("You do not have sufficient permissions/privileges to edit the Addresses for this site."));
		
	if ($_POST) {
		switch($_POST['action']) {
			// TODO:
			// validation. empty strings are passed for name/address
			// which should be required
			
			case 'create':
				// doing it this way so it is easier to debug the query...
				$sql = $wpdb->prepare("
					INSERT INTO ". ZOS_STP_ADDRESSES_TABLE . " 
					(name, address, email_from, email_subject, email_message, stp_button)
					VALUES
					(%s, %s, %s, %s, %s, %s)",
					$_POST['zos_stp_name'],
					$_POST['zos_stp_address'],
					$_POST['zos_stp_email_from'],
					$_POST['zos_stp_email_subject'],
					$_POST['zos_stp_email_message'],
					$_POST['zos_stp_button']
				);
				
				if ($wpdb->query($sql) === FALSE)
					zos_admin_message(__("Address could not be saved."));
				else
					zos_admin_message(__("Address has been saved."));
					
				break;
				
			case 'update':
				$sql = $wpdb->prepare("
					UPDATE " . ZOS_STP_ADDRESSES_TABLE . " 
					SET
						name = %s,
						address = %s,
						email_from = %s,
						email_subject = %s,
						email_message = %s,
						stp_button = %s
					WHERE
						address_id = %d",
					$_POST['zos_stp_name'],
					$_POST['zos_stp_address'],
					$_POST['zos_stp_email_from'],
					$_POST['zos_stp_email_subject'],
					$_POST['zos_stp_email_message'],
					$_POST['zos_stp_button'],
					$_POST['zos_stp_address_id']
				);
				
				if ($wpdb->query($sql) === FALSE)
					zos_admin_message(__("Address could not be updated."));
				else
					zos_admin_message(__("Address has been updated."));
				
				// get the address and pass it to the edit form
				$address = zos_get_address($_POST['zos_stp_address_id']);
				_zos_stp_address_form($address, 'edit');
				break;
				
			default:
				zos_admin_message(__("There has been an unexpected error, please try again."));
		}
	} else {
		switch ($_GET['action']) {
			case 'edit':
				$address = zos_get_address($_GET['address_id']);
				_zos_stp_address_form($address, $_GET['action']);
				break;
			case 'delete':
				zos_delete_address($_GET['address_id']);
				zos_admin_message(__("Address has been deleted."));
				break;
			case 'new':
			default:
				_zos_stp_address_form(null, $_GET['action']);
				break;
		}
	}
}

// presents a div for messaging
function zos_admin_message($message) {
?>
	<div id="message" class="updated below-h2">
		<p><?php echo $message; ?></p>
	</div>
<?php
}

// prints the form configured for editing or creating
function _zos_stp_address_form($address, $purpose) {
	switch($purpose) {
		case 'edit':
			$title = __('Edit Address');
			$action = 'update';
			break;
		case 'new':
		default:
			$title = __('Add New Address');
			$action = 'create';
			break;
	}
?>
<script type="text/javascript">
//<![CDATA[
	function CheckForm() {
		var alertMsg = "";
		
		if (jQuery("#newaddress textarea[name=zos_stp_address]").val().length <= 0) 
			alertMsg += "The Address field is required.\n";
				
		if (jQuery("#newaddress input[name=zos_stp_name]").val().length <= 0) 
			alertMsg += "The Name field is required.\n";
				
		if (!jQuery("#newaddress input:radio[name=zos_stp_button]").is(':checked')) 
			alertMsg += "Please select a button style.\n";
				
		if (alertMsg.length > 0) {
			alertMsg = "We need some more information:\n\n" + alertMsg;
			alert(alertMsg);
			return false;
		}
		
		return true;
	}
	
	function PreviewWindow() {		
		if (typeof jQuery != 'undefined') {
			// build the url for the preview
			var stpURI = "";
			stpURI = "http://zms.zhiing.com/webclient/zhiingchat/zmschat2.aspx?addrTxt=";
			
			stpURI += encodeURI(jQuery("#newaddress textarea[name=zos_stp_address]").val());
			
			stpURI += "&txtFrom=";
			stpURI += encodeURI(jQuery("#newaddress input[name=zos_stp_email_from]").val());
			
			stpURI += "&txtSubject=";
			stpURI += encodeURI(jQuery("#newaddress input[name=zos_stp_email_subject]").val());
			
			stpURI += "&txtMessage=";
			stpURI += encodeURI(jQuery("#newaddress textarea[name=zos_stp_email_message]").val());			
			
			stpURI += "&logoImg=";
			stpURI += "<?php echo get_option('zos_stp_logo_image', ''); ?>";
			
			stpURI += "&logoText="
			stpURI += "<?php echo urlencode(get_option('zos_stp_logo_text', '')); ?>";
			
			stpURI += "&logoHref=";
			stpURI += "<?php echo get_option('zos_stp_logo_href', ''); ?>";
			
			stpURI += "&entryBg=";
			stpURI += "<?php echo get_option('zos_stp_field_bgcolor', ''); ?>";
			
			stpURI += "&pageBg=";
			stpURI += "<?php echo get_option('zos_stp_page_bgcolor', ''); ?>";
			window.open(stpURI,'zhiing','resizable=no,scrollbars=no,height=436,width=568,status=yes');
		} else {
			// TODO:
			// handle the from using default javascript, I guess...
			alert('This plugin relies on the default WP jQuery installation.');
		}
	}
//]]>
</script>
<div class="wrap nosubsub">
	<div id="icon-zhiing" class="icon32"><br /></div>
	<h2><?php echo esc_html( $title ); ?></h2>
	
	<form id="newaddress" action="admin.php?page=zos-stp-address-form" method="post" name="newaddress" onsubmit="return CheckForm();">
	<input type="hidden" name="action" value="<?php echo $action; ?>" />

<?php
	if ($address->address_id)
		echo '<input type="hidden" name="zos_stp_address_id" value="' . $address->address_id . '" />';
		
	// TODO:
	// wp_nonce security
?>	
	<div id="poststuff" class="metabox-holder has-right-sidebar">
		<div id="side-info-column" class="inner-sidebar">
			<div id="side-sortables" class="meta-box-sortables ui-sortable">
				<div id="linksubmitdiv" class="postbox ">
					<div class="handlediv" title="Click to toggle"><br></div>
					<h3 class="hndle"><span>Save</span></h3>
					<div class="inside">
						<div class="submitbox" id="submitlink">
							<div id="minor-publishing-actions">
								<div id="preview-action">
									<a id="address-preview" class="preview button" tabindex="4" href="#" onClick="PreviewWindow();"><?php _e('Preview Send-to-Phone Window')?></a><br /><br />
								</div>
							</div>
							<div id="major-publishing-actions">
								<div id="delete-action"></div>
								<div id="publishing-action"><input name="save" class="button-primary" id="publish" tabindex="4" accesskey="p" value="Save Address" type="submit">
								</div>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="post-body">
			<div id="post-body-content">
				<div id="namediv" class="stuffbox">
					<h3><label for="zos_stp_name">Location Name</label></h3>
					<div class="inside">
						<input id="zos_stp_name" type="text" value="<?php echo $address->name; ?>" tabindex="1" size="30" name="zos_stp_name" />
						<p>Example: ZOS Communications Corporate Offices</p>
					</div>
				</div>
				<div id="addressdiv" class="stuffbox">
					<h3><label for="zos_stp_address">Address</label></h3>
					<div class="inside">
						<textarea id="zos_stp_address" tabindex="2" size="30" name="zos_stp_address"><?php echo $address->address; ?></textarea>
						<p>Example: 123 Any Street, Anytown, USA.</p>
						<p>You do not have to use HTML. Ps and BRs will be added automatically just like a Wordpress post.</p>
					</div>
				</div>
				<div id="fromdiv" class="stuffbox">
					<h3><label for="zos_stp_email_from">From</label></h3>
					<div class="inside">
						<input id="zos_stp_email_from" type="text" value="<?php echo $address->email_from; ?>" tabindex="3" size="30" name="zos_stp_email_from" />
						<p>Example: ZOS Communications or zos@zoscomm.com</p>
					</div>
				</div>
				<div id="subjectdiv" class="stuffbox">
					<h3><label for="zos_stp_email_subject">Subject</label></h3>
					<div class="inside">
						<input id="zos_stp_email_subject" type="text" value="<?php echo $address->email_subject; ?>" tabindex="4" size="30" name="zos_stp_email_subject" />
						<p>Example: Meet me at ZOS Communications' Corporate Offices</p>
					</div>
				</div>
				<div id="messagediv" class="stuffbox">
					<h3><label for="zos_stp_email_message">Message</label></h3>
					<div class="inside">
						<textarea id="zos_stp_email_message" tabindex="5" size="30" name="zos_stp_email_message"><?php echo $address->email_message; ?></textarea>
						<p>Example: Meet me here at 1pm.</p>
					</div>
				</div>
				<div id="buttondiv" class="stuffbox">
					<h3><label for="zos_stp_button">Send-to-Phone Button</label></h3>
					<div class="inside">
						<p><label class="selectit" for="zos_stp_button_v1"><input id="zos_stp_button_v1" type="radio" name="zos_stp_button" value="buttonv1" <?php if ($address->stp_button == "buttonv1") echo 'checked="true"'; ?> />&nbsp;<img src="http://images.zoscomm.com/buttonv1.png"  /></label></p>
						<p><label class="selectit" for="zos_stp_button_v2"><input id="zos_stp_button_v2" type="radio" name="zos_stp_button" value="buttonv2" <?php if ($address->stp_button == "buttonv2") echo 'checked="true"'; ?> />&nbsp;<img src="http://images.zoscomm.com/buttonv2.png" /></label></p>
						<p><label class="selectit" for="zos_stp_button_v3"><input id="zos_stp_button_v3" type="radio" name="zos_stp_button" value="buttonv3" <?php if ($address->stp_button == "buttonv3") echo 'checked="true"'; ?> />&nbsp;<img src="http://images.zoscomm.com/buttonv3.png" /></label></p>
						
						<p>This button will be used as the link to the email form.</p>
					</div>
				</div>
			</div><!-- post-body-content -->
		</div><!-- post-body -->
	</div><!-- poststuff -->
<?php
}

return;