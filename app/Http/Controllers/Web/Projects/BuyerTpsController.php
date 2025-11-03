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
use App\Models\Document;
use App\Models\ItemsCategories;
use App\Models\ResponseVendors;
use App\Models\Question;

use DB;

use Carbon\Carbon;



 
class BuyerTpsController extends Controller
{
  
     public function __construct() {
        $this->middleware('auth', ['except' => ['login', 'register']]);

        $this->locales = Language::all();
        view()->share([
            'locales' => $this->locales,

        ]);
    }

    
    
 

    public function create(Request $request)
    {

      // dd($request->all());

        $id = auth('sanctum')->id();

        $user = auth('sanctum')->user();

         $rules = [
                 "rfp_id" => 'required',
                 "type" => 'required',
              ];

         $validator = Validator::make($request->all(), $rules,);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

                $status="Completed";
                $rfp = RFPStep::where('id',$request->rfp_id)->first();

                $item = Approve::where('user_id',$id)->where('rfp_id', $request->rfp_id)->where('type',$request->type)->first();
                // dd($item);
                
                if($item && $item != ''){
                   $item = $item; 
                }else{
                    $item = New Approve();
                }

                if($request->status != 'Completed' ){
                    $status="Decline";
                }else{

                    $status="Completed";
                }
 
                $item->status = $status; 
                $item->comment = $request->comment; 
                $item->rfp_id = $request->rfp_id; 
                $item->type = $request->type;
                $item->user_id = $id;
                // $item->deadline = $item->deadline ? $item->deadline: '' ;
                $item->status = $status;
                $item->department_id = $user->department;
                               

                $item->save();


                $createdAt = Carbon::parse($item->created_at);
                $deadline = Carbon::parse($item->deadline);
                $overdue = 0 ;

                $daysDifference = $createdAt->diffInDays($deadline, false) + 1;


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

        // dd($request->all());

        $id = auth('sanctum')->id();

        
        $items = Approve::with('department','user')
            ->where('rfp_id', $request->rfp_id)
            ->where('type', $request->type)
            ->orderBy('id','ASC')
            ->get();



             $rfp = RFPStep::where('id', $request->rfp_id)->first();
            $soiTeam = json_decode($rfp->buyer_tender_team, true); 


        if (!isset($items) || $items->count() == 0) {

           
                        
            foreach ($soiTeam as $key => $value) {
                $item = new Approve();
                $item->rfp_id = $request->rfp_id; 
                $item->type = 'buyerTpsTeam'; 
                $item->user_id = $value['id'];
                $item->deadline = $rfp->deadline_tps_buyer;
                $item->status = 'Ready';
                $item->department_id = $value['department']['id'];
                $item->save();
            }

            // تحديث الحالة إذا تخطى الموعد
            Approve::where('rfp_id', $request->rfp_id)
                ->where('type', $request->type)
                ->whereNull('date_approved')
                ->where('deadline', '<', Carbon::now())
                ->update(['status' => 'Overdue']);
        }


        $items = Approve::with('department','user')
            ->where('rfp_id', $request->rfp_id)
            ->where('type', $request->type)
            // ->whereNotNull('date_approved')
            ->orderBy('id','ASC')
            ->get();

        $disable= 1 ;
        
        if(isset($soiTeam[0]['id']) && $soiTeam[0]['id'] == $id){
            $disable = 0 ;
        }   

        $message = "success return";
        return mainResponse(true, $disable, $items, 200, 'items', '');
    }



    public function excelResponse(Request $request)
    {
        
        // dd($request->all());


        $rfp_id = $request->rfp_id;

        $criteria  = ItemsCategories::where('type_id',2)->get();
        $vendors = ItemsCategories::where('type_id',28)->get();

        $documents = Document::where('rfp_id', $rfp_id)
            ->where('type', 'vendorTeam')
            ->get()
            ->keyBy(function ($item) {
                return $item->approve_id . '_' . $item->criteria_id;
            });


        $table = [];

        foreach ($criteria as $criterion) {
            $row = [
                'criterion' => $criterion->name, 
            ];

            foreach ($vendors as $vendor) {
                $key = $vendor->id . '_' . $criterion->id;

                if (isset($documents[$key])) {
                    $approve = $documents[$key]->approve;
                    $row["vendor_{$vendor->id}"] = $approve === 'true' ? 'YES' : ($approve === 'false' ? 'NO' : '');
                } else {
                    $row["vendor_{$vendor->id}"] = 'No Response';
                }
            }

            $table[] = $row;
        }


        $message = "success return";
        return mainResponse(true, $message, $table, 200, 'items', '');

    }




    public function createItemDate(Request $request){


        $items = Approve::where('rfp_id',$request->rfp_id)->where('type',$request->type)->update(['deadline'=>$request->deadline]);

        $message = "success return";
        return mainResponse(true, $message, $items, 200, 'items', '');

    }


    public function getAllItemsResponseVendor(Request $request)
    {

        // dd($request->all());

        $id = auth('sanctum')->id();

        
       
        $items = ResponseVendors::where('rfp_id', $request->rfp_id)
            ->orderBy('id','ASC')
            ->get();




        $message = "success return";
        return mainResponse(true, $message, $items, 200, 'items', '');
    }



    public function Store(Request $request){

        // dd($request->all());

        $exists = DB::table('response_vendors')->where([
            'rfp_id' => $request->rfp_id,
            'criteria_id' => $request->criteria_id,
            'vendor_id' => $request->vendor_id,
            ])->first();

        if ($exists) {
            DB::table('response_vendors')
                ->where('id', $exists->id)
                ->update([
                    'response' => $request->response,
                    'updated_at' => now()
                ]);
        } else {
            DB::table('response_vendors')->insert([
                'rfp_id' => $request->rfp_id,
                'criteria_id' => $request->criteria_id,
                'vendor_id' => $request->vendor_id,
                'response' => $request->response,
                'user_id' => auth()->id(),
                'created_at' => now()
            ]);
        }


        $message = "success return";
        return mainResponse(true, $message, $exists, 200, 'items', '');

    }

 
    public function getAllItemsStaticitics(Request $request){

        // dd($request->all());

        $id = auth('sanctum')->id();
        $criteria_count  = DB::table('items_categories')->where('type_id',2)->count();

        $vendors = DB::table('response_vendors')
            ->select('vendor_id', DB::raw('COUNT(*) as total_yes'))
            ->where('rfp_id', $request->rfp_id)
            ->where('response', 'YES') 
            ->groupBy('vendor_id')
            ->having('total_yes', '=', $criteria_count)
            ->pluck('vendor_id')
            ->toArray();


        $fullyApprovedCount = count($vendors);

        $allVendors = DB::table('response_vendors')
            ->select('vendor_id')
            ->where('rfp_id', $request->rfp_id)
            ->groupBy('vendor_id')
            ->pluck('vendor_id')
            ->toArray();

        $notFullyApprovedCount = count(array_diff($allVendors, $vendors));





        $vendors = DB::table('r_f_p_steps')->where([
            'id' => $request->rfp_id,
            ])->pluck('vendors')->first();
        
        $rashed = count(json_decode($vendors, true));



       $response = DB::table('approves')
        ->where('rfp_id', $request->rfp_id)
        ->where('type', $request->type)
        ->whereNotNull('date_approved') 
        ->count();

        $passed = $fullyApprovedCount;


        $fail = $notFullyApprovedCount;


        $decline = DB::table('approves')
           ->where('rfp_id', $request->rfp_id)
           ->where('type', $request->type)
           ->where('status','Decline')
           ->count();


         $invited = $fullyApprovedCount;



         $items = ['rashed'=>$rashed , 'response'=>$response , 'passed'=>$passed , 'fail'=>$fail , 'decline'=>$decline, 'invited'=>$invited];
         $message = 'success return Data';


         $items22 = Approve::where('rfp_id', $request->rfp_id)
            ->where('type', 'VendorManagementTeam')
            ->orderBy('id','ASC')
            ->get();

        $disable= 1 ;

        // dd($items22[0]['user_id']);
        
        if(isset($items22[0]['user_id']) && $items22[0]['user_id'] == $id){
            $disable = 0 ;
        }   

         return mainResponse(true, $disable, $items, 200, 'items', '');  
    }


    public function createItemApprove(Request $request)
    { 

      // dd($request->all());

        $id = auth('sanctum')->id();

        $user = auth('sanctum')->user();

        $rules = [
                 "rfp_id" => 'required',
                 // "deadline" => 'required',
                 "buyer_tender_team" => 'required',
              ];

         $validator = Validator::make($request->all(), $rules,);

        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

            $item = RFPStep::where('id',$request->rfp_id)->first();
            $item->deadline_tps_buyer = $request->deadline ? $request->deadline : null ;
            $item->buyer_tender_team = json_encode($request->buyer_tender_team);

            $item->save();



            $buyerTps = json_decode($item->buyer_tender_team, true);

            if (!empty($buyerTps)) {
                $newUserIds = collect($buyerTps)->pluck('id')->toArray();

                Approve::where('rfp_id', $request->rfp_id)
                    ->where('type', 'buyerTpsTeam')
                    ->whereNotIn('user_id', $newUserIds)
                    ->delete();

                foreach ($buyerTps as $value) {
                    $check_is_found = Approve::where('rfp_id', $request->rfp_id)
                        ->where('user_id', $value['id'])
                        ->where('type', 'buyerTpsTeam')
                        ->exists();

                    if (!$check_is_found) {
                        $approve = new Approve();
                        $approve->rfp_id = $request->rfp_id;
                        $approve->type = 'buyerTpsTeam';
                        $approve->user_id = $value['id'];
                        $approve->deadline = $item->deadline_tps_buyer;
                        $approve->status = 'Ready';
                        $approve->department_id = $value['department']['id'];
                        $approve->save();
                    }
                }
            }


                Approve::where('rfp_id', $request->rfp_id)
                    ->where('type', 'buyerTpsTeam')
                    ->whereNull('date_approved')
                    ->where('deadline', '<', Carbon::now())
                    ->update(['status' => 'Overdue']);
            



            Approve::where('rfp_id',$request->rfp_id)->where('type','buyerTpsTeam')->update(['deadline'=> $item->deadline_tps_buyer]);

            $items = RFPStep::with('sections','category','contract','type_event')->where('id',$request->rfp_id)->first();


            $message ="The Operation Done successfully";
            return mainResponse(true, $message , $items, 200, 'items','');

               



       
        }
    }


    public function createTPSData(Request $request)
    {

      // dd($request->all());

        $id = auth('sanctum')->id();

        $rules = [
            // 'selectedValues' => 'required',  
            
        ];

      

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return mainResponse(false, '', null, 203, 'items', $validator);
        }

        $rfp_id = $request->input('rfp_id');
        $data_json = json_encode($request->all());

        $item = RFPStep::where('id', $rfp_id)->first();
        $item->data_json_tps = $data_json;
        $item->save();

        $message ="The Operation Done successfully";
        return mainResponse(true, $message , $item, 200, 'items','');

               

       
        }



    public function publish(Request $request)
    {
 
      // dd($request->all());

        $id = auth('sanctum')->id();

        $rules = [
            "rfp_id" => 'required'
        ];

        $validator = Validator::make($request->all(), $rules,);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{
          
            $items = RFPStep::where('id',$request->rfp_id)->first();
            $items->publish_buyer = $id ;
            $items->publish_buyer_date = Carbon::now()->format('Y-m-d');
            $items->save();
            $message ="The Operation Done successfully";
            return mainResponse(true, $message , $items, 200, 'items','');
       
        }

    }

     

    public function sendQuestion(Request $request)
    {
        // dd($request->all());


        $userId = auth('sanctum')->id();

        $rules = [
            "questionable_type" => 'required|string', 
            "questionable_id"   => 'required|integer', 
            "question"          => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return mainResponse(false, '', null, 203, 'items', $validator);
        }

        $question = Question::create([
            'user_id'           => $userId,
            'rfp_id'           => $request->rfp_id,
            'questionable_id'   => $request->questionable_id,
            'questionable_type' => $request->questionable_type,
            'question'          => $request->question,
        ]);

        $message = "The question was created successfully";
        return mainResponse(true, $message, $question, 200, 'items', '');
    }


    public function getAllItemsQuestions(Request $request)
    {
        $userId = auth('sanctum')->id();

        $rules = [
            "questionable_type" => 'required|string',
            "questionable_id"   => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return mainResponse(false, '', null, 203, 'items', $validator);
        }

        $questions = Question::where('user_id', $userId)->where('rfp_id',$request->rfp_id)
            ->where('questionable_type', $request->questionable_type)
            ->where('questionable_id', $request->questionable_id)
            ->orderBy('id', 'ASC')
            ->get();

        $message = "Questions retrieved successfully";
        return mainResponse(true, $message, $questions, 200, 'items', '');
    }










  

    

}