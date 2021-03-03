<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => 1,
            'message' => $message,
            'data'    => $result,
        ];
        return response()->json($response, 200);
    }

    public function sendResponse_category($result, $message)
    {
    	$response = [
            'success' => 1,
            'message' => $message,
            'category_list'    => $result,
        ];
        return response()->json($response, 200);
    }

    public function sendResponse_subcategory($result, $message)
    {
    	$response = [
            'success' => 1,
            'message' => $message,
            'subcategory_list'    => $result,
        ];
        return response()->json($response, 200);
    }

    public function sendResponse_product($result, $message)
    {
    	$response = [
            'success' => 1,
            'message' => $message,
            'product_list'    => $result,
        ];
        return response()->json($response, 200);
    }

    public function sendResponse_test($message ,$result = [])
    {
    	$response = [
            'success' => 1,
            'message' => $message,
        ];

        if(!empty($result)){
            $response['data'] = $result;
        }
        return response()->json($response, 200);
    }

    
    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 200)
    {
    	$response = [
            'success' => 0,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    // for register
    public function sendErrors($message)
    {
    	$response = [
            'success' => 0,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
}
