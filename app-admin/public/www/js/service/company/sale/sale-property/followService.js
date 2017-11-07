define([
    'jquery',
    'component/ajax'
], function ($, ajax) {

    function _store(opts) {
        ajax({
            type: 'POST',
            url: '/api/company/sale/follow-store/' + opts.params.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function _getCompanyByKeyword(oData) {
        ajax({
            type: 'GET',
            url: '/api/company/sale/developer-group/get-developer-group-by-keyword',
            data: oData.data,
            dataType: 'json',
            beforeSend: oData.beforeSend,
            success: oData.success,
            error: oData.error
        });
    }


    return {
        store: _store,
        getCompanyByKeyword:_getCompanyByKeyword
    };
});