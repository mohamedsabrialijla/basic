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
use App\Models\ScopeProject;
use App\Models\ActivityProject;
use App\Models\TaskProject;
use App\Models\SubTaskProject;
use Carbon\Carbon;


 
class ScopeProjectController extends Controller
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

      $rules = [
                'project_id' => 'required',
                'scope_id' => 'required|unique:scope_projects',
                'priority' => 'required',
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date', 'after_or_equal:start_date'],
                   
            
            ];


        $custom = [
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be the same or after the start date.',
        ];


         $validator = Validator::make($request->all(), $rules, $custom);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
            $days_difference = $start_date->diffInDays($end_date);

                $item = New ScopeProject;
                $item->company_id = company_auth_id();
                $item->project_id = $request->project_id;
                $item->scope_id = $request->scope_id;
                $item->priority = $request->priority;
                $item->start_date = $request->start_date;
                $item->end_date = $request->end_date;
                $item->duration = $days_difference;
                $item->created_by = $id;



                $item->save();

                $message ="The Operation Done successfully";
                return mainResponse(true, $message , $item, 200, 'items','');

               

       
        }

    }



    // public function edit(Request $request)
    // {

    // }


    public function getAll(Request $request)
    {

         $id = auth('sanctum')->id();

            $items = ScopeProject::with('scope')->where('company_id', company_auth_id());


            if($request->has('search') && !empty($request->search)) {
                $items->where(function($query) use ($request) {
                    $query->whereTranslationLike('name','%'.$request->search.'%')
                          ->orWhereTranslationLike('description', '%' . $request->search . '%');
                });
            }


           


            if(isset($request->pagination) && $request->pagination == 1) {
                $items = $items->orderBy('id','ASC')->paginate(10); 
            } else {
                $items = $items->orderBy('id','ASC')->get();
            }

            $message = "success return";

            return mainResponse(true, $message, $items, 200, 'items', '');
    }



    // public function getById(Request $request)
    // {
    //     $items = Project::with('category','manager','zone','client')->where('id',$request->ID)->first();
    //     $message ="success return";
    //     return mainResponse(true, $message , $items, 200, 'items',''); 
    // }

    public function delete($id)
    {
        if(ScopeProject::where('id',$id)->delete()){
            $message ="success return";
            return mainResponse(true, $message , '', 200, 'items','');
        }else{
            $message ="Error happens";
            return mainResponse(false, $message , '', 203, 'items','');
        }
        
    }

    

}