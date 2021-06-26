<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\CategoryStoreRequest;

class TagController extends Controller
{

    public function index()
    {
        $tags = Tag::orderBy('id', 'desc')->paginate(5);
        return view('tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagStoreRequest $request)
    {
        $file = $request->file('image');
        $imgName = time() . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path() . '/tag', $imgName);
        $imgPath = 'tag/' . $imgName;

        $tag = new Tag();
        $tag->name = $request->tag;
        $tag->image = $imgPath;
        if ($tag->save()) {
            return redirect()->route('tag.index')->with('success', 'tag create success!');
        } else {
            return redirect()->back()->with('error', 'Tag ထည့်သွင်းခြင်းမအောင်မြင်ပါ။');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view('tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $check = Tag::where('name', $request->tag)->where('id', '!=', $id)->first();
        if (!$check) {
            $tag->name = $request->tag;
            ## check image
            if ($request->hasFile('image')) {
                File::delete($tag->image);
                $file = $request->file('image');
                $imgName = time() . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/tag', $imgName);
                $imgPath = 'tag/' . $imgName;
                $tag->image = $imgPath;
            }
            if ($tag->update()) {
                return redirect()->route('tag.index')->with('success', 'tag update success!');
            } else {
                return redirect()->back()->with('error', 'tag update fail!');
            }
        } else {
            return redirect()->back()->withErrors(['tag' => 'Tag အမျိုးအစားသည်ရှိပီးသားဖြစ်ပါသည်။']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);

        if ($tag->image) {
            File::delete($tag->image);
        }
        $tag->delete();
        return redirect()->back()->with('success', 'tag delete success!');
    }
    
}
