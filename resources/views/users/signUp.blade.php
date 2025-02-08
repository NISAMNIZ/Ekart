<section class="h-100 bg-dark" style="height: min-content !important;">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
<form action="{{route('user.doSignUp')}}" method="POST" id="SignUpForm">
                @csrf
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card card-registration my-4">
          <div class="row g-0">
            <div class="col-xl-6 d-none d-xl-block">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/img4.webp"
                alt="Sample photo" class="img-fluid"
                style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;max-width: 107%;height: 100%;" />
            </div>
            <div class="col-xl-6">
              <div class="card-body p-md-5 text-black">
                <h3 class="mb-5 text-uppercase">registration form</h3>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                      <input type="text" id="firstname" class="form-control form-control-lg" name="firstname" />
                      <label class="form-label" for="form3Example1m">First name</label>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                      <input type="text" id="lastname" class="form-control form-control-lg" name="lastname" />
                      <label class="form-label" for="form3Example1n">Last name</label>
                    </div>
                  </div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" id="email" class="form-control form-control-lg" name="email" />
                  <label class="form-label" for="form3Example97">Email ID</label>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                      <input type="possword" id="password" class="form-control form-control-lg" name="password" />
                      <label class="form-label" for="form3Example1m1">Password</label>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                      <input type="password" id="confirm_password" class="form-control form-control-lg" name="confirm_password"/>
                      <label class="form-label" for="form3Example1n1">Confirm Password</label>
                    </div>
                  </div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" id="address" class="form-control form-control-lg" name="address"/>
                  <label class="form-label" for="form3Example8">Address</label>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                      <input type="text" id="state" class="form-control form-control-lg" name="state" />
                      <label class="form-label" for="form3Example1m">State</label>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                      <input type="text" id="city" class="form-control form-control-lg" name="city" />
                      <label class="form-label" for="form3Example1n">City</label>
                    </div>
                  </div>
                </div>

                <div class="d-md-flex justify-content-start align-items-center mb-4 py-2">

                  <h6 class="mb-0 me-4">Gender: </h6>

                  <div class="form-check form-check-inline mb-0 me-4" style="margin-left: 20px;">
                    <input class="form-check-input" type="radio" name="gender" id="gender"
                      value="female" />
                    <label class="form-check-label" for="femaleGender">Female</label>
                  </div>

                  <div class="form-check form-check-inline mb-0 me-4">
                    <input class="form-check-input" type="radio" name="gender" id="gender"
                      value="male" />
                    <label class="form-check-label" for="maleGender">Male</label>
                  </div>

                </div>

                

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="date" id="dob" name="dob" class="form-control form-control-lg" />
                  <label class="form-label" for="form3Example9">DOB</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" id="pincode" class="form-control form-control-lg" name="pincode"/>
                  <label class="form-label" for="form3Example90">Pincode</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="number" id="phone" class="form-control form-control-lg" name="phone" />
                  <label class="form-label" for="form3Example99">Phone Number</label>
                </div>

                <div class="d-flex justify-content-end pt-3">
                  <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-light btn-lg">Reset</button>
                  <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2 RegisterUser">Sign Up</button>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<style>
    .card-registration .select-input.form-control[readonly]:not([disabled]) {
font-size: 1rem;
line-height: 2.15;
padding-left: .75em;
padding-right: .75em;
}
.card-registration .select-arrow {
top: 13px;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
      $(function() {
        $(".RegisterUser").on("click",function (e) {
            e.preventDefault();
            $('.error-message').remove();
        $('.form-control').removeClass('is-invalid');
          $.post('{{ route('user.doSignUp') }}', $('#SignUpForm').serialize(), function () {
                      toastr.success("User Registered Successfully");
                      setTimeout(function() {
                        window.location.href = '/user/login';
                  }, 1000);
                  }).fail(function (response) {
                      let errors = response.responseJSON.errors;
                      
                      $.each(errors, function (field, messages) {
                let inputField = $('#' + field);
                inputField.addClass('is-invalid');
                inputField.after('<span class="text-danger error-message">' + messages[0] + '</span>');
            });

            toastr.error("Please fix the errors and try again.");
                  })
      }); 
    }); 
      </script>