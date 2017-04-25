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
});
