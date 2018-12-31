# Featured Users

Allows the administrator to make users featured. All it does is give the user a custom meta field called `jsfeatured_user`. Now available are a shortcode, widget, filters, and theme functions.

## Description

While working on a custom WordPress theme we needed the ability to feature users and authors. So we created the ‘Featured users’ plugin which allows the administrator to easily star (feature) users. Then using a custom query in the theme, shortcode or widget; featured users can be displayed by only retrieving users with the custom user meta `jsfeatured_user`. The plugin does not make any changes to your current theme it only does the following:

* Adds a featured column in the Users panel of the WordPress Admin
* When a user is featured the plugin adds or updates the custom field ‘jsfeatured_user’ and sets the value to yes.
* Provides custom widget that echoes out shortcode.
* Provides custom shortcode that echoes ul list of featured users.
* Includes theme functions and filters for developers.

Feel free to use and include in your WordPress Installs, please think of us if you need a custom theme or plugin developed! Use documented code examples on the settings page to modify the expected output.

For WordPress plugin and custom theme development request’s [email us at info@reactivedevelopment.net](mailto:info@reactivedevelopment.net) or [go here](http://www.reactivedevelopment.net/). If you have [questions or requests for this plugin go here](http://wordpress.org/support/plugin/featured-users-wordpress-plugin), [for quick and paid support message us here](https://www.reactivedevelopment.net/contact/project-mind/?plugin=featured-users).

### Installation

1. Visit 'Plugins > Add New'
1. Search for 'Featured Users'
1. Click on 'Install Now'
1. Activate the Featured Users plugin.
1. Go to 'Settings > Featured Users' and modify.

### How to

After activating and after updating the plugin's settings go to wp-admin > Users > All Users and feature a few users. To use the 'Featured Users' plugin edit a page and add the 'Featured Users' shortcode or update a sidebar and add the 'Featured Users' widget.

#### Shortcode Paramaters

[rd-featured-users role="administrator,author" avatar="yes" max="100"]

* role = A comma separated list of roles of trhe users you want to include in the query. Note the settings page can override this. The default is all roles again unless the settings page specifies which to allow.
* avatar = Options are yes or no, specify whether to show or not show the users avatar image. The default is no.
* max = The maximum number of users to display.

#### Filters

WordPress filters allow a 'developer' to modify aspects of the 'Featured Users' plugin without editing the core plugin. If you are not familiar with filters [please read this](https://codex.wordpress.org/Plugin_API) before continuing.

1. 'featured-users-args', https://codex.wordpress.org/Class_Reference/WP_User_Query
1. 'featured-users-css', url to css file
1. 'featured-users-JS', url to js file
1. 'featured-user-shortcode-row', user row in shortcode and widget
1. 'featured-user-shortcode-return', shortcode and widget content

### Frequently Asked Questions

Let us know what questions you have!

### Support

For WordPress plugin and custom theme development request’s [email us at info@reactivedevelopment.net](mailto:info@reactivedevelopment.net) or [go here](http://www.reactivedevelopment.net/). If you have [questions or requests for this plugin go here](http://wordpress.org/support/plugin/featured-users-wordpress-plugin), [for quick and paid support message us here](https://www.reactivedevelopment.net/contact/project-mind/?plugin=featured-users).