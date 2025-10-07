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
use DB;

use Carbon\Carbon;



 
class VendorManagementController extends Controller
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
              ];

         $validator = Validator::make($request->all(), $rules,);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

                $status="Completed";
                $rfp = RFPStep::where('id',$request->rfp_id)->first();

                $item = Approve::where('user_id',$id)->where('rfp_id', $request->rfp_id)->where('type','VendorManagementTeam')->first();
                
                if($item && $item != ''){
                   $item = $item; 
                }else{
                    $item = New Approve();
                }

                if($request->status != 'Completed' || $request->comment_vendor_management ){
                    $status="Decline";
                    $item->comment_vendor_management = $request->comment_vendor_management;                
                    $item->reason_id = $request->reason_id; 
                }else{

                    $item->comment_vendor_management = null;                
                    $item->reason_id = null; 
                }
 
                $item->rfp_id = $request->rfp_id; 
                $item->type = 'VendorManagementTeam';
                $item->user_id = $id;
                // $item->deadline = $item->deadline ? $item->deadline: '' ;
                $item->status = $status;
                $item->department_id = $user->department;
                               

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

        // dd($request->all());

        $id = auth('sanctum')->id();

        
        $items = Approve::with('department','user')
            ->where('rfp_id', $request->rfp_id)
            ->where('type', $request->type)
            ->orderBy('id','ASC')
            ->get();


        if (!isset($items) || $items->count() == 0) {

            $rfp = RFPStep::where('id', $request->rfp_id)->first();
            // dd($rfp);

            // تحديد تاريخ آخر موافقة من VendorTeam
            $lastSoiApprovalDate = Approve::where('rfp_id', $request->rfp_id)
                ->where('type', 'vendorTeam')
                ->whereNotNull('date_approved')
                ->orderByDesc('date_approved')
                ->value('date_approved');

            if(!isset($lastSoiApprovalDate) || $lastSoiApprovalDate == ''){

                $message = "success return";
                return mainResponse(true, $message, [], 200, 'items', '');

            }

            // إذا لا يوجد إطلاقًا، خذ التاريخ الحالي (كـ fallback)
            if (!$lastSoiApprovalDate) {
                $lastSoiApprovalDate = Carbon::now();
            } else {
                $lastSoiApprovalDate = Carbon::parse($lastSoiApprovalDate);
            }

            // حساب deadline النهائي
            $deadline = $lastSoiApprovalDate->copy()->addDays($rfp->soi_days_deadline);

            $soiTeam = json_decode($rfp->soi_team, true); 

            // dd($soiTeam);
            
            foreach ($soiTeam as $key => $value) {
                $item = new Approve();
                $item->rfp_id = $request->rfp_id; 
                $item->type = 'VendorManagementTeam'; 
                $item->user_id = $value['id'];
                $item->deadline = null;
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
        
        if(isset($items[0]['user_id']) && $items[0]['user_id'] == $id){
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













  

    

}