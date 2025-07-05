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
use App\Models\Approve;
use App\Models\RFPWord;
use Carbon\Carbon;



 
class ReviewApproveController extends Controller
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

        $user = auth('sanctum')->user();

         $rules = [
                 "rfp_id" => 'required',
              ];

         $validator = Validator::make($request->all(), $rules,);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{


                $rfp = RFPStep::where('id',$request->rfp_id)->first();

                $item = Approve::where('user_id',$id)->where('rfp_id', $request->rfp_id)->where('type','reviewTeam')->first();
                
                if($item && $item != ''){
                   $item = $item; 
                }else{
                    $item = New Approve();
                }

                $item->rfp_id = $request->rfp_id; 
                $item->type = 'reviewTeam';
                $item->user_id = $id;
                $item->deadline = $rfp->review_team_deadline;
                $item->status = 'Completed';
                $item->department_id = $user->department;
                $item->comment = $request->comment;                

                $item->save();


                $createdAt = Carbon::parse($item->created_at);
                $deadline = Carbon::parse($item->deadline);
                $overdue = 0 ;

                $daysDifference = $createdAt->diffInDays($deadline, false);

                if($daysDifference < 0){
                    $overdue = 1 ;
                    // $status = 'Overdue'
                }

                $item->kpi = $daysDifference;
                $item->overdue = $overdue;
                $item->date_approved = Carbon::now();
                $item->save();




                $message ="The Operation Done successfully";
                return mainResponse(true, $message , $item, 200, 'items','');

               



       
        }

    }



    

    public function getAll(Request $request)
    {


        $id = auth('sanctum')->id();

        $items = Approve::with('department','user')->where('rfp_id',$request->rfp_id)->where('type',$request->type);
        $items = $items->orderBy('id','ASC')->get();

        if(!isset($items) || count($items) == 0){

            $rfp = RFPStep::where('id',$request->rfp_id)->first();

            $reviewTeam = json_decode($rfp->review_team, true);
            // dd($reviewTeam);

                foreach ($reviewTeam as $key => $value) {
                    $item = New Approve();
                    $item->rfp_id = $request->rfp_id; 
                    $item->type = 'reviewTeam';
                    $item->user_id = $value['id'];
                    $item->deadline = $rfp->review_team_deadline;
                    $item->status = 'Ready';
                    $item->department_id = $value['department']['id'];

                    $item->save();
                }
          
                
                Approve::where('rfp_id',$request->rfp_id)->where('type',$request->type)->whereNull('date_approved')->where('deadline','<', Carbon::now())->update(['status'=>'Overdue']);


        }

        $message = "success return";
        return mainResponse(true, $message, $items, 200, 'items', '');
    }



  

    

}