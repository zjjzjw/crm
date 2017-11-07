module.exports = (function($, common) {
    var Dialog = require('./../../../component/AUI/dialog'),
        FuzzyQuery = require('./../../../component/fuzzyQuery.chosen'),
        FormUtils = require('./../../../component/formUtils'),
        services = require('./../../services/commonServices'),
        tpl = '<form action="" class="visit-dialog">' +
                '<input type="hidden" name="id" />' +
                '<div class="row">' +
                    '<div class="columns small-2"><label class="text-right middle">带看时间：</label></div>' +
                    '<div class="columns small-3">' +
                        '<div class="form-group"><input type="text" name="visit_date" /></div>' +
                    '</div>' +
                    '<div class="columns small-3">' +
                        '<div class="input-group">' +
                            '<div class="form-group"><select name="visit_hour"></select></div>' +
                            '<span class="input-group-label no-border">时</span>' +
                        '</div>' +
                    '</div>' +
                    '<div class="columns small-3 end">' +
                        '<div class="input-group">' +
                            '<div class="form-group"><select name="visit_min"></select></div>' +
                            '<span class="input-group-label no-border">分</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="row">' +
                    '<div class="columns small-2"><label class="text-right middle">见面地点：</label></div>' +
                    '<div class="columns small-10">' +
                        '<div class="form-group"><input type="text" name="meet_place" maxlength="50"/></div>' +
                    '</div>' +
                '</div>' +
                '<div class="row">' +
                    '<div class="columns small-2"><label class="text-right middle">带看楼盘：</label></div>' +
                    '<div class="columns small-10">' +
                        '<div class="form-group"><select name="visit_loupan_ids[]" multiple></select></div>' +
                    '</div>' +
                '</div>' +
                '<div class="row">' +
                    '<div class="columns small-2"></div>' +
                    '<div class="columns small-10"><p class="error text-alert"></p></div>' +
                '</div>' +
            '</form>';

    function VisitDialog(opts) {
        common.inherit(this, common.Observer);

        this.opts = opts;
    }

    VisitDialog.prototype = {
        constructor: VisitDialog,

        open: function(visit) {
            if (!this.dialog) {
                this._createDialog();
            }

            this._initDialog(visit);

            this.dialog.open();
        },

        _createDialog: function() {
            var self = this,
                dialog = new Dialog({
                    'id': 'visit_dialog',
                    'title': this.opts.title,
                    'contentTpl': tpl,
                    'btnGroupTpl': '<button class="button small" data-status="1">预约并报备</button>'
                }),
                $form = dialog.$body.children().eq(0),
                $error = dialog.$body.find('.error');

            dialog.dom.parent().off('click.zf.reveal');
            dialog.on('dialog_closed', function($dom) {
                if ($dom && $dom.data('status')) {
                    var data = confirmData(analysisParam($form.serializeArray()));

                    if (typeof data === 'string') {
                        $error.text(data).show();
                    } else {
                        self.trigger('visit_confoirm', [data, dialog, $error]);
                    }
                } else {
                    dialog.close();
                    $error.hide();
                }
            });

            self._initDialogDom(['id', 'visit_date', 'visit_hour', 'visit_min', 'meet_place', 'visit_loupan_ids[]'], dialog.$body);
            self.dialog = dialog;
        },

        _initDialogDom: function(names, $dom) {
            var self = this,
                formUtils = new FormUtils({
                    'wrap': $dom
                }),
                domCache = {},
                $unit;

            $.each(names, function(i, item) {
                switch(item) {
                    case 'visit_loupan_ids[]':
                        $unit = formUtils.getUnitByName(item, 'select');
                        self.fuzzyQuery = new FuzzyQuery({
                            'select': $unit,
                            'resources': services.propertySearch,
                            format: formatLoupan
                        });
                        self.fuzzyQuery.chosen.container.css('width', '100%');
                        break;
                    case 'visit_date':
                        $unit = formUtils.getUnitByName(item);
                        formUtils.initDatepicker($unit, {minDate: getDate()});
                        break;
                    case 'visit_hour':
                        $unit = formUtils.getUnitByName(item, 'select');
                        $unit.append(compileOptions(1, 24, 1));
                        break;
                    case 'visit_min':
                        $unit = formUtils.getUnitByName(item, 'select');
                        $unit.append(compileOptions(0, 55, 5));
                        break;
                    default:
                        $unit = formUtils.getUnitByName(item);
                }

                domCache[item] = $unit;
            });

            self.dialogDom = domCache;
        },

        _initDialog: function(visit) {
            var data;

            if (visit) {
                data = formatDialogData(visit);
            } else {
                data = {
                    'visit_date': getDate(1),
                    'visit_hour': '09',
                    'visit_min': '00'
                };
            }

            this._fullDialog(data);
        },

        _fullDialog: function(data) {
            var self = this;

            $.each(self.dialogDom, function(key, $dom) {
                if (key == 'visit_loupan_ids[]') {
                    self.fuzzyQuery.update(data[key] || []);
                } else {
                    $dom.val(data[key] || '');
                }
            });
        }
    };

    function formatLoupan(data, selected) {
        /* jshint camelcase: false */
        var formatData = [];

        $.each(data, function(i, item) {
            formatData.push({
                'loupan_id': item.loupan_id,
                'loupan_name': item.loupan_name,
                'value': item.loupan_id,
                'name': item.loupan_name,
                'selected': (selected ? true : item.selected)
            });
        });

        return formatData;
    }

    function formatDialogData(data) {
        /* jshint camelcase: false */
        var visitTime = new Date(Date.parse(data.visit_time.replace(/-/g, '/'))),
            loupans = formatLoupan(data.visit_loupans, true);

        return {
                'id': data.id,
                'visit_date': getDate(visitTime),
                'visit_hour': timeFormat(visitTime.getHours()),
                'visit_min': timeFormat(visitTime.getMinutes()),
                'meet_place': data.meet_place,
                'visit_loupan_ids[]': loupans
            };
    }

    function compileOptions(min, max, step) {
        var optionsTpl = '';

        while (min <= max) {
            optionsTpl += '<option value="' + timeFormat(min) + '">' + timeFormat(min) + '</option>';
            min += step;
        }

        return optionsTpl;
    }

    function timeFormat(num) {
        var numStr = '0' + num;

        return numStr.substr(-2);
    }

    function confirmData(data) {
        /* jshint camelcase: false */
        var visitData = {};

        if (data.visit_date && data.visit_hour && data.visit_min) {
            visitData.visit_time = data.visit_date + ' ' + data.visit_hour + ':' + data.visit_min + ':00';
        } else {
            return '请填写带看日期';
        }

        if (data.meet_place) {
            visitData.meet_place = data.meet_place;
        } else {
            return '请填写见面地点';
        }

        if (data.visit_loupan_ids) {
            visitData.visit_loupan_ids = data.visit_loupan_ids;
        } else {
            return '请填写带看楼盘';
        }

        visitData.id = data.id;

        return visitData;
    }

    function analysisParam(list) {
        var params = {};

        $.each(list, function(i, item) {
            var key = item.name,
                val = $.trim(item.value);

            if (val) {
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

    function getDate(date) {
        var dateObj;

        if (date) {
            if (date instanceof Date) {
                dateObj = date;
            } else if (typeof date === 'number') {
                dateObj = new Date();
                dateObj.setDate(dateObj.getDate() + date);
            } else {
                dateObj = new Date(Date.parse(date.replace(/-/g, '/')));
            }
        } else {
            dateObj = new Date();
        }

        return dateObj.getFullYear() + '-' + timeFormat(dateObj.getMonth() + 1) + '-' + timeFormat(dateObj.getDate());
    }

    return VisitDialog;
}(jQuery, AGJ.common)); // jshint ignore:line