// The following line allows Chrome Developer Tools to detect this file in its Sources section:
//# sourceURL=remove-recording.js

function removeRecording() {
    jQuery( "#recording-file-url" ).val( "" );
    jQuery( "#remove-recording" ).append( "<span id=\"recording-deleted\"> - Click \"Update\" to confirm deletion</span>" );
}