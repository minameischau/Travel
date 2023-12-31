// NAVIGATION CALLBACK
jQuery(function($){
 	"use strict";
   	jQuery('.main-menu-navigation > ul').superfish({
		delay:     500,
		animation: {opacity:'show',height:'show'},  
		speed:     'fast'
   	});
});

jQuery(function($){
	$( '.toggle-menu button' ).click( function(e){
        $( 'body' ).toggleClass( 'show-main-menu' );
        var element = $( '.side-nav' );
        modern_blogger_trapFocus( element );
    });

    $( '.closebtn' ).click( function(e){
        $( '.toggle-menu button' ).click();
        $( '.toggle-menu button' ).focus();
    });
    $( document ).on( 'keyup',function(evt) {
        if ( $( 'body' ).hasClass( 'show-main-menu' ) && evt.keyCode == 27 ) {
            $( '.toggle-menu button' ).click();
            $( '.toggle-menu button' ).focus();
        }
    });

	setTimeout(function(){
		$(".tg-loader").delay(2000).fadeOut("slow");
	    $("#overlayer").delay(2000).fadeOut("slow");
	});

	setTimeout(function(){
		$(".preloader").delay(2000).fadeOut("slow");
	    $(".preloader .preloader-container").delay(2000).fadeOut("slow");
	});

	// back to top.
	$( window ).scroll( function() {
		if ( $( this ).scrollTop() > 200 ) {
			$( '.back-to-top' ).addClass( 'show-back-to-top' );
		} else {
			$( '.back-to-top' ).removeClass( 'show-back-to-top' );
		}
	});

	$( '.back-to-top' ).click( function() {
		$( 'html, body' ).animate( { scrollTop : 0 }, 200 );
		return false;
	});
});

function modern_blogger_trapFocus( element, namespace ) {
    var modern_blogger_focusableEls = element.find( 'a, button' );
    var modern_blogger_firstFocusableEl = modern_blogger_focusableEls[0];
    var modern_blogger_lastFocusableEl = modern_blogger_focusableEls[modern_blogger_focusableEls.length - 1];
    var KEYCODE_TAB = 9;

    modern_blogger_firstFocusableEl.focus();

    element.keydown( function(e) {
        var isTabPressed = ( e.key === 'Tab' || e.keyCode === KEYCODE_TAB );

        if ( !isTabPressed ) { 
            return;
        }

        if ( e.shiftKey ) /* shift + tab */ {
            if ( document.activeElement === modern_blogger_firstFocusableEl ) {
                modern_blogger_lastFocusableEl.focus();
                e.preventDefault();
            }
        } else /* tab */ {
            if ( document.activeElement === modern_blogger_lastFocusableEl ) {
                modern_blogger_firstFocusableEl.focus();
                e.preventDefault();
            }
        }

    });
}

(function( $ ) {
	jQuery(document).ready(function() {
		var owl = jQuery('#slider-section .owl-carousel');
			owl.owlCarousel({
				nav: true,
				autoplay:true,
				autoplayTimeout:9000,
				autoplayHoverPause:true,
				loop: true,
				navText : ['<i class="fas fa-arrow-left"></i>','<i class="fas fa-arrow-right"></i>'],
				responsive: {
				  0: {
				    items: 1
				  },
				  600: {
				    items: 1
				  },
				  1000: {
				    items: 1
				}
			}
		})
	})
})( jQuery );