=== Video Thumbnailer for Elementor  ===

Contributors: StuckOn_dev, nickarkell

Tags: elementor, vimeo, youtube, video

Requires at least: 5.0

Tested up to: 6.2

Requires PHP: 5.6

Stable tag: 1.2.8

License: GPLv2 or later

License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically add thumbnails to YouTube and Vimeo videos added with Elementor.

== Description ==

Video Thumbnailer for Elementor is a simple add-on plugin for Elementor, pulling in the thumbnails for any YouTube or Vimeo videos embedded into pages or posts via Elementor.

The plugin removes the need to manually select and add a thumbnail image in Elementor when adding a video. Instead, the plugin will automatically pull in the image that has been set as the thumbnail on either YouTube or Vimeo.

It performs two main tasks:

- Find any videos that have the image overlay set to show, but do not have an image set, and it resets the media field for the image back to default instead of being blank.

- Add a switch in the image overlay section of videos in the Elementor editor called ‘Auto Thumbnail’. If it is switched on, and the video is from Vimeo or YouTube, the thumbnail is pulled in automatically on the frontend for that video. If a thumbnail is set for that video in Elementor, it will be ignored if ‘Auto Thumbnail’ is on.

We have developed and continue to maintain this free plugin but if you have found it useful and wish to contribute towards our development costs at Engage Web, donating via PayPal is safe, fast and easy via a button on the plugin settings page. Thank you!

== Installation ==

1. Upload `video-thumbnailer-for-elementor` folder to the `/wp-content/plugins/` directory.

2. Activate the plugin through the 'Plugins' menu in WordPress.

3. You can set automatic thumbnail to be on by default for all Elementor videos across the website. This will only work for videos where you have no yet switched Automatic Thumbnail on or off for that video in Elementor yet. Go to Settings -> Video Thumbnailer for Elementor in the WordPress Dashboard and set 'Default to on or off' to 'Default On'. If you are using caching, you may need to clear the cache on any pages that contain Elementor videos to reflect the change.

4. For individual videos, open the settings for a video in the Elementor editor, go to the Image Overlay section and switch 'Automatic thumbnail' on or off for that video.

== Frequently Asked Questions ==

= Does this work with other embedded videos eg. through HTML snippets?

Not currently but it is a possibility for future development.

== Screenshots ==

1. screenshot-1.png shows the automatically thumbnailed videos in situ.

== Changelog ==

= 1.0.1 =

Corrected code to prevent a potential error when installing the plugin before having Elementor installed

= 1.1.0 =

Added a new switch both in the main settings (and also for individual videos), allowing the user to select whether they are cropped or resized to fit with black bars filling any blank space.

= 1.2.0 =

Updated settings page and added donation option

= 1.2.1 =

Stopped square-like thumbnails repeating horizontally and added black background to fill the blank space

= 1.2.2 =

Change background colour CSS line to ensure it only applies to this plugin

= 1.2.6 =

Fix PHP error

= 1.2.7 =

Update readme.txt

= 1.2.8 =

Fixed minor PHP error