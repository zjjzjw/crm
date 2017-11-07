module.exports = (function($, common) {

    var TeamFilter = function(options) {
        if (!(this instanceof TeamFilter)) {
            return new TeamFilter(options);
        }

        common.inherit(this, common.Observer);

        var defOpts = {
                filters: {
                    'broker': 'broker_id',
                    'team': 'team_id',
                    'center': 'center_id'
                },
                config: null
            };

        this.opts = $.extend({}, defOpts, options);

        if (this.opts.config) {
            this._init();
        } else {
            return false;
        }
    }

    TeamFilter.prototype = {
        constructor: TeamFilter,

        _init: function() {
            var self = this;

            self.filters = {};

            $.each(self.opts.filters, function(key, val) {
                var $target = typeof val === 'string' ? $('select[name='+ val +']') : val;

                self.filters[key] = $target;

                $target.change(function() {
                    if (key == 'center') {
                        self._tempOptions(self.config[self.filters.center.val()], 'team');
                        self._tempOptions('broker');
                    } else if (key == 'team') {
                        var teams = self.config[self.filters.center.val()].team || {};
                        self._tempOptions(teams[self.filters.team.val()] || {}, 'broker');
                    }

                    self.trigger('team_filter_change', [key]);
                });
            });
        },

        _tempOptions: function(config, type) {
            if (typeof config === 'string') {
                type = config;
                config = {};
            } else {
                config = config[type] || {};
            }

            var temp = '<option value="">请选择</option>';

            $.each(config, function(key, item) {
                temp += '<option value="' + key + '">' + item[type + '_name'] + '</option>';
            });

            this.filters[type].empty().append(temp);
        }
    };

    return TeamFilter;
}(jQuery, AGJ.common))