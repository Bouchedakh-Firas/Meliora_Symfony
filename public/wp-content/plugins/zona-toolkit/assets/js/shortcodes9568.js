/**
 * Shortcodes
 *
 * @author Rascals Themes
 * @category JavaScripts
 * @package Meloo Toolkit
 * @version 1.0.0
 */


var rascals_shortcodes = (function($) {

    "use strict";


    /* Run scripts
     -------------------------------- */

    /* Ajax: Enabled */
    if ( $( 'body' ).hasClass('WPAjaxLoader') && window.location.href.indexOf('kc_action=live-editor') <= 0 ) {
        $( document ).on('AjaxLoadEnd', function() {
            rascals_shortcodes.init();
        });

    /* Ajax: Disabled */
    } else {
        $( document ).ready(function($){
            rascals_shortcodes.init($);
        });
    }

    return {
        loaded : false,

        /* Init
         -------------------------------- */
        init : function(){
            
            /* First load */
            if ( ! rascals_shortcodes.loaded ) {
                this.countdown();

            /* Reloaded */
            } else {
                this.countdown();
              
            }

            rascals_shortcodes.loaded = true;

        },

        countdown : function() {

            if ( $.fn.countdown ) {

                $( '.countdown' ).each( function(e) {
                    var date = $( this ).data( 'event-date' );
                    $( this ).countdown( date, function( event ) {
                        var $this = $( this );

                        switch( event.type ) {
                            case "seconds":
                            case "minutes":
                            case "hours":
                            case "days":
                            case "weeks":
                            case "daysLeft":
                                $this.find( '.' + event.type ).html( event.value );
                                break;

                            case "finished":
                          
                                break;
                        }
                    });
                });
            }
        },

    }

}( jQuery ));