<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

#登录
Route::match(['get','post'],'admin/login/login','Admin\LoginController@login')->name('login');
#退出
Route::get('admin/login/logout','Admin\LoginController@logout');
Route::group(['middleware'=>['auth:admin'],'prefix'=>'admin','namespace'=>'Admin'],function(){
    #首页展示
    Route::match(['post','get'],'user/index','UserController@index');
    Route::match(['get','post'],'user/info','UserController@info');
    #文章分类添加操作
    Route::match(['get','post'],'category/add','CategoryController@add');
    #文章分类展示操作
    Route::get('category/index','CategoryController@index');
    Route::post('category/changeorder','CategoryController@changeorder');
    Route::match(['post','get'],'category/edit/{cate_id}','CategoryController@edit');
    Route::match(['get','post'],'category/del/{cate_id}','CategoryController@del');
    #文章添加操作
    Route::match(['get','post'],'article/add','ArticleController@add');
    #文章列表展示
    Route::get('article/index','ArticleController@index');
    #修改密码
    Route::match(['get','post'],'user/pass','UserController@pass');

});