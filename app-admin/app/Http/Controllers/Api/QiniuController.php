<?php

namespace Huifang\Admin\Http\Controllers\Api;


use Huifang\Crm\Http\Controllers\Controller;
use Huifang\Src\Surport\Domain\Model\ResourceEntity;

use Huifang\Src\Surport\Infra\Repository\ResourceRepository;
use Illuminate\Http\Request;

class QiniuController extends Controller
{

    public function actionStorageTokens()
    {
        $resource_repository = new ResourceRepository();
        $token = $resource_repository->uploadToken(env('STORAGE_QINIU_DEFAULT_BUCKET'));
        $result = ["items" => [0 => $token]];
        return response()->json($result);
    }
}