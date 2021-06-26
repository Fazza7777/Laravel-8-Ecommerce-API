@extends('layout.master')
@section('title', 'Order')
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class=" col-12">
              <div class="card">
                  <div class="card-header text-center">
                    <a href="{{url()->previous() }}" style="text-decoration: none" class="float-left btn btn-primary"><i
                        class="fas fa-chevron-left mr-2"></i> Back</a>
                        <h4 class="d-inline text-center">All Orders</h4>
                  </div>
                </div>
                    <table class="table table-bordered mt-4">
                        <thead class="bg-primary text-white">
                            <th>No</th>
                            <th>Name</th>
                            <th>Count</th>
                            <th> Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>

                            @foreach ($orders as $ind => $order)
                                <tr>
                                    <td>{{ $ind + 1 }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->count }}</td>
                                    <td>{{ $order->total }} MMK</td>
                                    <td>{{ $order->status }}</td>
                                    <td>
                                        <a href="{{ route('order_item', $order->id) }}"
                                            class="btn btn-sm btn-info mr-3"><i class="fa fa-eye"></i></a>
                                        {{-- <x-button :action="route('order.destroy',$order->id)" :slug="$order->slug" /> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>



            </div>
        </div>
    </div>
@endsection
