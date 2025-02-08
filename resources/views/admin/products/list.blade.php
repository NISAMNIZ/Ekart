@extends('admin.layout.master')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Products</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Products</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
               <a href="{{route('admin.product.create')}}" class="btn-primary" style="float:right;padding: 3px 5px;border-radius: 4px;">Add Product</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Price</th>
                      <th>Description</th>
                      <th>Category</th>
                       <th>Status</th>
                       <th>Favorite</th>
                      <th style="width: 40px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($products as $product)
                    <tr>
                      <td>{{ $products->firstItem() + $loop->index}}</td>
                      <td><img src="{{asset("storage/images/".$product->image)}}"style="width:100px"></td>
                      <td>{{$product->name}}</td>
                      <td>{{number_format($product->price,2)}}</td>
                      <td>{{$product->description}}</td>
                      <td>{{$product->category_id ? $product->category->name: 'NA'}}</td>
                      <td>{{$product->status == 1 ? 'Active' : 'Inactive'}}</td>
                      <td>{{$product->is_favorite == 1? 'Yes' : 'No'}}</td>
                      <td style="display:flex">
                        <button type="button" class="btn btn-success btn-rounded EditProduct" style="margin-right: 10px;" data-id="{{$product->id}}">Edit</button>
                        <button type="button" class="btn btn-danger btn-rounded DeleteProduct" data-id="{{$product->id}}">Delete</button>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                {{$products->links()}}
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <script>
      $(document).ready(function () {
        // Add CSRF token to every AJAX request header
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.DeleteProduct', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            
            if (confirm('Are you sure you want to delete this product?')) {
                $.post('{{ route('admin.product.delete') }}', {id: id}, function () {
                    toastr.success("Product Deleted Successfully");
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }).fail(function () {
                    toastr.error("Failed to delete product.");
                });
            }
        });
        $(document).on('click', '.EditProduct', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            window.location.href = '/admin/product/edit/' + id;
        });
    });

    </script>
@endsection
