=== Twitcasting Status ===
Contributors: katz515
Plugin Name: Twitcasting Status
Plugin URI: http://katzueno.com/wordpress/twitcasting-status/
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=TYQTWQ7QGN36J
Author: Katz Ueno
Author URI: http://katzueno.com/
Tags: livecasting, status, twitcasting, twitter, facebook
License: GPL2
Requires at least: 2.8.0
Tested up to: 4.3
Stable tag: 2.0.0

Display the online/offline status of a Twitcasting channel.

== Description ==

"Twitcasting Status" is a widget and shortcode plug-in to display the live/offline status of a Twitcasting channel, using the images.

Enter a Twitcasting (Twitter) ID, and it will fetch the online/offline status. Then it will display the online/offline status images of your choice.

Twitcasting is the light-weight easy live casting service from your iPhone or Android using your Twitter or Facebook login. No registration is required. You can start the live cast right away.

Check out the demo at (although you only see it when I'm live.)
http://katzueno.com/

I'm looking for your feedback! Please contact me via my website
or @katz515 on twitter.

Fork me on GitHub. Pull Requests are always welcome!
https://github.com/katzueno/TwitcastingStatus-WordPress

Plug-in Support Page
http://katzueno.com/wordpress/twitcasting-status/

Also check out my other WordPress plugins
http://katzueno.com/wordpress/


== Installation ==

How to install and use it

= Installation =

1. Upload `twitcasting-status` folder to the `/wp-content/plugins/` directory or you can install from admin panel directly.
1. Activate the plugin through the 'Plugins' menu in WordPress

= Preparation =

1. Create Twitcasting account (if you haven't done so)
1. Upload two (2) images which indicates online and offline status

= Create a widget =

1. Go to `Theme` - `Widget` and set up your Twitcasting ID and enter the image URLs
1. Save

= Insert a shortcode =

Enter the shortcode as following format

[twitcasting-status channel="Account Name" online="Online Image URL" offline="Offline Image URL"]

- Account Name: Enter the channel name (Or you can enter the full URL of a Twitcasting page)
- Online Image URL: Enter the full path to the online image.
- Offline Image URL: Enter the full path to the online image.

Shortcode Example:

[twitcasting-status channel="yokosonews" online="http://example.com/yokoso_online.gif" offline="http://example.com/yokoso_offline.gif"]

This plugin uses cache. You may have to wait for 60 seconds until you see the channel becomes live or offline. Please be patient!


== Frequently Asked Questions ==

= What do I need? =

In addition to WordPress site, you need to sign-up at Twitcasting.tv and start live casting.

= How do I sign up for Twitcasting? =

Click LOGIN icon from Twitcasting.tv using your Twitter or Facebook account

= I don't have any images for offline/online images =

You need to make your own images. I may make preset later if you ask me so.

= I'm live. But my status won't change. =

First, wait for 60 seconds. Twitcasting Status uses cache. It only check the live/offline status once a min.

If you don't see the change os status after 60 seconds you become live, you may have misspelled your Twitcasting ID, your WordPress site may be having hard time reaching Twitcasting Server, or your IP may be blocked from Twitcasting Server.

= How can I check if Twitcasting server is working or not? =

In order to check if Twitcasting service itself is working or not, you could directly ping their server by going to

http://api.twitcasting.tv/api/livestatus?type=jason&user=XXXXXXXXXXX

Replace the last "X" to your account ID (e.g., YokosoNews) when you're live. You should be able to see "islive":true in your browser.

If you're still having problem getting the status, you can think of the following situation

- You mistyped your Twistcasting ID (Twitter ID)
- You mistyped the wrong URL of images
- Twitcasting Server may be having some problem.
- Your WordPress server may be blocked by Twitcasting Server



== Screenshots ==

1. Setting menu at the widget

1. Twitcasting Status in action

== Changelog ==

= 2.0.0 =

* Added the support multiple accounts to display their status.
* Added the support for shortcode.
* Tested up to Version 4.3

= 1.0.1 =

* fixed the bug that not showing the Twitcasting title

= 1.0.0 =

* Adding the cache (by using Transient API)

= 0.9.1 =
* Fixing the file structure

= 0.9.0 =
* The initial version. This is in beta but it should work ok.

== Upgrade Notice ==

= 2.0.0 =

* Added the support multiple accounts to display their status.
* Added the support for shortcode.

= 1.0.1 =

Fixed minor bug. Added cache so that the large scale WordPress site can now enjoy the live status. Twitcasting Status is now calling once per min. Your status may remain online/offline max. 1 min.

= 1.0.0 =

Added cache so that the large scale WordPress site can now enjoy the live status. Twitcasting Status is now calling once per min. Your status may remain online/offline max. 1 min.

= 0.9.1 =

If you've installed 0.9.0, you may have to move the files from `/wp-content/plugins/twitcasting-status/twitcastingstatus/` to `/wp-content/plugins/twitcasting-status/` manually using FTP. This is the mistake from the author who didn't get used to their SVN system. Sorry about that.

= 0.9.0 =

This is initial version.
