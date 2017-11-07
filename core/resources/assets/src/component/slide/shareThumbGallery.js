module.exports = (function ($) {
    var sp = require('../subscribepublish.js');
    var CombineSlides = require('./combine-slide.js');
    var Slide = require('./slide.js');
    /*
     * op: {
     *   curThumbClass: 'cur-thumb'
     * }
     * */
    var ShareThumbGallery = function (op) {
        this._op = $.extend({
            indexArr: [],
            idArr: [],   //#id
            dealImage: null
        }, op);

        this.slidesArr = [];
        this.curSlide = null;
        this.curSlideIndex = 0;
        this.slideArrLen = 0;

        this.shareThumb = null;

        this.$imageTab = $('.image-tab');
        this.$imageTab.splice(-1);
        this.$imageTitle = $('.image-title a');
        this.numThumbPerPage = 10;
        this.thumbCurPage = 0;

        this.init();
        this.bindEvent();
    };

    ShareThumbGallery.prototype.init = function () {
        var self = this,
            slideLen = this._op.idArr.length;

        function initSlide(id) {
            var $images = $('img', $(id)),
                imageSize = (window.devicePixelRatio > 1) ? '?imageView2/1/w/960/h/720' : '?imageView2/1/w/600/h/450',
                $img,
                src;
            for (var i = 0, len = $images.length; i < len; i++) {
                $img = $images.eq(i);
                src = $img.attr('data-src') + imageSize;
                $img.attr('data-src', src);
            }
        }

        for (var i = 0; i < slideLen; i++) {
            this.slidesArr[i] = new CombineSlides({
                imageId: this._op.idArr[i]['imageId'],
                thumbId: this._op.idArr[i]['thumbId'],
                dealImage: this._op.dealImage
            });
        }
        this.curSlide = this.slidesArr[0];
        this.slideArrLen = slideLen;
        this.shareThumb = new Slide({
            index: 0,
            id: this._op.shareThumb
        });
        if ($('li', this._op.shareThumb).length <= self.numThumbPerPage) {
            $('.next-arrow', this._op.shareThumb).hide();
            $('.prev-arrow', this._op.shareThumb).hide();
        }
    };

    ShareThumbGallery.prototype.bindEvent = function () {
        var self = this;
        var len = self.slidesArr.length;

        for (var i = 0; i < len; i++) {
            sp.subscribe(self._op.idArr[i]['imageId'] + 'slide_last_image', nextTab);
            sp.subscribe(self._op.idArr[i]['imageId'] + 'slide_first_image', prevTab);

            sp.subscribe(self._op.idArr[i]['imageId'] + 'slide_next_image', (function (i) {
                return function (index) {
                    dealThumb(i, index);
                };
            })(i));
            sp.subscribe(self._op.idArr[i]['imageId'] + 'slide_prev_image', (function (i) {
                return function (index) {
                    dealThumb(i, index);
                };
            })(i));

            sp.subscribe(self._op.idArr[i]['imageId'] + 'slide_last_image', (function (i) {
                return function (index) {
                    dealThumb((i + 1) % len, 0);
                };
            })(i));

            sp.subscribe(self._op.idArr[i]['imageId'] + 'slide_first_image', (function (i) {
                return function (index) {
                    var tabNum = (i + len - 1) % len;
                    dealThumb(tabNum, $('li.big-image', self.$imageTab.eq(tabNum)).length - 1);
                };
            })(i));
        }

        self.$imageTitle.click(function () {
            var $target = $(this), index = $target.attr('tab-index');
            self.goSlide(index);
            self.changeTab(index);
            self.dealShareThumb({
                tabIndex: index,
                imageIndex: 0
            });
            self.dealBigImage({
                tabIndex: index,
                imageIndex: 0
            });
        });

        function nextTab() {
            if (self.curSlideIndex + 1 >= self.slideArrLen) {
                self.curSlideIndex = 0;
            } else {
                self.curSlideIndex++;
            }

            self.curSlide = self.slidesArr[self.curSlideIndex];
            self.curSlide.goFirst();
            //sp.publish('change-tab', self.curSlideIndex);
            self.changeTab(self.curSlideIndex);
        }

        function prevTab() {
            if (self.curSlideIndex - 1 < 0) {
                self.curSlideIndex = self.slideArrLen - 1;
            } else {
                self.curSlideIndex--;
            }

            self.curSlide = self.slidesArr[self.curSlideIndex];
            self.curSlide.goLast();
            //sp.publish('change-tab', self.curSlideIndex);
            self.changeTab(self.curSlideIndex);
        }

        function dealThumb(tabIndex, imageIndex) {
            //sp.publish('change-share-thumb', [{tabIndex: tabIndex, imageIndex: imageIndex}]);
            self.dealShareThumb({tabIndex: tabIndex, imageIndex: imageIndex});
        }

        $('.slide-box', self._op.shareThumb).on('click', 'li', function (e) {
            var $target = $(e.currentTarget);
            self.curSlideIndex = parseInt($target.attr('tab-index'));
            self.curSlide = self.slidesArr[self.curSlideIndex];
            //sp.publish('change-big-image', [{tabIndex: $target.attr('tab-index'), imageIndex: $target.attr('image-index')}]);
            self.dealBigImage({tabIndex: $target.attr('tab-index'), imageIndex: $target.attr('image-index')});
        });
    };

    ShareThumbGallery.prototype.changeTab = function (index) {
        this.$imageTab.removeClass('cur-tab');
        this.$imageTitle.removeClass('cur-title');

        this.$imageTab.eq(index).addClass('cur-tab');
        this.$imageTitle.eq(index).addClass('cur-title');
    };

    ShareThumbGallery.prototype.dealShareThumb = function (index) {
        var $shareThumb = $('li', this._op.shareThumb),
            $curTabShareThumb = $('li[tab-index=' + index.tabIndex + ']'),
            $curThumb = $curTabShareThumb.eq(index.imageIndex);

        $shareThumb.removeClass('cur-thumb');
        $curThumb.addClass('cur-thumb');

        if (Math.floor(parseInt($curThumb.attr('num')) / this.numThumbPerPage) != this.thumbCurPage) {
            this.thumbCurPage = Math.floor(parseInt($curThumb.attr('num')) / this.numThumbPerPage);
            this.shareThumb.go(this.thumbCurPage);
        }
    };

    ShareThumbGallery.prototype.dealBigImage = function (index) {
        this.changeTab(index.tabIndex);
        this.dealShareThumb(index);
        this.getSlide(index.tabIndex).getImageSlide().go(index.imageIndex);
    };

    ShareThumbGallery.prototype.goSlide = function (index) {
        var self = this;

        if (index < 0 || index > self.slideArrLen - 1) {
            return;
        }

        self.curSlideIndex = parseInt(index);
        self.curSlide = self.slidesArr[self.curSlideIndex];
        //sp.publish('change-tab', self.curSlideIndex);
        //self.dealBigImage(index);
    };

    /*    ShareThumbGallery.prototype.goTab = function (index) {
     return this.slidesArr[index];
     };*/

    ShareThumbGallery.prototype.getSlide = function (index) {
        return this.slidesArr[index];
    };

    ShareThumbGallery.prototype.getThumb = function () {
        return this.shareThumb;
    };

    return ShareThumbGallery;
}(jQuery));
