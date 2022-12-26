<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user=$request->user();
        $cart=Cart::where('user_id',$user->id)->get();
        return response([
            'data'=>$cart
        ]);
    }
    public function store(Request $request)
    {
        $data=$request->validate([
            'id'=>'',
            'user_id'=>'',
            'quantity'=>''
        ]);
      
        $user_id=$request->user()->id;
        $product_id=$request->id;
        $data['user_id']=$user_id;
        $product=Product::find($request->id);
        $cart=Cart::where(['user_id'=>$user_id,'product_id'=>$product_id])->get();
        if($cart->count()>0)
        {
            Cart::where(['user_id'=>$user_id,'product_id'=>$product_id])->increment('quantity');
        }else
        {
            $cart=Cart::create([
                'user_id'=>$user_id,
                'name'=>$product->name,
                'product_id'=>$product_id,
                'quantity'=>1,
                'price'=>$product->price
            ]);
        }
         return response([
            'data'=>$cart,
            'status'=>201
        ]);


    }
    public function decrement(Request $request)
    {
      $user_id=$request->user()->id;
      $id=$request->id;
      $cart=Cart::where(['product_id'=>$id,'user_id'=>$user_id])->first();
      if($cart->quantity <=1)
      {
        $cart->delete();
      }else{
        $cart=Cart::where(['product_id'=>$id,'user_id'=>$user_id])->decrement('quantity');
      }
     // echo 'success';
    return response([
        'data'=>$cart,
    ]);

    }
    public function remove(Request $request)
    {
      $user_id=$request->user()->id;
      $id=$request->id;
      $cart=Cart::where(['id'=>$id,'user_id'=>$user_id])->first();
      $cart->delete();
      $carts=Cart::where('user_id',$user_id)->get();
      return response(['data'=>$carts]);

    }
}
