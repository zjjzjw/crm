module.exports = (function() {
    // 带看管理
    var _manageVisit = function (data) {
        $.http({
            type: 'PUT',
            dataType: 'json',
            url: '/api/visit/' + data.type,
            data: data.data,
            success: data.success,
            error: data.error
        });
    };

    // 完成带看
    var _completeVisit = function (data) {
        $.http({
            type: 'POST',
            dataType: 'json',
            url: '/visit',
            data: data.data,
            success: data.success,
            error: data.error
        });
    };

    // 记录陪看
    var _putAccompany = function (data) {
        $.http({
            type: 'GET',
            dataType: 'json',
            url: '/api/visit/withlook',
            data: data.data,
            success: data.success,
            error: data.error
        });
    };

    // 记录回访
    var _putFeeback = function (data) {
        $.http({
            type: 'PUT',
            dataType: 'json',
            url: '/api/visit/visitinterview',
            data: data.data,
            success: data.success,
            error: data.error
        });
    };

    // 电话记录
    var _putCallFeeback = function (data) {
        $.http({
            type: 'PUT',
            dataType: 'json',
            url: '/api/visit/callinterview',
            data: data.data,
            success: data.success,
            error: data.error
        });
    };

    return {
        manageVisit: _manageVisit,
        completeVisit: _completeVisit,
        putAccompany: _putAccompany,
        putFeeback: _putFeeback,
        putCallFeeback: _putCallFeeback
    };
}());
