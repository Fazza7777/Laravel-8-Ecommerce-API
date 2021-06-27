@extends('layout.master')
@section('title', 'Category')
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-12">
                <a href="{{ route('category.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> create
                    category</a>
                <table class="table table-bordered mt-4">
                    <thead class="bg-primary text-white">
                        <th>No</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Child</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>

                        @foreach ($categories as $ind => $cat)
                            <tr>
                                <td>{{ $ind + 1 }}</td>
                                <td>{{ $cat->name }}</td>
                                <td><img src="{{ asset($cat->image) }}" alt="" width="50" height="50" class="rounded">
                                </td>
                                <td>
                                    <a href="{{ route('category.sub.index',$cat->id) }}" class="btn-sm btn btn-info">
                                        <i class="fa fa-eye"></i>

                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('category.edit', $cat->id) }}"
                                        class="btn btn-sm btn-success mr-3"><i class="fa fa-edit"></i> Edit</a>
                                    <x-button :action="route('category.destroy',$cat->id)" :slug="$cat->slug" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
