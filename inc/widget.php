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
	 
	 Filters to hook into

 	 * 01.  

    Plugin Class

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
            

        }
        
        /**
         * @package add_page
         * @author Jeremy Selph <jselph@reactivedevelopment.net>
         * @version 0.1
         * @access public
        */
        public function add_page(){
            


        }

    } $featuredUsersWidget = new featuredUsersWidget();