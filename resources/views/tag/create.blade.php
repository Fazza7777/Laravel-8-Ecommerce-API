@extends('layout.master')
@section('title', 'Create Tag')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-12">
                <h3>Create Tag</h3>
                <hr>
                <form action="{{ route('tag.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-input name='tag' type='text' />
                    <x-input name='image' type='file' class="p-1" />
                    <div class="mt-4">
                        <button class="btn btn-primary">create</button>
                        <a href="{{ route('tag.index') }}" class="btn btn-outline-primary ml-3">cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @endsection
