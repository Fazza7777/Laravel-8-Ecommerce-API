@extends('layout.master')
@section('title', 'Sub Category')
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-12">
                <a href="{{url()->previous() }}" class="btn btn-primary"><i
                    class="fas fa-chevron-left"></i></a>
                <a href="{{ route('category.sub.create', $category->id) }}" class="btn btn-primary"><i
                        class="fas fa-plus-circle"></i> create
                    sub category</a>
                @if (count($category->subcat) > 0)
                    <table class="table table-bordered mt-4">
                        <thead class="bg-primary text-white">
                            <th>No</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @foreach ($category->subcat as $ind => $cat)
                                <tr>
                                    <td>{{ $ind + 1 }}</td>
                                    <td>{{ $cat->name }}</td>
                                    <td><img src="{{ asset($cat->image) }}" alt="" width="50" height="50" class="rounded">
                                    </td>
                                   <td>{{ $category->name }}</td>
                                    <td>

                                        <a href="{{ route('sub.edit', $cat->id) }}" class="btn btn-sm btn-warning mr-3"><i
                                                class="fa fa-edit"></i> Edit</a>
                                        <x-button :action="route('sub.destroy',$cat->id)" :slug="$cat->id" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                @else
                <div class="alert mt-5 alert-info"><a href="{{ route('category.index') }}"><i class="fas fa-long-arrow-alt-left mr-3"></i></a> Sub Category is Empty!</div>
                @endif
            </div>
        </div>
    </div>
@endsection
