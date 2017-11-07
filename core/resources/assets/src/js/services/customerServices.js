module.exports = (function () {
    // 填写跟进
    var _followup = function (data) {
        $.http({
            type: 'POST',
            dataType: 'json',
            url: '/buyer/' + data.id + '/followup',
            data: data.data,
            success: data.success,
            error: data.error
        });
    };

    // 验证手机号
    var _phoneValidate = function (data) {
        $.http({
            type: 'GET',
            dataType: 'json',
            url: '/api/buyer/search',
            data: data.data,
            success: data.success,
            error: data.error
        });
    };

    // 保存call_log_id
    var _putCallLogId = function (data) {
        $.http({
            type: 'PUT',
            dataType: 'json',
            url: '/api/customer/calllog',
            data: data.data,
            success: data.success,
            error: data.error
        });
    };

    // 踢公拉私
    var _maintainCustomer = function (data) {
        var apiUrl;

        if (data.type == 'public') {
            apiUrl = '/api/buyer/gopublic';
        } else {
            apiUrl = '/api/public/gobuyer';
        }

        $.http({
            type: 'PUT',
            dataType: 'json',
            url: apiUrl,
            data: data.data,
            success: data.success,
            error: data.error
        });
    };

    return {
        followup: _followup,
        phoneValidate: _phoneValidate,
        putCallLogId: _putCallLogId,
        maintainCustomer: _maintainCustomer
    };
}());