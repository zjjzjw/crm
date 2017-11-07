define([
    'jquery',
    'component/ajax'
], function ($, ajax) {

    function _store(opts) {
        console.log(opts);
        ajax({
            type: 'POST',
            url: '/api/company/sale/building-store/' + opts.params.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        store: _store
    };
});