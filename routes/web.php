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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'Frontend\Homecontroller@index');
Route::get('/{title}', 'Frontend\Homecontroller@story');
Route::group(['prefix' => 'admin'], function() {
    Auth::routes();
    //    dashboard
    Route::get('dashboard', 'Backend\HomeController@index')->name('admin');
//    quản lý tài khoản
    Route::get('user', 'Backend\UserController@index')->name('user')->middleware('user');
//quản lý truyện
    Route::group(['prefix' => 'post', 'middleware' => 'post'], function () {
        Route::get('/', 'Backend\PostController@index')->name('post');
        Route::get('create', 'Backend\PostController@create')->name('post.create');
        Route::post('postCreate', 'Backend\PostController@postCreate')->name('post.postCreate');
        Route::get('edit/{id}', 'Backend\PostController@edit');
        Route::post('postEdit/{id}', 'Backend\PostController@postEdit');
        Route::get('delete/{id}', 'Backend\PostController@delete');
        Route::post('ajaxEditShortContent', 'Backend\PostController@ajaxEditShortContent')->name('ajax.editShortContent');
        Route::post('ajaxEditContent', 'Backend\PostController@ajaxEditContent')->name('ajax.editContent');
        Route::post('ajaxEditStatus', 'Backend\PostController@ajaxEditStatus')->name('ajax.editStatus');
        Route::post('validateTitleSeo', 'Backend\PostController@validateTitleSeo')->name('ajax.validateTitleSeo');
        Route::post('mainContent', 'Backend\PostController@mainContent')->name('ajax.mainContent');

        //delete type
        Route::get('typeDelete/{id}', 'Backend\PostController@typeDelete');

        Route::post('addType', 'Backend\PostController@addType')->name('addType');
    });
    //tool đăng bài tự động
    Route::group(['prefix' => 'tool', 'middleware' => 'post'], function () {
        Route::get('/', 'Backend\ToolController@index')->name('tool');
        Route::get('siteDelete/{id}', 'Backend\toolController@siteDelete');
        Route::post('siteStory', 'Backend\ToolController@siteStory')->name('tool.siteStory');
        Route::post('searchSite', 'Backend\ToolController@searchSite')->name('tool.ajax.searchSite');
        //get story
        Route::post('getStory', 'Backend\ToolController@getStory')->name('tool.ajax.getStory');
        Route::post('getPagination', 'Backend\ToolController@getPagination')->name('tool.ajax.pagination');
        Route::post('postCreate', 'Backend\ToolController@postCreate')->name('tool.postCreate');

    });
});