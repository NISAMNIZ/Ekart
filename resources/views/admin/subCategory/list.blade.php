@extends('admin.layout.master')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sub Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sub Category</li>
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
               <a href="{{route('admin.subCategory.create')}}" class="btn-primary" style="float:right;padding: 3px 5px;border-radius: 4px;">Add Sub Category</a>
              </div>
              @if ($subCategories->count())
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Slug</th>
                      <th style="width: 40px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($subCategories as $subCategory)
                    <tr>
                      <td>{{ $subCategories->firstItem() + $loop->index}}</td>
                      <td>{{$subCategory->name}}</td>
                      <td>{{$subCategory->slug ?:'NA'}}</td>
                      <td style="display:flex">
                        <button type="button" class="btn btn-success btn-rounded EditCategory" style="margin-right: 10px;" data-id="{{$subCategory->id}}">Edit</button>
                        <button type="button" class="btn btn-danger btn-rounded DeleteCategory" data-id="{{$subCategory->id}}">Delete</button>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              @else
              <div class="card-body">No data found</div>
              @endif
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                {{$subCategories->links()}}
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

        $(document).on('click', '.DeleteCategory', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            
            if (confirm('Are you sure you want to delete this category?')) {
                $.post('{{ route('admin.subCategory.delete') }}', {id: id}, function () {
                    toastr.success("Category Deleted Successfully");
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }).fail(function () {
                    toastr.error("There product underthis category so can't delete category.");
                });
            }
        });
        $(document).on('click', '.EditCategory', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            window.location.href = '/admin/subCategoryEdit/' + id;
        });
    });

    </script>
@endsection
