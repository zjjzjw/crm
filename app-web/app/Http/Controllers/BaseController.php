<?php namespace Huifang\Web\Http\Controllers;

use View;
use Request;
use Huifang\Domain\Uuid\Services\UuidService;

class BaseController extends Controller
{
    const CONST_WEILIAO = 'weiliao';
    const CONST_APP = 'app';
    const CONST_TOUCH = 'touch';
    const CONST_WECHAT = 'wechat';
    const CONST_BROWSER = 'browser';
    const CONST_MOBILE = 'mobile';
    const CONST_DISPATCH_PHONE = 'dispatch_phone';

    const DEVICE_ANDROID = 'android';
    const DEVICE_IPHONE = 'iphone';

    protected $title = '';
    protected $app_title = '';
    protected $meta_title = '';
    protected $meta_keyword = '';
    protected $meta_description = '';
    protected $file_css = '';
    protected $file_js = '';
    protected $log_params;
    protected $page_params;

    protected $is_member_page = true;

    public function __construct()
    {
        //是用户页面
        if ($this->is_member_page) {
        }
    }

    public function setSeo($title, $keyword, $description)
    {
        $this->meta_title = $title;
        $this->meta_keyword = $keyword;
        $this->meta_description = $description;
    }

    /**
     * 基类控制器增加一个获取设备编号的方法
     * @return mixed
     */
    public function getGuid()
    {
        /** @var $uuid_service \Huifang\Domain\Uuid\Services\UuidService */
        $uuid_service = app(UuidService::class);
        return $uuid_service->get();
    }


    protected function view($view, $data = array())
    {
        $data = array_merge(
            array(
                'debug'            => config('page.debug'),
                'title'            => $this->title,
                'meta_title'       => $this->meta_title ? $this->meta_title : $this->title,
                'app_title'        => $this->app_title,
                'meta_keyword'     => $this->meta_keyword,
                'meta_description' => $this->meta_description,
                'file_css'         => $this->file_css,
                'file_js'          => $this->file_js,
                'host'             => config('page.host'),
                'base_url'         => config('page.host') . '/js',
                'log_server'       => config('page.server')['log'],
                'uuid'             => $this->getGuid(),
                'sandbox'          => Request::get('from') ?: 'mobile',
                'from_code'        => config('page.from_code'),
                'page_params'      => $this->page_params,
                'city_jianpin'     => 'sh',
                'log_params'       => [
                    'uid'  => '',
                    'guid' => $this->getGuid(),
                ],
                'user'             => $this->getUser(),
            ),
            $data
        );
        return view($view, $data);
    }

    protected function get_view($view, $sandbox)
    {
        $file = '../resources/views/' . str_replace('.', '/', $view) . ucwords($sandbox) . '.blade.php';
        return (file_exists($file)) ? $view . ucwords($sandbox) : $view;
    }

    /**
     * 得到登录用户
     * @return mixed
     */
    public function getUser()
    {
        $user = request()->user();
        return $user;
    }

}
