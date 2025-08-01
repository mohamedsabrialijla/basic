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

use Carbon\Carbon;



 
class VendorApproveController extends Controller
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

                $item = Approve::where('user_id',$id)->where('rfp_id', $request->rfp_id)->where('type','vendorTeam')->first();
                
                if($item && $item != ''){
                   $item = $item; 
                }else{
                    $item = New Approve();
                }

                if($request->reason_id && $request->status != 'Completed' || $request->comment && $request->status != 'Completed'){
                    $status="Decline";
                    $item->comment = $request->comment;                
                    $item->reason_id = $request->reason_id; 
                }else{

                    $item->comment = null;                
                    $item->reason_id = null; 

                    $doc = Document::where('user_id',$id)->where('rfp_id', $request->rfp_id)->where('type','vendorTeam')->where('approve_id', $item->id)->count();

                    $cre = ItemsCategories::where('type_id',2)->count();

                    if($cre != $doc ){

                        $message ="Please Add missing Attachmets to Technical Criteiria ?! ";
                        return mainResponse(true, $message ,'', 203, 'items','');

                    }
                }

                $item->rfp_id = $request->rfp_id; 
                $item->type = 'vendorTeam';
                $item->user_id = $id;
                $item->deadline = $item->deadline ? $item->deadline: '' ;
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

        // dd($id);

        $items = Approve::with('department','user')
            ->where('rfp_id', $request->rfp_id)
            ->where('type', $request->type)
            ->orderBy('id','ASC')
            ->get();

        if (!isset($items) || $items->count() == 0) {

            $rfp = RFPStep::where('id', $request->rfp_id)->first();

            // تحديد تاريخ آخر موافقة من RevieTeam
            $lastSoiApprovalDate = Approve::where('rfp_id', $request->rfp_id)
                ->where('type', 'reviewTeam')
                ->whereNotNull('date_approved')
                ->orderByDesc('date_approved')
                ->value('date_approved'); // يرجع null إذا لا يوجد

          

            // إذا لا يوجد إطلاقًا، خذ التاريخ الحالي (كـ fallback)
            if (!$lastSoiApprovalDate) {
                $lastSoiApprovalDate = Carbon::now();
            } else {
                $lastSoiApprovalDate = Carbon::parse($lastSoiApprovalDate);
            }

            // حساب deadline النهائي
            $deadline = $lastSoiApprovalDate->copy()->addDays($rfp->soi_days_deadline);

            $soiTeam = json_decode($rfp->vendors, true); 
            
            foreach ($soiTeam as $key => $value) {
                $item = new Approve();
                $item->rfp_id = $request->rfp_id; 
                $item->type = 'vendorTeam'; 
                $item->user_id = $value['id'];
                $item->deadline = $deadline;
                $item->status = 'Ready';
                if(isset($value['department']) && $value['department'] != ''){
                    $item->department_id = $value['department'] ? $value['department']['id'] : '';
                }
                $item->save();
            }

            // تحديث الحالة إذا تخطى الموعد
            Approve::where('rfp_id', $request->rfp_id)
                ->where('type', $request->type)
                ->whereNull('date_approved')
                ->where('deadline', '<', Carbon::now())
                ->update(['status' => 'Overdue']);


        }


        $items2 = Approve::with('department','user')
            ->where('rfp_id', $request->rfp_id)
            ->where('type', $request->type)
            ->where('user_id', $id)
            // ->whereNotNull('date_approved')
            ->orderBy('id','ASC')
            ->first();
            // dd($items2);

        $message = "success return";
        return mainResponse(true, $message, $items2, 200, 'items', '');
    }


    public function createItemDocument(Request $request)
    {

      // dd($request->all());

        $id = auth('sanctum')->id();

        $user = auth('sanctum')->user();

         $rules = [
             "rfp_id" => 'required',
             // "approve_id" => 'required',
          ];

         $validator = Validator::make($request->all(), $rules,);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

                $approve = Approve::where('user_id',$id)->where('rfp_id', $request->rfp_id)->where('type','vendorTeam')->first();
                // dd($approve)


                $item = Document::where('user_id',$id)->where('rfp_id', $request->rfp_id)->where('type','vendorTeam')->where('criteria_id',$request->criteria_id)->first();
                
                if($item && $item != ''){
                   $item = $item; 
                }else{
                    $item = New Document();
                }


                $item->rfp_id = $request->rfp_id; 
                $item->approve_id = $approve->id;
                // if($request->has('approve')){
                    $item->approve = $request->approve;
                // } 
                $item->criteria_id = $request->criteria_id; 
                $item->type = 'vendorTeam';
                $item->user_id = $id;


                if ($request->hasFile('file') && $request->file('file')->isValid()) {
                    $destinationPath = public_path('uploads/approve');
                    $extension = strtolower($request->file('file')->getClientOriginalExtension());
                    $fileName = uniqid() . '.' . $extension;
                    $request->file('file')->move($destinationPath, $fileName);
                    $item->file = 'uploads/approve/' . $fileName;
                }

                $item->save();



                // $approve = Approve::where('id',$request->approve_id)->first();
                // $approve->status = 'Completed';
                // $approve->save();


                $message ="The Operation Done successfully";
                return mainResponse(true, $message , $item, 200, 'items','');

               



       
        }

    }



  

    

}