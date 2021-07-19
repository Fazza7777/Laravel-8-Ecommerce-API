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
use App\Models\SaveProduct;
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
            'phone' => 'required|unique:users|digits_between:7,11',
            'password' => 'required',
            'password_confrim' => 'required|same:password'
        ], [
            'required' => ':attribute ထည့်ရန်လိုအပ်ပါသည်',
            'digits_between' => ':attribute သည်အနည်းဆုံး 9လုံး အများဆုံး 11လုံး ထည့်ရန်လိုအပ်ပါသည်',
            'unique' => ' :attribute သည်အသုံးပြုပီးဖြစ်ပါသည်',
            'same' => ':attribute များတူညီရန်လိုအပ်ပါသည်။'
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
        $user = User::where('email', $request->email)->first();
        if ($token) {
            return response()->json([
                'status' => 200,
                'success' => true,
                'token' => $token,
                'user' => $user
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
        $categories = Category::withcount('product')->latest()->get();
        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => $categories,
        ]);
    }
    public function subcats()
    {
        $subcats = SubCategory::withcount('product')->take(15)->get();

        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => $subcats,
        ]);
    }
    public function subCategories($id)
    {
        $subCategories = SubCategory::where('category_id', $id)->get();
        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => $subCategories,
        ]);
    }
    public function tags()
    {
        $tags = Tag::get();

        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => $tags,
        ]);
    }
    public function products(Request $request)
    {
        $products = Product::with('cat', 'subcat', 'tag')->latest()->simplePaginate(12);
        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => $products,

        ]);
    }
    public function productById($id)
    {
        $chkSave = SaveProduct::where('product_id', $id)->first();
        if ($chkSave) {
            $save = true;
        } else {
            $save = false;
        }

        $product = Product::with('cat', 'subcat', 'tag')->where('id', $id)->first();
        $product['save'] = $save;
        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => $product,

        ]);
    }
    public function productByCategory($id)
    {
        $products = Product::where('category_id', $id)->with('cat', 'subcat', 'tag')->simplePaginate(5);
        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => $products
        ]);
    }
    public function productBysubCat($id)
    {
        $products = Product::where('subcat_id', $id)->simplePaginate(50);
        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => $products
        ]);
    }

    public function productByTag($id)
    {
        $products = Product::where('tag_id', $id)->latest()->take(6)->get();
        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => $products
        ]);
    }
    public function productByAllTag($id)
    {
        $products = Product::where('tag_id', $id)->latest()->paginate(50);
        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => $products
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
            'data' => $orders
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
    ## save product
    public function saveProduct(Request $request)
    {
        $user_id = auth()->user()->id;
        $product_id = $request->product_id;
        $save_product = new SaveProduct();
        $save_product->user_id = $user_id;
        $save_product->product_id = $product_id;
        $save_product->save();
        $product = Product::with('cat', 'subcat', 'tag')->where('id', $product_id)->first();
        $product['save'] = true;
        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => $product,

        ]);
    }
    public function unsaveProduct(Request $request)
    {

        $product_id = $request->product_id;
        $product = Product::with('cat', 'subcat', 'tag')->where('id', $product_id)->first();
        $product['save'] = false;

        SaveProduct::where('product_id', $product_id)->delete();

        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => $product,

        ]);
    }
}
