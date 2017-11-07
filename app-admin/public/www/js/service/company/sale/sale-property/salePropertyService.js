define([
    'jquery',
    'component/ajax'
], function ($, ajax) {
    function _delete(oData) {
        ajax({
            type: 'GET',
            url: '/api/company/sale/delete/' + opts.params.id,
            data: oData.data,
            dataType: 'json',
            beforeSend: oData.beforeSend,
            success: oData.success,
            error: oData.error
        });
    }
    return {
        delete: _delete
    };
});