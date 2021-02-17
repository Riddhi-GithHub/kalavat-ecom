<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\category;

class CategoriesController extends BaseController
{
    public function category_list(Request $request)
    {
        $cat = category::get();
        if(!empty($cat)){
            return $this->sendResponse($cat,'category retrieved successfully.');
        }else{
                return $this->sendError('category not found.'); 
                }
    }
}
