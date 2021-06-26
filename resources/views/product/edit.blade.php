@extends('layout.master')
@section('title', 'Product Edit')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-12">
                <h3>Edit Product</h3>
                <hr>
                <form action="{{ route('product.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <x-input name='name' type='text' value='{{ $product->name }}'/>

                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-control rounded-0" name="category_id" id="category_id"
                                    onchange="catChange(event)">
                                    @foreach ($cats as $cat)
                                        <option {{ $product->category_id == $cat->id ? 'selected' : ''}} value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="">Sub Category</label>
                                <select name="subcat_id" class="form-control" id="subcat_id">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="">Tag</label>
                                <select name="tag_id" class="form-control">
                                    @foreach ($tags as $cat)
                                        <option {{ $product->tag_id == $cat->id ? 'selected' : ''}} value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <x-input name='price' value='{{ $product->price }}' type='text' />
                        </div>
                        <div class="col-md-6 col-12">
                            <x-input name='colors' value='{{ $product->colors }}' type='text' cn="Colors ( ကော်မာခံပီးထည့်ပါ )" />
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <x-input name='sizes' value='{{ $product->sizes }}' type='text' cn="Sizes ( ကော်မာခံပီးထည့်ပါ )" />
                        </div>
                        <div class="col-md-6 col-12">
                            <x-input type='file' name="images[]"    class="p-1" m="multiple" />
                            @foreach (explode(',',$product->images) as $img)
                            <img src="{{ asset('product/'.$img) }}" alt="" width="30" height="30" class="rounded">
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-12">
                            <x-textarea name='description' value='{{ $product->description }}'  class="p-1"  />
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary">update</button>
                        <a href="{{ route('product.index') }}" class="btn btn-outline-primary ml-3">cancel</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
    @endsection
    @push('script')
    <script>
        let cats = "{{ $cats }}";
        cats = cats.replace(/&quot;/g, "\"");
        cats = JSON.parse(cats);
        let subcats = "{{ $subcats }}";
        subcats = subcats.replace(/&quot;/g, "\"");
        subcats = JSON.parse(subcats);
        let catChange = (e) => {
            let catId = e.target.value;
            filterSub(catId);
        }
        let filterSub = (id) => {
            let subs = subcats.filter((s) => s.category_id == id);
            console.log(subs);
            let str = "";
            for (let sub of subs) {
                str += ` <option value="${sub.id}">${sub.name}</option>`;
            }
            document.querySelector('#subcat_id').innerHTML = str;
        }
        let selectCatId =  "{{ $product->category_id }}";
        filterSub(selectCatId);
    </script>
@endpush
