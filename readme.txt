=== Featured Users ===
Contributors: jeremyselph
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=RESFMU9LDAEDQ&source=url
Tags: users, featured
Requires at least: 3.1.1
Tested up to: 5.0
Requires PHP: 5.6
License: GPL v3
License URI: http://www.gnu.org/licenses/gpl-3.0.en.html

Allows the administrator to make users featured. All it does is give the user a custom meta field called `jsfeatured_user`. Now available are a shortcode, widget, filters, and theme functions.

== Description ==

While working on a custom WordPress theme we needed the ability to feature users and authors. So we created this ‘Featured users’ plugin which allows the administrator to easily star (feature) users. Then using a custom query in the theme, shortcode or widget; featured users can be displayed by only retrieving users with the custom user meta `jsfeatured_user`. The plugin does not make any changes to your current theme it only does the following:

* Adds a featured column in the Users panel of the WordPress Admin.
* When a user is featured the plugin adds or updates the custom field ‘jsfeatured_user’ and sets the value to yes.
* Provides custom widget that echoes out shortcode.
* Provides custom shortcode that echoes ul list of featured users.
* Includes theme functions and filters for developers.

Feel free to use and include in your WordPress Installs, please think of us if you need a custom theme or plugin developed! Use documented code examples on the settings page to modify the expected output.

== Installation ==

1. Visit 'Plugins > Add New'
1. Search for 'Featured Users'
1. Click on 'Install Now'
1. Activate the Featured Users plugin.
1. Go to 'Settings > Featured Users' and modify.

== How to ==

After activating and after updating the plugin's settings go to wp-admin > Users > All Users and feature a few users. To use the 'Featured Users' plugin edit a page and add the 'Featured Users' shortcode or update a sidebar and add the 'Featured Users' widget.

== Shortcode Paramaters ==

[rd-featured-users role="administrator,author" avatar="yes" max="100"]

* role = A comma-separated list of roles of the users you want to include in the query. Note the settings page can override this. The default is all roles again unless the settings page specifies which to allow.
* avatar = Options are yes or no, specify whether to show or not show the users' avatar image. The default is no.
* max = The maximum number of users to display.

== Filters ==

WordPress filters allow a 'developer' to modify aspects of the 'Featured Users' plugin without editing the core plugin. If you are not familiar with filters [please read this](https://codex.wordpress.org/Plugin_API) before continuing.

1. 'featured-users-args', [https://codex.wordpress.org/Class_Reference/WP_User_Query](https://codex.wordpress.org/Class_Reference/WP_User_Query)
1. 'featured-users-css', url to css file
1. 'featured-users-JS', url to js file
1. 'featured-user-shortcode-row', user row in shortcode and widget
1. 'featured-user-shortcode-return', shortcode and widget content

== Frequently Asked Questions ==

Let us know what questions you have!

== Support ==

For custom WordPress plugin and theme development requests email us at [info@reactivedevelopment.net](mailto:info@reactivedevelopment.net) or go to [https://www.reactivedevelopment.net/](https://www.reactivedevelopment.net/). If you have questions or requests for this plugin go to [http://wordpress.org/support/plugin/featured-users-wordpress-plugin](http://wordpress.org/support/plugin/featured-users-wordpress-plugin) or for quick and paid support go to [https://www.reactivedevelopment.net/contact/project-mind/?plugin=featured-users](https://www.reactivedevelopment.net/contact/project-mind/?plugin=featured-users) to message us.

== Screenshots ==

1. screenshot-1.jpg
1. screenshot-2.jpg
1. screenshot-3.jpg
1. screenshot-4.jpg

== Changelog ==

= 2.1 =

Release Date: 2019/01/14

* Updated settings page content, see inc/settings.php. Updated readmes as well.

= 2.0 =

Release Date: 2018/12/31

* Finished 2.0 development, testing and documentation.

= 1.6 =

Release Date: 2018/12/17

* Added new functions rd_is_user_featured() and rd_featured_users()

= 1.5 =

Release Date: 2018/12/17

* Re-developed by, Jeremy Selph http://www.reactivedevelopment.net/							

= 1.0 =

* Released to WordPress.

= 0.1 =

* initial plugin development by, Jeremy Selph http://www.reactivedevelopment.net/