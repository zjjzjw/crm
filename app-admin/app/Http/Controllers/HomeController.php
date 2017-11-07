<?php namespace Huifang\Admin\Http\Controllers;


class HomeController extends BaseController
{
    public function home()
    {
        $this->file_css = 'pages.home.index';
        $this->file_js = 'pages.home.index';
        $data = [];

        $view = $this->view('pages.home.index', $data);
        return $view;
    }
}

