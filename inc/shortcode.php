<?php /**
 *
 * @package Featured Users
 * @subpackage shortcode.php
 * @author Jeremy Selph <jselph@reactivedevelopment.net>
 * @link http://www.reactivedevelopment.net/
 * @license GPLv3
 * @version 0.1

    Change Log

     * 0.1 	initial plugin development by, Jeremy Selph http://www.reactivedevelopment.net/ 		    2018/12/17

    Filters to hook into

	 * 01. 	FILTER : featured-user-shortcode-row [user row in shortcode and widget]
	 * 02. 	FILTER : featured-user-shortcode-return [shortcode and widget content]

    Plugin Class

     * @package featuredUsersShortcode
     * @author Jeremy Selph <jselph@reactivedevelopment.net>
     * @version 0.1
     * @access public
    */
	class featuredUsersShortcode extends rdFeaturedUsers {

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
            add_shortcode( 'rd-featured-users', array( $this, 'shortcode_content' ) );

        }
        
        /**
         * @package shortcode_content
         * @author Jeremy Selph <jselph@reactivedevelopment.net>
         * @version 0.1
         * @access public
        */
        public function shortcode_content( $atts ){
            
            $return = '';
            $atts = shortcode_atts(

                array( 'role' => '', 'avatar' => false, 'max' => 1000 ), 
                $atts, 
                'rd-featured-users'

            );
            
            /**
             * Query featured users
             * @author Jeremy Selph <jselph@reactivedevelopment.net>
             * @since 0.1
            */
            $user_query = $this->return_featured_users( $atts[ 'role' ], $atts[ 'avatar' ], $atts[ 'max' ] );
            $users = $user_query->results;
            if ( $users && count( $users ) > 0 ){
                
                $return .= '<ul>';
                foreach( $users as $u ){                    
                    $return .= '<li>';
                        $return .= '<a href="' . get_author_posts_url( $u->ID, get_the_author_meta('user_nicename') ) . '">';
                            
                            if ( strtolower( $atts[ 'avatar' ] ) == 'yes' ){ $return .= get_avatar( $u->ID. 16 ) . ' '; }
                            $return .= apply_filters(

                                'featured-user-shortcode-row',
                                get_the_author_meta( 'display_name', $u->ID ) . ' (' . count_user_posts( $u->ID ) . ')',
                                $u->ID
                                
                            );
                        
                        $return .= '</a>';
                    $return .= '</li>';
                } $return .= '</ul>';
            
            } return apply_filters( 'featured-user-shortcode-return', $return, $users );

        }

    } $featuredUsersShortcode = new featuredUsersShortcode();