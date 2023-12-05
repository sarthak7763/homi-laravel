@extends('buyer::auth.auth_layout.authmaster')
@section('title',"Homi Forgot Password")
@section('content')
<div class="row">
<div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
<form action="{{route('buyer-forget-password-post')}}" method = "Post">
    @csrf
<section class="signup-section pt-4 pb-4">
   <div class="container h-100">
    <div class="row align-items-center justify-content-center h-100">  
      <div class="col-12">  
        <form class="signup-form p-5">
          <h1>Welcome!</h1>
          <strong>Signup your account</strong>
          <div class="mb-4">            
            <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Email ID">            
          </div> 
          <button type="submit" class="btn btn-primary">Send Link</button>
      
        </form>
      </div>
    </div>
  </div>
</section>
</form>
</div>
@endsection
