<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: shook Liu  |  Email:24147287@qq.com  | Time: 2018/6/19/019 15:52
// +----------------------------------------------------------------------
// | TITLE: todo?
// +----------------------------------------------------------------------



Route::group('api', function () {

   // Route::get('/', 'api/web.homeController/index');

    Route::group([], function () {
        Route::any('token', 'api/auth/token');
    });

    Route::group([], function () {
        Route::resource('test', \app\api\controller\TestController::class);
    })
        ->middleware([\Dawn\Auth\http\middleware\Authenticate::class.':api',]);



});

