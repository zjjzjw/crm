<?php namespace Huifang\Mobi\Http\Controllers;


class ProductController extends BaseController
{
    public function product()
    {
        $this->file_css = 'pages.product';
        $this->file_js = 'pages.product';

        $view = $this->view('pages.product');
        return $view;
    }
}
