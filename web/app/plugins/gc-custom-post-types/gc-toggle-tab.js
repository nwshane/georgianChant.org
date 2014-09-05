// The following line allows Chrome Developer Tools to detect this file in its Sources section:
//# sourceURL=gc-toggle-tab.js

function toggle_visibility() {
    var content_tab = jQuery( 'li.single-chant-variant div.content' );
    content_tab.toggleClass( 'closedTab' );

    var toggle_button = jQuery('span.toggle-button');
    if ( content_tab.hasClass( 'closedTab' )) {
        toggle_button.html('&#x025B8;').text();
    } else {
        toggle_button.html('&#x025BE;').text();
    }
}