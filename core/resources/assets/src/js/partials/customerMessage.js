module.exports = (function () {
    $(function () {
        var FuzzyQuery = require('./../../component/fuzzyQuery.chosen');
        var services = require('./../services/commonServices');
        var customerServices = require('./../services/customerServices');
        var messageDialog = require('./../../component/AUI/alert');
        var $unit = $('#loupan');
        var $callLogId = $('#call_log_id');
        var blocks = $.params.block || [];
        var selectedBlock = $.params.selectedBlock || '';
        var phoneOnly = true;
        var $resultType = $('.call-result');

        function init() {
            var loupan = new FuzzyQuery({ // jshint ignore:line
                'select': $unit,
                'resources': services.propertySearch,
                format: formatLoupan
            });
            $.validate({
                onSuccess: function () {
                    if ($.params.isMax) {
                        messageDialog.error('当前私客数已达上限');
                        return false;
                    } else {
                        if (phoneOnly) {
                            if (!$callLogId.length || $callLogId.val() || $('.call-result').filter(':checked').val() == 3) {
                                $('#submit').attr('disabled', true);
                            } else {
                                messageDialog.error('还未拨打客户电话，请拨打并录入客户信息');
                                return false;
                            }
                        } else {
                            return false;
                        }
                    }
                },
                onError: function () {

                }
            });
            bindParentSelect($('.block-one'));

            if (typeof(selectedBlock) == 'object') {

                loadBlock(selectedBlock);
            }

        }

        function bindEvent() {
            $('.block-js').on('click', '.add', function () {
                var tempBlock = $.temp('block_tpl');
                $(this).parent().parent().parent().after(tempBlock);
                bindParentSelect($($($($(this).parent().parents('.row')[0]).next('.row')[0]).children()[1]).children('.block-one'));
            });
            $('.row').on('change', '.block-one', function () {
                var blockChildren;

                for (var block in blocks) {
                    if (blocks[block].id == $(this).children('option:selected').val()) {
                        blockChildren = blocks[block].block;
                    }
                }
                bindSelect(this, blockChildren);
            });

            $('#phone').blur(function () {
                if ($(this).data('iscreate') === 1) {
                    customerServices.phoneValidate({
                        data: {phone: $(this).val()},
                        success: function (rs) {
                            if (rs.length === 0) {
                                $('.phone-error').hide();
                                phoneOnly = true;
                            } else {
                                phoneOnly = false;
                                $('.phone-error').show();
                            }
                        }
                    });
                } else {
                    phoneOnly = true;
                }
            })
        }

        function bindSelect(dom, blockChildrens) {
            $(dom).parent().next().children().children().remove();
            var tempOptions = '';
            for (var blockChildren in blockChildrens) {
                tempOptions += '<option value="' + blockChildren + '">' + blockChildrens[blockChildren] + '</option>';
            }
            $(dom).parent().next().children().append(tempOptions);
        }

        function bindParentSelect(dom) {
            var tempOptions = '';
            for (var block in blocks) {
                tempOptions += '<option value="' + blocks[block].id + '">' + blocks[block].name + '</option>';
            }
            $(dom).append(tempOptions);
        }

        function formatLoupan(data, selected) {
            var formatData = [];

            $.each(data, function (i, item) {
                /* jshint camelcase: false */
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

        function loadBlock(districts) {
            /* jshint camelcase: false */
            var i = 0,
                blockChildren, block;
            for (var district in districts) {
                if (i == 0) { // jshint ignore:line
                    $('.block-one').find("option[value='" + districts[district].district_id + "']").attr("selected", true);
                    for (block in blocks) {
                        if (blocks[block].id == districts[district].district_id) {
                            blockChildren = blocks[block].block;
                        }
                    }
                    bindSelect($('.block-one'), blockChildren);

                    $('.block-two').find("option[value='" + districts[district].id + "']").attr("selected", true);
                } else {
                    var tempBlock = $.temp('block_tpl', {i: i});
                    $('.add').parent().parent().parent().after(tempBlock);
                    bindParentSelect($($($($('.add').parent().parents('.row')[0]).next('.row')[0]).children()[1]).children('.block-one'));
                    $('.block-one-' + i).find("option[value='" + districts[district].district_id + "']").attr("selected", true);
                    for (block in blocks) {
                        if (blocks[block].id == districts[district].district_id) {
                            blockChildren = blocks[block].block;
                        }
                    }
                    bindSelect($('.block-one-' + i), blockChildren);
                    $('.block-two-' + i).find("option[value='" + districts[district].id + "']").attr("selected", true);
                }
                i++;
            }
        }

        init();
        bindEvent();
    });
})();
