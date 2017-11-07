<?php

namespace Huifang\Web\Http\Controllers\Auth;

use Huifang\Web\Http\Controllers\BaseController;
use Huifang\Web\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class AuthController extends BaseController
{

    use AuthenticatesUsers;

    /**
     * @var string redirect path
     */
    protected $redirectPath = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        parent::__construct();
    }

    public function getLogin()
    {
        $this->file_css = 'login';
        $this->file_js = 'login';
        return $this->view('touch.login', ['title' => '登录']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {

        $this->validate($request, [
            'phone' => 'required', 'password' => 'required',
        ]);
        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return redirect()->intended($this->redirectPath());
        }

        return redirect($this->loginPath())
            ->withInput($request->only('phone', 'remember'))
            ->withErrors([
                'phone' => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        return $request->only('phone', 'password');
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        $error_msg = app('Huifang\Web\Src\UserCenter\Service\UserCenterService')->getFailedLoginMessage();

        return !empty($error_msg) ? $error_msg : '没有权限！';
    }
}
