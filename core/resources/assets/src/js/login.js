$(function(){
    var $img = $('#code_img');
    $img.on('click',function(){
        $(this).attr('src', '/api/graphiccode?' + Math.random());
    });
});