window.jQuery = window.$;

require('./tools/date');

$('.must_be_select2').each(function() {
    let config = {};
    let place_holder = $(this).attr('data-placeholder');
    config.placeholder = place_holder ? place_holder : 'Select';
    $(this).select2(config);
})