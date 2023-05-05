@php $pic=getProfilePic(); @endphp
<div class="profileBox mt-4 pt-2">
  <div class="container">
      <div class="row rowmailing">
          <div class="col-md-12 text-right">
              <span class="callDiv"><img src="{{asset('assets_front/images/icons/call.svg')}}" />  {{ @$buyerInfo->mobile_no ? getMobileFormat($buyerInfo->mobile_no) : "" }}</span>
              <span class="mailtoDiv"><img src="{{asset('assets_front/images/icons/envelop.svg')}}" /> {{ @$buyerInfo->email ? $buyerInfo->email : "" }}</span>
          </div>
      </div>
      <div class="row">
          <div class="col-md-12">
              <div class="proBox">
                  <img class="userBox rounded-circle" src="{{@$pic}}" width="130px"/>
                  <h2>{{ @$buyerInfo->name ? $buyerInfo->name : "" }}</h2>
                  <h3><span class="bg_primary">Profile</span> <span class="float-right btnEdit">
                  <a href="{{route('buyer-profile')}}" class="editProfile">Edit Profile</a></span></h3>
              </div>
          </div>
      </div>
  </div>
</div>