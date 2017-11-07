define([
    'jquery',
    'component/ajax'
], function ($, ajax) {

    function level(opts) {
        ajax({
            type: 'POST',
            url: '/api/company/depart/next-level/' + opts.data.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }
    function addNode(opts) {
        ajax({
            type: 'POST',
            url: '/api/company/depart/store/' + opts.data.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }
    function edit(opts) {
        ajax({
            type: 'POST',
            url: '/api/company/depart/update/' + opts.data.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }
    function deleteitem(opts) {
        ajax({
            type: 'POST',
            url: '/api/company/depart/delete/' + opts.data.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }
    function depart(opts) {
        ajax({
            type: 'POST',
            url: '/api/company/depart/next-depart/' + opts.data.id,
            data: opts.data,
            dataType: 'json',
            beforeSend: opts.beforeSend,
            success: opts.sucFn,
            error: opts.errFn
        });
    }

    return {
        level: level,
        addNode: addNode,
        edit: edit,
        deleteitem: deleteitem,
        depart: depart
    };
});