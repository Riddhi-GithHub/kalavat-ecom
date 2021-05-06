<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// success run
// Route::post('login','ApiController@app_login');
// Route::post('register','ApiController@app_register');
// Route::post('resend','ApiController@resend_mobile_otp');
// Route::post('test','ApiController@getFavouriteList');

Route::post('register', 'API\UsersController@register');
Route::post('verification_otp', 'API\UsersController@verification_otp');
Route::post('resend', 'API\UsersController@resend_mobile_otp');
Route::post('login', 'API\UsersController@login');

Route::post('add_account', 'API\UsersController@add_account');
Route::post('edit_account', 'API\UsersController@edit_account');
Route::post('add_contact', 'API\UsersController@add_contact');
Route::post('bank_detail_add', 'API\UsersController@bank_detail_add');
Route::post('bank_details', 'API\UsersController@bank_details');

Route::post('forgot_password','ApiController@forgot_password');
Route::get('change-password/{id}','ApiController@change_password')->name('change-password');
Route::post('change-password', 'ApiController@store_password')->name('password');   

// address
// Route::post('address_list', 'API\AddressController@address_list');
// Route::post('add_address', 'API\AddressController@add_address');
// Route::post('edit_address', 'API\AddressController@edit_address');
Route::post('delete_address', 'API\AddressController@delete_address');

// category
Route::post('category_list', 'API\CategoriesController@category_list');
// sub category
Route::post('subcategory_list', 'API\CategoriesController@subcategory_list');

// product list
Route::post('product_list', 'API\ProductsController@product_list');
// retrive product by category
Route::post('product_details', 'API\ProductsController@product_details');
// search product by category and product
Route::post('product_search', 'API\ProductsController@product_search');
// retrive product by subcategory
Route::post('subcategory_product_details', 'API\ProductsController@subcategory_product_details');
// retrive product images
Route::post('image_list', 'API\ProductsController@getIamgeList');
// retrive filtering product apply
Route::post('filter_product', 'API\ProductsController@filter_product');
// retrive filtering product 
Route::post('filter_product_get', 'API\ProductsController@filter_product_get');
# sort By Product
Route::post('sort_by_product', 'API\ProductsController@sort_by_product');
# product more informattion
Route::post('product_more_information', 'API\ProductsController@product_more_information');
# sale wise product list
Route::post('sale_product_list', 'API\ProductsController@sale_product_list');
# product list sale wise
Route::post('sale_product_details', 'API\ProductsController@sale_product_details');



// add to favourite product
Route::post('add_fav', 'API\FavouritesController@add_favourites');
// Route::post('favourite_list', 'API\FavouritesController@favourite_list');
// Route::post('delete_favourite', 'API\FavouritesController@delete_favourite');    ---incomplete



// ------------------  other way       ----------------
# Favourite
Route::post('add_favourite', 'API\FavouritesController@AddFavouriteProduct');
Route::post('favourite_list', 'API\FavouritesController@getFavouriteList');
Route::post('favourite_product_delete', 'API\FavouritesController@deleteFavouriteProdcut');
Route::post('favourite_product_update', 'API\FavouritesController@UpdateFavouriteProduct');

# Address
Route::post('add_address', 'API\AddressController@Address_Add');
Route::post('edit_address', 'API\AddressController@Address_Edit');
// Route::post('delete_address', 'API\AddressController@Address_Delete');
Route::post('address_list', 'API\AddressController@Address_List');


# Cart
Route::post('add_to_cart', 'API\CartController@addProductToCart');
Route::post('cart_list', 'API\CartController@getCartList');
Route::post('delete_to_cart', 'API\CartController@deleteCartProdcut');
Route::post('cart_quantity_update', 'API\CartController@cart_quantity_update');

# Order
Route::post('add_order', 'API\OrdersController@add_order');
Route::post('order_list', 'API\OrdersController@order_list');
Route::post('order_details', 'API\OrdersController@order_details');

# Order Details
// Route::post('add_cart_to_order', 'API\OrderDetailsController@Add_cart_to_Order');
Route::post('add_cart_to_order', 'API\OrdersController@add_cart_to_order');

## APP_VERSION_SETTING_UPDATE
Route::post('app_version_setting_update', 'ApiController@app_version_setting_update');

# Slider
Route::post('app_slider_list', 'ApiController@app_slider_list');
# banner click
Route::post('app_banner_click', 'ApiController@app_banner_click');


# Rating 
Route::post('app_product_rating_add', 'API\Ratingscontroller@app_product_rating_add');
Route::post('app_product_rating_list', 'API\Ratingscontroller@app_product_rating_list');
Route::post('app_product_rating_update', 'API\Ratingscontroller@app_product_rating_update');
Route::post('app_rating_helpful', 'API\Ratingscontroller@app_rating_helpful');

# count cart and favourite
Route::post('count_list', 'ApiController@count_list');

# App catlog/chat
Route::post('app_catlog_list', 'ApiController@app_catlog_list');

# setting list riddhi
Route::post('app_setting_list', 'API\UsersController@app_setting_list');

# share product or catalog
Route::post('app_share_item', 'API\ProductsController@app_share_item');
# catalog rating 
Route::post('app_catalog_rating_add', 'API\Ratingscontroller@app_catalog_rating_add');
Route::post('app_catalog_rating_list', 'API\Ratingscontroller@app_catalog_rating_list');

# search vipul
Route::post('app_home_page_search_list', 'ApiController@app_home_page_search_list');

Route::post('app_setting_update', 'ApiController@app_setting_update');
Route::post('app_my_bank_details_update', 'ApiController@app_my_bank_details_update');
Route::post('app_my_bank_details_list', 'ApiController@app_my_bank_details_list');













