<?php /**
 *
 * Plugin Name:   	Featured Users
 * Plugin URI:    	http://www.reactivedevelopment.net/featured-users
 * Description:   	Adds the ability to set a user's custom meta filed called "jsfeatured_user".
 * Version:       	2.0
 * Author:        	Reactive Development LLC
 * Author URI:    	http://www.reactivedevelopment.net/
 * 
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
	 * Star image is from: http://www.iconfinder.com/icondetails/9662/24/bookmark_star_icon and http://www.iconfinder.com/icondetails/9604/24/star_icon
 
 	Change Log
	
	 * 1.6 	Added new functions rd_is_user_featured() and rd_featured_users() 							2018/12/17
	 * 1.5 	Re-developed by, Jeremy Selph http://www.reactivedevelopment.net/							2018/12/17
	 * 1.0 	Released to WordPress.
	 * 0.1 	initial plugin development by, Jeremy Selph http://www.reactivedevelopment.net/

	Activation Instructions

	 * 01. 	Visit 'Plugins > Add New'
	 * 02. 	Search for 'Featured Users'
	 * 03. 	Activate Featured Users from your Plugins page.

    Shortcodes

	 * 01. 	[rd-featured-users max="Max amount of users to return"]
	 * 02. 	[rd-featured-users-widget]

    Theme functions

	 * 01. 	rd_is_user_featured( (int)user_id )
	 * 02. 	rd_featured_users( (int)max_users )

    Filters to hook into

	 * 01. FILTER : 

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
		public $_meta_name = 'jsIs_user_featured';

		/**
		 * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5 
    	 * @access public
	    */
		public $_meta_value = 'yes';

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
		public function __construct(){

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
	    public function return_featured_users( $max = 1000 ){
			return new WP_User_Query(				
				array( 
					
					'meta_key' => $this->_meta_name,
					'meta_value' => $this->_meta_value,
					'number' => $max
					
				)
			);
		}

	    /**
		 * @package save_featured_users
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
	    public function save_featured_users( $users = false ){
			
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
					if ( $id > 0 ){ 
						
						update_user_meta( $id, $this->_meta_name, $this->_meta_value );
						$return[] = $id;
					
					}

				} return $return;
				

			} return false;

		}

	    /**
		 * @package delete_featured_user
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 1.5
	     * @access public
	    */
	    public function delete_featured_user( $user = false ){
			
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
				
			$isFeatured	= $this->is_user_featured( $user ); ?>			
			<h3><?php _e( 'Featured Setting' ); ?></h3>
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
			if( $column_name == 'featured_user' ) {				
				
				$class =  ( $this->is_user_featured( $user_id ) ) ? ' selected' : '';
				return  '<a id="userFeatured_'.$user_id.'" href="#" class="featuredStar'.$class.'"></a>';
					
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
					plugin_dir_url( __FILE__ ) . 'assets/featured_users.css',
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
					plugin_dir_url( __FILE__ ) . 'assets/featured_users.js',
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