@extends('layout.master')
@section('title', 'Product')
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <a href="{{ route('product.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> create Product
                </a>
                <table class="table table-bordered mt-4">
                    <thead class="bg-primary text-white">
                        <th>No</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Colors</th>
                        <th>Size</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>

                        @foreach ($products as $ind => $product)
                            <tr>
                                <td>{{ $ind + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    @foreach (explode(',',$product->images) as $img)
                                      <img onclick="showLightBox('{{ asset("product/".$img) }}','{{ $product->name }}')" src="{{ asset('product/'.$img) }}" alt="" width="50" height="50" class="rounded">
                                    @endforeach
                                </td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->colors }}</td>
                                <td>{{ $product->sizes }}</td>
                                <td>{{ $product->description }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('product.edit', $product->id) }}"
                                        class="btn btn-sm btn-success mr-3"><i class="fa fa-edit"></i> Edit</a>
                                    <x-button :action="route('product.destroy',$product->id)" :slug="$product->slug" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <div class="mt-3">
                   <div class="">
                    {{ $products->links() }}
                   </div>
                </div>

            </div>
        </div>
    </div>
          <!--    ImageLight Box or    Modal Box Start -->
          <div class="modal" tabindex="-1" id='lightBox' role="dialog">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id='title'></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <p class="text-center"><img src="" id='image'  alt="" width="270" height="300"></p>
                </div>

            </div>
            </div>
        </div>
      <!--    ImageLight Box or    Modal Box end -->
@endsection

@push('script')
<script>
    let showLightBox = (img,title)=>{
     document.querySelector('#image').src = img;
     document.querySelector('#title').innerHTML = title;
     $('#lightBox').modal('show')
    }
</script>

@endpush
