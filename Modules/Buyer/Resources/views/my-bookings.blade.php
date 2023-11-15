
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
          <div class="search-input-group">
          <div class="form-outline">
          <input type="search" id="form1" class="form-control" placeholder="Search data" />
          </div>
          <button type="button" class="btn-search">
          Search
          </button>
</div>
        </div>
      </div>      
      <div class="total-bookings">
        <table class="table mb-0">
          <thead>
            <tr>
              <th class="bookings-image-th" scope="col">Image</th>
              <th scope="col">Name</th>
              <th class="text-center" scope="col">Booking ID</th>
              <th class="text-center" scope="col">Check in</th>
              <th class="text-center" scope="col">Check out</th>
              <th class="text-center" scope="col">Price</th>
              <th class="bookings-status text-end" scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="bookings-image-td">
                <a href="#" tabindex="-1" class="product-item-photo">
                  <span class="bookings-image">                    
                    <img class="product-image-photo" src="images/bookings-image-01.jpg">
                  </span>
                </a>
              </td>
              <td>
                 <a href="#" tabindex="-1" class="bookings-product-name">
                  Luxury family house
                 </a>              
            </td>
               <td class="text-center">#102415899</td>
              <td class="text-center">10 April 2023</td>
              <td class="text-center">15 April 2023</td>
              <td class="text-center">156kz</td>
              <td class="text-end"><span class="text-warning">Ongoing</span></td>              
            </tr>
               <tr>
              <td class="bookings-image-td">
                <a href="#" tabindex="-1" class="product-item-photo">
                  <span class="bookings-image">
                     <img class="product-image-photo" src="images/bookings-image-02.jpg">
                  </span>
                </a>
              </td>
              <td>
                 <a href="#" tabindex="-1" class="bookings-product-name">
                  Luxury family house
                 </a>              
            </td>
              <td class="text-center">#102415899</td>
              <td class="text-center">10 April 2023</td>
              <td class="text-center">15 April 2023</td>
              <td class="text-center">156kz</td>
              <td class="text-end"><span class="text-success">Completed</span></td>              
            </tr>
               <tr>
             <td class="bookings-image-td">
                <a href="#" tabindex="-1" class="product-item-photo">
                  <span class="bookings-image">
                    <img class="product-image-photo" src="images/bookings-image-03.jpg" loading="lazy" >
                  </span>
                </a>
              </td>
              <td>
                 <a href="#" tabindex="-1" class="bookings-product-name">
                  Luxury family house
                 </a>              
            </td>
              <td class="text-center">#102415899</td>
              <td class="text-center">10 April 2023</td>
              <td class="text-center">15 April 2023</td>
              <td class="text-center">156kz</td>
              <td class="text-end"><span class="text-danger">Cancelled</span></td>                
            </tr>
          
                      <tr>
              <td class="bookings-image-td">
                <a href="#" tabindex="-1" class="product-item-photo">
                  <span class="bookings-image">                    
                    <img class="product-image-photo" src="images/bookings-image-01.jpg">
                  </span>
                </a>
              </td>
              <td>
                 <a href="#" tabindex="-1" class="bookings-product-name">
                  Luxury family house
                 </a>              
            </td>
               <td class="text-center">#102415899</td>
              <td class="text-center">10 April 2023</td>
              <td class="text-center">15 April 2023</td>
              <td class="text-center">156kz</td>
              <td class="text-end"><span class="text-warning">Ongoing</span></td>              
            </tr>
               <tr>
              <td class="bookings-image-td">
                <a href="#" tabindex="-1" class="product-item-photo">
                  <span class="bookings-image">
                     <img class="product-image-photo" src="images/bookings-image-02.jpg">
                  </span>
                </a>
              </td>
              <td>
                 <a href="#" tabindex="-1" class="bookings-product-name">
                  Luxury family house
                 </a>              
            </td>
              <td class="text-center">#102415899</td>
              <td class="text-center">10 April 2023</td>
              <td class="text-center">15 April 2023</td>
              <td class="text-center">156kz</td>
              <td class="text-end"><span class="text-success">Completed</span></td>              
            </tr>
               <tr>
             <td class="bookings-image-td">
                <a href="#" tabindex="-1" class="product-item-photo">
                  <span class="bookings-image">
                    <img class="product-image-photo" src="images/bookings-image-03.jpg" loading="lazy" >
                  </span>
                </a>
              </td>
              <td>
                 <a href="#" tabindex="-1" class="bookings-product-name">
                  Luxury family house
                 </a>              
            </td>
              <td class="text-center">#102415899</td>
              <td class="text-center">10 April 2023</td>
              <td class="text-center">15 April 2023</td>
              <td class="text-center">156kz</td>
              <td class="text-end"><span class="text-danger">Cancelled</span></td>                
            </tr>
                        <tr>
              <td class="bookings-image-td">
                <a href="#" tabindex="-1" class="product-item-photo">
                  <span class="bookings-image">                    
                    <img class="product-image-photo" src="images/bookings-image-01.jpg">
                  </span>
                </a>
              </td>
              <td>
                 <a href="#" tabindex="-1" class="bookings-product-name">
                  Luxury family house
                 </a>              
            </td>
               <td class="text-center">#102415899</td>
              <td class="text-center">10 April 2023</td>
              <td class="text-center">15 April 2023</td>
              <td class="text-center">156kz</td>
              <td class="text-end"><span class="text-warning">Ongoing</span></td>              
            </tr>
               <tr>
              <td class="bookings-image-td">
                <a href="#" tabindex="-1" class="product-item-photo">
                  <span class="bookings-image">
                     <img class="product-image-photo" src="images/bookings-image-02.jpg">
                  </span>
                </a>
              </td>
              <td>
                 <a href="#" tabindex="-1" class="bookings-product-name">
                  Luxury family house
                 </a>              
            </td>
              <td class="text-center">#102415899</td>
              <td class="text-center">10 April 2023</td>
              <td class="text-center">15 April 2023</td>
              <td class="text-center">156kz</td>
              <td class="text-end"><span class="text-success">Completed</span></td>              
            </tr>
    
              
          </tbody>
        </table>
      </div> 
<div class="mt-4 mb-4  text-end pe-4">
  <nav class="d-inline-block" aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Previous">
        <span aria-hidden="true"><svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M6 10.6668L1.33333 6.00016L6 1.3335" stroke="#2F80ED" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</span>
      </a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">4</a></li>
    <li class="page-item"><a class="page-link" href="#">5</a></li>
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Next">
        <span aria-hidden="true"><svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1 1.33317L5.66667 5.99984L1 10.6665" stroke="#2F80ED" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</span>
      </a>
    </li>
  </ul>
</nav>
</div>

    </div>
  </div>
</div>
</div>
</div>
</div>
</main>

<!-- Modal -->
<div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-header">
      <button type="button" class="close rounded-circle" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <form class="form-change-password">     
        <div class="mb-4">            
          <input type="password" class="form-control" id="" placeholder="Old Password">            
        </div>
        <div class="mb-4">
          <input type="password" class="form-control" id="" placeholder="New Password">
        </div>
        <div class="mb-4">
          <input type="password" class="form-control" id="" placeholder="Confirm Password">       
        </div>     
        <button type="submit" class="btn btn-secondary">Update</button>      
      </form>
    </div>
  </div>
</div>
</div>

@endsection


