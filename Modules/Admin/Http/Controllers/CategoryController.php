<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\{Request,Response};
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{Storage,File,Password};
use Illuminate\Support\Arr;
use Illuminate\Mail\Message;
use App\Helpers\Helper;
use App\Models\Category;
use Spatie\Permission\Models\{Role,Permission};
use Stichoza\GoogleTranslate\GoogleTranslate;


use Hash,Validator,Exception,DataTables,HasRoles,Auth,Mail,Str;


class CategoryController extends Controller{
 
 
 public function index(Request $request) {
    try{ 
      if($request->ajax()) {   
        $data =  Category::where('status','!=',2)->latest();
        return Datatables::of($data)
          ->addIndexColumn()
            ->addColumn('name', function($row){
                return $row->name;
            }) 
             ->addColumn('type', function($row){
                if($row->category_type==1)
                {
                  $typename="Renting";
                }
                else{
                  $typename="Buying";
                }
                return $typename;
            })
            ->addColumn('meta title', function($row){
              return $row->meta_title;
              
          })
          ->addColumn('meta description', function($row){
            return $row->description;
            
        })
        ->addColumn('meta keywords', function($row){
          return $row->meta_keywords;
          
      })
            ->addColumn('status', function($row){
                $status = $row->status;
                if($status==1){
                    $status='<span class="badge badge-success badge_category_status_change" style="cursor: pointer;" id="'.$row->id.'">Active</span>';
                }elseif($status==0){
                     $status='<span class="badge badge-danger badge_category_status_change" style="cursor: pointer;" id="'.$row->id.'">Inactive</span>';
                }else {
                   $status='<span class="badge badge-danger" id="'.$row->id.'">Inactive</span>';
                }
                return $status;
            }) 
            ->addColumn('created_at', function ($data) {
                $created_date=date('d M, Y g:i A', strtotime($data->created_at));
                return $created_date;   
            })
            ->addColumn('action__', function($row){
                $route=route('admin-category-edit',$row->id);
                $route_view=route('admin-category-details',$row->id);
                $action='<a href="'.$route.'" title="Edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>';
                return $action;
            })  
            ->make(true);
          }  

      return view('admin::category.index');  
    }
    catch (\Exception $e) 
    {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function add() {
    try{
      return view('admin::category.add');
    }
    catch (\Exception $e) {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

  public function save(Request $request){
    try {
      $data=$request->all();
      
    

	    $request->validate([
	        'name'=>[
                  'required',
                ],
          'type'=>[
                  'required',
                  Rule::in(['1','2']),
                ],
	    ],
      [
        'name.required' => 'Name field can’t be left blank.',
        'type.required'=>'Please select category type.',
        'type.in'=>'Please select valid category type.',
      ]);

      $checkcategory=Category::where('name',$data['name'])->where('category_type',$data['type'])->get()->first();
     
      if($checkcategory)
      {
        if($data['type']=="1")
        {
          return redirect()->back()->with('error', 'Category already exists in the booking type.');
        }
        else{
          return redirect()->back()->with('error', 'Category already exists in the renting type.');
        }
        
      }

      $name_pt=GoogleTranslate::trans($data['name'],'pt');
      if($data['description']!="")
      {
        $description_pt=GoogleTranslate::trans($data['description'],'pt');
      }
      else{
        $description_pt="";
      }

      if($data['meta_title']!="")
      {
        $meta_title_pt=GoogleTranslate::trans($data['meta_title'],'pt');
      }
      else{
        $meta_title_pt="";
      }

      if($data['meta_description']!="")
      {
        $meta_description_pt=GoogleTranslate::trans($data['meta_description'],'pt');
      }
      else{
        $meta_description_pt="";
      }

      if($data['meta_keywords']!="")
      {
        $meta_keywords_pt=GoogleTranslate::trans($data['meta_keywords'],'pt');
      }
      else{
        $meta_keywords_pt="";
      }
      
    
      $category = new Category;
      $category->name=$data['name'];
      $category->name_pt=$name_pt;
      $category->description=$data['description'];
      $category->description_pt=$description_pt;
      $category->category_type=$data['type'];
      $category->meta_title=$data['meta_title'];
      $category->meta_title_pt=$meta_title_pt;
      $category->meta_description=$data['meta_description'];
      $category->meta_description_pt=$meta_description_pt;
      $category->meta_keywords=$data['meta_keywords'];
      $category->meta_keywords_pt=$meta_keywords_pt;
      $category->status=1;
     
      $category->save();

      if($category){
        return redirect()->route('admin-category-list')->with('success', 'Category has been added !');
      }
      else{
      	return redirect()->back()->with('error', 'something wrong2');
      }
    }
    catch (\Exception $e){
      if($e instanceof ValidationException){
	        $listmessage=[];
	        foreach($e->errors() as $key=>$list)
	        {
	            $listmessage[$key]=$list[0];
	        }

	        if(count($listmessage) > 0)
	        {
	            return back()->with('valid_error',$listmessage);
	        }
	        else{
	            return back()->with('error','Something went wrong.');
	        }
	        
	    }
	    else{
	        return back()->with('error','Something went wrong.');
	    }
    }
  }

  public function edit($id){
    try{
      $catInfo =Category::where('id',$id)->first();
      return view('admin::category.edit', compact('catInfo'));
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');            
    }
  }
    
  public function update(Request $request){

    try {
      $data=$request->all();
     

      $request->validate([
          'name'=>[
                  'required',
                ],
          'type'=>[
                  'required',
                  Rule::in(['1','2']),
                ],
      ],
      [
        'name.required' => 'Name field can’t be left blank.',
        'type.required'=>'Please select category type.',
        'type.in'=>'Please select valid category type.',
      ]);

      if(!array_key_exists("id",$data))
      {
        return redirect('admin/category-list/')->with('error','Something went wrong.');
      }

      $category = Category::find($data['id']);
          if(is_null($category)){
           return redirect('admin/category-list/')->with('error','Something went wrong.');
        }

        if($category->name==$data['name'] && $category->category_type==$data['type'])
        {
            $category->description=$data['description'];
            $category->meta_title=$data['meta_title'];
            $category->meta_description=$data['meta_description'];
            $category->meta_keywords=$data['meta_keywords'];
        }
        else{
          $checkcategory=Category::where('name',$data['name'])->where('category_type',$data['type'])->get()->first();
          if($checkcategory)
          {
            if($data['type']=="1")
            {
              return redirect()->back()->with('error', 'Category already exists in the booking type.');
            }
            else{
              return redirect()->back()->with('error', 'Category already exists in the renting type.');
            }
            
          }
          else{
            $category->name = $data['name'];
            $category->category_type = $data['type'];
            $category->description=$data['description'];
            $category->meta_title=$data['meta_title'];
            $category->meta_description=$data['meta_description'];
            $category->meta_keywords=$data['meta_keywords'];
          }
        }

          $name_pt=GoogleTranslate::trans($data['name'],'pt');
          if($data['description']!="")
          {
            $description_pt=GoogleTranslate::trans($data['description'],'pt');
          }
          else{
            $description_pt="";
          }

          if($data['meta_title']!="")
          {
            $meta_title_pt=GoogleTranslate::trans($data['meta_title'],'pt');
          }
          else{
            $meta_title_pt="";
          }

          if($data['meta_description']!="")
          {
            $meta_description_pt=GoogleTranslate::trans($data['meta_description'],'pt');
          }
          else{
            $meta_description_pt="";
          }

          if($data['meta_keywords']!="")
          {
            $meta_keywords_pt=GoogleTranslate::trans($data['meta_keywords'],'pt');
          }
          else{
            $meta_keywords_pt="";
          }

          $category->name_pt=$name_pt;
          $category->description_pt=$description_pt;
          $category->meta_title_pt=$meta_title_pt;
          $category->meta_description_pt=$meta_description_pt;
          $category->meta_keywords_pt=$meta_keywords_pt;


        try{
            $category->save();
            return redirect('/admin/category-list/')->with('success', 'Category has been updated !');       

          }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
          }

    }
    catch (\Exception $e){
      if($e instanceof ValidationException){
          $listmessage=[];
          foreach($e->errors() as $key=>$list)
          {
              $listmessage[$key]=$list[0];
          }

          if(count($listmessage) > 0)
          {
              return back()->with('valid_error',$listmessage);
          }
          else{
              return back()->with('error','Something went wrong.');
          }
          
      }
      else{
          return back()->with('error',$e->getMessage());
      }
    }
  }

  public function updateCategoryStatus(Request $request){
    try{
      $data=$request->all();
      if(!array_key_exists("id",$data))
      {
        return redirect('admin/category-list/')->with('error','Something went wrong.');
      }

      $category=Category::where('id', $request->id)->first();
      if($category->status == 1){
        $updatedata = [ "status"=>0];
        Category::where('id', $request->id)->update($updatedata);
        $status=1;
      }else if($category->status == 0){
        $updatedata = [ "status"=>1];
        Category::where('id', $request->id)->update($updatedata);
        $status=1;
      }else{
        $status=0;
      }
        return response()->json(["success" => $status]);
    }
    catch(Exception $e){  
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }
   
  public function deleteCategory(Request $request){
    try{
      $data = ["status"=>2];
      $catInfo=Category::where('id', $request->id)->first();  
      Category::where('id', $request->id)->update($data);  
     
      toastr()->success('Buyer deleted successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
      
      return response()->json(["success" => "1"]);
    }
    catch(Exception $e){
      return redirect()->back()->with('error', 'something wrong');     
    }  
  }

  public function softDeletedUser(Request $request){
     try { 
      if($request->ajax()) {   
        $data =  User::role("Buyer")->where('status',2)->latest();
        return Datatables::of($data)
          ->addIndexColumn()
           
            ->addColumn('name', function($row){
                $name = $row->name;
                return $name;
            }) 
             ->addColumn('email', function($row){
                $email = $row->email;
                return $email;
            })
            ->addColumn('status', function($row){
                $status = $row->status;
                if($status==1){
                    $status='<span class="badge badge-success badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Active</span>';
                }elseif($status==0){
                     $status='<span class="badge badge-danger badge_status_change" style="cursor: pointer;" id="'.$row->id.'">Inactive</span>';
                }else {
                   $status='<span class="badge badge-danger" id="'.$row->id.'">Inactive</span>';
                }
                return $status;
            }) 
          
            ->addColumn('action__', function($row){
               
                $route_view=route('admin-user-details',$row->id);
               
                  $action='<button title="restore" class="btn btn-primary btn-sm badge_restore" data-id="'.$row->id.'"> <i class="fa fa-refresh"></i></button>';
                return $action;
            })  
            ->filter(function ($instance) use ($request) {
              if (!empty($request->get('search'))) {
                $instance->where(function($w) use($request){
                    $search = $request->get('search');
                    $w->orWhere('email', 'LIKE', "%$search%")
                    ->orWhere('name', 'LIKE', "%$search%");
                });
              }
           
              if($request->get('status') == '0' || $request->get('status') == '1') {
                $instance->where('status', $request->get('status'));
              }
              
              if(!empty($request->get('start_date'))  &&  !empty($request->get('end_date'))) {
                $instance->where(function($w) use($request){
                   $start_date = $request->get('start_date');
                   $end_date = $request->get('end_date');
                   $start_date = date('Y-m-d', strtotime($start_date));
                   $end_date = date('Y-m-d', strtotime($end_date));
                   $w->orwhereRaw("date(created_at) >= '" . $start_date . "' AND date(created_at) <= '" . $end_date . "'");
                });
              } 
            })
            
            ->make(true);
          }  

      return view('admin::user.soft_deleted_user_list',compact('stateList'));  
    }
    catch (\Exception $e) 
    {
      return redirect()->back()->with('error', 'something wrong');
    }
  }

}