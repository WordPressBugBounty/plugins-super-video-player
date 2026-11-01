/*
 * Pro switches on the player settings screen (free version).
 *
 * The captions, share, picture-in-picture, download and control-shadow
 * switches are Pro features and used to be locked completely. Players made
 * before 1.8.16 keep them switched on, so a free user who wanted to remove,
 * say, the download button was told to pay. Now a Pro switch that is ON can
 * be switched OFF; switching it on again needs Pro, so it locks once off.
 */
jQuery( function ( $ ) {
	var note = ( window.svpProSwitches && window.svpProSwitches.note ) || '';

	$( '.svp-pro-switch' ).each( function () {
		var $field = $( this );
		var $input = $field.find( '.csf--switcher input' ).first();

		if ( String( $input.val() ) !== '1' ) {
			return; // Off: stays locked.
		}

		$field.removeClass( 'svp-readonly' ).addClass( 'svp-pro-switch--unlocked' );
		if ( note ) {
			$field.find( '.csf-title' ).first().append( $( '<span class="svp-pro-switch-note"></span>' ).text( note ) );
		}

		$input.on( 'change', function () {
			if ( String( $input.val() ) !== '1' ) {
				$field.addClass( 'svp-readonly' ).removeClass( 'svp-pro-switch--unlocked' );
				$field.find( '.svp-pro-switch-note' ).remove();
			}
		} );
	} );
} );
