<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $orders=Order::where('status','pending')->get();
        return view('welcome',compact('orders'));
    }
    public function store(Request $request)
    {
        $order=Order::find($request->id);
        $discount=$request->discount;
        //dd($request->all());
        if($discount>0)
        {
            $old_total=$order->total;
            $new_total=$old_total-$discount;
            $order->update([
                'status'=>'completed',
                'total'=>$new_total,
                'discount'=>$discount
            ]);
        }else
        {
            $order->update([
                'status'=>'completed',
                
            ]); 
            //dd($order);
        }
         return redirect('/');
    }
}
