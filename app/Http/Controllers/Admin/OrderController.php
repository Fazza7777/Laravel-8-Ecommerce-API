<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(5);
        return view('order.order',compact('orders'));
    }

    public function changeOrderStatus($id){
        $order = Order::findOrFail($id);
        $order->status = !$order->status;
        $order->update();
        if($order->status)
        return redirect()->back()->with('success','Order check success!');
        else 
        return redirect()->back()->with('info','Order not check!');
    }
}
