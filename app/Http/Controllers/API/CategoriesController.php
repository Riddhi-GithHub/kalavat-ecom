<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Category;
use App\Models\Sub_Category;

class CategoriesController extends BaseController
{
    public function category_list(Request $request)
    {
        $cat = Category::latest()->get();
        // $cat = Category::with('product')->get();
        if(!empty($cat)){
            return $this->sendResponse_category($cat,'Category retrieved Successfully.');
        }else{
                return $this->sendError('Category not found.'); 
            }
    }

    public function subcategory_list(Request $request)
    {
        if($request->cat_id){
            $cat = Category::find($request->cat_id);
            if(!empty($cat)){
                 $subcat = Sub_Category::where('cat_id','=',$request->cat_id)->get();
                if(!empty($subcat->count() > 0)){
                    return $this->sendResponse_subcategory($subcat,'Subcategory retrieved Successfully.');
                }else{
                        return $this->sendError('Subcategory not found.'); 
                    }
            }else{
                return $this->sendError('Category not found.'); 
            }
        }else{
            return $this->sendError('Fill Required Data.'); 
        }
    }

}
