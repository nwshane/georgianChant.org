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

    } else if (monthSelectValue === "January"
        || monthSelectValue === "March"
        || monthSelectValue === "May"
        || monthSelectValue === "July"
        || monthSelectValue === "August"
        || monthSelectValue === "October"
        || monthSelectValue === "December") {
        deleteDayOptions();
        addDayOptionsUpTo(31, syncDayToDatabaseValue, daySelectValue);

    } else if (monthSelectValue === "April"
        || monthSelectValue === "June"
        || monthSelectValue === "September"
        || monthSelectValue === "November") {
        deleteDayOptions();
        addDayOptionsUpTo(30, syncDayToDatabaseValue, daySelectValue);

    } else if (monthSelectValue === "February") {
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


