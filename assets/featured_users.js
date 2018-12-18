/*!
 * Featured Users Admin Scripts
 * @company Reactive Development LLC
 * @author Jeremy Selph <jselph@reactivedevelopment.net>
 * @link http://www.reactivedevelopment.net/
 * @version 0.1
 */ /**

    Change Log

     * 0.1  initial development by, Jeremy Selph                                                        2018/12/17
 
 */ /**
     * variables
     * @author Jeremy Selph <jselph@reactivedevelopment.net>
     * @version 1.4
     * @since 0.1
    */
   var ajaxUrl = featured_users.ajax_url
        ajaxNounce = featured_users.ajaxNounce;

    /**
    * send a ajax request to update a users featured status
    * @author Jeremy Selph <jselph@reactivedevelopment.net>
    * @uses jquery.min.js
    * @version 1.5
    * @since 0.1
    */
    function rd_update_featured_status( user_id, status ){
        
        var user = user_id.split( "_" );
        var featured_status = 'yes';
        if ( !status ){ featured_status = 'no'; }

        /**
         * debugging
         * @author Jeremy Selph <jselph@reactivedevelopment.net>
         * @since 0.1
        */
        console.log( "JS user_id: " + user[ 1 ] );
        console.log( "JS featured: " + featured_status );

        /**
         * query the datbase to decode this url
         * @author Jeremy Selph <jselph@reactivedevelopment.net>
         * @since 0.1
        */
        jQuery.post( ajaxUrl, { action: "featured_users", user_id: user[ 1 ], featured: featured_status, nounce: ajaxNounce },
            function( data ){
                
                console.log( data );
            
            }
        );

    }

    /**
     * jquery onload
     * @author Jeremy Selph <jselph@reactivedevelopment.net>
     * @uses jquery.min.js
     * @version 0.2
     * @since 0.1
    */
    jQuery( document ).ready(function() {

        /**
         * when the star is clicked we need to update the users status
         * @author Jeremy Selph <jselph@reactivedevelopment.net>
         * @since 0.1
        */
        jQuery( "#the-list" ).on( "click", "a.featuredStar", function(){
            
            /**
             * @author Jeremy Selph <jselph@reactivedevelopment.net>
             * @since 0.1
            */
           if ( jQuery( this ).hasClass( "selected" ) ){ 
                
                var is_featured = false;
                jQuery( this ).removeClass( "selected" );
            
            } else { 
                
                var is_featured = true;
                jQuery( this ).addClass( "selected" );                
            
            }             
            
            /**
             * @author Jeremy Selph <jselph@reactivedevelopment.net>
             * @since 0.1
            */
            rd_update_featured_status( jQuery( this ).attr( "id" ), is_featured );
            return false;

        });

    });