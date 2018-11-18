# Changes by Version

Starting with version 0.6.4, this is a list of changes in the self-hosted, open source version of Known.

0.9.9
-----
May 15, 2017

* A simpler user registration experience
* Fixed image preview rotation
* Removed Convoy
* Improved indieweb support
* Improved migration support
* Advanced access control internal API
* Design and layout fixes
* Better error pages
* Support for PHP 7
* Deprecated support for MongoDB
* Countless fixes and speed improvements in the background

0.9.2
-----
April 23, 2016

* Any theme can be single or multi-user
* Improved UI when replying to tweets
* Improved support for non-Latin URLs
* Better audio UI
* Support "delete" webmentions
* Improved support for receiving indieweb RSVPs
* Database speed and efficiency enhancements
* Better support for embedding YouTube videos
* Numerous back-end fixes and improvements

0.9.1
-----
February 20, 2016

* Notifications
* Improved webmention support
* Improved RSS feed import
* Pubsubhubbub now pings the homepage
* Improved MongoDB compatibility
* Fixed a bug with some hashtag links
* Fixed an issue with APC caching detection
* Logging interface is now PSR-3 compatible

0.9.0.4
-------
February 6, 2016

* Improved user registration page and onboarding flow
* Cleaned up some text pages
* Fixed an issue where you couldn't change back to the default theme
* Fixed a compatibility issue with Photos on PHP 5.4
* Removed an EXIF error message
* Retroactive POSSE
* MongoDB fix for newer MongoDB versions
* Updated diagnostics
* Ability to shush notifications from certain domains
* Minor default theme style changes

0.9
---
February 2, 2016

* Significantly faster performance
* Twitter card support
* Support for non-Latin characters in post URLs and hashtags
* Character count in status updates is now safe for Twitter URLs
* Choose between a number of permalink URL styles
* Export RSS for import into WordPress
* Import WordPress comments
* Improved search
* Improved autosave
* Improved bookmarks and bookmarklet
* Improved indiepub and webmention functionality
* Improved notifications
* Navigation style fixes
* Reliability improvements when posting long pieces
* Fixed an issue where pressing "cancel" could close the window
* Syndicated photos no longer list "untitled" in syndicated version when title is not set

0.8.5
-----
October 13, 2015

* Experimental AMP support! See http://ampproject.org for more details
* Better support for embedded content
* A slew of indieweb improvements, including upgraded micropub support for actions like likes and reshares
* A command line tool (with extensible plugin interface) to automatically create a config.ini file, among other things
* Themes now take template precedence over plugins - so a theme can create a new style for a plugin-provided feature
* Known now works better under FastCGI on some shared hosts
* Lots of API fixes and consistency changes under the hood

0.8.4
-----
September 28, 2015

* See who you've invited to Known, and resend or rescind invitations
* Hashtag linking improvements
* Added support for SIP, Bitcoin and Spotify profile fields
* SVG upload support
* Numerous interface improvements
* Fixed aggressive caching of Known posts
* Assorted API fixes and improvements
* Introduced HTML purifier component
* Webmentions no longer strip HTML

0.8.3.1
-------
August 19, 2015

* Fixing a bug with account settings

0.8.3
-----
August 18, 2015

* Block users by email address
* Fixes a bug with per-item access permissions in location check-ins
* Improved Convoy display for syndicated content
* Most content types now have a rich text editor
* Improved brid.gy interactions
* Improved audio player display
* Improved RSS feed display
* Fixed an issue with saving configuration
* Experimental Postgres support
* Such dogeon support so removed wow

0.8.2
-----
July 22, 2015

* Fixes a bug with pagination in subdirectory installations
* Experimental support for SQLite as a database engine

0.8.1
-----
July 21, 2015

* Corrected an issue with subdirectory installations

0.8
---
July 21, 2015

It's been a while! Additions and fixes include:

* Per-site access permissions. Want to keep just this one post private? Now you can.
* Much better accessibility for screen readers and mobility-impaired users.
* The bookmark tool handles page titles more intelligently.
* Support for non-Latin characters in hashtags.
* You can reply to multiple Twitter accounts more easily.
* The public comment form is more robot-proof.
* An upgraded, all-new interface framework using Bootstrap 3 and the latest Font Awesome fonts.
* You can now install Known in a subdirectory.
* The installer now does more checking to make sure you have the right server configuration.
* A handy diagnostics tool to give you more information if something's gone wrong with your installation.
* Developers have access to more tests.

0.7.8.5.1
---------
May 16, 2015

* Correcting an issue with accented characters in page slugs

0.7.8.5
-------
May 16, 2015

* Better tag support, including for short tags
* Fixed an issue with hashtags containing numbers
* Native MongoDB notifications
* Improved brid.gy integration
* Fixed issue with login forwarding on walled garden sites

0.7.8
-----
May 4, 2015

* Hashtags now handle unicode character sets
* Improved PubSubHubbub handling
* Installation now detects rewrite rule support more reliably
* Sessions do not persist between http and https
* Site URL in public comments is now optional
* Better mobile Twitter URL support
* Internal web client is more configurable
* Object annotations are included in JSON
* Bookmarks syndicate to Twitter
* Included tweets auto-embed in status updates
* Includes Vagrant and Ansible configuration files

0.7.7.1
-------
April 10, 2015

* Corrected brid.gy connection flow

0.7.7
-----
April 9, 2015

* More consistent publishing flow
* Introducing Convoy for easier social media connections
* Faster database access for some tasks
* Introducing getStaticURL for static resources (eg for use with CDNs)

0.7.6
-----
March 31, 2015

* Better bookmark page title handling (again!)
* Improved session handling
* Thumbnails are higher quality
* Further improvement to Open Graph tag handling
* Improvement to PubSubHubbub HTTP headers
* A number of fixes across plugins
* Experimental release of WordPress importer

0.7.5
-----
March 2, 2015

* Better bookmark page title handling
* Improved username matching
* Improved email handling
* Exports better SQL
* Import from external blogging platforms like Blogger
* Source code highlighting
* Simpler link to brid.gy
* More efficient user session handling
* Better syndication workflow
* Improved open graph tag handling

0.7.1
-----
February 8, 2015

* Improved support for root-level domains
* Fixed bug with HTML pasted from other sources

0.7
---
January 31, 2015

* Infinite accounts per syndication service
* Static pages
* Webhooks
* Improved interface when AdBlock Plus is used
* Changed rich text editor to TinyMCE
* Introducing the Uploads folder, for easier installation / configuration
* Introducing prerequisite plugins, which are always loaded first
* Webmention client now uses internal web services API
* Improved export format
* Improved session user storage
* Numerous internal API and interface improvements

0.6.5
-----
November 24, 2014

* API improvements
* Cleaner hashtag and username parsing
* PubSubHubbub implemented by default
* KML output template
* Delete users from the user admin panel
* Better button behavior when saving content
* Authentication can be overridden and extended by plugins
* Framework for syndicating to multiple accounts on the same service
* Installer is more compatible with shared hosts like Arvixe (and easier overall)
* More compatible with sites that switch to using HTTPS
* Better compatibility with brid.gy
* Better compatibility with Amazon Elastic Beanstalk
* .htaccess is more compatible with a wider range of hosts

0.6.4
-----
October 27, 2014

* Export your data
* Improved session handling, particularly for MongoDB installations
* .htaccess is now more compatible with shared hosts like Dreamhost and GoDaddy
* Fewer system requirements for installation
* No need for 'http://' in profile URLs
* Improved Micropub support
* More efficient file interface
* Some style improvements, particularly with input fields
* Bookmarklet now opens in a new page
* Removed humans.txt
* More traditional array and other internal syntax
* Additional stability and speed improvements

0.6.3
-----
September 23, 2014
