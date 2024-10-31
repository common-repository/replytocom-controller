=== Replytocom Controller ===
Contributors: claytonl
Tags: replytocom, bandwidth saving, duplicate content, seo, bots, comments
Requires at least: 2.7
Tested up to: 3.5.1
Stable tag: 1.2

Replytocom Controller lets remove "?replytocom" from comment reply urls and redirect bots who try to use it anyway.

== Description ==
Hate duplicate content? Hate wasting server resources?

Replytocom Controller gives you the option to remove "?replytocom" from comment urls and optionally redirect visitors & bots who try to use it anyway to a destination of your choice.

For those concerned about duplicate content for SEO purposes, the benefits should be obvious.

If you want to speed up your Wordpress server, the redirection will let you stop wasting resources serving up the same page over and over again to a crawler bot. Even worse, pages with a question mark in the url aren't typically cached by caching plugins like WP Super Cache. That means that those bot crawls are eating up way more resources then a normal url would. Now you can send them to a cached copy of that page, a less resource intensive page, or any other url.

Of course, the cost of all this is that visitors can't have JavaScript turned off if they want to leave replies in threaded comments.

Borrows code from:
* http://wordpress.org/extend/plugins/all-in-one-seo-pack/
* http://wordpress.org/extend/plugins/replytocom-redirector/

== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings->Replytocom Controller if you want to override default settings

== Changelog ==
= 2016/12/11 - 1.2 =
 * Fixed parse error php < 5.4
= 2016/12/10 - 1.1 =
 * Brought code up to date
= 2013/03/20 - 1.0 =
 * Initial release
