<?php namespace Huifang\Mobi\Http\Controllers;


class HomeController extends BaseController
{
    public function home()
    {
        $this->file_css = 'pages.home';
        $this->file_js = 'pages.home';
        $data = [];

        $view = $this->view('pages.home', $data);
        return $view;
    }
}
