=== Links With Icons Widget ===
Contributors: ethanpil
Tags: widget, widgets, link widget, icons, link with icon, icon link, links with icons, link, icon, link icon, link image, image, uploader, widget image, icon and link, nofollow
Requires at least: 3.0
Tested up to: 3.8
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A widget to display links with icons alongside.

== Description ==

Links With Icons Widget adds a new custom widget which displays links with icons alongside. The links are dynamically added to each widget in the widget admin. This plugin does not use the links manager and does not create any custom post type to store the links. All data is self contained in each widget as widget option data. Images are added and managed using the media library and uploader.


Usage:

1. In the WordPress admin, go to Appearance...Widgets
2. Drag the "Links With Icons" widget to a sidebar
3. Select the number of links the widget will display and save the widget.
4. The widget will reload with the proper number of fields for the number of links needed.
5. Fill out the data (URL, Title and Image) and save the widget.
6. Viola! The widget now appears with your pretty icons.

Important Notes:

1. The widget doesn't care about icon / image size. You should probably keep it consistent (and small) so it will be pretty.
2. If you reduce the number of links in a widget after it has been populated with data, the excess links data will be deleted forever.
3. The default CSS class for the container UL is links-with-icons-widget
4. Each link li has a class of link-with-icon
5. You can style and override the defaults in your own custom css, like:

`
.links-with-icons { /* custom styles */ }
.link-with-icon a { /* custom styles */ }
.link-with-icon img { /* custom styles */ }
etc...
`
	 
Fork away: https://github.com/ethanpil/wp-links-with-icons-widget

Future Plans:

1. Display the size of selected image in the widget under the preview
2. Choose icon position for each link (left (default) or right side)

== Installation ==

Like every other Wordpress plugin! :)

1. Upload all the files from links-with-icons-widget.zip into a folder within the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

1.  The link doesn't work! Its showing a 404 error!
    Don't forget to add http:// to your link.

2.  What if I decrease the number of links in a widget?
    The excess links will be removed and the data deleted.
	
== Screenshots ==

1. Managing links inside the widget
2. Example Widget Output

== Changelog ==

= 1.1 =

* Added option for No Follow links
* Image URLs are now returned without protocol to support HTTP or HTTPS

= 1.0 =

* Initial Release