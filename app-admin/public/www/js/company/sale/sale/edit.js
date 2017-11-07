require([
    'jquery',
    'lib/temp',
    'component/area',
    'page.params',
    'jquery.form.validator',
    'component/ajax'
], function ($, temp, Area, params) {
    var Edit = function () {
        var self = this;
        self.init();
    };

    Edit.prototype.init = function () {
        var self = this;
        $.validate({
            form: '#form',
            onSuccess: function ($form) {

            }
        });

        var area = new Area({'idNames': ['province_id', 'city_id', 'county_id'], 'data': params.area});
        area.selectedId(params.province_id, params.city_id, params.county_id);

    };

    new Edit();
});