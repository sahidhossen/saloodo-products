<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'stock','price','discount'
    ];

    /**
     * Get all products from the database
     * Find grouped products and sum grouped products prices
     * Check if product has discount 
     */
    public static function getAllProducts() {
        $products = Product::all();
        if( count($products) ) {
            foreach ($products as $product ) {
                if ($product->grouped && $product->group_ids) {
                    if( $product->price < 1 ) {
                        $product->price = Product::whereIn('id',explode(',',$product->group_ids))->sum('price');
                    }
                    if ($product->discount) {
                        $product->discount_price = self::getDiscountPrice($product->price, $product->discount);
                    }
                } else if($product->discount){
                    $product->discount_price = self::getDiscountPrice($product->price, $product->discount);
                }
            }
        }
        return $products;
    }

    /**
     * Get Single Product
     * @param   $id     Product ID
     */
    public static function getProductById($id) {
        $product = Product::find($id); 
        if( $product->grouped && $product->price < 1 ) {
            $product->price = Product::whereIn('id',explode(',',$product->group_ids))->sum('price');
        }
        if ($product->dicount) {
            $product->price = self::getDiscountPrice($product->price,$product->discount);
        }
        return $product;
    }

    /**
     * Get discount price
     * @param   $price      Product Price
     * @param   $discount   Product discount
     */
    public static function getDiscountPrice($price, $discount) {
        // Check if the discount with percentage or concrete amount
        $discountValue = explode('%', $discount);
        if(count($discountValue)>1) {
            // Discount with percentage
            return $price - (((float) $discountValue[0] / 100) * $price);
        } else {
            // Discount with concrete amount
            return $price - (float) $discountValue[0];
        }
    }
}