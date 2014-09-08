// The following line allows Chrome Developer Tools to detect this file in its Sources section:
//# sourceURL=gc-toggle-tab.js



function toggle_visibility() {
    var target = event.target;
    var content_tab = jQuery( target ).parent().next( 'div.content' );
    content_tab.toggleClass( 'closedTab' );

    var toggle_button = jQuery( target );
    if ( content_tab.hasClass( 'closedTab' )) {
        toggle_button.html( '&#x025B8;' ).text();
    } else {
        toggle_button.html( '&#x025BE;' ).text();
    }
}