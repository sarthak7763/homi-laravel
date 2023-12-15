@extends('buyer::auth.auth_layout.authmaster')
@section('title',"Homi Forget Password")

@section('content')

<div class="row">
<div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div>
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <section class="signup-section pt-4 pb-4">
        <div class="container h-100">
            <div class="row align-items-center justify-content-center h-100">
                <div class="col-12">
                    <form name="loginForm" id="loginAction" action="{{route('buyer-forget-password-post')}}" method="POST" class="signup-form p-5">
                      @csrf
                        <h1>Welcome!</h1>
                        <strong>Signin your account</strong>
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Email ID"  style="display:block;"> 
                                @if($errors->has('email'))
                        <div class="invalid-feedback">
                           {{$errors->first('email')}}
                        </div>
                        @endif    
                        </div>
                        <button type="submit" class="btn btn-primary">Send Link</button>
                      </form>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
