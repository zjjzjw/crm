<?php namespace Huifang\Crm\Http\Controllers;

use View;
use Request;
use Huifang\Domain\Uuid\Services\UuidService;

class BaseController extends Controller
{

    public $file_js;
    public $file_css;

    public function __construct()
    {
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
                'debug'      => config('page.debug'),
                'host'       => config('page.host'),
                'base_url'   => config('page.host') . '/js',
                'file_css'   => $this->file_css ?? '',
                'file_js'    => $this->file_js ?? '',
                'title'      => $this->title ?? '',
                'log_params' => [
                    'uid'  => '',
                    'guid' => $this->getGuid(),
                ],
                'user'       => $this->getUser(),
            ),
            $data
        );
        return view($view, $data);
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
