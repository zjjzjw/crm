module.exports = (function($) {
    var sp = require('../../component/subscribepublish.js');
    var CombineSlides = require('./combine-slide.js');

    /*
    * op: {
    *   curThumbClass: 'cur-thumb'
    * }
    * */
    var MultiSlides = function (op) {
        this._op = $.extend({
            indexArr: [],
            idArr: []   //#id
        }, op);

        this.slidesArr = [];
        this.curSlide = null;
        this.curSlideIndex = 0;
        this.slideArrLen = 0;

        this.init();
        this.bindEvent();
    };

    MultiSlides.prototype.init = function () {
        var self = this,
            slideLen = this._op.idArr.length;

        function initSlide(id) {
            var $images = $('img', $(id)),
                imageSize = (window.devicePixelRatio > 1) ? '-900x600' : '-450x300',
                $img,
                src;
            for (var i = 0, len = $images.length; i < len; i++) {
                $img = $images.eq(i);
                src = $img.attr('data-src') + imageSize;
                $img.attr('data-src', src);
            }
        }

        for(var i=0; i<slideLen; i++) {
            sp.subscribe(self._op.idArr[i]['imageId'] + 'slide_init', function() {
                initSlide(self._op.idArr[i]['imageId']);
            });
            this.slidesArr[i] = new CombineSlides({
                imageId: this._op.idArr[i]['imageId'],
                thumbId: this._op.idArr[i]['thumbId']
            });
        }
        this.curSlide = this.slidesArr[0];
        this.slideArrLen = slideLen;
    };

    MultiSlides.prototype.bindEvent = function () {
        var self = this;
        var len = self.slidesArr.length;

        for(var i = 0; i < len; i++) {
            sp.subscribe(self._op.idArr[i]['imageId'] + 'slide_last_image', nextTab);
            sp.subscribe(self._op.idArr[i]['imageId'] + 'slide_first_image', prevTab);
        }

        function nextTab() {
            if(self.curSlideIndex + 1 >= self.slideArrLen ) {
                self.curSlideIndex = 0;
            } else {
                self.curSlideIndex++;
            }

            self.curSlide = self.slidesArr[self.curSlideIndex];
            self.curSlide.goFirst();
            sp.publish('change-tab', self.curSlideIndex);
        }

        function prevTab() {
            if(self.curSlideIndex - 1 < 0) {
                self.curSlideIndex = self.slideArrLen - 1;
            } else {
                self.curSlideIndex--;
            }

            self.curSlide = self.slidesArr[self.curSlideIndex];
            self.curSlide.goLast();
            sp.publish('change-tab', self.curSlideIndex);
        }
    };

    MultiSlides.prototype.goSlide = function (index) {
        var self = this;

        if(index < 0 || index > self.slideArrLen - 1) {
            return ;
        }

        self.curSlideIndex = index;
        self.curSlide = self.slidesArr[self.curSlideIndex];
        sp.publish('change-tab', self.curSlideIndex);
    };

    return MultiSlides;
}(jQuery));
