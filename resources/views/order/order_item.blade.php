@extends('layout.master')
@section('title', 'Order')
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class=" col-12">

                <a href="{{ url()->previous() }}" class="float-left btn btn-primary mb-3"><i
                        class="fas fa-chevron-left"></i></a>

                <table class="table table-bordered">
                    <thead class="bg-primary text-white">
                        <th>No</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th> Price</th>
                        <th>Count</th>
                        <th> Total</th>

                    </thead>
                    <tbody>

                        @foreach ($orderItem as $ind => $order)
                            <tr>
                                <td>{{ $ind + 1 }}</td>
                                <td>{{ $order->name }}</td>
                                <td>
                                    @foreach (explode(',', $order->images) as $img)
                                        <img src="{{ asset('product/' . $img) }}" alt="" width="55" height="50" class="rounded mx-1">
                                    @endforeach
                                </td>
                                <td>{{ $order->price }} MMK</td>
                                <td>{{ $order->count }}</td>
                                <td>{{ $order->total }} MMK</td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>



            </div>
        </div>
    </div>
@endsection
