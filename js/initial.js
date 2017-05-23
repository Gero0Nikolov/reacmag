jQuery( document ).ready(function(){
    jQuery( window ).scroll(function(){
        if ( jQuery( window ).scrollTop() >= 10 ) {
            jQuery( "#sticky-bar" ).css( {
                "padding-top" : "0.85em",
                "padding-bottom" : "0.85em"
            } );
        } else {
            jQuery( "#sticky-bar" ).css( {
                "padding-top" : "1.5em",
                "padding-bottom" : "1.5em"
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

    if ( jQuery( "body" ).hasClass( "single" ) || jQuery( "body" ).hasClass( "search-results" ) ) {
        jQuery( '.owl-carousel' ).owlCarousel({
    	    center: false,
    	    items: 4,
    	    loop: false,
    	    margin: 10,
            dots: true,
            nav: false,
            autoplay: false,
    	    responsive:{
                0:{
                    items:1
                },
    	        600:{
    	            items:4
    	        }
    	    }
    	});
    } else {
        jQuery( '.owl-carousel' ).owlCarousel({
    	    center: true,
    	    items: 1,
    	    loop: true,
    	    margin: 0,
            dots: false,
            nav: false,
            autoplay: true,
    	    responsive:{
    	        600:{
    	            items:1
    	        }
    	    }
    	});
    }

	if ( jQuery( ".promote" ).length ) {
		jQuery( ".promote #buy-controller" ).each( function(){
			jQuery( this ).on( "click", function(){
				promotion_id = jQuery( this ).attr( "promotion-id" );
				jQuery.ajax( {
					url : ajax_url,
					type : "POST",
					data : {
						action : "buy_promotion",
						promotion_id : promotion_id
					},
					success : function( response ) {
						response = JSON.parse( response );
						console.log( response );

						if ( response == "login-action" ) { window.location = window.location.origin +"/login"; }
						else {}
					}
				} );
			} );
		} );
	}

	if ( jQuery( "#login-form" ).length ) {
		jQuery( "#login-form #password" ).on( "keyup", function( e ){ if ( e.keyCode == 13 ) { loginUser(); } });
		jQuery( "#login-form #login-button" ).on( "click", function( e ){ loginUser(); } );
	}

	if ( jQuery( "#registration-form" ).length ) {
		jQuery( "#registration-form #password" ).on( "keyup", function( e ){ if ( e.keyCode == 13 ) { registerUser(); } });
		jQuery( "#registration-form #register-button" ).on( "click", function(){ registerUser(); } );
	}

	if ( jQuery( "#my-profile" ).length ) {
		jQuery( "#my-profile .controller" ).each(function(){
			jQuery( this ).on( "click", function(){
				if ( jQuery( this ).attr( "id" ) != "logout-controller" ) {
					jQuery( "#my-profile .active" ).each(function(){ jQuery( this ).removeClass( "active" ); });
					tab_id = "#"+ jQuery( this ).attr( "id" ).split( "-controller" )[ 0 ];
					jQuery( this ).addClass( "active" );
					jQuery( "#my-profile #tabs "+ tab_id ).addClass( "active" );
				} else {
					jQuery.ajax( {
						url : ajax_url,
						type : "POST",
						data : {
							action : "logout_user"
						},
						success : function( response ) {
							response = JSON.parse( response );
							if ( response == "logout" ) { window.location = window.location.origin; }
							else { console.log( response ); }
						},
						error : function( response ){}
					} );
				}
			} );
		});

		jQuery( "#my-profile #general #user-password" ).on( "keyup", function( e ){
			if ( e.keyCode == 13 ) { jQuery( "#my-profile #update-general-info" ).trigger( "click" ); }
		} );

		jQuery( "#my-profile #update-general-info" ).on( "click", function(){
			var args = {
				email : jQuery( "#my-profile #general #user-email" ).val().trim(),
				password : jQuery( "#my-profile #general #user-password" ).val().trim()
			};

			view_ = "\
			<div id='popup' class='animated fadeIn'>\
				<div id='popup-inner'>\
					<button id='popup-closer' class='close-button'>\
						<span class='bar'></span>\
						<span class='bar'></span>\
					</button>\
					<input id='confirm-password' type='password' placeholder='Your current password...'>\
				</div>\
			</div>\
			";

			jQuery( "body" ).append( view_ );

			jQuery( "#popup #popup-closer" ).on( "click", function(){
				removePopup();
			} );

			jQuery( "#popup #popup-inner #confirm-password" ).focus().on( "keyup", function( e ){
				if ( e.keyCode == 13 ) {
					args.current_password = jQuery( this ).val();

					jQuery.ajax( {
						url : ajax_url,
						type : "POST",
						data : {
							action : "update_general_info",
							args : args
						},
						success : function( response ) {
							result_ = JSON.parse( response );
							if ( result_ == "updated" ) { window.location.reload( true ); }
							else { removePopup(); trowError( result_ ); }
						},
						error : function( response ) {}
					} );
				}
			} );
		} );

		jQuery( "#my-profile #add-contents-controller" ).on( "click", function(){
			jQuery( "#my-profile #add-contents-container" ).toggle();
			jQuery( "#my-profile #add-contents-container #post-title" ).val( "" );
			jQuery( "#my-profile #add-contents-container #link-to-featuredimage" ).val( "" );
			jQuery( "#my-profile #add-contents-container #link-to-content" ).val( "" );
		} );

		jQuery( "#my-profile #upload-content" ).on( "click", function(){
			args = {
				content_id : jQuery( "#my-profile #add-contents-container #form" ).attr( "content-id" ),
				post_title : jQuery( "#my-profile #add-contents-container #post-title" ).val().trim(),
				featured_image : jQuery( "#my-profile #add-contents-container #link-to-featuredimage" ).val().trim(),
				content : jQuery( "#my-profile #add-contents-container #link-to-content" ).val().trim()
			};

			jQuery.ajax( {
				url : ajax_url,
				type : "POST",
				data : {
					action : "add_content",
					args : args
				},
				success : function( response ) {
					result_ = JSON.parse( response );
					console.log( result_ );
					if ( result_ == "added" ) { window.location.reload( true ); }
					else { trowError( result_ ); }
				},
				error : function( response ) {}
			} );
		} );

		jQuery( "#my-profile #edit-controller" ).each( function(){
			jQuery( this ).on( "click", function(){
				content_id = jQuery( this ).attr( "content-id" );

				jQuery( "#my-profile #add-contents-container #form" ).attr( "content-id", content_id );
				jQuery( "#my-profile #add-contents-container #post-title" ).val( jQuery( "#my-profile #content-"+ content_id +" #title" ).html() );
				jQuery( "#my-profile #add-contents-container #link-to-featuredimage" ).val( jQuery( "#my-profile #content-"+ content_id +" #featured-image" ).children( "a" ).attr( "href" ) );
				jQuery( "#my-profile #add-contents-container #link-to-content" ).val( jQuery( "#my-profile #content-"+ content_id +" #content" ).children( "a" ).attr( "href" ) );

				jQuery( "#my-profile #add-contents-container" ).show();
			} );
		} );
	}
});

function loginUser() {
	args = {
		email : jQuery( "#login-form #email" ).val().trim(),
		password : jQuery( "#login-form #password" ).val().trim()
	};

	jQuery( "#login-form #login-button" ).addClass( "jello" );

	jQuery.ajax( {
		url : ajax_url,
		type : "POST",
		data : {
			action : "login_user",
			args : args
		},
		success : function( response ){
			result_ = JSON.parse( response );
			jQuery( "#login-form #login-button" ).removeClass( "jello" );

			console.log( result_ );
			if ( result_ == "logged" ) { window.location = window.location.origin +"/my-profile"; }
			else { trowError( result_ ); }
		},
		error : function( response ){}
	} );
}

function registerUser() {
	args = {
		email : jQuery( "#registration-form #email" ).val().trim(),
		username : jQuery( "#registration-form #username" ).val().trim(),
		password : jQuery( "#registration-form #password" ).val().trim()
	};

	jQuery( "#registration-form #register-button" ).addClass( "jello" );

	jQuery.ajax( {
		url : ajax_url,
		type : "POST",
		data : {
			action : "register_user",
			args : args
		},
		success : function( response ){
			jQuery( "#registration-form #register-button" ).removeClass( "jello" );
			result_ = JSON.parse( response );
			console.log( result_ );
			if ( result_ == "registered" ) { trowError( "Welcome to Reacmag!" ); }
			else { trowError( result_ ); }
		},
		error : function( response ){}
	} );
}

function trowError( message ) {
	view_ = "\
	<div id='popup' class='animated fadeIn'>\
		<div id='popup-inner'>\
			<button id='popup-closer' class='close-button'>\
				<span class='bar'></span>\
				<span class='bar'></span>\
			</button>\
			<div class='text'>"+ message +"</div>\
		</div>\
	</div>\
	";

	jQuery( "body" ).append( view_ );

	jQuery( "#popup #popup-closer" ).on( "click", function(){
		removePopup();
	} );
}

function removePopup() {
	jQuery( "#popup" ).removeClass( "fadeIn" ).addClass( "fadeOut" );
	setTimeout(function(){ jQuery( "#popup" ).remove(); }, 750);
}
