@extends('layout.master')
@section('title', 'Create Sub Category')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-12">
                <h3>Create Sub Category</h3>
                <hr>
                <form action="{{ route('category.sub.store',$category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Parent Category</label>
                        <input type="text" value="{{ $category->name }}" class="form-control" readonly>
                    </div>
                    <x-input name='category' type='text' />
                    <x-input name='image' type='file' class="p-1" />
                    <div class="mt-4">
                        <button class="btn btn-primary">create</button>
                        <a href="{{ route('category.index') }}" class="btn btn-outline-primary ml-3">cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @endsection
