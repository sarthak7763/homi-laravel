<script>

$(".js-example-tokenizer").select2({
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
   $(document).ready(function(){
     var property_typeonload="{{$propertyDetail->property_type}}";
     var property_price_type="{{$propertyDetail->property_price_type}}";
     var property_category="{{$propertyDetail->property_category}}";
     var optionhtmlonload='<option value="">Select price type</option>';
     if(property_typeonload==1)
     {
   
       if(property_price_type==4)
       {
         var selectoption4="selected";
       }
       else{
         var selectoption4="";
       }
   
       if(property_price_type==5)
       {
         var selectoption5="selected";
       }
       else{
         var selectoption5="";
       }
   
       if(property_price_type==6)
       {
         var selectoption6="selected";
       }
       else{
         var selectoption6="";
       }
   
       optionhtmlonload+='<option '+selectoption4+' value="4">Per night</option>';
     }
     else{
       if(property_price_type==1)
       {
         var selectoption1="selected";
       }
       else{
         var selectoption1="";
       }
   
       if(property_price_type==2)
       {
         var selectoption2="selected";
       }
       else{
         var selectoption2="";
       }
   
       if(property_price_type==3)
       {
         var selectoption3="selected";
       }
       else{
         var selectoption3="";
       }
   
       optionhtmlonload+='<option '+selectoption1+' value="1">PerSq.Ft</option><option '+selectoption2+' value="2">Fixed </option><option '+selectoption3+' value="3">Persq.yard</option>';
     }
   
     $('#property_price_type').html(optionhtmlonload);
   
     $.ajax({
           type: "POST",
           data:{_token: "{{ csrf_token() }}",property_type:property_typeonload,property_category:property_category}, 
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