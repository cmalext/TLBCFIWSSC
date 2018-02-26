<?php
Route::get('/cache',function(){
	\Cache::flush();
});
Route::controller('/test', 'TestController');
Route::controller('/client', 'User\ClientController');
Route::controller('/billing', 'User\BillingController');
Route::controller('/payment', 'User\PaymentController');
Route::controller('/newsfeed', 'User\NewsfeedController');
Route::controller('/accounts', 'User\AccountController');
Route::controller('/user', 'User\UserController');
Route::controller('/system', 'User\SystemController');
Route::controller('/statistics', 'User\StatisticController');
Route::controller('/', 'HomeController');



