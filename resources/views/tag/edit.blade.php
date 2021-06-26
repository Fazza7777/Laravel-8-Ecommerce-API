@extends('layout.master')
@section('title', 'Tag Edit')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-12">
                <h3>Edit Tag</h3>
                <hr>
                <form action="{{ route('tag.update',$tag->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <x-input name='tag' type='text' value="{{ $tag->name }}" />
                        <p>
                            <img src="{{ asset($tag->image) }}" width="50" height="50" class="rounded" alt="">
                        </p>
                    <x-input name='image' type='file' class="p-1" />
                    <div class="mt-4">
                        <button class="btn btn-primary">update</button>
                        <a href="{{ route('tag.index') }}" class="btn btn-outline-primary ml-3">cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @endsection
