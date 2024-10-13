<?php
namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role,Permission};
use Illuminate\Support\Facades\{Storage,File};
use App\Models\{User,CmsPage};
use Illuminate\Support\Arr;
use App\Helpers\Helper;
use Hash,Validator,Exception,Toastr;

class CmsPageController extends Controller{
    public function index()
    {
        try
        {
            $pageList = CmsPage::get();     
            return view('admin::cms.index',compact('pageList'));  

        }
        catch (\Exception $e) 
        {
            return redirect()->back()->with('error', 'something wrong');
        }
    }

    public function add() 
    {
        try
        {
            return view('admin::cms.add');
        }
        catch (\Exception $e) 
        {
            return redirect()->back()->with('error', 'something wrong');
        }
    }
   

    public function save(Request $request)
    {
        $data = $request->all();

        request()->validate([
            'page_name' => 'required|unique:cms_pages,page_name',
            'page_title'=>'required',
            'page_description' => 'required'
        ]);

        try
        {
           $cms = new CmsPage;
           //$cms->page_slug=$data['page_slug'];
          $cms->page_title=$data['page_title'];
          $cms->page_name=$data['page_name'];
          $cms->page_description=$data['page_description'];
          $cms->save(); 
            toastr()->success('Page saved successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
           return redirect()->route('admin-cms-page-list')->with('success',"Page saved successfully");
        }
        catch(Exception $e)
        {
            return redirect()->back()->with('error', 'something wrong');  
        }
    }

    public function edit($page_slug){
        try
        {
            $cmsInfo =CmsPage::where('page_slug','=',$page_slug)->first();
            return view('admin::cms.edit', compact('cmsInfo'));
        }
        catch(Exception $e)
        {
            return redirect()->back()->with('error', 'something wrong');            
        }
    }

    public function update(Request $request)
    {
        
        request()->validate([
            'page_name' => 'required|unique:cms_pages,page_name,'.$request->id,
            'page_title'=>'required',
            'page_description' => 'required'
        ]);

        try 
        {
            $update = [
                //"page_slug"=>$request->page_slug,
                "page_title"=>$request->page_title,
                "page_name"=>$request->page_name,
                "page_description" => $request->page_description
                ];

            CmsPage::where(['id' =>$request->id])->update($update);
             toastr()->success('Page information updated successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
            return redirect()->route('admin-cms-page-list')->with('success','Page updated successfully');
        }
        catch (\Exception $e)
        {
           return redirect()->back()->with('error', 'something wrong');
        }
    }

    public function show($slug)
    {
      $pageInfo=CmsPage::where('page_slug',$slug)->first();
     
      return view('admin::cms.show',compact('pageInfo'));  
    }


   public function activeStatus(Request $request){
    try{
        $data = [ "status"=>1];
        Category::where('id',$request->id)->update($data);
         toastr()->success('Status updated successfully!','',["progressBar"=> false, "showDuration"=>"3000", "hideDuration"=> "3000", "timeOut"=>"100"]);
        return response()->json(["success" => "1"]);
    }catch(Exception $e){  
         //Toastr()->error('Either something went wrong or invalid access!', 'Error');
    }  
}

public function updatePageStatus(Request $request)
    {
      try
      {
        $page=CmsPage::where('id', $request->id)->first();
        if($page->status == 1)
        {
          $data = [ "status"=>0];
          CmsPage::where('id', $request->id)->update($data);
        }else
        {
          $data = [ "status"=>1];
          CmsPage::where('id', $request->id)->update($data);
        }

        return response()->json(["success" => "1"]);
      }
      catch(Exception $e)
      {  
        return redirect()->back()->with('error', 'something wrong');     
      }  
    }
   

    public function deletePage(Request $request)
    {
      try
      {
        $data = ["delete_status"=>1];
        CmsPage::where('id', $request->id)->update($data);  
        return response()->json(["success" => "1"]);
      }
      catch(Exception $e)
      {
        return redirect()->back()->with('error', 'something wrong');     
      }  
    }
   

    
}
