// 菜单交互
$(function() {
    var $menu = $('#page_menu').children();

    $menu.hover(function() {
        $menu.removeClass('active');
        $(this).addClass('active');
    }, function() {
        $menu.removeClass('active').filter('.selected').addClass('active');
    });
});