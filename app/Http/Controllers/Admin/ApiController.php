<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use \Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\RoleUser;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|digits_between:7,11',
            'password' => 'required',
            'password_confrim' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->save();
        ## Define level
        $role_user = new RoleUser();
        $role_user->user_id = $user->id;
        $role_user->role_id = 1;
        $role_user->save();

        return response()->json([
            'status' => 200,
            'success' => true,
            'user' => $user
        ]);
    }
    public function login(Request $request)
    {
        $cre = $request->only('email', 'password');
        $token = JWTAuth::attempt($cre);
        if ($token) {
            return response()->json([
                'status' => 200,
                'success' => true,
                'token' => $token
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'success' => false,

            ]);
        }
    }
    public function me()
    {
        $user = Auth::user();
        return response()->json([
            'status' => 200,
            'success' => true,
            'user' => $user
        ]);
    }
    public function categories()
    {
        $categories = Category::with('subCat')->get();
        $count = Category::count();
        return response()->json([
            'status' => 200,
            'success' => true,
            'categories' => $categories,
            'count' => $count
        ]);
    }
    public function subCategories($id)
    {
        $subCategories = SubCategory::where('category_id', $id)->get();
        $count = SubCategory::count();
        return response()->json([
            'status' => 200,
            'success' => true,
            'subCats' => $subCategories,
            'count' => $count
        ]);
    }
    public function tags()
    {
        $tags = Tag::latest()->get();
        $count = Tag::count();
        return response()->json([
            'status' => 200,
            'success' => true,
            'tags' => $tags,
            'count' => $count
        ]);
    }
    public function products(Request $request)
    {
        $products = Product::with('cat', 'subcat', 'tag')->simplePaginate(5);
        $count = Product::count();

        return response()->json([
            'status' => 200,
            'success' => true,
            'products' => $products,
            'count' => $count

        ]);
    }
    public function productByCategory($id)
    {
        $products = Product::where('category_id', $id)->with('cat', 'subcat', 'tag')->simplePaginate(5);
        return response()->json([
            'status' => 200,
            'success' => true,
            'products' => $products
        ]);
    }
    public function productBysubCat($id)
    {
        $products = Product::where('subcat_id', $id)->with('cat', 'subcat', 'tag')->simplePaginate(5);
        return response()->json([
            'status' => 200,
            'success' => true,
            'products' => $products
        ]);
    }

    public function productByTag($id)
    {
        $products = Product::where('tag_id', $id)->with('cat', 'subcat', 'tag')->simplePaginate(5);
        return response()->json([
            'status' => 200,
            'success' => true,
            'products' => $products
        ]);
    }
    ## set order
    public function  setOrder(Request $request)
    {
        $orders = $request->orders;
        $orderId = $this->saveOrder($orders);
        foreach ($orders as $od) {
            $product = Product::find($od['id']);
            $order_item = new OrderItem();
            $order_item->order_id = $orderId;
            $order_item->user_id = auth()->user()->id;
            $order_item->category_id = $product->category_id;
            $order_item->subcat_id = $product->subcat_id;
            $order_item->tag_id = $product->tag_id;
            $order_item->name = $product->name;
            $order_item->price = $product->price;
            $order_item->images = $product->images;
            $order_item->color = $product->colors;
            $order_item->size = $product->sizes;
            $order_item->count = $od['count'];
            $order_item->total = $product->price * $od['count'];
            $order_item->save();
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'order success'
        ]);
    }
    public function saveOrder($orders)
    {
        ## calculate total
        $total = 0;
        foreach ($orders as $od) {
            $product = Product::find($od['id']);
            $total += $product->price * $od['count'];
        }
        ## save database
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->count = count($orders);
        $order->status = false;
        $order->total = $total;
        $order->save();

        return $order->id;
    }
    ## get order
    public function myOrder()
    {
        $orders = Order::where('user_id', auth()->user()->id)->get()->load('orderItem');
        return response()->json([
            'status' => 200,
            'success' => true,
            'orders' => $orders
        ]);
    }
    public function orderItemByorderId($id)
    {
        $orders = OrderItem::where('order_id', $id)->get();
        return response()->json([
            'status' => 200,
            'success' => true,
            'orders' => $orders
        ]);
    }
}
