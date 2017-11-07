<?php

namespace Huifang\Mobi\Http\Controllers\Api\Auth;

use Huifang\Mobi\Http\Controllers\BaseController;
use Huifang\Mobi\Src\Forms\Auth\LoginForm;
use Huifang\Mobi\Src\Service\Auth\MobileSessionService;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    public function login(Request $request, LoginForm $form)
    {
        $data = [];
        $form->validate($request->all());
        $mobile_session_service = new  MobileSessionService();
        $result = $mobile_session_service->login($form->mobile_login_specification);
        if ($result['success']) {
            $data['code'] = 200;
            $data['msg'] = 'success';
            $data['data']['user_id'] = $result['user_id'];
            $data['data']['token'] = $result['token'];
            return response()->json($data, 200);
        } else {
            $data['code'] = $result['code'];
            $data['msg'] = 'failed';
            return response()->json($data, 400);
        }
    }

}


