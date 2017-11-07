<?php
//找不到的路由,统一跳转到首页
Route::any('/{one?}/{two?}/{three?}/{four?}/{five?}', [
    'uses' => function () {
        return redirect()->route('index');
    },
]);
