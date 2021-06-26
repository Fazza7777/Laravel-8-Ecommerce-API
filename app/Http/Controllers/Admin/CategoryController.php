<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Support\Facades\File;


class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(5);
        return view('category.index', compact('categories'));
    }


    public function create()
    {
        return view('category.create');
    }


    public function store(CategoryStoreRequest $request)
    {
        $file = $request->file('image');
        $imgName = time() . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path() . '/category', $imgName);
        $imgPath = 'category/' . $imgName;

        $category = new Category();
        $category->name = $request->category;
        $category->slug = time() . Str::slug($request->category);
        $category->image = $imgPath;
        if ($category->save()) {
            return redirect()->route('category.index')->with('success', 'category create success!');
        } else {
            return redirect()->back()->with('error', 'Category ထည့်သွင်းခြင်းမအောင်မြင်ပါ။');
        }
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }


    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $check = Category::where('name', $request->category)->where('id', '!=', $id)->first();
        if (!$check) {
            $category->name = $request->category;
            $category->slug = time() . Str::slug($request->category);
            ## check image
            if ($request->hasFile('image')) {
                File::delete($category->image);
                $file = $request->file('image');
                $imgName = time() . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/category', $imgName);
                $imgPath = 'category/' . $imgName;
                $category->image = $imgPath;
            }
            if ($category->update()) {
                return redirect()->route('category.index')->with('success', 'category update success!');
            } else {
                return redirect()->back()->with('error', 'Category update fail!');
            }
        } else {
            return redirect()->back()->withErrors(['category' => 'Category အမျိုးအစားသည်ရှိပီးသားဖြစ်ပါသည်။']);
        }
    }

    public function destroy($id)
    {
        $category = Category::with('subCat')->findOrFail($id);
        if($category->subcat){
            foreach($category->subcat as $cat){
                File::delete($cat->image);
            }
        }
        if ($category->image) {
            File::delete($category->image);
        }
        $category->delete();
        return redirect()->back()->with('success', 'category delete success!');
    }
}
