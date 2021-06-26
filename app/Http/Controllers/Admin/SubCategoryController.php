<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class SubCategoryController extends Controller
{

    public function index($id)
    {
        $category = Category::with('subCat')->findOrFail($id);
        return view('subcategory.index', compact('category'));
    }

    public function create($id)
    {
        $category = Category::findOrFail($id);
        return view('subcategory.create', compact('category'));
    }


    public function store(CategoryStoreRequest $request, $id)
    {
        $file = $request->file('image');
        $imgName = time() . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path() . '/subCategory', $imgName);
        $imgPath = 'subCategory/' . $imgName;

        $subCat = new SubCategory();
        $subCat->name = $request->category;
        $subCat->category_id = $id;
        $subCat->image = $imgPath;
        if ($subCat->save()) {
            return redirect()->route('category.sub.index', $id)->with('success', 'sub category create success!');
        } else {
            return redirect()->back()->with('error', 'Sub Category ထည့်သွင်းခြင်းမအောင်မြင်ပါ။');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {

        $subCat = SubCategory::with('cat')->findOrFail($id);
        return view('subcategory.edit', compact('subCat'));
    }


    public function update(CategoryUpdateRequest $request, $id)
    {

        $category = SubCategory::findOrFail($id);
        $check = SubCategory::where('name', $request->category)->where('id', '!=', $id)->first();
        if (!$check) {
            $category->name = $request->category;
            ## check image
            if ($request->hasFile('image')) {
                File::delete($category->image);
                $file = $request->file('image');
                $imgName = time() . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/subCategory', $imgName);
                $imgPath = 'subCategory/' . $imgName;
                $category->image = $imgPath;
            }
            if ($category->update()) {
                return redirect()->route('category.sub.index',$category->category_id)->with('success', 'sub category update success!');
            } else {
                return redirect()->back()->with('error', 'Sub Category update fail!');
            }
        } else {
            return redirect()->back()->withErrors(['category' => 'Sub Category အမျိုးအစားသည်ရှိပီးသားဖြစ်ပါသည်။']);
        }
    }

    public function destroy($id)
    {
        $category = SubCategory::findOrFail($id);
        if ($category->image) {
            File::delete($category->image);
        }
        $category->delete();
        return redirect()->back()->with('success', 'category delete success!');
    }
}
