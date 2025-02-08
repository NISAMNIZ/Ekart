@extends('admin.layout.master')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>General Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">Add Category
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('admin.subCategory.save')}}" method="POST" id="subCategoryForm" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="hidden" name="sub_category_id" value="{{isset($subCategory) ? $subCategory->id : ''}}">
                    <input type="text" class="form-control" id="name" name="name" value="{{isset($subCategory) ? $subCategory->name : ''}}" placeholder="Enter sub Category Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{isset($subCategory->slug) ? $subCategory->slug : ''}}" placeholder="Enter sub Category slug ">
                  </div>
                  <div class="form-group">
                  <label for="exampleSelectRounded0">Category <code></code></label>
                  <select class="custom-select rounded-0" name="category" id="category">
                    <option value="">Please Select a Category</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}"
                    @if(isset($subCategory) && $subCategory->category_id == $category->id) 
                    selected 
                    @endif>{{$category->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleSelectRounded0">Show Home</label>
                  <select class="custom-select rounded-0" name="show_home" id="show_home">
                    <option value="yes" @if (isset($subCategory->show_home) && $catesubCategorygory->show_home == 'yes') selected @endif>YES</option>
                    <option value="no" @if (isset($subCategory->show_home) && $subCategory->show_home == 'no') selected @endif>NO</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="customRadio1">Status</label>
                  <div class="radio-group">
        <label>
            <input type="radio" class="custom-radio" value="1" @if(isset($subCategory) && $subCategory->status == 1) 
                    checked 
                    @endif id="statusActive" name="status"/>
            Active
        </label>
        <label>
            <input type="radio" class="custom-radio" value="0" @if(isset($subCategory) && $subCategory->status == 0) 
                    checked 
                    @endif id="statusInactive" name="status"/>
            Inactive
        </label>
    </div>
                    </div>
    </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" class="btn btn-primary SavesubCategory" style= "margin-bottom: 6px; margin-right: 8px;">Submit</button>
                  <a href="{{route('admin.subCategory.list')}}" class=""btn btn-primary Back">Back</a>
                </div>
              </form>
            </div>
            <!-- /.card -->
            <!-- /.card -->

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
     <style>
.custom-radio {
    width: 1rem;
    height: 1.25rem;
    opacity: 0.46; /* Corrected opacity */
    margin-right: 0.5rem; /* Space between radio button and text */
    vertical-align: middle; /* Aligns the radio button vertically with the text */
}

.radio-group {
    display: flex;
    flex-direction: column; /* Aligns radio buttons and labels vertically */
}

.radio-group label {
    display: flex;
    align-items: center; /* Aligns items within the label vertically */
    margin-bottom: 0.5rem; /* Space between the radio button options */
    font-weight: 500 !important;
}
.Back{
  color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    box-shadow: none;
    border: 1px solid transparent;
    /* padding: 0.375rem 0.75rem; */
    border-radius: 5px;
    margin-top: 13px;
    padding: 9px 9px 7px 6px;
}
     </style>
     <script>
      $(function() {
      $(".SavesubCategory").on("click", function(e) {
        console.log(11);
    e.preventDefault(); // Prevent the default form submission
    let errorWrapper = $('.errorWrapper').slideUp().empty();
    console.log("Save category button clicked!");
    // Create a FormData object from the form
    var editId ={{isset($subCategory) ? $subCategory->id : 'null'}}
    let formData = new FormData($('#subCategoryForm')[0]);
    $('.error-message').remove();
        $('.form-control').removeClass('is-invalid');
    $.ajax({
        url: '{{ route('admin.subCategory.save') }}',
        type: 'POST',
        data: formData,
        contentType: false, // Do not set any content type header
        processData: false, // Prevent jQuery from converting the data into a query string
        success: function() {
          
          if(editId != null){
            toastr.success("Sub Category Updated Successfully");
          }else
            toastr.success("Sub Category Created Successfully");
            setTimeout(function() {
                window.location.href = '/admin/subCategory';
            }, 1000);
        },
        error: function (jqXHR, textStatus, errorThrown) {
          
          let errors = jqXHR.responseJSON.errors;
                      
                      $.each(errors, function (field, messages) {
                let inputField = $('#' + field);
                inputField.addClass('is-invalid');
                inputField.after('<span class="text-danger error-message">' + messages[0] + '</span>');
            });
        }
    });
});
      });

</script>
@endsection