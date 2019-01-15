<?php /**
 *
 * @package Featured Users
 * @subpackage settings.php
 * @author Jeremy Selph <jselph@reactivedevelopment.net>
 * @link http://www.reactivedevelopment.net/
 * @license GPLv3
 * @version 0.2

    Change Log

     * 0.2  Updated page content text, needed proof-reading and added shortode example.                 2019/01/15
     * 0.1 	initial plugin development by, Jeremy Selph http://www.reactivedevelopment.net/ 		    2018/12/17

    Plugin Class

     * @package featuredUsersSettings
     * @author Jeremy Selph <jselph@reactivedevelopment.net>
     * @version 0.1
     * @access public
    */
	class featuredUsersSettings extends rdFeaturedUsers {

        /**
         * @package __construct
         * @author Jeremy Selph <jselph@reactivedevelopment.net>
         * @version 0.1
         * @access public
        */
        public function __construct(){

            parent::__construct( true );

            /**
             * Populate settings
             * @author Jeremy Selph <jselph@reactivedevelopment.net>
             * @since 0.1
            */
            $this->_settings = get_option( $this->_option_name );
            
			/**
             * Actions/Filters
             * @author Jeremy Selph <jselph@reactivedevelopment.net>
             * @since 0.1
            */
            add_action( 'admin_init', array( $this, 'register_options' ) );
            add_action( 'admin_menu', array( $this, 'add_page' ) );
            add_action( 'admin_head', array( $this, 'add_featured_settings_css' ) );
            add_filter( 'plugin_row_meta', array( $this, 'settings_link' ), 5, 2 );

        }

	    /**
		 * @package register_options
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
        public function register_options(){

            register_setting( $this->_option_name . '-options', $this->_option_name );

        }

	    /**
		 * @package settings_link
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
        public function settings_link( $plugin_meta, $plugin_file ){
			if ( $this->_plugin_base === $plugin_file ){

				$plugin_meta[] = sprintf(
					'<a href="%s">%s</a>',
					admin_url( 'options-general.php?page=rd-featured-users' ),
					esc_html__( 'Settings' )
				);

			} return $plugin_meta;
		}

	    /**
		 * @package add_featured_settings_css
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
	    public function add_featured_settings_css(){
            if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'rd-featured-users' ){
                
              ?><style type="text/css">
                    .rdLogo{ display: inline-block; }
                    .rdLogoImg{ max-width: 90%; height: auto; }
                    .supportImg{ max-width: 100%; height: auto; }
                    #rd_feat_settings{ }
                    #rd_feat_settings td{ width: 70%; }
                    #rd_feat_settings td.row-title{ width: 30%; }
                    #rd_feat_settings td select{ width: 70%; }
                    #rd_feat_settings td span{ display: inline-block; }
                    code{  }
                    code span{ display: inline-block; }
                    code span.tab{ margin: 0 0 0 2em; }
                </style><?php

            }             
		}
        
        /**
         * @package page_content
         * @author Jeremy Selph <jselph@reactivedevelopment.net>
         * @version 0.2
         * @since 0.1
         * @access public
        */
        public function page_content(){

          ?><div class="wrap">

                <div id="icon-options-general" class="icon32"></div>
                <h1><?php _e( 'Featured Users' ) ?></h1>
            
                <div id="poststuff"><div id="post-body" class="metabox-holder columns-2"><div id="post-body-content">

                    <!-- How to -->
                    <div class="meta-box-sortables ui-sortable"><div class="postbox">    
                        <div class="inside">

                            <p><?php _e( 'While working on a custom WordPress theme we needed the ability to feature users and authors. So we created this ‘Featured users’ plugin which allows the administrator to easily star (feature) users. Then using a custom query in the theme, shortcode or widget; featured users can be displayed by only retrieving users with the custom user meta `jsfeatured_user`. The plugin does not make any changes to your current theme it only does the following:' ); ?></p>
                            <ol>
                                <li><?php _e( 'Adds a featured column in the Users panel of the WordPress Admin.' ); ?></li>
                                <li><?php _e( 'When a user is featured the plugin adds or updates the custom field ‘jsfeatured_user’ and sets the value to yes.' ); ?></li>
                                <li><?php _e( 'Provides custom widget that echoes out shortcode.' ); ?></li>
                                <li><?php _e( 'Provides custom shortcode that echoes ul list of featured users.' ); ?></li>
                                <li><?php _e( 'Includes theme functions and filters for developers.' ); ?></li>
                            </ol>

                            <p><?php _e( 'Feel free to use and include in your WordPress Installs, please think of us if you need a custom theme or plugin developed! Use documented code examples on the settings page to modify the expected output.' ); ?></p>
                        
                        </div>    
                    </div></div>
                    
                    <!-- Settings -->
                    <div class="meta-box-sortables ui-sortable"><div class="postbox">    
                        <h2><span><?php _e( 'Settings' ); ?></span></h2>            
                        <div class="inside">

                            <p><?php _e( 'Use the form below to hide the settings page form the WordPress admin menu and to choose what roles are allowed to be featured.' ); ?></p>
                            <form action="options.php" method="post" id="rd_feat_settings">

                                <p class="submit"><input type="submit" id="submit1" class="button delete" value="<?php _e( 'Save Settings' ); ?>"></p>
                                
                                <?php settings_fields( $this->_option_name . '-options' ); ?>
                                <table class="widefat">
                                    <tbody>
                                        
                                        <tr class="alternate">
                                            <td class="row-title"><label for="<?php echo $this->_option_name; ?>[feat_hide]"><?php _e( 'Hide featured users page' ); ?>:</label></td>
                                            <td><input type="checkbox" value="yes" name="<?php echo $this->_option_name; ?>[feat_hide]"<?php 
                                                if( esc_attr( $this->_settings[ 'feat_hide' ] ) == 'yes' ){ ?> checked="checked"<?php } 
                                                    ?>> <span><?php _e( 'Check to hide this settings page' ); ?>.</span></td>
                                        </tr>
                                        <tr>
                                            <td class="row-title"><label for="<?php echo $this->_option_name; ?>[feat_role]"><?php _e( 'Roles of users that can be featured' ); ?>:</label></td>
                                            <td>
                                                <select multiple="multiple" name="<?php echo $this->_option_name; ?>[feat_role][]" id="rd_feat_role">
                                        <?php   $roles = $this->_settings[ 'feat_role' ];
                                                $editable_roles = array_reverse( get_editable_roles() );
                                                foreach ( $editable_roles as $role => $details ){
                                                    
                                                    $key = esc_attr( $role );
                                                    $name = translate_user_role( $details['name'] );
                                                    $checked = ( in_array( $key, $roles ) ) ? ' selected="selected"' : '';
                                                    echo '<option value="' . $key . '"' . $checked . '>' . $name . '</option>';
                                                    
                                                } ?>
                                                </select>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table><br />

                                <input type="submit" id="submit2" class="button-primary" value="<?php _e( 'Save Settings' ); ?>">

                            </form>

                        </div>    
                    </div></div>
                    
                    <!-- Settings -->
                    <div class="meta-box-sortables ui-sortable"><div class="postbox">    
                        <h2><span><?php _e( 'Shortcode' ); ?></span></h2>            
                        <div class="inside">

                            <p><code>[rd-featured-users role="administrator,author" avatar="yes" max="100"]</code></p>
                            <ol>
                                <li><?php _e( 'role = A comma-separated list of roles of the users you want to include in the query. Note the settings page can override this. The default is all roles again unless the settings page specifies which to allow.' ); ?></li>
                                <li><?php _e( 'avatar = Options are yes or no, specify whether to show or not show the users\' avatar image. The default is no.' ); ?></li>
                                <li><?php _e( 'max = The maximum number of users to display.' ); ?></li>
                            </ol>

                        </div>    
                    </div></div>
                    
                    <!-- Code Examples -->
                    <div class="meta-box-sortables ui-sortable"><div class="postbox">    
                        <h2><span><?php _e( 'Code Examples (For experienced developers ONLY!)' ); ?></span></h2>            
                        <div class="inside">

                            <p><?php _e( 'This plugin was originally developed for developers and the idea was to easily add to a theme or mu-plugins folder. Keeping that in mind here are some code examples a developer might find useful.' ); ?></p>
                            
                            <p><strong><?php _e( 'Use this function to change the CSS file that is used for the featured users plugin' ); ?></strong></p>
                            <p>
                                <code>
                                /**<br />
                                <span></span> * @package rd_featured_users_css<br />
                                <span></span> * @author Jeremy Selph &lt;jselph@reactivedevelopment.net&gt;<br />
                                <span></span> * @version 1.6<br />
                                <span></span> * @access public<br />
                                <span></span>*/<br />
                                function rd_featured_users_css(){<br /><br />
                                    
                                <span class="tab"></span>return get_template_directory_uri() . '/assets/featured_users.css';<br /><br />

                                } add_filter( 'featured-users-css', 'rd_featured_users_css' );
                                </code>
                            </p><br />

                            <p><strong><?php _e( 'Use this function to change the JS file that is used for the featured users plugin' ); ?> ?></strong></p>
                            <p>
                                <code>
                                /**<br />
                                <span></span> * @package rd_featured_users_css<br />
                                <span></span> * @author Jeremy Selph &lt;jselph@reactivedevelopment.net&gt;<br />
                                <span></span> * @version 1.6<br />
                                <span></span> * @access public<br />
                                */<br />
                                function rd_featured_users_js(){<br /><br />
                                    
                                <span class="tab"></span>return get_template_directory_uri() . '/assets/featured_users.js';<br /><br />
                                
                                } add_filter( 'featured-users-js', 'rd_featured_users_js' );
                                </code>
                            </p><br />

                            <p><strong><?php _e( 'Copy "featured_users.php" to mu-plugins or plugins folder and use this code to stop the featured users plugin from using its own CSS and JS includes' ); ?></strong></p>
                            <p>
                                <code>
                                /**<br />
                                <span></span> * @package rd_featured_users_css<br />
                                <span></span> * @author Jeremy Selph &lt;jselph@reactivedevelopment.net&gt;<br />
                                <span></span> * @version 1.6<br />
                                <span></span> * @access public<br />
                                */<br />
                                if ( class_exists( 'rdFeaturedUsers' ) ){<br /><br />

                                    <span class="tab"></span>/**<br />
                                    <span class="tab"></span><span></span> * @author Jeremy Selph &lt;jselph@reactivedevelopment.net&gt;<br />
                                    <span class="tab"></span><span></span> * @version 1.6<br />
                                    <span class="tab"></span><span></span> * @access public<br />
                                    <span class="tab"></span>*/<br />
                                    <span class="tab"></span>global $featuredUsers;<br />
                                    <span class="tab"></span>remove_action( 'admin_enqueue_scripts', array( $featuredUsers, 'add_featured_column_css_js' ) );<br /><br />
                                    
                                    <span class="tab"></span>/**<br />
                                    <span class="tab"></span><span></span> * @package rd_featured_users_css<br />
                                    <span class="tab"></span><span></span> * @author Jeremy Selph &lt;jselph@reactivedevelopment.net&gt;<br />
                                    <span class="tab"></span><span></span> * @version 1.6<br />
                                    <span class="tab"></span><span></span> * @access public<br />
                                    <span class="tab"></span>*/<br />
                                    <span class="tab"></span>function rd_add_featured_column_css_js( $hook ){<br />
                                    <span class="tab"></span><span class="tab"></span>if ( $hook == 'users.php' ){<br /><br />

                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span>/**<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span></span> * add admin styles<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span></span> * @author Jeremy Selph &lt;jselph@reactivedevelopment.net&gt;<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span></span> * @version 1.5<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span>*/<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span>wp_enqueue_style(<br /><br />
                                                
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>'featured-users-css',<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>get_template_directory_uri() . '/assets/featured_users.css',<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>array(),<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>'0.1'<br /><br />
                                            
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span>);<br /><br />

                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span>/**<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span></span> * add admin scripts<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span></span> * @author Jeremy Selph &lt;jselph@reactivedevelopment.net&gt;<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span></span> * @version 1.5<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span>*/<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span>wp_enqueue_script(<br /><br />
                                                
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>'featured-users-js',<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>get_template_directory_uri() . '/assets/featured_users.js',<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>array( 'jquery' ),<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>'0.1',<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>true<br /><br />
                                            
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span>);<br /><br />

                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span>/**<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span></span> * add ajax params<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span></span> * @author Jeremy Selph &lt;jselph@reactivedevelopment.net&gt;<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span></span> * @version 1.5<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span>*/<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span>wp_localize_script(<br /><br />
                                                
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>'featured-users-js',<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>'featured_users',<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>array(<br /><br />

                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>'ajax_url' => admin_url( 'admin-ajax.php' ),<br />
                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>'ajaxNounce' => wp_create_nonce( 'featured-users' )<br /><br />

                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span><span class="tab"></span>)<br /><br />

                                    <span class="tab"></span><span class="tab"></span><span class="tab"></span>);<br /><br />			

                                    <span class="tab"></span><span class="tab"></span>}<br />
                                    <span class="tab"></span>} add_action( 'admin_enqueue_scripts', 'rd_add_featured_column_css_js', 10, 1 );<br /><br />
                                
                                }
                                </code>
                            </p>

                        </div>    
                    </div></div>
    
                </div><div id="postbox-container-1" class="postbox-container"><div class="meta-box-sortables">

                    <!-- Developer -->
                    <div class="postbox">
                        <h2><span><?php _e( 'Developed by Jeremy Selph' ); ?> @</span></h2>
                        <div class="inside">

                            <a href="https://www.reactivedevelopment.net/" target="_blank" class="rdLogo">
                                <img class="rdLogoImg" src="https://www.reactivedevelopment.net/wp-content/themes/reactive/img/reactive-development-web-development.png" alt="<?php _e( 'Web Development Experts' ); ?>">
                            </a>
                            <p><strong><?php _e( 'Reactive Development is a team of development experts, specializing in pixel perfect web development.' ); ?></strong></p>
                        
                        </div>
                    </div>
                    
                    <!-- Contact -->
                    <div class="postbox supportBox">
                        <h2><span><?php _e( 'Need Support or help?' );  ?></span></h2>
                        <div class="inside">

                            <p><?php echo sprintf( 
                                __( 'For questions or free support and after reading the &quot;How to&quot; section on this page go to %s. Otherwise...'),
                                '<strong><a href="' . esc_url( 'https://wordpress.org/support/plugin/featured-users-wordpress-plugin' ) . '" target="_blank">' . esc_url( 'https://wordpress.org/support/plugin/featured-users-wordpress-plugin' ) . '</strong></a>'
                            ); ?></p>
                            <p><img class="supportImg" src="<?php echo 'https://www.reactivedevelopment.net/wp-content/themes/reactive/img/support.jpg'; ?>" alt="<?php _e( 'Need support' ); ?>"></p>
                            <p><strong><?php echo sprintf( 
                                __( 'For paid or immediate support please go to %s to submit a request.' ),
                                '<a href="https://www.reactivedevelopment.net/contact/project-mind/?plugin=featured-users" target="_blank">https://www.reactivedevelopment.net/contact/project-mind/?plugin=featured-users</a>'
                            ); ?></strong></p>

                        </div>
                    </div>
        
                </div></div></div><br class="clear"></div>
            
            </div><?php

        }
        
        /**
         * @package add_page
         * @author Jeremy Selph <jselph@reactivedevelopment.net>
         * @version 0.1
         * @access public
        */
        public function add_page(){
            
            /**
             * add our settings page
             * @author Jeremy Selph <jselph@reactivedevelopment.net>
             * @since 0.1
            */
            add_options_page(

                __( 'Featured Users' ),
                __( 'Featured Users' ),
                'manage_options',
                'rd-featured-users',
                array( $this, 'page_content' )

            );

            /**
             * Hide the page from the menu
             * @author Jeremy Selph <jselph@reactivedevelopment.net>
             * @since 0.1
            */
            if ( esc_attr( $this->_settings[ 'feat_hide' ] ) == 'yes' ){
                
                remove_submenu_page( 'options-general.php', 'rd-featured-users' );
            
            }

        }

    } $featuredUsersSettings = new featuredUsersSettings();