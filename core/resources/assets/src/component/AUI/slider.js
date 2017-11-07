/**
 *
 * Please include two libraries before using it:
 *  - js/lib/jssor.slider
 *
 * Steps as following:
 *  Step 1: put the following code in your view to include those library:
 *      ufa()->extJs(array(
 *        '../lib/jssor.slider'
 *      ));
 *
 *  Step 2: require this module in your JS file, and execute slider function:
 *      // require module.
 *      var slider = require('./component/slider');
 *      // execute slider funciton.
 *      $('#slider_wrap').append(temp('slider_img_tpl', {
 *         images: [{
 *              url: 'http://img.agjimg.com/FhCNcrLWbNswf9ylW-nrU7jZSrC7'
 *           }, {
 *               url: 'http://img.agjimg.com/FmRHLczZWQL7-4rYlQi3o8osy15l'
 *           }]
 *       }))
 *
 * @returns {slider}
 */

;(function(){
    var moduleName = (function($, JssorSlider) {
        var Slider = function(opts) {
            var defOpt = {
                wrap: 'slider_wrap',
                imgSrcDom: '.img-wrap',
                autoPlay: false,
                speed: 500,
                delay: 5000,
                loop: 0,
                thumbnailSpacingX: 3,
                thumbnailSpacingY: 3,
                thumbnailDisplayPieces: 6,
                thumbnailParkingPosition: 0,
                thumbnailSteps: 6,
            };

            this.opt = $.extend({}, defOpt, opts);

            this.$wrap = $('#'+ this.opt.wrap);

            this.init();
        };

        Slider.prototype = {
            init: function() {
                this.jssorOpt = {
                    $AutoPlay: this.opt.autoPlay,
                    $AutoPlayInterval: this.opt.delay,
                    $SlideDuration: this.opt.speed,
                    $Loop: this.opt.loop,

                    $ArrowNavigatorOptions: {
                        $Class: $JssorArrowNavigator$,
                        $ChanceToShow: 2
                    },

                    $ThumbnailNavigatorOptions: {
                        $Class: $JssorThumbnailNavigator$,
                        $ChanceToShow: 2,
                        $Loop: this.opt.loop,
                        $SpacingX: this.opt.thumbnailSpacingX,
                        $SpacingY: this.opt.thumbnailSpacingY,
                        $DisplayPieces: this.opt.thumbnailDisplayPieces,
                        $ParkingPosition: this.opt.thumbnailParkingPosition,

                        $ArrowNavigatorOptions: {
                            $Class: $JssorArrowNavigator$,
                            $ChanceToShow: 2,
                            $AutoCenter: 2,
                            $Steps: this.opt.thumbnailSteps
                        }
                    }
                };

                this._displayImg();
            },

            refresh: function() {
                this._displayImg();
            },

            setDisplay: function(index) {
                this.slider.$GoTo(index);
            },

            _displayImg: function(opt) {
                this.slider = new JssorSlider(this.opt.wrap, this.jssorOpt);

                var $img = this.$wrap.find(this.opt.imgSrcDom);

                $img.each(function() {
                    var $target = $(this),
                        src = $target.data('src'),
                        displayStr;

                    displayStr = '<img src="'+ src +'" /><em></em>'

                    $target.append(displayStr);
                });
            }
        };

        return Slider;
    })(jQuery, $JssorSlider$);
    
    if (typeof module !== 'undefined' && typeof exports === 'object') {
        module.exports = moduleName;
    } else if (typeof define === 'function' && (define.amd || define.cmd)) {
        define(function() { return moduleName; });
    } else {
        this.moduleName = moduleName;
    }
}).call(function() {
    return this || (typeof window !== 'undefined' ? window : global);
});
