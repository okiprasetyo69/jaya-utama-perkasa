<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Helpers\GlobalHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;;
use App\Models\Inventories;

class InventoriesController extends Controller
{

    public function getInventory(Request $request){
        try{
            $inventories = Inventories::all();
            return response()->json(
                [
                    'status' => 200,
                    'message' => true,
                    'data' => $inventories
                ]
            ); 

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        try{

            $inventory = new Inventories();
            $inventory->fill($request->all());

            $validator = Validator::make($request->all(), [
                'inventory_number' => 'required',
                'inventory_date' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors(),
                    'status' => 422
                ]);
            }

            if($request->id != null){
                $inventory = $inventory::find($request->id);
            }

            $inventory->inventory_number = $request->inventory_number;
            $inventory->inventory_date = $request->inventory_date;
            $inventory->inventory_reference_number = $request->inventory_reference_number;
            $inventory->inventory_notes = $request->inventory_notes;
            $inventory->products = json_encode($request->products);

            $inventory->save();

            return response()->json(
                [
                'status' => 200,
                'message' => true,
                'data' => $inventory
                ]
            ); 

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        try{
            $category = Inventories::find($request->id);
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
}
