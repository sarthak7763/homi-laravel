<footer>
  <div class="copyright-section text-center">
    <div class="container">
      <p>© 2023 - Homi. All rights reserved</p>          
    </div>
  </div>
</footer>
<!--Jquery -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript" src="{{ asset('assets_front/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_front/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_front/js/slick.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_front/js/intlTelInput.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_front/js/script.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_front/timer/jquery.plugin.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets_front/timer/jquery.countdown.js')}}"></script>

<script type="text/javascript" src="{{url('/')}}/assets_front/js/owl.carousel.min.js"></script>

<script type="text/javascript" src="{{ asset('assets_admin/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
<!-- Select 2 js -->

<!-- ✅ load JS for Select2 ✅ -->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  ></script>

<!-- Multiselect js -->
<script type="text/javascript" src="{{ asset('assets_admin/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js')}}"></script>

<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->

<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

 <!-- custom JS code after importing jquery and owl -->

<script type="text/javascript">
        $(document).ready(function(){
          $(".delete_property_gallery").on("click", function(e) {
           e.preventDefault();
           var $this=$(this);
            var gallery_id = $(this).attr('data-id');
                  var propery_id = $(this).attr('data-property');
                  // console.log(gallery_id);
                  if (confirm("Are you sure you want to delete this property image?")) {
                    // 2nd method
                  // var display =  $(this).parent().find(".removeimage_"+gallery_id);
                  // $(".removeimage_"+gallery_id).css('display','none');
                  $.ajax({
                            url: "{{route('buyer.delete-propertyGallery')}}",
                            type: 'get',
                            dataType: "JSON",
                            data: {
                                "id": propery_id,
                                "gallery_id": gallery_id,
                              },
                            success: function (finaldata)
                            {
                              // 2nd method
                              // $(".removeimage_"+gallery_id).css('display','none');
                              $this.parent().remove();

                            }

                  });
                } 
                else {
                      return false;
                
            }
              
          });
        }); 
      
      </script>


<script>

$(".js-example-tokenizer").select2({
    tags: true,
    tokenSeparators: [',']
})


</script>
<script>

$(".js-edit-example-tokenizer").select2({
    tags: true,
    tokenSeparators: [',']
})


</script>


<script>

$(".profile-nav .item").on("click", function() {
    $(".profile-nav .item").removeClass("active");
    $(this).addClass("active");
  });

</script>

<script>
$(document).on('change','#owner_type',function(){
    var value=$(this).val();
    if(value==1)
    {
      $('#showagencydiv').show();
    }
    else{
      $('#showagencydiv').hide();
    }
});
</script>




<script>
    $(document).ready(function(){
      $(".status_change").on("click", function() {
       var property_id= $(this).attr('data-id');
       var property_status= $(this).attr('data-status');
        $('#property_hidden_id').val(property_id);
        $('#property_hidden_status').val(property_status);    
	}); 
});

 
</script>




 



<script>
    $(document).ready(function(){
      

      $(".status_change").on("click", function() {
        
       var booking_id= $(this).attr('data-id');
       
       var booking_status= $(this).attr('data-status');
       
        $('#booking_hidden_id').val(booking_id);
        $('#booking_hidden_status').val(booking_status);    
	}); 
});
 
</script>


<script>
    $(document).ready(function(){
    $(".cancel_booking").on("click", function() {
        var booking_id= $(this).attr('data-id');
        $('#cancel_booking_hidden_id').val(booking_id);

    }); 
});
 </script>



<!-- Owl Carousel -->
<script type="text/javascript">
  $('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
});
</script>




<script>
$('#property_type').on('change',function(){
    var property_type=$(this).val();
    var optionhtml='<option value="">Select price type</option>';
    if(property_type==2)
    {
      optionhtml+='<option value="1">PerSq.Ft</option><option value="2">Fixed </option><option value="3">Persq.yard</option>';
    }
    else{
      optionhtml+='<option value="4">Per Month</option>';
    }

    $('#property_price_type').html(optionhtml);

     $.ajax({
        type: "POST",
        data:{_token: "{{ csrf_token() }}",property_type:property_type}, 
        url: "{{ route('buyer.get-category') }}",
        dataType:'json',
        beforeSend: function(){
            $("#loading").show();
        },
        complete: function(){
            $("#loading").hide();
        },
        success:function(result){
            if(result.code==200) {
                $('#property_category').html(result.categoryhtml);
            }
            else {
                alert('error');
            }
        }
    });

  });
</script>



