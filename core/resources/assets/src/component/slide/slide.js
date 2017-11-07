module.exports = (function ($) {
    var sp = require('../subscribepublish.js');

    var Slide = function (op) {
        this._op = $.extend({
            index: 0,
            use: 'img',//img or background
            id: '',
            dealImageCallback: null
        }, op);

        this.$slide = $(this._op.id);
        this.$slideBox = $('.slide-box', this.$slide);
        this.slideWidth = 0;
        this.moveVal = 0;
        this.imageNum = 0;
        this.moveNum = 0;
        this.curIndex = 0;
        this.leftVal = 0;

        this.moveTimer = null;
        this.addVal = 50;

        this.init();
        this.bindEvent();
    };

    Slide.prototype.init = function () {
        var $image = $('li', this.$slideBox);
        var $imageLeft = parseInt($image.css('margin-right'));
        var imageWidth = $image.outerWidth() + $imageLeft;

        this.moveVal = $('.view', this.$slide).width() + $imageLeft;
        this.imageNum = $image.length;
        this.slideWidth = imageWidth * this.imageNum;
        this.moveNum = Math.ceil(this.slideWidth / this.moveVal);
        this.numPerpage = parseInt(this.moveVal / imageWidth);
        this.$slideBox.width(this.slideWidth);

        if (this._op.dealImageCallback && $.isFunction(this._op.dealImageCallback)) {
            this._op.dealImageCallback($('img', this.$slideBox));
        }

        sp.publish(this._op.id + 'slide_init', {});

        this.loadImage(this.curIndex);
        if (this.curIndex + 1 < this.moveNum) {
            this.loadImage(this.curIndex + 1);
            this.loadImage(this.moveNum - 1);
        }
    };

    Slide.prototype.bindEvent = function () {
        var self = this;


        $('.next-arrow', self.$slide).click(function () {
            if (self.curIndex + 1 >= self.moveNum) {
                // 最后一页
                self.go(0);  //单个轮播时，循环
                sp.publish(self._op.id + 'slide_last_image', 0);
            } else {
                sp.publish(self._op.id + 'slide_next_image', self.curIndex + 1);
            }
        });

        sp.subscribe(self._op.id + 'slide_next_image', function () {
            self.next();
        });

        $('.prev-arrow', self.$slide).click(function () {
            if (self.curIndex - 1 < 0) {
                // 第一页
                self.go(self.moveNum - 1);  //单个轮播时，循环
                sp.publish(self._op.id + 'slide_first_image', self.moveNum - 1);
            } else {
                sp.publish(self._op.id + 'slide_prev_image', self.curIndex - 1);
            }
        });

        sp.subscribe(self._op.id + 'slide_prev_image', function () {
            self.prev();
        });
    };

    Slide.prototype.goLast = function () {
        this.go(this.moveNum - 1);
    };

    Slide.prototype.goFirst = function () {
        this.go(0);
    };

    //向后移动一个步长单位
    Slide.prototype.next = function () {
        this.curIndex++;
        this.doAnimation(this.leftVal, (this.leftVal + this.moveVal), this.addVal);

        this.leftVal += this.moveVal;
        //this.$slideBox.css("left", "-" + this.leftVal + "px");
        if (this.curIndex + 1 < this.moveNum) {
            this.loadImage(this.curIndex + 1);
        }
    };

    //向前移动一个步长单位
    Slide.prototype.prev = function () {
        this.curIndex--;
        this.doAnimation(this.leftVal, (this.leftVal - this.moveVal), this.addVal);

        this.leftVal -= this.moveVal;
        //this.$slideBox.css("left", "-" + this.leftVal + "px");
        if (this.curIndex - 1 >= 0) {
            this.loadImage(this.curIndex - 1);
        }
    };

    //移动以步长为单位
    Slide.prototype.go = function (index) {
        index = parseInt(index);
        if (index < 0 || index > this.moveNum - 1) {
            return;
        }
        var temp = Math.abs(index - this.curIndex);
        this.curIndex = parseInt(index);
        this.doAnimation(this.leftVal, (this.moveVal * index), temp * this.addVal);

        this.loadImage(index);
        ((index + 1) < this.moveNum) && this.loadImage(index + 1);
        (index - 1 > -1) && this.loadImage(index - 1);
        this.leftVal = this.moveVal * index;
        //this.$slideBox.css("left", "-" + this.leftVal + "px");
        sp.publish(this._op.id + 'slide_index_image', index); //???
    };

    Slide.prototype.getCurIndex = function () {
        return this.curIndex;
    };

    Slide.prototype.getImageNum = function () {
        return this.imageNum;
    };

    Slide.prototype._loadImage = function (index) {

        var $imageList = $('img', this.$slide),
            baseNum = index * this.numPerpage,
            $image = $imageList.eq(baseNum);

        var i = 0;

        while (i < this.numPerpage && $image.attr('data-src')) {
            $image.attr('src', $image.attr('data-src'));
            $image.attr('data-src', '');
            $image = $imageList.eq(++i + baseNum);
        }
    }

    Slide.prototype._loadBackground = function (index) {
        var $liList = $('li', this.$slide),
            $imageList = $('img', this.$slide),
            baseNum = index * this.numPerpage,
            $image = $imageList.eq(baseNum);

        var i = 0;
        while (i < this.numPerpage && $image.attr('data-src')) {
            $liList.eq(baseNum + i)
                .css('background', 'url(' + $image.attr('data-src') + ') center center no-repeat')
                .css('background-size', 'contain')
                .css('background-color', '#f8f8f8');
            $image.attr('data-src', '');
            $image.hide();
            $image = $imageList.eq(++i + baseNum);
        }
    }

    Slide.prototype.loadImage = function (index) {
        if (this._op.use === 'img') {
            this._loadImage(index);
        } else {
            this._loadBackground(index);
        }

    };

    Slide.prototype.loadSingleImage = function (index) {
        var $img = $('img', this.$slide).eq(index);
        if ($img.attr('src') == "") {
            $img.attr('src', $img.attr('data-src'));
        }
    };

    Slide.prototype.render = function ($parent, childStr) {
        $parent.html(childStr);
    };

    Slide.prototype.hiddenArrow = function () {
        $('.prev-arrow', this.$slide).hide();
        $('.next-arrow', this.$slide).hide();
    };

    Slide.prototype.displayArrow = function () {
        $('.prev-arrow', this.$slide).show();
        $('.next-arrow', this.$slide).show();
    };

    Slide.prototype.doAnimation = function (start, end, add) {
        var self = this;

        if (Math.abs(end - start) <= add) {
            self.$slideBox.css("left", "-" + end + "px");
            clearTimeout(self.moveTimer);
            return;
        }

        if (start < end) {
            // move to right
            start += add;
        } else {
            // move to left
            start -= add;
        }
        this.$slideBox.css("left", "-" + start + "px");

        var animation = arguments.callee;
        self.moveTimer = setTimeout(function () {
            animation.apply(self, [start, end, add]);
        }, 10);
    };

    return Slide;
}(jQuery));
