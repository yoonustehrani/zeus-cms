window.persianDate       = require('persian-date')
window.persianDatepicker = require('persian-datepicker/dist/js/persian-datepicker');

$(document).ready(function() {
    let dateTime = $('#date-time');
    var pdt = dateTime.persianDatepicker({
        format: 'dddd, DD MMMM YYYY, h:mm a',
        // checkYear: function(year) {
        //     return (year <= (new persianDate().year() - 8)) && (year >= (new persianDate().year() - 80));
        // },
        onSelect: function(unix){
            dateTime.attr("unixValue", unix)
        },
        viewMode: 'year',
        calendar:{
            persian: {
                locale: 'fa'
            },
            gregorian: {
                locale: 'fa'
            }
        },
        toolbox:{
            calendarSwitch:{
                enabled: false
            },
            todayButton: {
                enabled: false
            },
            submitButton: {
                enabled: true
            }
        },
        timePicker: {
            enabled: true,
            second: {
                enabled: false
            }
        }
    });
    let defate = new persianDate().format("dddd, DD MMMM YYYY, h:mm a")
    dateTime.attr("unixValue", new persianDate().unix() * 1000);
    pdt.setDate(defate)
});