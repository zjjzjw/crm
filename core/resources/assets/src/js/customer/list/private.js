$(function() {
    var FormUtils = require('./../../../component/formUtils'),
        messageDialog = require('./../../../component/AUI/alert'),
        services = require('./../../services/customerServices');

    var teamSelect = $.params.teamSelect,
        formUtils = new FormUtils();


    function view() {
        initTeamSelect();
        initMaintain();
    }

    function initTeamSelect() {
        var $centerSelect = formUtils.getUnitByName('center_id', 'select'),
            $teamSelect = formUtils.getUnitByName('team_id', 'select'),
            $brokerSelect = formUtils.getUnitByName('broker_id', 'select');

        $centerSelect.change(function() {
                tempOptions(teamSelect[$centerSelect.val()], 'team');
                tempOptions('broker');
            });

        $teamSelect.change(function() {
                tempOptions(teamSelect[$centerSelect.val()].team[$teamSelect.val()], 'broker');
            });
    }

    function tempOptions(list, type) {
        if (typeof list === 'string') {
            type = list;
            list = {};
        } else {
            list = list[type];
        }

        var temp = '<option value="">请选择</option>';

        $.each(list, function(key, item) {
            temp += '<option value="' + key + '">' + item[type + '_name'] + '</option>'
        });

        formUtils.getUnitByName(type + '_id', 'select')
            .empty()
            .append(temp);
    }

    function initMaintain() {
        $('#list').on('click', '.maintain', function() {
            var $target = $(this);

            messageDialog.confirm('确定将该用户' + $target.html(), maintainCustomer.bind(null, $target));
        });
    }

    function maintainCustomer($dom, data) {
        if (data.status) {
            services.maintainCustomer({
                data: {'customer_id': $dom.data('id')},
                type: $dom.data('maintain'),
                success: function() {
                    location.reload(true);
                },
                error: function(res) {
                    messageDialog.error(res.msg);
                }
            });
        }
    }

    view();
});