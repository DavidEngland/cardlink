# Card Link Shortcode for Connections

A simple WordPress plugin that outputs a phone, SMS, email, or Facebook Messenger link for a single [Connections Business Directory](https://connections-pro.com/) entry by ID.

## Features

- Outputs a clickable link for phone, SMS, email, or Messenger.
- Customizable link label using template tags.
- Automatically pulls contact info from Connections entry.
- Lightweight and easy to use.

## Installation

1. Upload the plugin folder to your WordPress site's `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Ensure the [Connections Business Directory](https://connections-pro.com/) plugin is installed and active.

## Usage

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

## FAQ

**Q: Does this require the Connections plugin?**  
A: Yes, this plugin requires the [Connections Business Directory](https://connections-pro.com/) plugin.

**Q: What if the entry does not have the requested contact info?**  
A: The shortcode will output "Contact info not available."

**Q: Can I customize the link label?**  
A: Yes, use the `format` attribute and template tags like `%first%`, `%last%`, etc.

## License

GPLv2 or later. See [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) for details.

---

**Author:** David E. England, Ph.D.
