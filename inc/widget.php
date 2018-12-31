<?php /**
 *
 * @package Featured Users
 * @subpackage widget.php
 * @author Jeremy Selph <jselph@reactivedevelopment.net>
 * @link http://www.reactivedevelopment.net/
 * @license GPLv3
 * @version 0.1

    Change Log

     * 0.1 	initial plugin development by, Jeremy Selph http://www.reactivedevelopment.net/ 		    2018/12/17

    Plugin Class

     * @package rd_featured_Users_widget
     * @author Jeremy Selph <jselph@reactivedevelopment.net>
     * @version 0.1
     * @access public
    */
	class rd_featured_Users_widget extends WP_Widget {

        /**
         * @package __construct
         * @author Jeremy Selph <jselph@reactivedevelopment.net>
         * @version 0.1
         * @access public
        */
        public function __construct(){            
            parent::__construct(

                'rd_featured_Users_widget', 
                'Featured users',  
                array(

                    'classname' => 'rd_featured_Users_widget',
                    'description' => 'This widget displays all of your featured users in a one-column list.'

                )

            );
        }
        
        /**
         * @package widget
         * @author Jeremy Selph <jselph@reactivedevelopment.net>
         * @version 0.1
         * @access public
        */
        public function widget( $args, $instance ){

            if ( !isset( $args['widget_id'] ) ) { $args['widget_id'] = $this->id; }    
            $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Featured Users' );
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            /**
             * get options from widget
             * @author Jeremy Selph <jselph@reactivedevelopment.net>
             * @since 0.1
            */
            $roles = ( ! empty( $instance['roles'] ) ) ? $instance['roles'] : '';
            $avatar = ( ! empty( $instance['avatar'] ) ) ? $instance['avatar'] : '';
            $max = ( ! empty( $instance['max'] ) ) ? $instance['max'] : '';
    
            /**
             * echo out widget code
             * @author Jeremy Selph <jselph@reactivedevelopment.net>
             * @since 0.1
            */
            echo $args['before_widget'];
            if ( $title ){ echo $args['before_title'] . $title . $args['after_title']; }
            echo do_shortcode( '[rd-featured-users role="' . $roles . '" avatar="' . $avatar . '" max="' . $max . '"]' );
            echo $args['after_widget'];

        }
        
        /**
         * @package form
         * @author Jeremy Selph <jselph@reactivedevelopment.net>
         * @version 0.1
         * @access public
        */
        public function form( $instance ){
            
            $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
            <p class="feat_users_p">
                <label class="feat_users_title" for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget title' ); ?>:</label>
                <input class="feat_users_title" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
            </p>

    <?php   $featuredUsers = rdFeaturedUsers::getInstance();
            $roles = ! empty( $instance['roles'] ) ? explode( ',', $instance['roles'] ) : array(); ?>
            <p class="feat_users_p">
                <label class="feat_users_roles" for="<?php echo $this->get_field_id( 'roles' ); ?>"><?php _e( 'Roles of users to display' ); ?>:</label>
                <select class="feat_users_roles" multiple="multiple" name="<?php echo $this->get_field_id( 'roles' ); ?>[]" id="<?php echo $this->get_field_id( 'roles' ); ?>">
        <?php   $editable_roles = array_reverse( get_editable_roles() );
                foreach ( $editable_roles as $role => $details ){
                    
                    $key = esc_attr( $role );
                    if( $featuredUsers->is_role_allowed( $key ) ){
                    
                        $name = translate_user_role( $details['name'] );
                        $checked = ( in_array( $key, $roles ) ) ? ' selected="selected"' : '';
                        echo '<option value="' . $key . '"' . $checked . '>' . $name . '</option>';
                    
                    }

                } ?>
                </select>
            </p>
            
    <?php   $avatar = ! empty( $instance['avatar'] ) ? $instance['avatar'] : ''; ?>
            <p class="feat_users_p">
                <label class="feat_users_avatar" for="<?php echo $this->get_field_id( 'avatar' ); ?>"><?php _e( 'Include avatar images' ); ?>:</label>
                <select class="feat_users_avatar" id="<?php echo $this->get_field_id( 'avatar' ); ?>" name="<?php echo $this->get_field_name( 'avatar' ); ?>">
                    <option<?php if( $avatar == 'No' ){ ?> selected="selected"<? } ?>>No</option>
                    <option<?php if( $avatar == 'Yes' ){ ?> selected="selected"<? } ?>>Yes</option>
                </select>
            </p>
    
    <?php   $max = ! empty( $instance['max'] ) ? $instance['max'] : ''; ?>
            <p class="feat_users_p">
                <label class="feat_users_max" for="<?php echo $this->get_field_id( 'max' ); ?>"><?php _e( 'Max users to query' ); ?>:</label>
                <input class="feat_users_max" type="text" id="<?php echo $this->get_field_id( 'max' ); ?>" name="<?php echo $this->get_field_name( 'max' ); ?>" value="<?php echo esc_attr( $max ); ?>" />
            </p>
            <p class="feat_users_p"><?php _e( 'This widget displays all of your featured users in a one-column list' ) ?>.</p>
    
    <?php }
        
        /**
         * @package update
         * @author Jeremy Selph <jselph@reactivedevelopment.net>
         * @version 0.1
         * @access public
        */
        public function update( $new_instance, $old_instance ){

            $instance = $old_instance;
            $new_roles = array();
            $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
            $instance[ 'avatar' ] = strip_tags( $new_instance[ 'avatar' ] );
            $instance[ 'max' ] = intval( $new_instance[ 'max' ] );
            
            $roles = $_REQUEST[ $this->get_field_id( 'roles' ) ];
            if( $roles && count( $roles ) > 0 ){
                foreach( $roles as $r ){ 
                    if ( !in_array( $r, $new_roles ) ){ $new_roles[] = sanitize_text_field( $r ); }
                }
            } $instance[ 'roles' ] = implode( ',', $new_roles );
            
            return $instance;

        }        

    } 
    
    /**
     * @package featuredUsersWidget
     * @author Jeremy Selph <jselph@reactivedevelopment.net>
     * @version 0.1
     * @access public
    */
	class featuredUsersWidget extends rdFeaturedUsers {
        
        /**
         * @package __construct
         * @author Jeremy Selph <jselph@reactivedevelopment.net>
         * @version 0.1
         * @access public
        */
        public function __construct(){

            parent::__construct( true );
            
			/**
             * Actions/Filters
             * @author Jeremy Selph <jselph@reactivedevelopment.net>
             * @since 0.1
            */
            add_action( 'widgets_init', array( $this, 'shortcode_content' ) );
            add_action( 'admin_head', array( $this, 'add_widget_css' ) );

        }
        
        /**
         * @package shortcode_content
         * @author Jeremy Selph <jselph@reactivedevelopment.net>
         * @version 0.1
         * @access public
        */
        public function shortcode_content( $atts ){
            
            register_widget( 'rd_featured_Users_widget' );

        }

	    /**
		 * @package add_widget_css
	     * @author Jeremy Selph <jselph@reactivedevelopment.net>
		 * @version 0.1
	     * @access public
	    */
	    public function add_widget_css(){

            global $pagenow;
            if ( $pagenow == 'widgets.php' ){
                
              ?><style type="text/css">
                    
                    p.feat_users_p{ display: block; clear: both; margin: 1em 0 1em 0; }
                    input.feat_users_title, select.feat_users_roles, select.feat_users_avatar, input.feat_users_max{ 
                        float: right; width: 50%; }
                    select.feat_users_roles, select.feat_users_avatar{ width: 50%; }
                    label.feat_users_title, label.feat_users_roles, label.feat_users_avatar, label.feat_users_max{ float left; 
                        /* display: block; */ clear: both; display: inline-block; padding: 0.5em 0 0 0; }

                    @media only screen and (max-width: 700px) {

                        label.feat_users_title, label.feat_users_roles, label.feat_users_avatar, label.feat_users_max,
                        input.feat_users_title, select.feat_users_roles, select.feat_users_avatar, input.feat_users_max{
                            float: left; width: 100%; }
                        input.feat_users_title, select.feat_users_roles, select.feat_users_avatar, input.feat_users_max{
                            margin: 0 0 5px 0; }

                    }

                </style><?php

            }
        
        }

    } $featuredUsersWidget = new featuredUsersWidget();