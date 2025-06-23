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
use App\Models\RFPStep;
use App\Models\Step;
use App\Models\Project;
use App\Models\RFPWord;
use Carbon\Carbon;



 
class RFPStepController extends Controller
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
                 "ID_rfp" => 'required',
                  // "category_id" => 'required',
                  // "contract_id" => 'required',
                  "name" => 'required',
                  "description" => 'required',
                  "type_event" => 'required',
                  "business_unite" => 'required',
                  "estimated_budget" => 'required',
              ];

         $validator = Validator::make($request->all(), $rules,);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

          
                $item = New RFPStep;
               
               $item->ID_rfp = $request->ID_rfp;
                $item->category_id = $request->category_id;
                $item->contract_id = $request->contract_id;
                $item->name = $request->name;
                $item->description = $request->description;
                $item->business_unite = $request->business_unite;
                $item->type_event = $request->type_event;
                $item->estimated_budget = $request->estimated_budget;
                $item->created_by = $id;
                $item->number_contractor = $request->number_contractor;
                

                $item->commercial_commite = json_encode($request->commercial_commite);
                $item->review_team = json_encode($request->review_team);
                $item->technical_commite = json_encode($request->technical_commite);
                $item->vendors = json_encode($request->vendors);
                $item->currency = $request->currency;
                $item->due_date = $request->due_date;
                $item->duration = $request->duration;
                $item->location = $request->location;
                

                $item->check_1 = $request->check_1;
                $item->check_2 = $request->check_2;
                $item->check_3 = $request->check_3;
                $item->check_4 = $request->check_4;
                $item->check_5 = $request->check_5;
                $item->check_6 = $request->check_6;

                $item->save();


                $steps_word = Project::whereNull('type_item')->get();

                foreach ($steps_word as $key => $value) {
                    
                    $obj = New RFPWord();
                    $obj->rfp_id = $item->id;
                    $obj->title = $value->title;
                    $obj->description = $value->description;
                    $obj->type = $value->type;
                    $obj->order = $value->order;
                    $obj->save();
                }

                $items = RFPStep::with('sections')->where('id',$item->id)->first();

                $message ="The Operation Done successfully";
                return mainResponse(true, $message , $items, 200, 'items','');

               



       
        }

    }



    public function edit(Request $request)
    {

      // dd($request->all());

        $id = auth('sanctum')->id();

         $rules = [
                 "ID_rfp" => 'required',
                  // "category_id" => 'required',
                  // "contract_id" => 'required',
                  "name" => 'required',
                  "description" => 'required',
                  "type_event" => 'required',
                  "business_unite" => 'required',
                  "estimated_budget" => 'required',
              ];

         $validator = Validator::make($request->all(), $rules,);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

          
                $item = RFPStep::findOrFail($request->Item_id);
               
                $item->ID_rfp = $request->ID_rfp;
                $item->category_id = $request->category_id;
                $item->contract_id = $request->contract_id;
                $item->name = $request->name;
                $item->description = $request->description;
                $item->business_unite = $request->business_unite;
                $item->type_event = $request->type_event;
                $item->estimated_budget = $request->estimated_budget;
                $item->created_by = $id;
                $item->number_contractor = $request->number_contractor;
                

                $item->commercial_commite = json_encode($request->commercial_commite);
                $item->review_team = json_encode($request->review_team);
                $item->technical_commite = json_encode($request->technical_commite);
                $item->vendors = json_encode($request->vendors);
                $item->currency = $request->currency;
                $item->due_date = $request->due_date;
                $item->duration = $request->duration;
                $item->location = $request->location;
                

                $item->check_1 = $request->check_1;
                $item->check_2 = $request->check_2;
                $item->check_3 = $request->check_3;
                $item->check_4 = $request->check_4;
                $item->check_5 = $request->check_5;
                $item->check_6 = $request->check_6;
               
               

                $item->save();


                // $steps_word = Project::whereNull('type_item')->get();

                // foreach ($steps_word as $key => $value) {
                    
                //     $obj = New RFPWord();
                //     $obj->rfp_id = $item->id;
                //     $obj->title = $value->title;
                //     $obj->description = $value->description;
                //     $obj->type = $value->type;
                //     $obj->order = $value->order;
                //     $obj->save();
                // }

                $items = RFPStep::with('sections')->where('id',$item->id)->first();

                $message ="The Operation Done successfully";
                return mainResponse(true, $message , $items, 200, 'items','');

               



       
        }

    }


    public function getAll(Request $request)
    {

         $id = auth('sanctum')->id();

            $items = RFPStep::query();


            if($request->has('search') && !empty($request->search)) {
                $items->where(function($query) use ($request) {
                    $query->whereTranslationLike('name','%'.$request->search.'%')
                          ->orWhereTranslationLike('description', '%' . $request->search . '%');
                });
            }


           


            if(isset($request->pagination) && $request->pagination == 1) {
                $items = $items->orderBy('id','DESC')->paginate(10); 
            } else {
                $items = $items->orderBy('id','DESC')->get();
            }

            $message = "success return";

            return mainResponse(true, $message, $items, 200, 'items', '');
    }



    public function getById(Request $request)
    {
        $items = RFPStep::with('sections','category','contract')->where('id',$request->ID)->first();
        $message ="success return";
        return mainResponse(true, $message , $items, 200, 'items',''); 
    }

    public function delete($id)
    {
        if(RFPStep::where('id',$id)->delete()){
            $message ="success return";
            return mainResponse(true, $message , '', 200, 'items','');
        }else{
            $message ="Error happens";
            return mainResponse(false, $message , '', 203, 'items','');
        }
        
    }




    public function getAllItemsAllSteps(Request $request)
    {
            $items = RFPStep::where('project_id',$request->project_id)->get();
            $message = "success return";
            return mainResponse(true, $message, $items, 200, 'items', '');
    }



    public function editStep(Request $request)
    {

      // dd($request->all());

        $id = auth('sanctum')->id();

         $rules = [
                  "title" => 'required',
                  "description" => 'required',
              ];

         $validator = Validator::make($request->all(), $rules,);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

          
                    $item = RFPWord::findOrFail($request->Item_id);
                    $item->title = $request->title;
                    $item->description = $request->description;
                    $item->order = $request->order;
                    $item->save();


                 $items = RFPStep::with('sections','category','contract')->where('id',$item->rfp_id)->first();

                $message ="The Operation Done successfully";
                return mainResponse(true, $message , $items, 200, 'items','');

               



       
        }

    }

    

}