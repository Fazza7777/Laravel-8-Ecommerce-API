@extends('layout.master')
@section('title', 'Category')
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-12">
                <a href="{{ route('tag.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> create Tag
                </a>
                <table class="table table-bordered mt-4">
                    <thead class="bg-primary text-white">
                        <th>No</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>

                        @foreach ($tags as $ind => $tag)
                            <tr>
                                <td>{{ $ind + 1 }}</td>
                                <td>{{ $tag->name }}</td>
                                <td><img src="{{ asset($tag->image) }}" alt="" width="50" height="50" class="rounded">
                                </td>
                                <td>
                                    <a href="{{ route('tag.edit', $tag->id) }}"
                                        class="btn btn-sm btn-warning mr-3"><i class="fa fa-edit"></i> Edit</a>
                                    <x-button :action="route('tag.destroy',$tag->id)" :slug="$tag->slug" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
