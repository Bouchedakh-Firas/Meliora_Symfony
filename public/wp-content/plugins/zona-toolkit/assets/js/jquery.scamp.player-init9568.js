/**
 * Scamp Player init scripts
 *
 * @author Rascals Themes
 * @category JavaScripts
 * @package Meloo Toolkit
 * @version 1.0.0
 */

var sc = (function($) {

    "use strict";

    /* Extended functions
	 -------------------------------- */
    (function(func) {
        jQuery.fn.addClass = function() {
            func.apply(this, arguments);
            this.trigger('classChanged');
            return this;
        }
    }
    )(jQuery.fn.addClass);
    // pass the original function as an argument


    /* Run scripts
	 -------------------------------- */

    /* Ajax: Enabled */
    if ($('body').hasClass('WPAjaxLoader')) {
        $(document).on('AjaxLoadEnd', function() {
            sc.init();
        });

        /* Ajax: Disabled */
    } else {
        $(document).ready(function($) {
            sc.init($);
        });
    }

    return {
        loaded: false,
        scamp_player: null,

        /* Init
		 -------------------------------- */
        init: function() {

            /* First load */
            if (!sc.loaded) {
                this.player.init();
                this.music_album();
                
            /* Reloaded */
            } else {
                sc.scamp_player.update_events('body');
                this.music_album();
            }

            sc.loaded = true;

            $(document).on( "AjaxPostsLoaded" , function(e){
                sc.scamp_player.update_events(e.wrapper);
            } );

        },

        /* Music Album
         -------------------------------- */

        music_album: function() {

            if ( $( '.music-album--wrap' ).length <= 0 || $( '#scamp_player' ).length <= 0 ) {
                return;
            }

            $( '.music-album--wrap' ).each( function(){
        
                var $this = $( this ),
                    $list = $this.find('.sp-list'),
                    limit = $this.find('.sp-list li').length-1,
                    has_cover = false,
                    current = 0;

                $this.data( 'current', 0 )

                if ( $this.hasClass( 'is-album-image' ) ) {
                    has_cover = true;
                }

                // Check status
                $this.find( '.sp-list li a' ).on('classChanged', function(){ 

                    if ( $( this ).hasClass( 'sp-play' ) ) {
                        $this.addClass( 'play' ).removeClass( 'pause loading' );
                    } else if ( $( this ).hasClass( 'sp-pause' ) ) {
                        $this.addClass( 'pause' ).removeClass( 'play loading' );
                    } else if ( $( this ).hasClass( 'sp-loading' ) ) {
                        $this.addClass( 'loading' ).removeClass( 'play pause' );
                    } else {
                        $this.removeClass( 'play pause loading' );
                    }
                    current = $(this).parent().index();

                    // Replace details
                    if ( $this.data( 'current') != current ) {
                        $this.data( 'current', current);

                        // Cover
                        if ( ! has_cover  ) {
                            var cover = $( this ).attr( 'data-cover_full' );
                            $this.find( '.music-album--cover' ).addClass('old');
                            $this.find( '.music-album--img-holder' ).append( '<div class="music-album--cover temp" style="background-image:url(' + cover + ')"></div>' );
                        }

                        // Waveform
                        var waveform = $( this ).attr( 'data-waveform');
                        $this.find( '.music-album--waveform-wrap img' ).addClass('old');
                        if ( waveform != '' ) {
                            $this.find( '.music-album--waveform-top' ).append( '<img class="temp" src="' + waveform  + '" alt="image waveform" />' );
                            $this.find( '.music-album--waveform-bottom' ).append( '<img class="temp" src="' + waveform  + '" alt="image waveform" />' );
                        }

                        // Meta
                        var title = $( this ).find( '.track-title' ).text(),
                            artists = $( this ).find( '.artists' ).text();
                            $this.find( '.music-album--meta span' ).removeClass( 'is-active' );

                        setTimeout(function(){
                            $this.find( '.music-album--meta span' ).text( '');
                            if ( title != '' ) {
                                $this.find( '.music-album--title span' ).text( title ).addClass('is-active');
                            }
                            if ( artists != '' ) {
                                $this.find( '.music-album--artists span' ).text( artists ).addClass('is-active');
                            }
                        },500); 

                        setTimeout(function(){
                            if ( ! has_cover  ) {
                                $this.find( '.music-album--img-holder' ).addClass('is-active');
                            }
                        
                            $this.find( '.music-album--waveform-wrap' ).addClass('is-active');

                                setTimeout(function(){

                                    // Cover
                                    if ( ! has_cover  ) {
                                        $this.find( '.music-album--cover.old' ).remove();
                                        $this.find( '.music-album--cover.temp' ).removeClass('temp');
                                        $this.find( '.music-album--img-holder' ).removeClass('is-active');
                                    }

                                    // Waveform
                                    $this.find( '.music-album--waveform-wrap img.old' ).remove();
                                    $this.find( '.music-album--waveform-wrap img.temp' ).removeClass('temp');
                                    $this.find( '.music-album--waveform-wrap' ).removeClass('is-active');

                                },500);
                        },100);

                    }

                });

                // Prev
                $( this ).find( '.music-album--prev' ).on('click', function(){
                    sc.scamp_player.playerAction( 'stop' );
                    current--;
                    if ( current <= -1  ) {
                        current = limit;
                    }
                    $list.find( 'li:eq('+current+') a.sp-play-track' ).trigger('click');

                });

                // Next
                $( this ).find( '.music-album--next' ).on('click', function(){
                    sc.scamp_player.playerAction( 'stop' );
                    current++;
                    if ( current > limit  ) {
                        current = 0;
                    }
                    $list.find( 'li:eq('+current+') a.sp-play-track' ).trigger('click');
                });

                // Play
                $( this ).find( '.music-album--play' ).on('click', function(){
                    $list.find( 'li:eq('+current+') a.sp-play-track' ).trigger('click');
                });

            });

        },


        /* Scamp Player
		 -------------------------------- */
        player: {

            init: function() {

                // Add Iframe
                var isMobile = false; //initiate as false
                // device detection
                if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
                    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
                    isMobile = true;
                }

                if ( isMobile == false ) {
                    var iframe = document.createElement('iframe');
                    iframe.style.display = "none";
                    iframe.allow = 'autoplay';
                    iframe.id = 'audio';
                    iframe.src = scamp_vars.plugin_uri + '/blank.mp3';
                    document.body.appendChild(iframe);
                }

                var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);

                if ( isSafari ) {
                    var analyser = false;
                    scamp_vars.autoplay = false;
                } else {
                    var analyser = true;
                }


                sc.scamp_player = new $.ScampPlayer($('#scamp_player'),{

                    // Default Scamp Player options
                    volume: scamp_vars.volume,
                    // Start volume level
                    autoplay: scamp_vars.autoplay,
                    // Autoplay track
                    no_track_image: scamp_vars.plugin_assets_uri + '/images/no-track-image.png',
                    // Placeholder image for track cover
                    path: scamp_vars.plugin_uri,
                    loop: scamp_vars.loop,
                    // Loop tracklist
                    load_first_track: scamp_vars.load_first_track,
                    // Load First track
                    random: scamp_vars.random,
                    // Random playing
                    titlebar: scamp_vars.titlebar,
                    // Replace browser title on track title
                    client_id: scamp_vars.soundcloud_id,
                    // Soundcloud Client ID
                    shoutcast: scamp_vars.shoutcast,
                    enable_analyser: analyser,
                    base64: scamp_vars.base64,
                    shoutcast_interval: scamp_vars.shoutcast_interval,
                    player_content: '<div id="sp-toggle-wrap"><div id="sp-toggle"></div></div><div class="sp-main-container"><div class="sp-queue-container"><div class="sp-queue"><div id="sp-scroller"><table id="sp-queue-scroll"><thead><tr><th class="sp-list-controls" colspan="5"><span id="sp-empty-queue">'+ scamp_vars.empty_queue +'</span></th></tr><tr><th>'+ scamp_vars.play_label +'</th><th>'+ scamp_vars.cover_label +'</th><th class="sp-th-title">'+ scamp_vars.title_label +'</th><th class="sp-th-cart sp-small-screen">'+ scamp_vars.buy_label +'</th><th class="sp-th-remove sp-small-screen sp-medium-screen">'+ scamp_vars.remove_label +'</th></tr></thead><tbody></tbody></table></div></div><div class="sp-progress-mobile"><div class="sp-progress"><span class="sp-loading"></span><span class="sp-position"></span><span class="sp-time-elapsed"></span><span class="sp-time-total"></span></div></div></div><div class="sp-player-container"><div class="sp-buttons-container"><div class="sp-controls"><a class="sp-prev-button"></a><a class="sp-play-button"></a><a class="sp-next-button"></a><div class="sp-volume-container"><div class="sp-volume-bar-container"><div class="sp-volume-slider"><span class="sp-volume-position"></span></div></div><a class="sp-volume-button sp-show-volume"></a></div></div><div class="sp-queue-button-container"><span class="sp-badge"></span><a class="sp-queue-button"></a></div></div><div class="sp-progress-container"><div class="sp-progress"><span class="sp-loading"></span><span class="sp-position"></span><span class="sp-time-elapsed"></span><span class="sp-time-total"></span></div></div><div class="sp-track-container"><div class="sp-track-details"><a class="sp-track-cover"><img src="' + scamp_vars.plugin_assets_uri + 'images/no-track-image.png" alt="Track cover" class="sp-track-artwork"/></a><a class="sp-track-title"></a><a class="sp-track-artist"></a><div class="sp-marquee-container"><span class="sp-marquee"></span></div></div></div></div></div>',
                    debug: false,
                });

            },
           
        },

    }

}(jQuery));