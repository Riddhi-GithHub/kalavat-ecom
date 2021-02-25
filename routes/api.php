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

Route::post('edit_account', 'API\UsersController@edit_account');
Route::post('add_contact', 'API\UsersController@add_contact');

// address
// Route::post('address_list', 'API\AddressController@address_list');
// Route::post('add_address', 'API\AddressController@add_address');
// Route::post('edit_address', 'API\AddressController@edit_address');
Route::post('delete_address', 'API\AddressController@delete_address');

// category
Route::post('category_list', 'API\CategoriesController@category_list');

// product
Route::post('product_list', 'API\ProductsController@product_list');
// retrive product by category
Route::post('product_details', 'API\ProductsController@product_details');
// search product by category and product
Route::post('product_search', 'API\ProductsController@product_search');

Route::post('image_list', 'API\ProductsController@getIamgeList');



// add to favourite product
Route::post('add_fav', 'API\FavouritesController@add_favourites');
// Route::post('favourite_list', 'API\FavouritesController@favourite_list');
// Route::post('delete_favourite', 'API\FavouritesController@delete_favourite');    ---incomplete



// ------------------  other way       ----------------
# Favourite
Route::post('add_favourite', 'API\FavouritesController@AddFavouriteProduct');
Route::post('favourite_list', 'API\FavouritesController@getFavouriteList');
Route::post('favourite_product_delete', 'API\FavouritesController@deleteFavouriteProdcut');

# Address
Route::post('add_address', 'API\AddressController@Address_Add');
Route::post('edit_address', 'API\AddressController@Address_Edit');
// Route::post('delete_address', 'API\AddressController@Address_Delete');
Route::post('address_list', 'API\AddressController@Address_List');


# Cart
Route::post('add_to_cart', 'API\CartController@addProductToCart');
Route::post('cart_list', 'API\CartController@getCartList');
Route::post('delete_to_cart', 'API\CartController@deleteCartProdcut');

# Order
Route::post('add_order', 'API\OrdersController@AddOrder');
Route::post('edit_order', 'API\OrdersController@EditOrder');
Route::post('order_list', 'API\OrdersController@ListOrder');
Route::post('delete_order', 'API\OrdersController@DeleteOrder');



