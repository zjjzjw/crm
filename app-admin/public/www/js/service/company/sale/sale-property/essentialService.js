define([
    'jquery',
    'component/ajax'
], function ($, ajax) {

    function _store(opts) {
        console.log(opts);
        ajax({
            type: 'POST',
            url: '/api/company/sale/essential-store/' + opts.params.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function _getEssentialByKeyword(oData) {
        ajax({
            type: 'GET',
            url: '/api/company/sale/developer/get-developer-keyword',
            data: oData.data,
            dataType: 'json',
            beforeSend: oData.beforeSend,
            success: oData.success,
            error: oData.error
        });
    }

    function _getProjectByKeyword(oData) {
        ajax({
            type: 'GET',
            url: '/company/user/get-user-by-keyword',
            data: oData.data,
            dataType: 'json',
            beforeSend: oData.beforeSend,
            success: oData.success,
            error: oData.error
        });
    }

    return {
        store: _store,
        getEssentialByKeyword:_getEssentialByKeyword,
        getProjectByKeyword:_getProjectByKeyword
    };
});