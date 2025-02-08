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
              <form action="{{route('admin.brand.save')}}" method="POST" id="brandForm" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="hidden" name="sub_category_id" value="{{isset($brand) ? $brand->id : ''}}">
                    <input type="text" class="form-control" id="name" name="name" value="{{isset($brand) ? $brand->name : ''}}" placeholder="Enter sub Category Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{isset($brand->slug) ? $brand->slug : ''}}" placeholder="Enter sub Category slug ">
                  </div>
                <div class="form-group">
                  <label for="customRadio1">Status</label>
                  <div class="radio-group">
        <label>
            <input type="radio" class="custom-radio" value="1" @if(isset($brand) && $brand->status == 1) 
                    checked 
                    @endif id="statusActive" name="status"/>
            Active
        </label>
        <label>
            <input type="radio" class="custom-radio" value="0" @if(isset($brand) && $brand->status == 0) 
                    checked 
                    @endif id="statusInactive" name="status"/>
            Inactive
        </label>
    </div>
                    </div>
    </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" class="btn btn-primary Savebrand" style= "margin-bottom: 6px; margin-right: 8px;">Submit</button>
                  <a href="{{route('admin.brand.list')}}" class=""btn btn-primary Back">Back</a>
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
      $(".Savebrand").on("click", function(e) {
        console.log(11);
    e.preventDefault(); // Prevent the default form submission
    let errorWrapper = $('.errorWrapper').slideUp().empty();
    console.log("Save category button clicked!");
    // Create a FormData object from the form
    var editId ={{isset($brand) ? $brand->id : 'null'}}
    let formData = new FormData($('#brandForm')[0]);
    $('.error-message').remove();
        $('.form-control').removeClass('is-invalid');
    $.ajax({
        url: '{{ route('admin.brand.save') }}',
        type: 'POST',
        data: formData,
        contentType: false, // Do not set any content type header
        processData: false, // Prevent jQuery from converting the data into a query string
        success: function() {
          
          if(editId != null){
            toastr.success("Brand Updated Successfully");
          }else
            toastr.success("Brand Created Successfully");
            setTimeout(function() {
                window.location.href = '/admin/brand';
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