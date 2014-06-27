// Changes the number of day options according to the selected month in the Rubric section

// The following line allows Chrome Developer Tools to detect this file in its Sources section:
//# sourceURL=month-day-synchronizer.js

console.log("month-day-synchronizer running");

jQuery("#calendar-date-month").change(synchronizeDaysToMonths);

function synchronizeDaysToMonths() {
    var monthSelectValue = jQuery("#calendar-date-month").val();

    if (monthSelectValue === "") {
        deleteDayOptions();
        jQuery("#calendar-date-day").append('<option value></option>');

    } else if (monthSelectValue === "1"
        || monthSelectValue === "3"
        || monthSelectValue === "5"
        || monthSelectValue === "7"
        || monthSelectValue === "8"
        || monthSelectValue === "10"
        || monthSelectValue === "12") {
        deleteDayOptions();
        addDayOptionsUpTo(31);

    } else if (monthSelectValue === "4"
        || monthSelectValue === "6"
        || monthSelectValue === "9"
        || monthSelectValue === "11") {
        deleteDayOptions();
        addDayOptionsUpTo(30);

    } else if (monthSelectValue === "2") {
        deleteDayOptions();
        addDayOptionsUpTo(29);
    }
}

function deleteDayOptions() {
    jQuery("#calendar-date-day option[value]").remove();
    for (var i = 1; i <= 31; i++) {
        jQuery("#calendar-date-day option[value="+i+"]").remove();
    }
}

function addDayOptionsUpTo(lastDay) {
    var daySelect = jQuery("#calendar-date-day");
    var calendar_date_day = "1";
    for (var i = 1; i <= lastDay; i++) {
        if (calendar_date_day === i.toString()) {
            daySelect.append("<option value=" + i + ">" + i + "</option>");
        } else {
            daySelect.append("<option value=" + i + ">" + i + "</option>");
        }
    }
}


