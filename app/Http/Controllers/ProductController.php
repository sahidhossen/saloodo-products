<?php

namespace App\Http\Controllers;

use Exception;
use App\User;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get All products list for this user only
     */
    public function getAll() {
        try{
            return ['success'=>true, 'data'=> Product::getAllProducts()];
        } catch( Exception $e) {
            return ['success'=> false, 'message'=>$e->getMessage()];
        }   
    }

   /**
    * Create product
    * @param   Object  $request
    */
    public function create (Request $request) {
        try{
            //Validate required fields
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'price' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors(); 
               throw new Exception( implode('|', $errors->all()) );
            }

            $product = new Product();
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->image_url = $request->input('image_url');
            $product->stock = $request->input('stock') ?? 1;
            $product->grouped = $request->input('grouped') ?? false;
            $product->group_ids = $request->input('group_ids');
            $product->discount = $request->input('discount');
            $product->price = $request->input('price');
            $product->save();

            return ['success'=>true, 'data'=> $product , 'message'=>"Product create successfull"];
        } catch(Exception $e) {
            return ['success'=> false, 'message'=>$e->getMessage()];
        }
    }

    /**
     * Update product
     */
    public function edit (Request $request) {
        try{
             //Validate required fields
             $validator = Validator::make($request->all(), [
                'id' => 'required'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors(); 
               throw new Exception( implode('|', $errors->all()) );
            }

            $product = Product::find($request->input('id'));
            if (!$product) {
                throw new Exception("Product Not found!");
            }

            $product->name = $request->input('name') ?? $product->name;
            $product->price = $request->input('price') ?? $product->price;
            $product->description = $request->input('description') ?? $product->description;
            $product->image_url = $request->input('image_url') ?? $product->image_url;
            $product->stock = $request->input('stock') ?? $product->stock;
            $product->grouped = $request->input('grouped') ?? $product->grouped;
            $product->group_ids = $request->input('group_ids') ?? $product->group_ids;;
            $product->discount = $request->input('discount') ?? $product->discount;
            $product->save();

            return ['success'=>true, 'data'=>$product, 'message'=>"Product update successfull!"];

         } catch(Exception $e) {
            return ['success'=> false, 'message'=>$e->getMessage()];
        }
    }

}
