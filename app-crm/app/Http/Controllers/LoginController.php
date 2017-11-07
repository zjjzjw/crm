<?php namespace Huifang\Crm\Http\Controllers;


class LoginController extends BaseController
{
    public function login()
    {
        $this->file_css = 'pages.login';
        $this->file_js = 'pages.login';
        $data = [];

        return $this->view('pages.login', $data);
    }

}