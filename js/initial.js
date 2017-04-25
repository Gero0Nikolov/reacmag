jQuery( document ).ready(function(){
    jQuery( window ).scroll(function(){
        if ( jQuery( window ).scrollTop() >= 10 ) {
            jQuery( "#sticky-bar" ).css( {
                "padding-top" : "1em",
                "padding-bottom" : "1em"
            } );
        } else {
            jQuery( "#sticky-bar" ).css( {
                "padding-top" : "2em",
                "padding-bottom" : "2em"
            } );
        }
    });

    jQuery( "#menu-controller" ).on( "click", function(){
        global_menu = jQuery( ".global-menu" );
        if ( global_menu.hasClass( "active" ) ) {
            global_menu.removeClass( "active" ).css( {
                "opacity" : "0",
                "pointer-events" : "none"
            } );
        } else {
            global_menu.addClass( "active" ).css( {
                "opacity" : "1",
                "pointer-events" : "initial"
            } );
        }
    } );

    jQuery( "#menu-closer" ).on( "click", function(){
        global_menu = jQuery( ".global-menu" );
        if ( global_menu.hasClass( "active" ) ) {
            global_menu.removeClass( "active" ).css( {
                "opacity" : "0",
                "pointer-events" : "none"
            } );
        }
    } );

    jQuery( "#search-controller" ).on( "click", function(){
        global_search = jQuery( ".global-search" );
        if ( global_search.hasClass( "active" ) ) {
            global_search.removeClass( "active" ).css( {
                "opacity" : "0",
                "pointer-events" : "none"
            } );
        } else {
            global_search.addClass( "active" ).css( {
                "opacity" : "1",
                "pointer-events" : "initial"
            } );
        }
    } );

    jQuery( "#search-closer" ).on( "click", function(){
        global_search = jQuery( ".global-search" );
        if ( global_search.hasClass( "active" ) ) {
            global_search.removeClass( "active" ).css( {
                "opacity" : "0",
                "pointer-events" : "none"
            } );
        }
    } );

    jQuery( '.owl-carousel' ).owlCarousel({
	    center: true,
	    items: 1,
	    loop: true,
	    margin: 0,
        dots: false,
        autoplay: true,
	    responsive:{
	        600:{
	            items:1
	        }
	    }
	});
});
