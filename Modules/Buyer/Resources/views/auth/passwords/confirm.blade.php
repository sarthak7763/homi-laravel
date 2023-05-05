@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}
                      @if (isset($errors) && count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    {{ $error }}
                    @endforeach
                </div>
            @endif 
            @if(session()->has('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
               <label  class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true"  style="font-size: 19px;margin-top: -1px;">&times;</span>
                </label>
                   {{ session()->get('success') }}
              </div>
            @endif
             @if(session()->has('error'))
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <label  class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true"  style="font-size: 19px;margin-top: -1px;">&times;</span>
                </label>
                   {{ session()->get('error') }}
              </div>
            @endif

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
