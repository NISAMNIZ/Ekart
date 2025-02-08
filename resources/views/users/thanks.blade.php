@extends ('users.app')
@section('content')
<section class="container">
<div class="col-md-12 text-center py-5"> I
@if (Session::has('success'))
<div class="alert alert-success">
{{Session::get('success') }}
</div>
@endif
<h1>Thank You!</h1>
<p style="color: black">Your Order will be delivered shortly </p>
</div>
</section>
@endsection
