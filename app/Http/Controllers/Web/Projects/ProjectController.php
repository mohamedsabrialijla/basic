<?php

namespace App\Http\Controllers\Web\Projects;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Language;
use App\Models\ItemsProject;
use App\Models\ItemsTypes;
use App\Models\Project;
use App\Models\Step;
use Carbon\Carbon;


 
class ProjectController extends Controller
{
  
     public function __construct() {
        $this->middleware('auth', ['except' => ['login', 'register']]);

        $this->locales = Language::all();
        view()->share([
            'locales' => $this->locales,

        ]);
    }

    public function image_extensions(){
        return array('jpg','png','jpeg','gif','bmp');
    }

   


    public function create(Request $request)
    {

      // dd($request->all());

 
        $id = auth('sanctum')->id();

       if($request->type_item == 'project'){


                $rules = [
                'name' => 'required',                
                'code' => 'required', 
                   
            
               ];

            }else{

                 $rules = [
                 'title' => 'required',
                'description' => 'required',
                'type' => 'required',
                  
            ];

            }




         $validator = Validator::make($request->all(), $rules,);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

          
                $item = New Project;
               
                $item->order = $request->order;
                $item->name = $request->name;
                $item->title = $request->title;
                $item->type = $request->type;
                $item->description = $request->description;
                $item->code = $request->code;
                $item->created_by = $id;

                $item->save();

                $message ="The Operation Done successfully";
                return mainResponse(true, $message , $item, 200, 'items','');

               

       
        }

    }



    public function edit(Request $request)
    {


      // dd($request->all());

 
        $id = auth('sanctum')->id();

        $item = Project::query()->findOrFail($request->Item_id);

            if($request->type_item == 'project'){


                $rules = [
                'name' => 'required',                
                'code' => 'required|alpha_num|unique:projects,code,' . $item->id, 
                   
            
               ];

            }else{

                 $rules = [
                 'title' => 'required',
                'description' => 'required',
                'type' => 'required',
                  
            ];

            }
           



         $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

                $item = Project::findOrFail($request->Item_id);
                $item->order = $request->order;
                $item->name = $request->name;
                $item->title = $request->title;
                $item->type = $request->type;
                $item->description = $request->description;
                $item->code = $request->code;
                $item->created_by = $id;

                $item->save();

                $message ="Update Done successfully";
                return mainResponse(true, $message , $item, 200, 'items','');

               

       
        }

    }


    public function getAll(Request $request)
    {

         $id = auth('sanctum')->id();

            $items = Project::query()->where('type_item', $request->type_item);


            if($request->has('search') && !empty($request->search)) {
                $items->where(function($query) use ($request) {
                    $query->whereTranslationLike('name','%'.$request->search.'%')
                          ->orWhereTranslationLike('description', '%' . $request->search . '%');
                });
            }


           


            if(isset($request->pagination) && $request->pagination == 1) {
                $items = $items->orderBy('order','Asc')->paginate(10); 
            } else {
                $items = $items->orderBy('order','Asc')->get();
            }

            $message = "success return";

            return mainResponse(true, $message, $items, 200, 'items', '');
    }



    public function getById(Request $request)
    {
        $items = Project::query()->where('id',$request->ID)->first();
        $message ="success return";
        return mainResponse(true, $message , $items, 200, 'items',''); 
    }

    public function delete($id)
    {
        if(Project::where('id',$id)->delete()){
            $message ="success return";
            return mainResponse(true, $message , '', 200, 'items','');
        }else{
            $message ="Error happens";
            return mainResponse(false, $message , '', 203, 'items','');
        }
        
    }




    public function getAllItemsAllSteps(Request $request)
    {
            $items = Step::where('project_id',$request->project_id)->get();
            $message = "success return";
            return mainResponse(true, $message, $items, 200, 'items', '');
    }

    

}