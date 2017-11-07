<?php namespace Huifang\Http\Middleware;

use Xinfang\Exceptions\BuyerException;
use Angejia\Account\Middleware\SsoMiddleware;

class Authenticate extends SsoMiddleware
{
    public function getAppKey()
    {
        return getenv('ACCOUNT_APP_KEY');
    }

    public function intecept($request)
    {
    }

    public function notAuthToUrl($request)
    {
        $allow_departs = explode(',', getenv('ALLOW_DEPARTMENT_ID'));
        $allow_users = explode(',', getenv('ALLOW_USER_ID'));
        if (!in_array(sso()->get()->getId(), $allow_users) &&
            !in_array(sso()->get()->getDepartment(), $allow_departs)) {
            throw new BuyerException('暂无权限', BuyerException::CODE_NO_PERMISSION);
        }
        return null;
    }
}
