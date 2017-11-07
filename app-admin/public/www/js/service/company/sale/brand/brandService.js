define([
    'jquery',
    'component/ajax'
], function ($, ajax) {

    function _store(opts) {
        ajax({
            type: 'POST',
            url: '/api/company/sale/brand/store',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }
    function _update(opts) {
        ajax({
            type: 'POST',
            url: '/api/company/sale/brand/update',
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    function _delete(opts) {
        ajax({
            type: 'GET',
            dataType: 'json',
            url: '/api/company/sale/brand/delete/' + opts.data.id,
            data: opts.data,
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        store: _store,
        update:_update,
        delete:_delete
    };
});