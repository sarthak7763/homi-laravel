@extends('buyer::layouts.master')
@section('content')
  <div class="col-md-9">
    <div class="profile-box">          
      <div class="profile-box-form">
        <h1 class="mb-3">My Subscription Plan</h1>
        
        @foreach($subscription_plan as $subscription)
        <div class="my-plant">
          <div class="my-plant-top">
            <div class="row">
              <div class="col-auto">
                <h4 class="mb-0">{{$subscription->name}}</h4>
              </div>
              @if($user_subscription_plan->plan_id == $subscription->id )
              <div class="col text-end" style="display:block";>
                <strong>Will be Purchase plan {{$user_subscription_plan->starting_date}}  and <span class="text-danger">Expired {{$user_subscription_plan->ending_date}}</span></strong>
              </div>
              @else
              <div class="col text-end" style="display:none";>
                <strong>Will be Purchase plan 05/01/2023 and <span class="text-danger">Expired 04/03/2023</span></strong>
              </div>
              @endif
            </div>
          </div>
          <div class="my-plant-contant">
            <ul class="my-plant-ul">
              <li>{{$subscription->plan_description}}</li>
              <li>{{$subscription->plan_price}}</li>
              <li>{{$subscription->plan_duration}}</li>
              <li>{{$subscription->product_listing}}</li>
              
            </ul>
            @if($user_subscription_plan->plan_id == $subscription->id)
            <div class="text-end" style="display:none";>
              <a href="#" class="btn btn-primary">
              </a>  
               </div> 
               @else
               <div class="text-end" style="display:block";>
              <a href="{{route('buyer.user-subscription',($subscription->id))}}" class="btn btn-primary">
              Activate Paln
                </a>  
               </div> 
              @endif
          </div>
        </div> 
        @endforeach

      
      </div>
    </div>
  </div>
</div>
</div>
</div>
@endsection