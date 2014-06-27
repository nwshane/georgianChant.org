// Changes the number of day options according to the selected month in the Rubric section

// The following line allows Chrome Developer Tools to detect this file in its Sources section:
//# sourceURL=month-day-synchronizer.js

console.log("month-day-synchronizer running");

jQuery("#calendar-date-month").change(function() {
    synchronizeDaysToMonths(false);
});

function synchronizeDaysToMonths(syncDayToDatabaseValue) {
    var monthSelectValue = jQuery("#calendar-date-month").val();
    var daySelectValue = jQuery("#calendar-date-day").val();

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
        addDayOptionsUpTo(31, syncDayToDatabaseValue, daySelectValue);

    } else if (monthSelectValue === "4"
        || monthSelectValue === "6"
        || monthSelectValue === "9"
        || monthSelectValue === "11") {
        deleteDayOptions();
        addDayOptionsUpTo(30, syncDayToDatabaseValue, daySelectValue);

    } else if (monthSelectValue === "2") {
        deleteDayOptions();
        addDayOptionsUpTo(29, syncDayToDatabaseValue, daySelectValue);
    }
}

function deleteDayOptions() {
    jQuery("#calendar-date-day option[value]").remove();
    for (var i = 1; i <= 31; i++) {
        jQuery("#calendar-date-day option[value="+i+"]").remove();
    }
}

function addDayOptionsUpTo(lastDay, syncDayToDatabaseValue, daySelectValue) {
    var daySelect = jQuery("#calendar-date-day");
    var calendarDateDay = getCalendarDateDay().toString();

    for (var i = 1; i <= lastDay; i++) {
        if ((syncDayToDatabaseValue && calendarDateDay === i.toString())
            || (daySelectValue === i.toString())) {
            daySelect.append("<option value=" + i + " selected>" + i + "</option>");
        } else {
            daySelect.append("<option value=" + i + ">" + i + "</option>");
        }
    }
}


