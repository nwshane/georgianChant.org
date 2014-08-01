// The following line allows Chrome Developer Tools to detect this file in its Sources section:
//# sourceURL=remove-recording.js

function remove_recording() {
    jQuery( "#recording-file-url" ).val( "" );
    jQuery( "#remove-recording" ).append( "<span> - Click \"Update\" to confirm deletion</span>" );
}