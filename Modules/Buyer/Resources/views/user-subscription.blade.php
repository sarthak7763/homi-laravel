@extends('buyer::layouts.master')
@section('content')
  <div class="col-md-9">
    <div class="profile-box">          
      <div class="profile-box-form">
        <h1 class="mb-3">My Subscription Plan </h1>
        
        <form action ="{{route('buyer.subscription-confirmation',($subscription_plan->id))}}" method = "Post">
          @csrf
        <div class="my-plant">
          <div class="my-plant-top">
            <div class="row">
              <div class="col-auto">
                <h4 class="mb-0">{{$subscription_plan->name}}</h4>
              </div>
              <div class="col text-end">
                <strong>Will be Purchase plan 05/01/2023 and <span class="text-danger">Expired 04/03/2023</span></strong>
              </div>
            </div>
          </div>
          <div class="my-plant-contant">
            <ul class="my-plant-ul">
              
              <li>{{$subscription_plan->plan_price}}</li>
              <li>{{$subscription_plan->plan_duration}}</li>
              
</ul>
            <div class="text-end">
              <button type ="submit" class="btn btn-primary">
              Confirm
              </button>
               </div>       
          </div>
        </div> 
</form>

      </div>
    </div>
  </div>
</div>
</div>
</div>
@endsection