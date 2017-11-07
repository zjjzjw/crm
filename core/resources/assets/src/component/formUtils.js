module.exports = (function($, common) {
    function Utils(opts) {
        var defOpts = {
            'wrap': '#form',
            'datepickerDefOpts': {
                'lang': 'zh',
                'dayOfWeekStart': 1,
                'format': 'Y-m-d',
                'formatDate': 'Y-m-d',
                'closeOnDateSelect': true,
                'timepicker': false,
                'scrollInput': false
            }
        };

        this.opts = $.extend({}, defOpts, opts);

        this._unitCache = {};

        this.$wrap = typeof this.opts.wrap === 'string' ? $(this.opts.wrap) : this.opts.wrap;
    }

    Utils.prototype = {
        constructor: Utils,

        serializeObject: function($wrap, noTrim) {
            if ($wrap && (typeof $wrap === 'boolean')) {
                noTrim = $wrap;
                $wrap = this.$wrap;
            } else {
                $wrap = $wrap || this.$wrap;
            }

            return analysisParam($wrap.serializeArray(), noTrim);
        },

        getUnitByName: function(unitName, tag, $wrap) {
            var unitSelector;

            if (!tag || typeof tag === 'object') {
                $wrap = tag;
                tag = 'input';
            }

            if (!this._unitCache[tag]) {
                this._unitCache[tag] = {};
            }

            unitSelector = tag + '[name=\'' + unitName + '\']';

            if ($wrap) {
                return $wrap.find(unitSelector);
            } else {
                return this._unitCache[tag][unitSelector] || (this._unitCache[tag][unitSelector] = this.$wrap.find(unitSelector));
            }
        },

        initDatepicker: function(dom, customOpts) {
            var opts = $.extend({}, this.opts.datepickerDefOpts, customOpts || {}),
                $dom;

            $dom = typeof dom === 'string' ? this.$wrap.find(dom) : dom;

            $dom.datetimepicker(opts);

            return this;
        },

        initSectionDatepicker: function(opts, datepickerOpts) {
            var self = this,
                $wrap = opts.wrap || self.$wrap;

            $wrap.each(function() {
                var $target = $(this),
                    $timeStart = self.getUnitByName(opts.startName, 'input', $target),
                    $timeEnd = self.getUnitByName(opts.endName, 'input', $target);

                self._initSectionDatepicker($timeStart, $timeEnd, datepickerOpts || {});
            });

            return self;
        },

        _initSectionDatepicker: function($start, $end, opts) {
            var startOpts, endOpts;

            startOpts = $.extend({}, opts, {
                onShow: function() {
                    this.setOptions({
                        maxDate: $end.val() || false
                    });
                }
            });

            endOpts = $.extend({}, opts, {
                onShow: function() {
                    this.setOptions({
                        minDate: $start.val() || false
                    });
                }
            });

            this.initDatepicker($start, startOpts).initDatepicker($end, endOpts);
        },
    };

    function analysisParam(list, noTrim) {
        var params = {};

        $.each(list, function(i, item) {
            var key = item.name,
                val = noTrim ? item.value : $.trim(item.value);

            if (noTrim || val) {
                if (~key.indexOf('[]')) {
                    key = key.split('[]')[0];

                    !params[key] && (params[key] = []); // jshint ignore:line

                    params[key].push(val);
                } else {
                    params[key] = val;
                }
            }
        });

        return params;
    }

    return Utils;
})(jQuery, AGJ.common);