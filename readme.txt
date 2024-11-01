=== Plugin Name ===
Contributors: devonl, ZOSComm
Tags: maps, mobile, navigation, shortcode, zhiing
Requires at least: 2.1.0
Tested up to: 3.0.1
Stable tag: 1.0.1

The Send-to-Phone plugin adds a button next to addresses on your site enabling the location, and point-to-point directions to be sent to a phone

== Description ==

The zhiing Send-to-Phone technology by ZOS Communications creates a browser-to-mobile, mobile-to-browser instant messaging interface with embedded location information.

ZOS Communications provides a send-to-mobile / send-to-email widget for Wordpress that can be placed next to any physical address on Posts, Pages, Widgets, or directly within PHP code, which enables that location to be sent to a phone.

When site visitors click on the send to mobile / email button a utility window opens. Users enter mobile numbers and/or emails and receive a pre-programmed message with a map route to the address.

== Installation ==

Activating and implementing the Send-to-Phone plugin tries to be straight-forward. Please follow the directions below:

1. Upload `zhiing-send-to-phone` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set global options under `Settings >> Send-to-Phone`
4. Create an address in the Send-to-Phone Address Book
5. Add `[send_to_phone address_id=XX /] shortcode to your post where XX is the id of the address you created
6. Read the documentation about how to use the extended features of the `[send_to_phone]` shortcode

== Frequently Asked Questions ==

Our documentation contains a set of FAQs that is updated more frequently than the plugin itself. Please refer to the documentation for frequently asked questions.

== Screenshots ==

1. An example of the zhiing Send-to-Phone location button next to an HTML street address embeded in a Post.
2. Creating an address in the zhiing Send-to-Phone address book.
3. The zhiing Send-to-Phone plugin lets you brand the utility window with your look-and-feel.
4. The zhiing Send-to-Phone address book stores addresses for use in multiple locations on the site, and provides testing and cut-and-paste shortcodes for quick integration into your content.

== Changelog ==

= 1.0.1 =
* Updated documentation

= 1.0 =
* Author can override global options within a shortcode
* Author can override options associated with an Address within a shortcode
* Add/Edit screen has a "preview" button
* Streamlined plugin architecture and improved code organization.
* Administrator can preview global window changes from the Settings page.
* Administrator can copy default shortcode for a given address from the Address list/Plugin home screen to paste into Posts/Pages.
* Add/Edit address form now shows button images and a radio button.
* Author can create, edit and delete Addresses from the database
* Author can embed shortcode with address_id parameter into Post that reads address from the database, embeds the address and the Send-to-Phone button in a post.
* Author can test button in administration screen (address list) prior to adding to a post.
* Author can hide or show address next to button using shortcode. Defaults to "show."
* Administrator can set global options for the following STP parameters: Logo Image, Logo Text, Logo HREF, Field Background Color, Page Background Color.
* Author can view Addresses using the "Manage >> Addresses" tab in the admin UI.
* Deleting the zhiing Send-to-Phone plugin from the Wordpress installation follows best practices by deleting all data from database and removing all files.
* Administrator can Activate and Deactivate zhiing Send-to-Phone plugin.
* Author can use a Wordpress shortcode to embed Address information and the Send-to-Phone button in a post.
* Author can use an enclosing Wordpress shortcode to embed the Send-to-phone button next to an Address in a post.
