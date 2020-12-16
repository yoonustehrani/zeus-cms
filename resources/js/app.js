/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

$('#toggle-logout').on('click', function(e) {
    e.preventDefault();
    $('#logout-form').trigger('submit');
});
$('.has_sub').on('click', function() {
    $(this).toggleClass('active');
    $(' .opener', this).toggleClass('fa-angle-right fa-angle-down');
});