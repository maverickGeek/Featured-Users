<?php /**
 *
 * Plugin Name:   	Featured Users
 * Plugin URI:    	http://www.reactivedevelopment.net/featured-users
 * Description:   	Adds the ability to set a user's custom meta field called "jsfeatured_user".
 * Version:       	2.0
 * Author:        	Jeremy Selph @ Reactive Development LLC
 * Author URI:    	http://www.reactivedevelopment.net/ * 
 * License:       	GPL v3
 * License URI:   	http://www.gnu.org/licenses/gpl-3.0.en.html
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.

	Credits

	 * Plugin Development by Jeremy Selph @ Reactive Development LLC
	 * Star image is from: http://www.iconfinder.com/icondetails/9662/24/bookmark_star_icon and 
	 * http://www.iconfinder.com/icondetails/9604/24/star_icon
 
 	Change Log
	
	 * 2.0	Finished 2.0 development, testing and documentation. 										2018/12/31
	 * 1.6 	Added new functions rd_is_user_featured() and rd_featured_users() 							2018/12/17
	 * 1.5 	Re-developed by, Jeremy Selph http://www.reactivedevelopment.net/							2018/12/17
	 * 1.0 	Released to WordPress.
	 * 0.1 	initial plugin development by, Jeremy Selph http://www.reactivedevelopment.net/

	Activation Instructions

	 * 01. 	Visit 'Plugins > Add New'
	 * 02. 	Search for 'Featured Users'
	 * 03.	Click on 'Install Now'
	 * 04. 	Activate the Featured Users plugin.
	 * 05. 	Go to 'Settings > Featured Users' and modify.

    Shortcodes

	 * 01. 	[rd-featured-users role="{comma separated roles of users to include}" avatar="yes|no" max="int"]

    Theme functions

	 * 01. 	rd_is_user_featured( (int)user_id )
	 * 02. 	rd_featured_users( (int)max_users )

    Filters to hook into

	 * 01. 	FILTER : featured-users-args [https://codex.wordpress.org/Class_Reference/WP_User_Query]
	 * 02.	FILTER : featured-users-css [url to css file]
	 * 03.	FILTER : featured-users-JS [url to js file]
	 * 04. 	FILTER : [inc/shortcode.php] featured-user-shortcode-row [user row in shortcode and widget]
	 * 05. 	FILTER : [inc/shortcode.php] featured-user-shortcode-return [shortcode and widget content]

    Plugin Class

     * @package rdFeaturedUsers
     * @author Jeremy Selph <jselph@reactivedevelopment.net>
     * @version 1.5
     * @access public
    */
	class rdFeaturedUsers {

		/**
		 * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5 
    	 * @access public
	    */
		public $_option_name = 'rd-featured-users';

		/**
		 * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5 
    	 * @access public
	    */
		public $_meta_name = 'jsIs_user_featured';

		/**
		 * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5 
    	 * @access public
	    */
		public $_meta_value = 'yes';

		/**
		 * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5 
    	 * @access protected
	    */
		protected $_settings = false;

		/**
		 * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5 
    	 * @access public
	    */
		public $_plugin_url = false;

		/**
		 * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5 
    	 * @access private
	    */
		private $_plugin_dir = false;

		/**
		 * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5 
    	 * @access protected
	    */
		protected $_plugin_base = false;

		/**
		 * Static property to hold class instance
		 * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
    	 * @var rdFeaturedUsers
    	 * @static
	    */
		static $_instance = false;

		/**
		 * @package __construct
    	 * @author Jeremy Selph <jselph@reactivedevelopment.net>
    	 * @version 1.5
    	 * @access public
	    */
		public function __construct( $child = false ){

			$this->_plugin_url = plugin_dir_url( __FILE__ );
			$this->_plugin_dir = plugin_dir_path( __FILE__ );
			$this->_plugin_base = plugin_basename( __FILE__ );
				
			/**
			 * Populate settings
			 * @author Jeremy Selph <jselph@reactivedevelopment.net>
			 * @since 1.5
			*/
			$this->_settings = get_option( $this->_option_name );

			/**
			 * only do the following when the parent class is loaded
			 * @author Jeremy Selph <jselph@reactivedevelopment.net>
			 * @since 1.5
			*/
			if ( !$child ){

				/**
				 * Actions/Filters
				 * @author Jeremy Selph <jselph@reactivedevelopment.net>
				 * @since 1.5
				*/
				add_action( 'show_user_profile', array( $this, 'add_checkBox_to_profile' ), 10, 1 );
				add_action( 'edit_user_profile', array( $this, 'add_checkBox_to_profile' ), 10, 1 );
				add_action( 'personal_options_update', array( $this, 'profile_update_featured_meta' ), 10, 1 );
				add_action( 'edit_user_profile_update', array( $this, 'profile_update_featured_meta' ), 10, 1 );
				add_filter( 'manage_users_columns', array( $this, 'add_featured_column' ), 10, 1 );
				add_filter( 'manage_users_custom_column', array( $this, 'featured_column_content' ), 10, 3 );
				add_action( 'admin_enqueue_scripts', array( $this, 'add_featured_column_css_js' ), 10, 1 );
				add_action( 'wp_ajax_featured_users', array( $this, 'ajax_save_featured_user' ) );
				add_filter( 'plugin_row_meta', array( $this, 'support_link' ), 10, 2 );
				
				/**
				 * Addons
				 * @author Jeremy Selph <jselph@reactivedevelopment.net>
				 * @since 1.5
				*/
				require_once( $this->_plugin_dir . 'inc/shortcode.php' );
				require_once( $this->_plugin_dir . 'inc/widget.php' );

				/**
				 * Addons for admin area
				 * @author Jeremy Selph <jselph@reactivedevelopment.net>
				 * @since 1.5
				*/
				if ( is_admin() ){ require_once( $this->_plugin_dir . 'inc/settings.php' ); }

			}

		}

		/**
		 * @package support_link
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
	    public function support_link( $plugin_meta, $plugin_file ){
			if ( $this->_plugin_base === $plugin_file ) {

				$plugin_meta[] = sprintf(
					'&#36; <a href="%s" target="_blank">%s</a>',
					'https://www.reactivedevelopment.net/contact/project-mind/?plugin=featured-users',
					esc_html__( 'Paid support' )
				);

				$plugin_meta[] = sprintf(
					'&hearts; <a href="%s" target="_blank">%s</a>',
					'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=RESFMU9LDAEDQ&source=url',
					esc_html__( 'Donate' )
				);

			} return $plugin_meta;
		}

	    /**
		 * @package is_user_featured
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
	    public function is_user_featured( $user = false ){
			if ( $user ){

				$user_id = ( is_object( $user ) && isset( $user->ID ) ) ? intval( $user->ID ) : intval( $user );
				if ( $user_id > 0 ){ return get_user_meta( $user_id, $this->_meta_name, true ); }

			} return false;
		}

	    /**
		 * @package return_featured_users
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
	    public function return_featured_users( $roles = false, $avatar = 'no', $max = 1000 ){
			
			$allowed_roles = false;
			$roles = ( $roles && !is_array( $roles ) && strpos( $roles, ',' ) ) ? explode( ',', $roles ) : array( $roles );
			$user_args = array( 
					
				'meta_key' => $this->_meta_name,
				'meta_value' => $this->_meta_value,
				'number' => $max
				
			);
			
			/**
			 * confirm the roles given are allowed by our settings
			 * @author Jeremy Selph <jselph@reactivedevelopment.net>
			 * @version 1.5
			*/
			if ( $roles && count( $roles ) > 0 ){

				$allowed_roles = array();
				foreach( $roles as $r ){
					if ( $this->is_role_allowed( $r ) ){ $allowed_roles[] = $r; }
				}
				
			}

			/**
			 * if no roles were given and we have roles in our settings lets use them
			 * @author Jeremy Selph <jselph@reactivedevelopment.net>
			 * @version 1.5
			*/
			$allowed_roles = ( !$allowed_roles ) ? $this->allowed_roles() : $allowed_roles;
			if ( count( $allowed_roles ) > 0 ){ $user_args[ 'role__in' ] = $allowed_roles; }

			/**
			 * query the db for featured users
			 * @author Jeremy Selph <jselph@reactivedevelopment.net>
			 * @version 1.5
			*/
			return new WP_User_Query( apply_filters( 'featured-users-args', $user_args ) );

		}

	    /**
		 * @package allowed_roles
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access private
	    */
	    private function allowed_roles(){
			if ( isset( $this->_settings[ 'feat_role' ] ) && !empty( $this->_settings[ 'feat_role' ] ) ){

				return $this->_settings[ 'feat_role' ];

			} return array();
		}

	    /**
		 * @package is_role_allowed
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
	    public function is_role_allowed( $roles = array() ){
			
			$roles = ( !is_array( $roles ) ) ? array( $roles ) : $roles;
			$allowed_roles = $this->allowed_roles();
			$role_allowed = ( count( $allowed_roles ) > 0 ) ? false : true;			
			if ( !$role_allowed && count( $roles ) > 0 ){
				foreach( $roles as $r ){
					if ( in_array( $r, $allowed_roles ) ){
						
						$role_allowed = true;
					
					}
				}
			} return $role_allowed;

		}

	    /**
		 * @package save_featured_users
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access private
	    */
	    private function save_featured_users( $users = false ){
			
			$return = $user_ids = array();
			$user_ids = ( !empty( $users ) && !is_array( $users ) ) ? array( $users ) : $users;
			if ( $user_ids && count( $user_ids ) > 0 ){
				
				/**
				 * Loop through each user and update their user meta
				 * @author Jeremy Selph <jselph@reactivedevelopment.net>
				 * @since 1.5
				*/
				foreach( $user_ids as $u ){

					$id = intval( $u );
					$user_meta = $role_allowed = false;
					if ( $id > 0 ){
						
						$user_meta = get_userdata( $id );
						$role_allowed = $this->is_role_allowed( $user_meta->roles );
						if ( $role_allowed ){
						
							update_user_meta( $id, $this->_meta_name, $this->_meta_value );
							$return[] = $id;

						}
					
					}

				} return $return;
				

			} return false;

		}

	    /**
		 * @package delete_featured_user
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access private
	    */
	    private function delete_featured_user( $user = false ){
			
			$user_id = ( is_object( $user ) && isset( $user->ID ) ) ? intval( $user->ID ) : intval( $user );
			if ( $user_id > 0 ){
				
				delete_user_meta( $user_id, $this->_meta_name );
				return true;
			
			} return false;

		}

	    /**
		 * @package ajax_save_featured_user
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
	    public function ajax_save_featured_user(){
			if ( wp_verify_nonce( $_REQUEST[ 'nounce' ], 'featured-users' ) &&
				 current_user_can( 'edit_user' ) ){

				$user_id = intval( $_REQUEST[ 'user_id' ] );
				$featured = ( !empty( $_REQUEST[ 'featured' ] ) && $_REQUEST[ 'featured' ] == 'yes' ) ? true : false;
				if ( $user_id > 0 ){
					
					if( $featured ){ $this->save_featured_users( array( $user_id ) ); echo 'added'; }
					else { $this->delete_featured_user( $user_id ); echo 'deleted'; }
				
				}

			} exit;
		}

	    /**
		 * @package profile_update_featured_meta
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
	    public function profile_update_featured_meta( $user_id ){
				
			if ( !current_user_can( 'edit_user', $user_id ) ){ return false; }			
			if ( isset( $_REQUEST[ '_' . $this->_meta_name ] ) && 
				 $_REQUEST[ '_' . $this->_meta_name ] == $this->_meta_value ){ $this->save_featured_users( $user_id ); } 
			else { $this->delete_featured_user( $user_id ); }
			
		}

	    /**
		 * @package add_checkBox_to_profile
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
	    public function add_checkBox_to_profile( $user ){
			
			$isFeatured	= $this->is_user_featured( $user );
			if ( $this->is_role_allowed( $user->roles ) ){ ?>
			<h3><?php _e( 'Feature User' ); ?></h3>
			<table class="form-table">
		
				<tr>
					<td>
						<input id="_<?php echo $this->_meta_name; ?>" name="_<?php echo $this->_meta_name; 
							?>" type="checkbox" value="<?php echo $this->_meta_value; ?>"<?php if ( $isFeatured ){ ?> checked="checked"<?php } ?>>
						<label for="_<?php echo $this->_meta_name; ?>"><?php _e( 'Check if Featured' ); 
							?> (<span class="description"><?php _e( 'Checked' ); ?> == <?php _e( 'This user is featured' ); 
								?>.</span>)</label>
					</td>
				</tr>
		
			</table><br /><?php
			}
			
		}

	    /**
		 * @package add_featured_column
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
	    public function add_featured_column( $columns ){			
			
			$columns[ 'featured_user' ] = __( 'Featured' );
			return $columns;
			
		}

	    /**
		 * @package featured_column_content
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
	    public function featured_column_content( $empty, $column_name, $user_id ){
			if( $column_name == 'featured_user' ){
				
				$user_meta = get_userdata( $user_id );
				$role_allowed = $this->is_role_allowed( $user_meta->roles );
				if ( $role_allowed ){
						
					$class =  ( $this->is_user_featured( $user_id ) ) ? ' selected' : '';
					return  '<a id="userFeatured_'.$user_id.'" href="#" class="featuredStar'.$class.'"></a>';

				}
					
			}
		}

	    /**
		 * @package add_featured_column_css_js
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
	    public function add_featured_column_css_js( $hook ){
		 	if ( $hook == 'users.php' ){

				/**
                 * add admin styles
                 * @author Jeremy Selph <jselph@reactivedevelopment.net>
                 * @version 1.5
                */
                wp_enqueue_style( 
					
					'featured-users-css',
					apply_filters( 'featured-users-css', plugin_dir_url( __FILE__ ) . 'assets/featured_users.css' ),
					array(),
					'0.1'
				
				);

				/**
                 * add admin scripts
                 * @author Jeremy Selph <jselph@reactivedevelopment.net>
                 * @version 1.5
                */
                wp_enqueue_script( 
					
					'featured-users-js', 
					apply_filters( 'featured-users-js', plugin_dir_url( __FILE__ ) . 'assets/featured_users.js' ),
					array( 'jquery' ),
					'0.1', 
					true
				
				);

                /**
                 * add ajax params
                 * @author Jeremy Selph <jselph@reactivedevelopment.net>
                 * @version 1.5
                */				
				wp_localize_script(
					
					'featured-users-js',
					'featured_users',
					array(

						'ajax_url' => admin_url( 'admin-ajax.php' ),
                        'ajaxNounce' => wp_create_nonce( 'featured-users' )

					)

				);				

		 	}
		}

		/**
		 * @package get_class_instance
    	 * @author Jeremy Selph <jselph@reactivedevelopment.net>
    	 * @version 1.5
    	 * @access public
    	 * @return rdFeaturedUsers
	    */
		public static function getInstance(){

			if ( !self::$_instance ){ self::$_instance = new self; } return self::$_instance;

		}

	} $featuredUsers = rdFeaturedUsers::getInstance();

	/**
	 * @package rd_is_user_featured
	 * @author Jeremy Selph <jselph@reactivedevelopment.net>
	 * @version 1.6
	 * @access public
	*/
	function rd_is_user_featured( $user_id = 0 ){

		global $featuredUsers; 
		return $featuredUsers->is_user_featured( $user_id );

	}

	/**
	 * @package rd_featured_users
	 * @author Jeremy Selph <jselph@reactivedevelopment.net>
	 * @version 1.6
	 * @access public
	*/
	function rd_featured_users( $max = 1000 ){
		
		global $featuredUsers; 
		return $featuredUsers->return_featured_users( $max );
	
	}