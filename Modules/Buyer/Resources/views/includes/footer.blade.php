<footer>
  <div class="copyright-section text-center">
    <div class="container">
      <p>© 2023 - Homi. All rights reserved</p>          
    </div>
  </div>
</footer>
<!--Jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
<!-- Owl Carousel -->
<script src="js/owl.carousel.min.js"></script>
<!-- custom JS code after importing jquery and owl -->

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


$('#property_type').on('change',function(){
    var property_type=$(this).val();
    var optionhtml='<option value="">Select price type</option>';
    if(property_type==2)
    {
      optionhtml+='<option value="1">PerSq.Ft</option><option value="2">Fixed </option><option value="3">Persq.yard</option>';
    }
    else{
      optionhtml+='<option value="4">Per night</option>';
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


</body>
</html> 