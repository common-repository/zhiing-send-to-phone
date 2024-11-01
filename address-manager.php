<?php

// TODO:
// implement bulk deletes

function zos_stp_address_list() {
	if (!current_user_can('edit_posts') )
		wp_die(__("You do not have sufficient permissions/privileges to edit the Addresses for this site."));
		
	$title = __('ZOS Send-to-Phone Addresses');
?>
<div class="wrap nosubsub">
	<div id="icon-zhiing" class="icon32"><br /></div>
	<h2><?php echo esc_html( $title ); ?> <a href="admin.php?page=zos-stp-address-form&action=new" class="button add-new-h2"><?php echo esc_html_x(__('Add New'), 'link'); ?></a></h2>
<?php
	$addresses = zos_get_addresses();
	
	if ($addresses) {
		// TODO:
		// not very DRY.
		// if we get more columns, we probably want a function.
?>
	<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th id="cb" class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
			<th id="name" class="manage-column column-name" scope="col"><?php _e('Name'); ?></th>
			<th id="address" class="manage-column column-address" scope="col"><?php _e('Address'); ?></th>
			<th id="button" class=manage-column column-button" scope="col"><?php _e('Test Button'); ?></th>
			<th id="address" class="manage-column column-id" scope="col"><?php _e('Shortcode'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th id="cb" class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
			<th id="name" class="manage-column column-name" scope="col"><?php _e('Name'); ?></th>
			<th id="address" class="manage-column column-address" scope="col"><?php _e('Address'); ?></th>
			<th id="button" class=manage-column column-button" scope="col"><?php _e('Test Button'); ?></th>
			<th id="address" class="manage-column column-id" scope="col"><?php _e('Shortcode'); ?></th>
		</tr>
	</tfoot>
	<tbody>
<?php
		$alt = 0;
	
		foreach ($addresses as $address) {
			$style = ($alt % 2) ? '' : ' class="alternate"';
			++ $alt;		
?>	
		<tr id="address-<?php echo $address->address_id; ?>"  valign="middle" <?php echo $style; ?>>
			<th class="check-column" scope="row"><input type="checkbox" value="<?php echo $address->address_id; ?>" name="addresscheck[]"></th>
			<td class="column-name"><strong><a class="row-title" href="admin.php?page=zos-stp-address-form&action=edit&address_id=<?php echo $address->address_id; ?>"><?php echo $address->name ?></a></strong><br />
				<div class="row-actions">
					<span class="edit"><a href="admin.php?page=zos-stp-address-form&action=edit&address_id=<?php echo $address->address_id; ?>"><?php _e('Edit'); ?></a></span> |
					<span class="delete"><a class="submitdelete" href="<?php echo wp_nonce_url("admin.php?page=zos-stp-address-form&amp;action=delete&amp;address_id=$address->address_id", 'delete-address_' . $address->address_id ); ?>" onclick="if ( confirm('<?php echo esc_js(sprintf( __("You are about to delete this address '%s'\n  'Cancel' to stop, 'OK' to delete."), $address->address_name )) ?>') ) { return true; } return false;"><?php _e('Delete'); ?></a></span>
				</div></td>
			<td class="column-address"><?php echo wpautop(wp_filter_nohtml_kses($address->address)) ?></td>
			<td><?php echo(do_shortcode('[send_to_phone address_id=' . $address->address_id . ' show_address=0 /]')); ?></td>
			<td class="column-id"><?php echo '[send_to_phone address_id=' . $address->address_id . ' /]' ?></td>
		</tr>
<?php	} ?>
	</tbody>
	</table>
<?php
	} else {
?>
	<p><?php _e( 'No addresses found.' ) ?></p>
<?php
	}
}

return;