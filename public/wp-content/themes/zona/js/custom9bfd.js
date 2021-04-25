// When DOM is fully loaded
jQuery(document).ready(function($) {

	"use strict";


	/* Main Settings
	 ---------------------------------------------------------------------- */

	// Detect Touch Devices
	var isTouch = ( ( 'ontouchstart' in window ) || ( navigator.msMaxTouchPoints > 0 ) );

	if ( isTouch ) {

		$( 'body' ).addClass( 'touch-device' );

	}


	/* Remove / Update plugins after page loaded
	 ---------------------------------------------------------------------- */
	(function() {

		if ( $.fn.waypoints ) {
				setTimeout(function(){
				$.waypoints('refresh');
				$.waypoints( 'destroy' );
			}, 400)
		}

		// Isotope
		if ( $.fn.isotope ) {
			if ( $( '.masonry' ).data( 'isotope') ) {
				$( '.masonry' ).isotope( 'destroy' );
			}
			if ( $( '.items' ).data( 'isotope') ) {
				$( '.items' ).isotope( 'destroy' );
			}
		}
		
		
	})();


	/* Responsive navigation
	 ---------------------------------------------------------------------- */
	(function() {

		// If menu is activated
		if ( $( '#responsive-nav' ).hasClass( 'activated' ) ) {
			return
		}

	 	if ( $( '#layer--nav-wrapper').length && $( '#layer--nav-wrapper').children().length ) {


		 	// Scroll
			var responsive_scroll = new IScroll( '#layer--nav-wrapper', {
			    mouseWheel: true,
			    interactiveScrollbars: true,
			    scrollbars: 'custom',
			    click: true
			});

			$( '#responsive-nav' ).addClass( 'activated' );

			// Navigation list
			$( '#responsive-nav .menu-item-has-children > a' ).each(function(){
				$( this ).after('<i class="submenu-trigger icon icon-angle-down"></i>' );
			});

			$( '#responsive-nav > ul > li' ).addClass( 'first-child' );
			$( '#responsive-nav .submenu-trigger, #responsive-nav .menu-item-has-children > a[href="#"]' ).on( 'click', function(e){
				e.preventDefault();
				var li = $( this ).closest('li'),
					main_index = $( this ).parents( '.first-child' ).index(),
					open_li = $( '#responsive-nav > ul > li:not(:eq('+main_index+'))'),
					main_parent;

				if ( $( this ).parent().hasClass( 'first-child' ) ) {
					main_parent = $( this ).parent().children();
					main_parent.find('.is-visible').removeClass( 'is-visible' );
					main_parent.find( 'ul:visible' ).slideUp(0);
				}
				open_li.removeClass( 'is-visible' );
				li.toggleClass( 'is-visible' );

				open_li.find( 'ul:visible' ).slideUp();
				li.find( ' > ul' ).slideToggle(400);
				setTimeout( function(){ responsive_scroll.refresh() }, 400  );
			});

			/* Responsive Layer */
			$( '.nav--responsive-trigger' ).on( 'click', function(){
		 		$( '.layer--nav' ).addClass( 'is-active is-nav' ).css( 'visibility', 'visible' );
		 		responsive_scroll.refresh();
		 	});
		 	$( '.layer--nav .layer--close' ).on( 'click', function(){
		 		$( '.layer--nav' ).removeClass( 'is-active is-nav' ).css( 'visibility', 'visible' );
		 		setTimeout( function(){
		 			$( '.layer--nav' ).css( 'visibility', 'hidden' );
		 			$( '#responsive-nav .is-visible' ).removeClass( 'is-visible' ).find( 'ul:visible' ).slideUp();
		 		}, 300);
		 	});
		 	$( '#responsive-nav a:not([href="#"])' ).on( 'click' , function(){
		 		setTimeout( function(){
		 			$( '.layer--nav' ).css( 'visibility', 'hidden' ).removeClass( 'is-active is-nav' );
		 			$( '#responsive-nav .is-visible' ).removeClass( 'is-visible' ).find( 'ul:visible' ).slideUp();
		 		}, 800);

			});

			
	 	}
	 })();



	/* Scroll Actions
	 ---------------------------------------------------------------------- */
	(function() {
		$( '#wpadminbar' ).css( 'position', 'fixed' );

		// Fixed header
		if ( $( 'body' ).hasClass( 'header-fixed' ) ) {

			// Overlay
			if ( $( 'body' ).hasClass( 'header-overlay' ) ) {

				var scroll_actions = function() {
					var st = $( window ).scrollTop();

					if ( st > 0 ) {
						$( '.header-overlay .main-header' ).removeClass('ontop');
					} else {
						$( '.header-overlay .main-header' ).addClass('ontop');
					}

				}

				$( window ).on( 'scroll', scroll_actions );

				scroll_actions();
	
			}

			// wpadmin bar fix
			if ( $( '#wpadminbar' ).length ) {
				var resize_actions = function() {
					var admin_bar_h = $( '#wpadminbar' ).outerHeight();
					$( '.header-fixed .main-header .header--wrap' ).css( 'top', admin_bar_h )
				}

				resize_actions();
				$( window ).on( 'resize', resize_actions );
			}
			return;
		}

		// Fixed header
		if ( $( 'body' ).hasClass( 'header-fixed' ) ) {

			// wpadmin bar fix
			if ( $( '#wpadminbar' ).length ) {
				var resize_actions = function() {
					var admin_bar_h = $( '#wpadminbar' ).outerHeight();
					$( '.header-fixed .main-header .header--wrap' ).css( 'top', admin_bar_h )
				}

				resize_actions();
				$( window ).on( 'resize', resize_actions );
			}
			return;
		}

		// Static header
		if ( $( 'body' ).hasClass( 'header-static' ) ) {
			return;
		}

		var header_h = $( '.header' ).outerHeight();
		$( '.header' ).css( 'height', header_h );
		$( '.header--moving' ).addClass( 'sticky' );

		// Moving header
		var 
			nav_h,
			sticky_nav_h = 0,
			moving_header_h = 0,
			lastScrollTop = 0;

		// Scroll
		var scroll_actions = function() {
			var st = $( window ).scrollTop(),
				wh = $( window ).height();

			header_h = $( '.header' ).outerHeight();

			// Down
			if ( st > lastScrollTop ){
				if ( st > 0 ) {
					$( '.header--moving' ).css( 'margin-top', -sticky_nav_h );
				}

			// UP
			} else {
				if ( st < header_h ) {
					$( '.header--moving' ).css( 'margin-top', 0 );
				}
				
			}
			lastScrollTop = st;

		};

		scroll_actions();
		$( window ).on( 'scroll', scroll_actions );

		// Resize
		var resize_actions = function() {

			nav_h = $( '.nav--wrapper' ).outerHeight();
			sticky_nav_h = 0;

			header_h = $( '.header--moving' ).outerHeight();
			sticky_nav_h = header_h - nav_h;

			moving_header_h = $( '.header--moving' ).outerHeight();
			$( '.header' ).css( 'height', moving_header_h );

			scroll_actions();
		}

		resize_actions();
		$( window ).on( 'resize', resize_actions );

	})();


	/* Parallax
	 ---------------------------------------------------------------------- */
	(function() {

		var images;
		
		function init() {
			images = [].slice.call( $('.slider--parallax') );
			if(!images.length) { return }
			
			$( window ).on( 'scroll', doParallax );
			$( window ).on( 'resize', doParallax );
			doParallax();
		}
		
		function getViewportHeight() {
			var a = document.documentElement.clientHeight, b = window.innerHeight;
			return a < b ? b : a;
		}
		
		function getViewportScroll() {
			if(typeof window.scrollY != 'undefined') {
				return window.scrollY;
			}
			if(typeof pageYOffset != 'undefined') {
				return pageYOffset;
			}
			var doc = document.documentElement;
			doc = doc.clientHeight ? doc : document.body;
			return doc.scrollTop;
		}
		
		function doParallax() {
			var el, elOffset, elHeight,
				offset = getViewportScroll(),
				vHeight = getViewportHeight();
			
			for(var i in images) {
				el = images[i];
				if ( $( el ).css( 'background-image' ) != 'none') {
					elOffset = el.offsetTop;
					elHeight = el.offsetHeight;
					
					if((elOffset > offset + vHeight) || (elOffset + elHeight < offset)) { continue; }
					
					el.style.backgroundPosition = '50% '+Math.round((elOffset - offset)*3/8)+'px';
				}
			}
		}

		init()
	})();


	/* DISQUS
	 ---------------------------------------------------------------------- */
	(function() {

 		if ( $( '#disqus_thread' ).length <= 0 ) return;

 		var 
 			disqus_identifier = $( '#disqus_thread' ).attr( 'data-post_id' ),
 			disqus_shortname = $( '#disqus_thread' ).attr( 'data-disqus_shortname' ),
 			disqus_title = $( '#disqus_title' ).text(),
 			disqus_url = window.location.href;
 		/* * * Disqus Reset Function * * */
		if ( typeof DISQUS != 'undefined' ) {
			DISQUS.reset({
	            reload: true,
	            config: function () {
	                this.page.identifier = disqus_identifier;
	                this.page.url = disqus_url;
	                this.page.title = disqus_title;
	            }
	        });
		} else {
			var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
    		dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
    		(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		}


 	})();

	/* Tracklist
	 ---------------------------------------------------------------------- */
	(function() {

 		if ( $( '.sp--tracklist' ).length <= 0 ) return;

 		// Add fixed width to progress elements
 		function tracklist_resize() {

 			var progress_width = $( '.sp--tracklist li' ).width();
 			$( '.track-row-progress .sp-content-position span' ).css( 'width', progress_width+'px' );
 			$( '.track-row-progress .sp-content-loading span' ).css( 'width', progress_width+'px' );

 			if ( typeof sc.scamp_player !== 'undefined' && sc.scamp_player != null ) {
				sc.scamp_player.update_events('body');
			
			}

 		}


 		$( window ).on( 'resize', tracklist_resize );
		tracklist_resize();

		// Lyrics button
		$( '.sp--tracklist li .track-lyrics' ).on( 'click', function(){
			var $this = $( this ),
			$li = $this.parents( 'li' ),
			$list = $this.parents( '.sp--tracklist' );

			$list.find( 'li').not($li).find( '.track-row-lyrics' ).slideUp();
			$list.find( 'li').not($li).find( '.track-lyrics.is-active' ).removeClass( 'is-active' );

			$this.toggleClass( 'is-active' );
			$li.find( '.track-row-lyrics' ).slideToggle();


		});



 	})();


	/* Content Slider
	 ---------------------------------------------------------------------- */
	(function() {

 		if ( $( '.slider--content' ).length <= 0 ) return;

		$( '.slider--content' ).each( function() {

			// Carousel slider
			var 
				content_slider = $( this ),
				id = '#' + $( this ).attr( 'id' ),
				owl = $( id ),
				navigation = content_slider.data( 'slider-nav' ),
				pagination = content_slider.data( 'slider-pagination' ),
				speed = content_slider.data( 'slider-speed' ),
				pause_time = content_slider.data( 'slider-pause-time' ),
				auto_height = content_slider.data( 'auto-height' ),
				autoplay = false;

				if ( pause_time > 0 ) {
					autoplay = true;
				} 

			owl.on('changed.owl.carousel', function(e) {

					return false;
                	var 
                		$this = $( e.target ),
                		$this_slide = $this.find( '.owl-item.active' );
                	var bg = $this_slide.find( '.slider--parallax' ).css('background-position');

                	$this.find( '.owl-item:not(.active) .slider--parallax' ).css( 'background-position', 'center top' );

                	
                });

			owl.owlCarousel({
			    nav : navigation,
			    navText : ['', ''],
			    dots : pagination,
			    smartSpeed : speed,
			    autoplayTimeout : pause_time,
			    autoplay : autoplay,
			    autoHeight:auto_height,
			    autoplayHoverPause : true,
			    loop: true,
			    items : 1,
			    video : false,

	  		});

	  		var slider_sizes = function() {
			setTimeout( function(){

				var 
					s = content_slider,
					w = s.outerWidth(),
					all_classes = 'slider--small slider--medium slider--large'

				if ( w <= 300 )
				    s.removeClass( all_classes ).addClass( 'slider--small' );
				else if ( w <= 768 )
				    s.removeClass( all_classes ).addClass( 'slider--medium' );
				else if ( w <= 1170 )
				    s.removeClass( all_classes ).addClass( 'slider--large' );
				else
				    s.removeClass( all_classes );


			 }, 100);
		}

		$( window ).on( 'resize', slider_sizes );
		slider_sizes();

		});
		
  	})();


  	/* Carousel Slider
	 ---------------------------------------------------------------------- */
	(function() {

 		if ( $( '.slider--carousel' ).length <= 0 ) return;

		$( '.slider--carousel' ).each( function() {

			// Carousel slider
			var 
				content_slider = $( this ),
				id = '#' + $( this ).attr( 'id' ),
				owl = $( id ),
				navigation = content_slider.data( 'slider-nav' ),
				pagination = content_slider.data( 'slider-pagination' ),
				speed = content_slider.data( 'slider-speed' ),
				pause_time = content_slider.data( 'slider-pause-time' ),
				auto_height = content_slider.data( 'auto-height' ),
				items = $( this ).data( 'items' ),
				autoplay = false;

				if ( pause_time > 0 ) {
					autoplay = true;
				} 

			owl.owlCarousel({
			    nav : navigation,
			    navText : ['', ''],
			    dots : pagination,
			    smartSpeed : speed,
			    autoplayTimeout : pause_time,
			    autoplay : autoplay,
			    autoHeight:auto_height,
			    autoplayHoverPause : true,
			    loop: true,
			    items : items,
			    video : false,
			    responsiveClass:true,
			    responsive:{
			        0:{
			            items:1,
			            dots:false,
			            nav:true
			        },
			        600:{
			            items:2,
			        },
			        900:{
			            items : items,
			        },
			    }

	  		});


		});
		
  	})();


	/* Small Functions
	 ---------------------------------------------------------------------- */
	(function() {

		
		/* Pause player on Iframe videos */
		$( 'a.iframebox, .float--videos a, .videos--grid a' ).on( 'click', function(){
			if ( typeof sc.scamp_player !== 'undefined' && sc.scamp_player != null ) {
				sc.scamp_player.playerAction( 'pause' );
			}
		
		} );


		/* Resonsive videos
	 	 ------------------------- */
		if ( $.fn.ResVid ) {
			$( 'body' ).ResVid();
		}

		/* Custom Post Navigation
	 	 ------------------------- */
		if ( ! $( 'body' ).hasClass( 'wp-ajax-loader' ) && $('.custom-post-nav' ).length ) {
			
			$('.custom-post-nav' ).detach().appendTo( 'body' );
			setTimeout( function() { $('.custom-post-nav' ).addClass( 'is-active' ); },1000 );
		}

		/* Search
	 	 ------------------------- */
	 	$( 'a[href="#show-search"]' ).on( 'click', function(){
	 		$( '.layer--search' ).addClass( 'is-active is-searching' ).css( 'visibility', 'visible' );
	 		return false;
	 	});
	 	$( '.layer--search .layer--close' ).on( 'click', function(){
	 		$( '.layer--search' ).removeClass( 'is-active is-searching' ).css( 'visibility', 'visible' );
	 		setTimeout( function(){
	 			$( '.layer--search' ).css( 'visibility', 'hidden' );
	 		}, 300);
	 	});
	 	$( '.layer--search #s' ).focusout(function(){
    		$( '.layer--search' ).removeClass( 'is-focused' );
		});
	 	$( '.layer--search #s' ).focusin(function(){
    		$( '.layer--search' ).addClass( 'is-focused' );
		});

		$( '.layer--searchform' ).submit(function (e) {
	 		setTimeout( function(){
	 			$( '.layer--search' ).css( 'visibility', 'hidden' ).removeClass( 'is-active is-searching' );
	 			$( '.layer--search #s' ).val( '' );
	 		}, 800);

		});

		// Waypoints
		$( '.is-anim .item-anim' ).waypoint( function() {

				if ( $( this ).hasClass( 'is-ready' ) ) return false;

				$( this ).addClass( 'is-ready' );
		}, {
			offset : '90%'
		});
		
		// Spotify
		 $( 'iframe[src*="embed.spotify.com"]' ).each(function() {
        	$(this).attr( 'width', '100%' );
    	}); 
	

	})();


	/* Google Maps
	 ---------------------------------------------------------------------- */
	(function() {
		if ( $.fn.gmap3 ) {

			$( '.gmap' ).each( function(){

				// Get Marker
				var marker = '';
				if ( theme_vars.map_marker !== '' ) {
					marker = theme_vars.map_marker;
				} else {
					marker = theme_vars.theme_uri + '/images/map-marker.png';
				}

				var 
					gmap = $( this ),
					address = gmap.data( 'address' ), // Google map address e.g 'Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia'
					zoom = gmap.data( 'zoom' ), // Map zoom value. Default: 16
					zoom_control, // Use map zoom. Default: true
					scrollwheel; // Enable mouse scroll whell for map zooming: Default: false

				if ( gmap.data( 'zoom_control' ) == 'true' ) {
					zoom_control = true;
				} else {
					zoom_control = false;
				}

				if ( gmap.data( 'scrollwheel' ) == 'true' ) {
					scrollwheel = true;
				} else {
					scrollwheel = false;
				}

				gmap.gmap3({
						address: address,
						zoom: zoom,
						zoomControl: zoom_control, // Use map zoom. Default: true
						scrollwheel: scrollwheel, // Enable mouse scroll whell for map zooming: Default: false
						mapTypeId : google.maps.MapTypeId.ROADMAP,
						mapTypeControlOptions: {
				          mapTypeIds: [google.maps.MapTypeId.ROADMAP, "style1"]
				        },
				        styles: [
						    {
						        "featureType": "all",
						        "elementType": "labels.text.fill",
						        "stylers": [
						            {
						                "saturation": 36
						            },
						            {
						                "color": "#696969"
						            },
						            {
						                "lightness": 40
						            }
						        ]
						    },
						    {
						        "featureType": "all",
						        "elementType": "labels.text.stroke",
						        "stylers": [
						            {
						                "visibility": "on"
						            },
						            {
						                "color": "#000000"
						            },
						            {
						                "lightness": 16
						            }
						        ]
						    },
						    {
						        "featureType": "all",
						        "elementType": "labels.icon",
						        "stylers": [
						            {
						                "visibility": "off"
						            }
						        ]
						    },
						    {
						        "featureType": "administrative",
						        "elementType": "geometry.fill",
						        "stylers": [
						            {
						                "color": "#000000"
						            },
						            {
						                "lightness": 20
						            }
						        ]
						    },
						    {
						        "featureType": "administrative",
						        "elementType": "geometry.stroke",
						        "stylers": [
						            {
						                "color": "#000000"
						            },
						            {
						                "lightness": 17
						            },
						            {
						                "weight": 1.2
						            }
						        ]
						    },
						    {
						        "featureType": "landscape",
						        "elementType": "geometry",
						        "stylers": [
						            {
						                "color": "#000000"
						            },
						            {
						                "lightness": 20
						            }
						        ]
						    },
						    {
						        "featureType": "landscape",
						        "elementType": "labels.text",
						        "stylers": [
						            {
						                "lightness": "-8"
						            }
						        ]
						    },
						    {
						        "featureType": "landscape",
						        "elementType": "labels.text.fill",
						        "stylers": [
						            {
						                "visibility": "on"
						            },
						            {
						                "gamma": "1.60"
						            }
						        ]
						    },
						    {
						        "featureType": "poi",
						        "elementType": "geometry",
						        "stylers": [
						            {
						                "color": "#000000"
						            },
						            {
						                "lightness": 21
						            }
						        ]
						    },
						    {
						        "featureType": "road.highway",
						        "elementType": "geometry.fill",
						        "stylers": [
						            {
						                "color": "#2f2f2f"
						            },
						            {
						                "lightness": 17
						            }
						        ]
						    },
						    {
						        "featureType": "road.highway",
						        "elementType": "geometry.stroke",
						        "stylers": [
						            {
						                "color": "#000000"
						            },
						            {
						                "lightness": 29
						            },
						            {
						                "weight": 0.2
						            }
						        ]
						    },
						    {
						        "featureType": "road.arterial",
						        "elementType": "geometry",
						        "stylers": [
						            {
						                "color": "#1f1f1f"
						            },
						            {
						                "lightness": 18
						            }
						        ]
						    },
						    {
						        "featureType": "road.local",
						        "elementType": "geometry",
						        "stylers": [
						            {
						                "color": "#323232"
						            },
						            {
						                "lightness": 16
						            }
						        ]
						    },
						    {
						        "featureType": "transit",
						        "elementType": "geometry",
						        "stylers": [
						            {
						                "color": "#000000"
						            },
						            {
						                "lightness": 19
						            }
						        ]
						    },
						    {
						        "featureType": "water",
						        "elementType": "geometry",
						        "stylers": [
						            {
						                "color": "#000000"
						            },
						            {
						                "lightness": "12"
						            }
						        ]
						    }
						]
					}).marker({
						address: address,
				        icon: marker
				});


			});

		}
	})();


	/* Magnific popup
 	 ---------------------------------------------------------------------- */
	(function() {
	 
	 	// Image
		$( '.imagebox' ).magnificPopup( { 
			type:'image',
			closeMarkup: '<a href="#" class="mfp-close"></a>',
		} );
		// iframe
		$( 'body' ).magnificPopup( { 
			delegate: '.iframebox',
			type:'iframe',
			iframe: {
		    	markup: '<div class="mfp-iframe-scaler">'+
		                '<div class="mfp-close"></div>'+
		                '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
		                '<div class="mfp-title">Some caption</div>'+
		              '</div>'
		  	},
		  	callbacks: {
		    	markupParse: function(template, values, item) {
		     		values.title = item.el.attr('title');

		    	}
		  	},

			closeMarkup: '<a href="#" class="mfp-close"></a>',
		} );
		$( '.vclightbox .vc_figure a' ).magnificPopup( { 
			type:'image', 
			closeMarkup: '<a href="#" class="mfp-close"></a>',
		} );
		$( '.vcvideobox .vc_single_image-wrapper' ).magnificPopup( { 
			type:'iframe', 
			closeMarkup: '<a href="#" class="mfp-close"></a>',
		} );
		// WP Gallery
		$( '.gallery' ).each(function() {

			var gallery = $( this ),
				id = $( this ).attr( 'id' ),
				attachment_id = false;
			if ( $( 'a[href*="attachment_id"]', gallery ).length ) {
				return false;
			}
			$( 'a[href*="uploads"]', gallery ).each( function(){
				$( this ).attr( 'data-group', id );
				$( this ).addClass( 'thumb' );
				if ( $( this ).parents( '.gallery-item' ).find( '.gallery-caption' ).length ) {
					var caption = $( this ).parents( '.gallery-item' ).find( '.gallery-caption' ).text();
					$( this ).attr( 'title', caption );
				}	

			});

			$( this ).magnificPopup({
				delegate: 'a',
				closeMarkup: '<a href="#" class="mfp-close"></a>',
		        type: 'image',
		        fixedBgPos: true,
		        gallery: {
		          	arrowMarkup: '<a href="#" class="mfp-arrow mfp-arrow-%dir%"></a>',
	          		enabled:true
		        }
		    });

		});

		// Theme Gallery
		$( '.images--grid' ).magnificPopup({
			delegate: 'a.g-item',
			closeMarkup: '<a href="#" class="mfp-close"></a>',
	        type: 'image',
	        image: {
				verticalFit: true,
			},
			callbacks: {
			    elementParse: function( item ) {

					if ( item.el.hasClass( 'iframe-link' ) ) {
						item.type = 'iframe';
					} else {
						item.type = 'image';
					}

			    }
			},
	        gallery: {
	        	arrowMarkup: '<a href="#" class="mfp-arrow mfp-arrow-%dir%"></a>',
	          	enabled:true
	        }
	    });


	})();

});