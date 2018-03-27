=== Home Page Slideshow ===
Contributors: jethin
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=BUH36ZU4GVA78
Tags: slideshow, gallery, home, front, slider
Requires at least: 3.0
Tested up to: 3.9.1
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create a simple, lightweight, responsive slideshow for your site's home page.

== Description ==

This plugin creates a "Home Slideshow" options page under the "Settings" menu in the WordPress admin. Editors and admins can create and manage individual slides on this page. These slides can then be displayed as a dynamic slideshow on a site's home page using the simple ‘[home_slideshow]’ shortcode. ([View an example slideshow](http://s89693915.onlinehome.us/wp/))

The plugin supports one optional “options” shortcode attribute:

`[home_slideshow options="timeout=5000"]`

*options*: This attribute can be used to override default slideshow options or set custom options. Attribute values use query string format, e.g.: 'option1=value1&option2=value2' etc. Option names are in standard Cycle2 format *without 'data-cycle-' prefix*. [See the Cycle2 website](http://jquery.malsup.com/cycle2/api/#options) for documentation and supported options.

**Notes**

Slides include image (required) and optional title, subtitle and link.

Links and image size can be set when selecting image. (Full size images recommended.)

Slideshows and slides are 100% the width of their container. Upload images that are at least as wide as the slideshow you want them to appear in.

Default Display: Aspect ratio of slideshow image area is set by the first image; images appear at 100% width / height of the slide container; images will show scaling in slideshows that contain both horizontally and vertically aligned images.

Default CSS ids begin with “hss-“, Cycle2 classes with "cycle-". Default slideshow id is "home-slideshow". Default CSS styles were created using Twenty Thirteen theme -- some theme CSS customization may be necessary for other themes.

Slideshows look and perform best if images are sized to desired slideshow container / aspect ratio.

This plugin uses [jQuery Cycle2](http://jquery.malsup.com/cycle2/). Cycle2 may conflict with previous versions of Cycle if used on the same page.

== Installation ==

1. Download and unzip the plugin file.
1. Upload the unzipped ‘home-page-slideshow' directory to your site’s '/wp-content/plugins/' directory.
1. Activate the “Home Page Slideshow” plugin through the 'Plugins' menu in WordPress.

== Screenshots ==

1. The “Home Page Slideshow” settings screen showing individual slides.
2. An “Edit Page” screen with a [home_slideshow] shortcode inserted into the visual editor. This is where the slideshow will be displayed.
3. A screen capture of a home page slideshow in the Twenty Thirteen theme. [View a working slideshow.](http://s89693915.onlinehome.us/wp/)
4. Mobile view (320 x 480px)

== Changelog ==

= 1.2 =
* Minor display improvements

= 1.1 =
* v. 1.0 housecleaning

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.1 =
Added ability to choose image size when selecting images; v 1.0 housecleaning

= 1.2 =
Minor display improvements