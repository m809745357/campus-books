<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('/bookmark/categories', CategoryController::class);
    $router->resource('/bookmark/books', BookController::class);
    $router->resource('/bookmark/demand', DemandController::class);
    $router->resource('/member', MemberController::class);
    $router->resource('/club/channels', ChannelController::class);
    $router->resource('/club/thread', ThreadController::class);
    $router->resource('/club/reply', ReplyController::class);
    $router->resource('/account/recharge', RechargeController::class);
    $router->resource('/account/bill', BillController::class);
    $router->resource('/account/bank', WithdrawController::class);
    $router->post('/account/bank/checkrow', 'WithdrawController@checkrow');
    $router->resource('/deloy/carousels', CarouselController::class);
    $router->resource('/deloy/config', ConfigController::class);
});
