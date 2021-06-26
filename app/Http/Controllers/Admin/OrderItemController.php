<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;


class OrderItemController extends Controller
{
    public function orderItem($id){
        $orderItem = OrderItem::where('order_id',$id)->latest()->get();
        return view('order.order_item',compact('orderItem'));
    }
}
