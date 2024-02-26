<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Helpers\GlobalHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;;
use App\Models\Categories;

class CategoryController extends Controller
{
    public function getAll(Request $request){
        try{
            
            $categories = Categories::all();

            return response()->json(
                [
                'status' => 200,
                'message' => true,
                'data' => $categories
                ]
            ); 

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        try{

            $category = new Categories();
            $category->fill($request->all());

            $validator = Validator::make($request->all(), [
                'category_code' => 'required',
                'category_name' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors(),
                    'status' => 422
                ]);
            }

            if($request->id != null){
                $category = $category::find($request->id);
            }

            $category->category_code = $request->category_code;
            $category->category_name = $request->category_name;

            $category->save();

            return response()->json(
                [
                'status' => 200,
                'message' => true,
                'data' => $category
                ]
            ); 

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        try{
            $category = Categories::find($request->id);
            return response()->json(
                [
                'status' => 200,
                'message' => true,
                'data' => $category
                ]
            );

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{
            $category = Categories::find($request->id)->first();
            if($category == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $category->delete();
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
