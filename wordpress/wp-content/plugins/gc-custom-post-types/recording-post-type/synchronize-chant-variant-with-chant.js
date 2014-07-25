// The following line allows Chrome Developer Tools to detect this file in its Sources section:
//# sourceURL=synchronize-chant-variant-with-chant.js

// When selected value of chant dropdown changes, changes the chant variants to correspond with it.


jQuery('#recording-grandparent').change(synchronize_chant_variant);

function synchronize_chant_variant() {
    var selected_chant_id_int = parseInt(jQuery('#recording-grandparent').val());

    var recording_parent_select = jQuery("#recording-parent");

    // 1. Remove all select options
    recording_parent_select.empty();

    // 2. Append the chant variants of selected chant
    recording_parent_select.append('<option value=""></option>');

    all_chant_variants.forEach(function(variant) {
        if (variant.post_parent === selected_chant_id_int) {
            var selectedString = "";
            if (variant.ID === recording_parent_id) {
                selectedString = "selected"
            }

            recording_parent_select.append('<option value="' + variant.ID + '" ' + selectedString + '>' + variant.post_title + '</option>');
        }
    });
}