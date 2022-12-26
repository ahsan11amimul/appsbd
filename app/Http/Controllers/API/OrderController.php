<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request)
    {
     $user=$request->user();
     $orders=Order::where('user_id',$user->id)->get();
     return response(['data'=>$orders]);
    }
    public function store(Request $request)
    {
        $user=$request->user();
        $total=$this->cartTotal($user->id);
        $order=new Order();
        $order->user_id=$user->id;
        $order->total=$total;
        $order->save();
        $order_id=$order->id;
        $items=Cart::where('user_id',$user->id)->get();
        foreach($items as $item)
        {
         $orderItem=new OrderItem();
         $orderItem->order_id=$order_id;
        //  $orderItem->product_id=$item->product_id;
         $orderItem->name=$item->name;
         $orderItem->quantity=$item->quantity;
         $orderItem->price=$item->price;
         $orderItem->save();
        }
        return response(['data'=>$order]);

    }
    private function cartTotal($id)
    {
       $cart=Cart::where('user_id',$id)->get();
       $total=0;
       foreach($cart as $item)
       {
           $total+=($item->quantity*$item->price);
       }
       return $total;
    }
   
}
