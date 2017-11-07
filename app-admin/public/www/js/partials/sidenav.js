require([
    'jquery'
], function ($) {
    $(".one-level > a").click(function () {
        $(this).find('.caret').toggleClass('towards-right');
        $(this).next('.second-level').toggleClass("active");
    });
});