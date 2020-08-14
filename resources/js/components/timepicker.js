window.persianDate = require('persian-date');
window.persianDatepicker = require('persian-datepicker/dist/js/persian-datepicker');

$(document).ready(function() {
    let time = $('#time-input');
    var pt = time.persianDatepicker({
        format: "HH:mm:ss",
        onSelect: function(unix) {
            time.attr('unixValue', unix)
        },
        calendar: {
            persian: {
                locale: 'fa'
            },
            gregorian: {
                locale: 'fa'
            }
        },
        toolbox: {
            calendarSwitch: {
                enabled: false
            },
            todayButton: {
                enabled: false
            },
            submitButton: {
                enabled: false
            }
        },
        yearPicker: {
            enabled: false
        },
        monthPicker: {
            enabled: false
        },
        dayPicker: {
            enabled: false
        },
        timePicker: {
            enabled: true
        }
    })
    let defate = new persianDate().format("HH:mm:ss")
    time.attr("unixValue", new persianDate().unix() * 1000);
    pt.setDate(defate)
})