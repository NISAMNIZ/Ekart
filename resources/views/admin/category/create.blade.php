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
              <form action="{{route('admin.category.save')}}" method="POST" id="categoryForm" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="hidden" name="category_id" value="{{isset($category) ? $category->id : ''}}">
                    <input type="text" class="form-control" id="name" name="name" value="{{isset($category) ? $category->name : ''}}" placeholder="Enter category Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{isset($category->slug) ? $category->slug : ''}}" placeholder="Enter category slug ">
                  </div>
                  <div class="form-group">
                  <label for="exampleSelectRounded0">Show Home</label>
                  <select class="custom-select rounded-0" name="show_home" id="show_home">
                    <option value="yes" @if (isset($category->show_home) && $category->show_home == 'yes') selected @endif>YES</option>
                    <option value="no" @if (isset($category->show_home) && $category->show_home == 'no') selected @endif>NO</option>
                  </select>
                </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image" id="image">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                    @if (isset($category) && $category->image)
                    <img src="{{asset("storage/images/".$category->image)}}"style="width:100px">
                    @endif
                  </div>
                  <div class="col-md-6" style="display:none">
                      <div class="mb-3">
                      <label for="image">Attachment</label>
                      <!-- <input type="hidden" id="image_id" name="image_id" value=""> -->
                      <div id="attachment" class="dropzone dz-clickable">
                      <div class="dz-message needsclick">
                      <br>Drop files here or click to upload. <br><br>
                      </div>
                      </div>
                      </div>
                      </div>
                      <div class="form-group">
            <label for="dropzone">Attach Files</label>
            <input type="hidden" id="image_id" name="image_id" value="">
            <div class="dropzone" id="fileDropzone"></div>
            <!-- Existing File Display -->
        </div>
    </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" class="btn btn-primary Savecategory" style= "margin-bottom: 6px; margin-right: 8px;">Submit</button>
                  <a href="{{route('admin.category.list')}}" class=""btn btn-primary Back">Back</a>
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
      $(".Savecategory").on("click", function(e) {
    e.preventDefault(); // Prevent the default form submission
    let errorWrapper = $('.errorWrapper').slideUp().empty();
    console.log("Save category button clicked!");
    // Create a FormData object from the form
    var editId ={{isset($category) ? $category->id : 'null'}}
    let formData = new FormData($('#categoryForm')[0]);
    $('.error-message').remove();
        $('.form-control').removeClass('is-invalid');
    $.ajax({
        url: '{{ route('admin.category.save') }}',
        type: 'POST',
        data: formData,
        contentType: false, // Do not set any content type header
        processData: false, // Prevent jQuery from converting the data into a query string
        success: function() {
          
          if(editId != null){
            toastr.success("category Updated Successfully");
          }else
            toastr.success("category Created Successfully");
            setTimeout(function() {
                window.location.href = '/admin/category';
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
// Dropzone.autoDiscover = false;
// const dropzone = $("#attachment").dropzone({
// init: function() {
// this.on('addedfile', function(file) {
// if (this.files.length >1) 
// this.removeFile(this. files[0]);
// });
// },
// url: "{{ route('admin.attachment.create') }}",
// maxFiles: 1,
// paramName: 'image',
// addRemoveLinks: true,
// acceptedFiles: "image/jpeg,image/png,image/gif",
// headers: {
// 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
// }, success: function(file, response) {
// $("#image_id").val(response.image_id);
// //console.log(response)
// }
// });

Dropzone.autoDiscover = false; // Disable automatic discovery for all Dropzones

var fileDropzone = new Dropzone("#fileDropzone", {
    url: "{{ route('admin.attachment.create') }}",  // URL to handle file uploads
    maxFiles: 1,                                  // Maximum number of files
    maxFilesize: 5,                               // Maximum file size in MB
    acceptedFiles: null,                          // Accept all file types
    addRemoveLinks: true, 
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },                       
    init: function() {
        this.on("success", function(file, response) {
          console.log(response);
          
            // Assuming the response contains the uploaded file info
            // let hiddenInput = `<input type="hidden" name="uploadedFiles[]" value="${response.fileName}">`;
            // document.getElementById('categoryForm').insertAdjacentHTML('beforeend', hiddenInput);
             $("#image_id").val(response.image_id);
        });

        this.on("removedfile", function(file) {
            // Handle file removal (if needed)
        });
    }
});
});
</script>
@endsection