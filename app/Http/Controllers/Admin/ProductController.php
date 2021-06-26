<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(5);
        return view('product.index', compact('products'));
    }


    public function create()
    {
        $cats = Category::all();
        $subcats = SubCategory::all();
        $tags = Tag::all();
        return view('product.create', compact('cats', 'subcats', 'tags'));
    }


    public function store(ProductStoreRequest $request)
    {
        if(!$request->hasFile('images')){
            return redirect()->back()->withErrors(['images[]' => 'ဓာတ်ပုံထည့်ရန်လိုအပ်ပါသည်။']);
        }
        $files = $request->file('images');
        $images = '';
        foreach ($files as $file) {
            $imgNames = time() . uniqid() . '.' . $file->getClientOriginalExtension();
            $images .= $imgNames . ',';
            $file->move(public_path() . '/product/', $imgNames);
        }
        $images =  rtrim($images, ',');
        $product = new Product();
        $product->category_id = $request->category_id;
        $product->subcat_id = $request->subcat_id;
        $product->tag_id = $request->tag_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->colors = $request->colors;
        $product->sizes = $request->sizes;
        $product->description = $request->description;
        $product->images = $images;
        $product->save();

        return redirect()->route('product.index')->with('success', 'product create success!');
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $cats = Category::all();
        $subcats = SubCategory::all();
        $tags = Tag::all();
        $product = Product::findOrFail($id);
        return view('product.edit', compact('product', 'cats', 'subcats', 'tags'));
    }


    public function update(ProductUpdateRequest $request, $id)
    {

        $product = Product::findOrFail($id);
        $check = Product::where('name', $request->name)->where('id', '!=', $id)->first();
        if (!$check) {
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->subcat_id = $request->subcat_id;
            $product->tag_id = $request->tag_id;
            $product->name = $request->name;
            $product->price = $request->price;
            $product->colors = $request->colors;
            $product->sizes = $request->sizes;
            $product->description = $request->description;
            ## check image
            if ($request->hasFile('images')) {
                if ($product->images) {
                    foreach (explode(',', $product->images) as $img) {
                        File::delete('product/'.$img);
                    }
                }
                $files = $request->file('images');
                $images = '';
                foreach ($files as $file) {
                    $imgNames = time() . uniqid() . '.' . $file->getClientOriginalExtension();
                    $images .= $imgNames . ',';
                    $file->move(public_path() . '/product/', $imgNames);
                }
                $images =  rtrim($images, ',');
                $product->images = $images;
            }
            if ($product->update()) {
                return redirect()->route('product.index')->with('success', 'product update success!');
            } else {
                return redirect()->back()->with('error', 'product update fail!');
            }
        } else {
            return redirect()->back()->withErrors(['name' => 'Product အမျိုးအစားသည်ရှိပီးသားဖြစ်ပါသည်။']);
        }
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->images) {
            foreach (explode(',', $product->images) as $img) {
                File::delete('product/' . $img);
            }
        }
        $product->delete();
        return redirect()->back()->with('success', 'product delete success!');
    }
}
