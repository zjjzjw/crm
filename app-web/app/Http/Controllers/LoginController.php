<?php namespace Huifang\Web\Http\Controllers;

class LoginController extends BaseController
{
    public function login()
    {
        $this->file_css = 'login';
        $this->file_js = 'login';
        $this->title = '登录';
        return $this->view('touch.login');
    }

    public function error()
    {
        $this->file_css = 'error';
        $this->file_js = 'error';
        $this->title = '提示';
        return $this->view('touch.error');
    }

}