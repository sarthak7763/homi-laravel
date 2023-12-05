// Route::get('/dealer/delete-propertiesData','PropertyController@ajaxdelete')->name('buyer.delete-propertyGallery');


<button class="deleteProduct" id="delete_property_gallery"  data-id= "{{$gallery['id']}}" data-property= "{{$gallery['property_id']}}" class ="btn-btn-delete delete_image" >Delete Image</button> -->




// using ajax

    // public function ajaxdelete(Request $request)
    // {
    // echo 226;
    //   die;
    //     $data = $request->all();

    //     $deleted_gallery  = PropertyGallery::where('property_id',$data['id'])->where('id',$data['gallery_id'])->where('status',1)->delete();
      
    
    //   return response()->json([
    //     'success' => 'Record has been deleted successfully!'
    // ]);



    <script>
        $(document).ready(function(){
          
          $("#delete_property_gallery").on("click", function() {
                  var gallery_id = $(this).attr('data-id');
      
                  var propery_id = $(this).attr('data-property');
              
                  
                  $.ajax({
                            url: "{{route('buyer.delete-propertyGallery')}}",
                            type: 'get',
                            dataType: "JSON",
                            data: {
                                "id": propery_id,
                                "gallery_id": gallery_id,
                              },
                            success: function ()
                            {
                              console.log('it works');
                            }
                  });
                            console.log("It failed");
              });
        }); 
      
      </script>
      
