window.persianDate       = require('persian-date')
window.persianDatepicker = require('persian-datepicker/dist/js/persian-datepicker');
$(document).ready(function() {
    let date = $('#date');
    var pd = date.persianDatepicker({
        format: 'YYYY/MM/DD',
        // checkYear: function(year) {
        //     return (year <= (new persianDate().year() - 8)) && (year >= (new persianDate().year() - 80));
        // },
        onSelect: function(unix){
            date.attr("unixValue", unix)
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
            }
        },
    });
    let defate = new persianDate().format('YYYY/MM/DD')
    date.attr("unixValue", new persianDate().unix() * 1000);
    pd.setDate(defate)
});