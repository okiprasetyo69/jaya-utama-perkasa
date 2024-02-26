<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Helpers\GlobalHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;;
use App\Models\ProductItems;

class ProductItemController extends Controller
{
    
    public function create(Request $request){
        try{
            $productItems = new ProductItems();
            $productItems->fill($request->all());

            $validator = Validator::make($request->all(), [
                'category_id' => 'required',
                'product_name' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors(),
                    'status' => 422
                ]);
            }

            if($request->id != null){
                $productItems = $productItems::find($request->id);
            }

            $productItems->category_id = $request->category_id;
            $productItems->product_name = $request->product_name;

            $productItems->save();

            return response()->json(
                [
                'status' => 200,
                'message' => true,
                'data' => $productItems
                ]
            ); 

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getProductItem(Request $request){
        try{
            $productItems = ProductItems::with('categories')->get();

            return response()->json(
                [
                    'status' => 200,
                    'message' => true,
                    'data' => $productItems
                ]
            ); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        try{
            $productItems = ProductItems::find($request->id);
            return response()->json(
                [
                'status' => 200,
                'message' => true,
                'data' => $productItems
                ]
            );

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{
            $productItems = ProductItems::find($request->id)->first();
            if($productItems == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $productItems->delete();
            return response()->json(
                [
                'status' => 200,
                'message' => 'Success delete category.',
                ]
            );

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
