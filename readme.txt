=== Card Link Shortcode for Connections ===
Contributors: davidengland  
Tags: connections, shortcode, phone, sms, email, messenger, contact  
Requires at least: 5.0  
Tested up to: 6.5  
Stable tag: 1.4  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html  

A simple shortcode to output a phone, SMS, email, or Facebook Messenger link for a single Connections entry by ID.

== Description ==

The Card Link Shortcode for Connections plugin provides a flexible shortcode to display a contact link (phone, SMS, email, or Facebook Messenger) for a specific [Connections](https://connections-pro.com/) directory entry.

**Features:**
- Outputs a clickable link for phone, SMS, email, or Messenger.
- Customizable link label using template tags.
- Automatically pulls contact info from Connections entry.
- Simple, lightweight, and easy to use.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Make sure the [Connections Business Directory](https://connections-pro.com/) plugin is installed and active.

== Usage ==

Use the `[cardlink]` shortcode in posts, pages, or widgets.

**Examples:**

- `[cardlink id="1" type="phone" format="Call %first%"]`
- `[cardlink id="1" type="sms" format="Text %first%"]`
- `[cardlink id="1" type="email" format="Email %first%"]`
- `[cardlink id="1" type="messenger" format="Message %first% on Messenger"]`

**Shortcode Attributes:**

- `id` (required): Connections entry ID.
- `type`: `phone`, `sms`, `email`, or `messenger` (default: `phone`).
- `format`: Output label. Supports `%first%`, `%last%`, `%phone%`, `%email%`, `%facebookid%`.

== Frequently Asked Questions ==

= Does this require the Connections plugin? =  
Yes, this plugin requires the [Connections Business Directory](https://connections-pro.com/) plugin.

= What if the entry does not have the requested contact info? =  
The shortcode will output "Contact info not available."

= Can I customize the link label? =  
Yes, use the `format` attribute and template tags like `%first%`, `%last%`, etc.

== Changelog ==

= 1.4 =
* Initial public release.

== Upgrade Notice ==

= 1.4 =
First public release.

== License ==

This plugin is free software, released under the GPLv2 or later.
