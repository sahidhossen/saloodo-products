<?php

namespace App\Http\Controllers;

use Exception;
use App\Product;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    private $error = "";
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
     * Get all order by user id
     */
    public function getOrders(Request $request) {
        try{
            $user = $request->user(); 
            $orders = Order::where(['user_id'=>$user->id])->get(); 
            $products = []; 
            if ( count($orders)) {
                foreach ($orders as $order) {
                    $product = Product::getProductById($order->product_id);
                    array_push($products, $product);
                }
            }
            return ['success'=>true, 'data'=>$products];
        } catch( Exception $e) {
            return ['succss'=>true, 'message'=>$e->getMessage()];
        }
    }

    /**
     * Create order from logged in customer
     * @param   $request        Request eloquent
     */
    public function create (Request $request) {
        try{
            $user = $request->user();
            $orders = $request->input('orders');

            if (!$orders) {
                throw new Exception("Order required!");
            }

            $products = [];
            $price = 0.00;
            
            if (is_array($orders) ) {
                foreach($orders as $order) {
                    $product = Product::getProductById($order['product_id']); // Get product by ID
                    $order['user_id'] = $user->id; // Inject user_id for current user
                    if (isset($order['id'])) {
                        // Update order
                        if (!$this->update($order)) {
                            throw new Exception($this->error);
                        }
                    } else {
                        // Create new order
                        if (!$this->store($order)) {
                            throw new Exception($this->error);
                        }
                    }
                    array_push($products, $product);
                    $price += $product->price;
                }

            } else {
                throw new Exception("Order must be an array");
            }

            return ['success'=>true, 'orders'=>$products, 'total_price'=>$price];
        } catch(Exception $e) {
            return ['success'=>false, 'message'=>$e->getMessage()];
        }
    }

    /**
     * Create new order from order object
     * @param   $order      Order Object
     */
    private function store( $order ) {
        try {
            $_order = new Order(); 
            $_order->user_id = $order['user_id'];
            $_order->product_id = $order['product_id'];
            $_order->save();
            return true;
        } catch(Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * Update previous order by providing the ID
     * @param   $order      Order Object
     */
    private function update( $order ) {
        try {
            $_order = Order::find( $order['id'] ); 
            $_order->user_id = isset($order['user_id']) ?? $_order->user_id;
            $_order->product_id = isset($order['product_id']) ?? $_order->product_id;
            $_order->save();
            return true;
        } catch(Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
        
    }

}