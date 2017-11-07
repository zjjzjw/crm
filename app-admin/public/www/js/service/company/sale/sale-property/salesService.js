define([
    'jquery',
    'component/ajax'
], function ($, ajax) {

    function _store(opts) {
        ajax({
            type: 'POST',
            url: '/api/company/sale/sale-store/' + opts.params.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function _getBrandByKeyword(oData) {
        ajax({
            type: 'GET',
            url: '/api/company/sale/brand/keyword',
            data: oData.data,
            dataType: 'json',
            beforeSend: oData.beforeSend,
            success: oData.success,
            error: oData.error
        });
    }


    return {
        store: _store,
        getBrandByKeyword:_getBrandByKeyword
    };
});