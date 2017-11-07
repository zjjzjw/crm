module.exports = (function () {
    // 房源搜索
    var _propertySearch = function (data) {
        $.http({
            type: 'GET',
            dataType: 'json',
            url: '/api/loupan/search',
            data: data.data,
            success: data.success,
            error: data.error
        });
    };

    // 拨打电话
    var _callUp = function (data) {
        $.http({
            type: 'GET',
            dataType: 'json',
            url: '/api/call/callback',
            data: data.data,
            success: data.success,
            error: data.error
        });
    };

    return {
        propertySearch: _propertySearch,
        callUp: _callUp
    };
}());