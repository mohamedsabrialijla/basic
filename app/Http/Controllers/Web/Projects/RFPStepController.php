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
                  "type_event_id" => 'required',
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
                $item->type_event_id = $request->type_event_id;
                $item->estimated_budget = $request->estimated_budget;
                $item->created_by = $id;
                $item->number_contractor = $request->number_contractor;
                $item->techinical_passing_score = $request->techinical_passing_score;
                

                $item->commercial_commite = json_encode($request->commercial_commite);
                $item->review_team = json_encode($request->review_team);
                $item->soi_team = json_encode($request->soi_team);
                $item->nogotiation_team = json_encode($request->nogotiation_team);
                $item->buyer_tender_team = json_encode($request->buyer_tender_team);
                $item->technical_commite = json_encode($request->technical_commite);
                $item->vendors = json_encode($request->vendors);
                $item->currency = $request->currency;
                $item->due_date = $request->due_date;
                $item->duration = $request->duration;
                $item->location = $request->location;
                

                $item->check_1 = $request->has('check_1') && $request->check_1 == true ? 1 : 0;
                $item->check_2 = $request->has('check_2') && $request->check_2 == true ? 1 : 0;
                $item->check_3 = $request->has('check_3') && $request->check_3 == true ? 1 : 0;
                $item->check_4 = $request->has('check_4') && $request->check_4 == true ? 1 : 0;
                $item->check_5 = $request->has('check_5') && $request->check_5 == true ? 1 : 0;
                $item->check_6 = $request->has('check_6') && $request->check_6 == true ? 1 : 0;
            

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
                  "type_event_id" => 'required',
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
                $item->type_event_id = $request->type_event_id;
                $item->estimated_budget = $request->estimated_budget;
                $item->created_by = $id;
                $item->number_contractor = $request->number_contractor;
                $item->techinical_passing_score = $request->techinical_passing_score;
                

                $item->commercial_commite = json_encode($request->commercial_commite);
                $item->review_team = json_encode($request->review_team);
                $item->soi_team = json_encode($request->soi_team);
                $item->nogotiation_team = json_encode($request->nogotiation_team);
                $item->buyer_tender_team = json_encode($request->buyer_tender_team);
                $item->technical_commite = json_encode($request->technical_commite);
                $item->vendors = json_encode($request->vendors);
                $item->currency = $request->currency;
                $item->due_date = $request->due_date;
                $item->duration = $request->duration;
                $item->location = $request->location;
                

                $item->check_1 = $request->has('check_1') && $request->check_1 == true ? 1 : 0;
                $item->check_2 = $request->has('check_2') && $request->check_2 == true ? 1 : 0;
                $item->check_3 = $request->has('check_3') && $request->check_3 == true ? 1 : 0;
                $item->check_4 = $request->has('check_4') && $request->check_4 == true ? 1 : 0;
                $item->check_5 = $request->has('check_5') && $request->check_5 == true ? 1 : 0;
                $item->check_6 = $request->has('check_6') && $request->check_6 == true ? 1 : 0;

               
                $item->review_team_deadline = $request->review_team_deadline ? $request->review_team_deadline : null ;
                $item->soi_days_deadline = $request->soi_days_deadline ? $request->soi_days_deadline : null ;
                $item->draft = $request->draft  ? $request->draft: 0 ;

                $item->approve_for_review_team = $request->approve_for_review_team ? Carbon::now() : null ;
                
               

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

            $items = RFPStep::query()->with('category');


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


            if ($request->has('review') && !empty($request->review)) {
                $items = $items->filter(function ($item) use ($id) {
                    $reviewTeam = json_decode($item->review_team, true);

                    // تأكد من وجود تاريخ صالح
                    if (empty($item->approve_for_review_team)) {
                        return false;
                    }

                    if (!is_array($reviewTeam)) {
                        return false;
                    }

                    foreach ($reviewTeam as $member) {
                        if (isset($member['id']) && $member['id'] == $id) {
                            return true;
                        }
                    }

                    return false;
                })->values();
            }


      


            if ($request->has('buyer') && !empty($request->buyer)) {
                $items = $items->filter(function ($item) use ($id) {
                    $soiTeam = json_decode($item->soi_team, true);
                    if (!is_array($soiTeam) || empty($soiTeam)) return false;

                    // شرط أساسي: المستخدم موجود في الفريق
                    // $userInTeam = collect($soiTeam)->pluck('id')->contains($id);
                    // if (!$userInTeam) return false;

                    // شرط جديد: كل vendorTeam عاملين approval
                    $anyReviewPending = \App\Models\Approve::where('rfp_id', $item->id)
                        ->where('type', 'vendorTeam')
                        ->whereNull('date_approved')
                        ->exists();

                    if ($anyReviewPending) return false;

                    // جلب أول شخص لم يوافق بعد (soiTeam)
                    $firstPendingApprove = \App\Models\Approve::where('rfp_id', $item->id)
                        ->where('type', 'BuyerTeam')
                        ->whereNull('date_approved')
                        ->orderBy('id', 'ASC')
                        ->first();

                    if ($firstPendingApprove) {
                        return $firstPendingApprove->user_id == $id;
                    } else {
                        // لا يوجد موافقات بعد → فقط أول واحد في الفريق يظهر له
                        $firstTeamMemberId = $soiTeam[0]['id'] ?? null;
                        return $firstTeamMemberId == $id;
                    }
                })->values();
            }


            if ($request->has('vendor') && !empty($request->vendor)) {
                $items = $items->filter(function ($item) use ($id) {
                    $vendors = json_decode($item->vendors, true);
                    if (!is_array($vendors) || empty($vendors)) return false;

                    // شرط أساسي: المستخدم موجود في الفريق
                    $userInTeam = collect($vendors)->pluck('id')->contains($id);
                    if (!$userInTeam) return false;

                    // شرط جديد: كل reviewTeam عاملين approval
                    $anyReviewPending = \App\Models\Approve::where('rfp_id', $item->id)
                        ->where('type', 'reviewTeam')
                        ->whereNull('date_approved')
                        ->exists();

                    if ($anyReviewPending) return false;

                    return true;

                })->values();
            }




            $message = "success return";

            return mainResponse(true, $message, $items, 200, 'items', '');
    }



    public function getById(Request $request)
    {
        $items = RFPStep::with('sections','category','contract','type_event')->where('id',$request->ID)->first();
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




    public function getAllItemsWordFile(Request $request)
    {
            $items = RFPWord::where('rfp_id',$request->rfp_id)->get();
            $message = "success return";
            return mainResponse(true, $message, $items, 200, 'items', '');
    }

    

}