@extends('buyer::layouts.master')
@section('content')
  <div class="col-md-12 col-lg-9">
    <div class="profile-box">          
      <div class="profile-box-form">
        <h1 class="mb-3"> All Subscription Plans</h1>

        <div>
                    @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>
        <section class="section-subscription">
          <div class="row ">
          @foreach($subscription_plan as $subscription)
           
            <div class="col-12 col-md-4 mt-4 mt-md-0">
            <form class="mx-auto mx-md-0" action ="{{route('buyer.subscription-confirmation',($subscription->id))}}" method = "Post">
             @csrf   
               <div class="subscription-box">
                <div class="subscription-box-inner">
                <div class="subscription-header">
                  <h2>{{$subscription->name}}</h2>
                  <strong>{{$subscription->plan_price}}<span>/ {{$subscription->plan_duration}}</span></strong>
                  <p>{{$subscription->plan_title}}</p>                
                </div>
                <ul>
                  <li>
                    Lorem Ipsum is simply dummy text the know printing and industry
                  </li>
                  <li>
                    Lorem Ipsum is simply dummy text the know printing and industry
                  </li>
                  <li>
                    Lorem Ipsum is simply dummy text the know printing and industry
                  </li>
                  <li>
                    Lorem Ipsum is simply dummy text the know printing and industry
                  </li>
                  <li>
                    Lorem Ipsum is simply dummy text the know printing and industry
                  </li>
                </ul>
              
                @if($user_subscription_plan_id!=$subscription->id)
                <!-- <button button type ="submit" class="btn-2 btn-primary">Purchase Plan</button> -->
                <a href="{{route('seller.subscription-details',$subscription->id)}}" class="btn-2 btn-primary">Purchase Plan</a>
                @endif
              </div>
                   
                   {!! $subscription->image !!}             
               </div>
               
               </form>

            </div>
          
            @endforeach
    `       </div>
   
        </section>
       
      </div>
    </div>
  </div>
</div>
</div>
</div>
@endsection