<?php

// present the page for setting global STP options
function zos_stp_plugin_options() {
?>
<script type="text/javascript">
//<![CDATA[
	function PreviewWindow() {		
		if (typeof jQuery != 'undefined') {
			// build the url for the preview
			stpURI = "";
			stpURI = "http://zms.zhiing.com/webclient/zhiingchat/zmschat2.aspx?addrTxt=";
			
			stpURI += "&logoImg=";
			stpURI += jQuery("#stp_options input[name=zos_stp_logo_image]").val();
			
			stpURI += "&logoText="
			stpURI += encodeURI(jQuery("#stp_options input[name=zos_stp_logo_text]").val());
			
			stpURI += "&logoHref=";
			stpURI += jQuery("#stp_options input[name=zos_stp_logo_href]").val();
			
			stpURI += "&entryBg=";
			stpURI += jQuery("#stp_options input[name=zos_stp_field_bgcolor]").val();
			
			stpURI += "&pageBg=";
			stpURI += jQuery("#stp_options input[name=zos_stp_page_bgcolor]").val();
			window.open(stpURI,'zhiing','resizable=no,scrollbars=no,height=436,width=568,status=yes');
		} else {
			// TODO:
			// handle the from using default javascript, I guess...
			alert('This plugin relies on the default WP jQuery installation.');
		}
	}
//]]>
</script>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>ZOS Communications Send-to-Phone Settings</h2>
	<p>Use these fields to enhance and customize the look of the send-to-phone window.</p>
	
	<form id="stp_options" method="post" action="options.php">
	<?php settings_fields('zos-stp-settings-group'); ?>
		<table class="form-table">
		<tr valign="top">
			<th><label for="zos_stp_logo_image">Logo Image</label></th>
			<td><input type="text" name="zos_stp_logo_image" value="<?php echo get_option('zos_stp_logo_image'); ?>" class="regular-text code" /><br />
			The URL of a 112 pixel wide x 64 pixel tall image</td>
		</tr>
		<tr valign="top">
			<th><label for="zos_stp_logo_text">Logo Text</label></th>
			<td><input type="text" name="zos_stp_logo_text" value="<?php echo get_option('zos_stp_logo_text'); ?>" class="regular-text code" /><br />
			Text to display in absence of Logo Image</td>
		</tr>
		<tr valign="top">
			<th><label for="zos_stp_logo_href">Logo HREF</label></th>
			<td><input type="text" name="zos_stp_logo_href" value="<?php echo get_option('zos_stp_logo_href'); ?>" class="regular-text code" /><br />
			If Logo Image is specified, it will link to this URL</td>
		</tr>
		<tr valign="top">
			<th><label for="zos_stp_field_bgcolor">Field Background Color</label></th>
			<td><input type="text" name="zos_stp_field_bgcolor" value="<?php echo get_option('zos_stp_field_bgcolor'); ?>" class="regular-text code" /><br />
			Text is dark, so light colors work best. Do not enter the hex (#) symbol.</td>
		</tr>
		<tr valign="top">
			<th><label for="zos_stp_page_bgcolor">Page Background Color</label></th>
			<td><input type="text" name="zos_stp_page_bgcolor" value="<?php echo get_option('zos_stp_page_bgcolor'); ?>" class="regular-text code" /><br />
			Colors close to white work best. Do not enter the hex (#) symbol.</td>
		</tr>
		</table>
	
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			<button type="button" class="button-secondary" onClick="PreviewWindow();"><?php _e('Preview Window Changes') ?></button>
		</p>
	</form>
	
	<div class="zos-credits">
		<p>Installed plugin version: <?php echo ZOS_PLUGIN_VERSION; ?></p>
		<p>Installed database version: <?php echo get_option('zos_stp_db_version'); ?></p>
	</div>
</div>
<?php
}

return;
