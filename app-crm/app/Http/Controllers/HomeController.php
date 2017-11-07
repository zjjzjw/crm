<?php namespace Huifang\Crm\Http\Controllers;


class HomeController extends BaseController
{
    public function home()
    {
        $this->file_css = 'pages.home.index';
        $this->file_js = 'pages.home.index';
        $this->title = 'CRM管理后台欢迎您！';
        $data = [];

        $view = $this->view('pages.home.index', $data);
        return $view;
    }
}
