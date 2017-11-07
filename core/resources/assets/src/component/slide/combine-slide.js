module.exports = (function($) {
    var sp = require('../../component/subscribepublish.js');
    var Slide = require('./slide.js');

    var CombineSlides = function (op) {
        this._op = $.extend({
            imageId: '',
            thumbId: '',
            curThumbClass: 'cur-thumb'
        }, op);

        this.imageSlide = null;
        this.thumbSlide = null;
        this.numPerpage = 0;
        this.$thumbItem = $('li', this._op.thumbId);

        this.init();
        this.bindEvent();
    };

    CombineSlides.prototype.init = function () {
        this.imageSlide = new Slide({
            index: 0,
            id: this._op.imageId,
            use: 'background',
            dealImageCallback: this._op.dealImage
        });

        this.thumbSlide = new Slide({
            index: 0,
            id: this._op.thumbId
        });

        var $thumb = $(this._op.thumbId);
        this.numPerpage = Math.floor($('.view', $thumb).width() / $('li', $thumb).width());

        if(this.numPerpage > $('li', $thumb).length) {
            //隐藏小图左右翻页箭头
            this.thumbSlide.hiddenArrow();
        }
    };

    CombineSlides.prototype.bindEvent = function () {
        var self = this;

        sp.subscribe(self._op.imageId + 'slide_next_image', thumbMove);
        sp.subscribe(self._op.imageId + 'slide_prev_image', thumbMove);

        sp.subscribe(self._op.imageId + 'slide_last_image', thumbMove);
        sp.subscribe(self._op.imageId + 'slide_first_image', thumbMove);

        function thumbMove(index) {
            self.dealThumb(index);
        }

        //点击小图时，选中大图
        $('.slide-box', self._op.thumbId).on('click', 'li', function (e) {
            var $target = $(e.currentTarget), index = parseInt($target.attr('image-index'));

            self.go(index);
        });
    };

    CombineSlides.prototype.go = function(index) {
        this.imageSlide.go(index);
        this.dealThumb(index);
    };

    CombineSlides.prototype.dealThumb = function (index) {
        var self = this;
        var pageIndex = Math.floor(index / self.numPerpage);

        if ( self.thumbSlide.getCurIndex() != pageIndex ) {
            self.thumbSlide.go(pageIndex);
        }
        self.$thumbItem.removeClass(self._op.curThumbClass);
        self.$thumbItem.eq(index).addClass(self._op.curThumbClass);
    };

    CombineSlides.prototype.goLast = function () {
        this.dealThumb(this.$thumbItem.length -1);
        this.imageSlide.goLast();
    };

    CombineSlides.prototype.goFirst = function () {
        this.dealThumb(0);
        this.imageSlide.goFirst();
    };

    CombineSlides.prototype.getImageSlide = function () {
        return this.imageSlide;
    }

    return CombineSlides;
}(jQuery));