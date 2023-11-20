@extends('buyer::layouts.master')
@section('content')


<div class="col-md-9">
  <div class="profile-box">          
    <div class="profile-box-form">
      <div class="row align-items-center mb-3">
        <div class="col">
          <h1 class="mb-0">Total Bookings</h1>
        </div>

        <div class="col-auto">
        <form action = "{{route('buyer.property-search')}}" >
      <div class="search-input-group">
          <div class="form-outline">
              <input type="text" id="form1" class="form-control" name = "title_search" placeholder="Search data" />
            </div>
            <button type="submit" class="btn-search" >
              Search
            </button>
          </div>
          </form>
        </div>

      </div>
</div>

<div>
<a href="{{route('buyer.add-property')}}" class="btn btn-info" button type="submit">Add Property</a>
</div> 

      <div class="manage-total-bookings">
        <ul class="manage-list">
          @foreach($propertyData as $property)
        
        <li class="manage-item">
            <div class="row">
              <div class="col colbox-img">
                <div class="manage-list-img">
                @if($property->property_image)
                <img src="{{url('/')}}/images/property/thumbnail/{{$property->property_image}}">
                  @else
                  <img src="{{url('/')}}/assets_front/images/rent-image-01.jpg">
                  @endif
                </div>
              </div>
              <div class="col">
                <div class="manage-list-text">
                  <h2>
                    <a href="#">{{$property->title}}</a>
                  </h2>
                  <p><svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.7141 11.8808C11.9335 12.6613 10.3013 14.2934 9.17818 15.4166C8.52726 16.0675 7.47309 16.0678 6.82218 15.4169C5.71863 14.3133 4.118 12.7128 3.28597 11.8808C0.682468 9.27725 0.682468 5.05612 3.28597 2.45262C5.88946 -0.150875 10.1106 -0.150875 12.7141 2.45262C15.3175 5.05612 15.3175 9.27725 12.7141 11.8808Z" stroke="#828282" stroke-linecap="round" stroke-linejoin="round"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 7.1665C10.5 8.54725 9.38075 9.6665 8 9.6665C6.61925 9.6665 5.5 8.54725 5.5 7.1665C5.5 5.7858 6.61925 4.6665 8 4.6665C9.38075 4.6665 10.5 5.7858 10.5 7.1665Z" stroke="#828282" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                135 Taylor Road Nigeria    |    Flat    |    Listed on:  April 12 2023</p>
                <p>Owner: Albert Flores    |    Featured: No</p>

                <div class="manage-btn-group">
                  <a href="{{route('buyer.view-property',($property->id))}}" class="btn btn-view">View</a>
                  <a href="{{route('buyer.edit-property',($property->id))}}" class="btn btn-edit">Edit</a>
                  <a href="#" class="btn btn-delete">Delete</a>
                </div>
                
            </div>
            
          </div>
        </li>
        @endforeach

        </ul>
      </div> 
      
      {{$propertyData->links() }}
      


  </div>
  </div>
</div>
</div>
</div>
</div>
@endsection

