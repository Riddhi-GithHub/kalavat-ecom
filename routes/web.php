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

Route::get('admin/login', 'AuthController@login');
Route::post('admin/login', 'AuthController@post_login');
Route::get('admin/logout', 'AuthController@logout');


Route::group(['middleware' => 'superadmin'], function () {


});

Route::group(['middleware' => 'admin'], function(){

	Route::get('admin/dashboard', 'Backend\DashboardController@dashboard_list');

	Route::get('admin/user', 'Backend\UserController@user_list');
	Route::get('admin/user/add', 'Backend\UserController@user_add');
	Route::post('admin/user/add', 'Backend\UserController@user_insert');
	Route::get('admin/user/edit/{id}', 'Backend\UserController@user_edit');
	Route::post('admin/user/edit/{id}', 'Backend\UserController@user_update');
	Route::get('admin/user/view/{id}', 'Backend\UserController@user_view');
	Route::get('admin/user/delete/{id}', 'Backend\UserController@user_delete')->name('user.delete');

	Route::resource('admin/category','Backend\CategoryController');
	Route::get('admin/category/delete/{id}', 'Backend\CategoryController@category_delete')->name('category.delete');

	Route::resource('admin/product','Backend\ProductController');
	Route::get('admin/product/delete/{id}', 'Backend\ProductController@product_delete')->name('product.delete');

	Route::resource('admin/favouriteitem','Backend\FavouriteController');
	Route::get('admin/favouriteitem/delete/{id}', 'Backend\FavouriteController@favouriteitem_delete')->name('favouriteitem.delete');

	Route::get('admin/contact_us', 'Backend\ContactUsController@contact_us_list');
	Route::get('admin/contact_us/delete/{id}', 'Backend\ContactUsController@contact_us_delete')->name('contact.delete');

	Route::resource('admin/cartitem','Backend\CartController');
	Route::get('admin/cartitem/delete/{id}', 'Backend\CartController@cartitem_delete')->name('cart.delete');
	
	Route::resource('admin/order','Backend\OrderController');
	Route::get('admin/changeStatus', 'Backend\OrderController@OderschangeStatus');
	Route::get('admin/order/delete/{id}', 'Backend\OrderController@order_delete')->name('order.delete');

	Route::resource('admin/subcategory','Backend\SubCategoryController');
	Route::get('admin/subcategory/delete/{id}', 'Backend\SubCategoryController@subcategory_delete')->name('subcategory.delete');

	Route::get('admin/versionsetting','Backend\VersionSettingController@versionsetting');
	Route::get('admin/versionsetting/edit/{id}', 'Backend\VersionSettingController@versionsetting_edit');
	Route::post('admin/versionsetting/edit/{id}', 'Backend\VersionSettingController@versionsetting_update');

	Route::get('admin/slider', 'Backend\SliderController@slider_list');
	Route::get('admin/slider/add', 'Backend\SliderController@slider_add');
	Route::post('admin/slider/add', 'Backend\SliderController@slider_insert');
	Route::get('admin/slider/edit/{id}', 'Backend\SliderController@slider_edit');
	Route::post('admin/slider/update/{id}', 'Backend\SliderController@slider_update');
	Route::get('admin/slider/delete/{id}', 'Backend\SliderController@slider_delete')->name('slider.delete');

	Route::get('admin/products/importexcel', 'Backend\ProductController@import')->name('product.import_excel');

});
