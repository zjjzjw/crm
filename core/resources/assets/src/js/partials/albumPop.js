module.exports = (function () {
    $(function () {
        var param = $.params;
        var Pop = require('./../../component/popup.js');
        var combineGallery = require('../../component/slide/combine-slide.js');
        var imageTypeNum = param.test;

        var albumPop = new Pop({
            width: 1000,
            height: 680,
            content: $('#albumTpl').html(),
            contentName: 'pop-album',
            contentBg: '#fff',
            maskOpacity: '0.7',
            maskName: 'album-pop-mask'
        });

        var tempnum = '';

        function init() {
        }

        function bindEvent() {

            $('.album').click(function () {
                tempnum = $(this).data('num');
                combineGallery.go(tempnum - 1);
                albumPop.showPop();
                event.stopPropagation();
            });

            $('.close-pop').click(function () {
                albumPop.closePop();
            });

            combineGallery = new combineGallery({
                imageId: '#album',
                thumbId: '#thumbnail'
            });
        }

        init();
        bindEvent();
    });
})();
