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
              <div class="card-header">Add Product
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('admin.product.save')}}" method="POST" id="ProductForm" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="hidden" name="product_id" value="{{isset($product) ? $product->id : ''}}">
                    <input type="text" class="form-control" id="name" name="name" value="{{isset($product) ? $product->name : ''}}" placeholder="Enter Product Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Price</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{isset($product) ? $product->price : ''}}" placeholder="Enter Product Price">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Compare price</label>
                    <input type="number" class="form-control" id="compare_price" name="compare_price" value="{{isset($product) ? $product->compare_price : ''}}" placeholder="Enter Product Compare Price">
                  </div>
                  <div class="form-group">
                  <label for="exampleSelectRounded0">Category <code></code></label>
                  <select class="custom-select rounded-0" name="category_id" id="category_id">
                    <option value="">Please Select a Category</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}"
                    @if(isset($product) && $product->category_id == $category->id) 
                    selected 
                    @endif>{{$category->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
    <label for="sub_category_id">SubCategory <code></code></label>
    <select class="custom-select rounded-0" name="sub_category_id" id="sub_category_id">
        <option value="">Please Select a Sub Category</option>
        @isset($subCategories)
            @foreach($subCategories as $subCategory)
                <option 
                    value="{{ $subCategory->id }}" 
                    @if(isset($product) && $product->sub_category_id == $subCategory->id) selected @endif>
                    {{ $subCategory->name }}
                </option>
            @endforeach
        @endisset
    </select>
</div>
                <div class="form-group">
                  <label for="exampleSelectRounded0">Brand <code></code></label>
                  <select class="custom-select rounded-0" name="brand_id" id="brand_id">
                    <option value="">Please Select a Brand</option>
                    @foreach($brands as $brand)
                    <option value="{{$brand->id}}"
                    @if(isset($product) && $product->brand_id == $brand->id) 
                    selected 
                    @endif>{{$brand->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <input type="textarea" class="form-control" id="description" name="description" value="{{isset($product) ? $product->description : ''}}"  placeholder="Enter Product Description">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Short Description</label>
                    <input type="textarea" class="form-control" id="short_description" name="short_description" value="{{isset($product->short_description) ? $product->short_description : ''}}"  placeholder="Enter Product short Description">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Shipping & Returns</label>
                    <input type="textarea" class="form-control" id="shipping_returns" name="shipping_returns" value="{{isset($product->shipping_returns) ? $product->shipping_returns : ''}}"  placeholder="Enter Shipping & Returns">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Store keeping  unit</label>
                    <input type="text" class="form-control" id="sku" name="sku" value="{{isset($product) ? $product->sku : ''}}" placeholder="Enter Product Store keeping  unit">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Bar Code</label>
                    <input type="text" class="form-control" id="bar_code" name="bar_code" value="{{isset($product) ? $product->bar_code : ''}}" placeholder="Enter Product Bar Code">
                  </div>
                  <!-- <div class="form-group">
                    <label for="exampleInputPassword1">Track Quantity</label>
                    <input type="hidden" class="form-control" id="track_qty" name="track_qty" value="{{isset($product) ? $product->track_qty : 'Yes'}}" placeholder="Enter Product Bar Code">
                    <input type="checkbox" class="form-control" id="track_qty" name="track_qty" value="{{isset($product) ? $product->track_qty : 'Yes'}}" placeholder="Enter Product Track Quantity">
                  </div> -->
                  <div class="form-group">
                    <label for="exampleInputPassword1">Quantity</label>
                    <input type="text" class="form-control" id="quantity" name="quantity" value="{{isset($product) ? $product->quantity : ''}}" placeholder="Enter Product Quantity">
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
                    @if (isset($product) && $product->image)
                    <img src="{{asset("storage/images/".$product->image)}}"style="width:100px">
                    @endif
                  </div>
                  <div class="form-group">
                  <label for="customRadio1">Status</label>
                  <div class="radio-group">
        <label>
            <input type="radio" class="custom-radio" value="1" @if(isset($product) && $product->status == 1) 
                    checked 
                    @endif id="statusActive" name="status"/>
            Active
        </label>
        <label>
            <input type="radio" class="custom-radio" value="0" @if(isset($product) && $product->status == 0) 
                    checked 
                    @endif id="statusInactive" name="status"/>
            Inactive
        </label>
    </div>
                    </div>

                    <div class="form-group">
                  <label for="customRadio1">Favorite</label>
                  <div class="radio-group">
                  <label>
                          <input type="radio" class="custom-radio" value="1" id="is_favorite" @if(isset($product) && $product->is_favorite == 1) 
                    checked 
                    @endif name="is_favorite"/>Yes
                          </label>
                          <label>
                          <input type="radio" class="custom-radio" value="0" id="is_favorite" @if(isset($product) && $product->is_favorite == 0) 
                    checked 
                    @endif name="is_favorite"/>No
                          </label>
                          </div>
                        </div>
                        <div class="form-group">
                  <label for="exampleSelectRounded0">Related Products</label>
                  <select multiple class="custom-select related_products rounded-0" name="related_products[]" id="related_products">
                    <!-- <option value="">Please Select a Related Products</option> -->
                     @if(!empty($relatedProducts))
                     @foreach($relatedProducts as $relproduct)
                    <option selected value="{{$relproduct->id}}">{{$relproduct->name}}</option>
                     @endforeach
                     @endif
                  
                  </select>
                </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" class="btn btn-primary SaveProduct" style= "margin-bottom: 6px; margin-right: 8px;">Submit</button>
                  <a href="{{route('admin.product.list')}}" class=""btn btn-primary Back">Back</a>
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
.select2-container--default .select2-selection--multiple .select2-selection__rendered li{
  color:#000;
}
     </style>
     <script>
      // $('#related_products').select2();
      $('.related_products').select2({
    ajax: {
        url: '{{ route('admin.product.getProducts') }}',
        dataType: 'json',
        tags: true,
        multiple: true,
        minimumInputLength: 3,
        processResults: function (data) {
            return {
                results: data.tags
            };
        }
    }
});
      $(function() {
      //   $(".SaveProduct").on("click",function (e) {
      //       console.log(111);
      //       e.preventDefault();
      //     let errorWrapper = $('.errorWrapper').slideUp().empty();
      //     $.post('{{ route('admin.product.save') }}', $('#ProductForm').serialize(), function () {
      //                 toastr.success("Product Created Successfully");
      //                 setTimeout(function() {
      //                   window.location.href = '/admin/product';
      //             }, 1000);
      //             }).fail(function (response) {
      //                 let errors = response.responseJSON;

      //                 for (let key in errors)
      //                     errorWrapper.append('<div class="error">' + errors[key] + '</div>');

      //                 errorWrapper.slideDown();
      //             })
      // }); 

      $('#category_id').on("change",function () {
        var category_id = $(this).val();
       $.get('{{route('admin.product.fetchSubCategory')}}',{category_id: category_id},function (response) {
        console.log(response['subCategories']);
        $('#sub_category_id').find("option").not(":first").remove();
        $.each(response['subCategories'],function(key,item){
          $('#sub_category_id').append(`<option value='${item.id}'>${item.name}</option>`);
        });
        
       });
        
      });
      $(".SaveProduct").on("click", function(e) {
    e.preventDefault(); // Prevent the default form submission
    let errorWrapper = $('.errorWrapper').slideUp().empty();

    // Create a FormData object from the form
    var editId ={{isset($product) ? $product->id : 'null'}}
    let formData = new FormData($('#ProductForm')[0]);
    $('.error-message').remove();
        $('.form-control').removeClass('is-invalid');

    $.ajax({
        url: '{{ route('admin.product.save') }}',
        type: 'POST',
        data: formData,
        contentType: false, // Do not set any content type header
        processData: false, // Prevent jQuery from converting the data into a query string
        success: function() {
          if(editId != null){
            toastr.success("Product Updated Successfully");
          }else
            toastr.success("Product Created Successfully");
            setTimeout(function() {
                window.location.href = '/admin/product';
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