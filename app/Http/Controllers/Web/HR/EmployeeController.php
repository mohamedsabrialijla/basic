<?php

namespace App\Http\Controllers\Web\HR;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Language;
use App\Models\User;
use App\Models\Employee;
use App\Models\ModelHasRole;
use DB;


class EmployeeController extends Controller
{
  
     public function __construct() {

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
        $id = auth()->id();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'code' => 'required|alpha_num|unique:employees',
            'mobile'=>'required|numeric|min:8|unique:employees',
            'id_number'=>'required|numeric|min:8|unique:employees',
            'position_id' => 'required' ,
            'logo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048'
           
        ]); 




        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

                $item = New Employee;
                $item->company_id = company_auth_id();
                $item->code = $request->code;
                $item->mobile = $request->mobile;
                $item->first_name = $request->first_name;
                $item->middle_name = $request->middle_name;
                $item->last_name = $request->last_name;
                $item->full_name = $request->first_name .' '.$request->middle_name.' '. $request->last_name ;
                $item->id_number = $request->id_number;
                $item->position_id = $request->position_id;
                $item->created_by = $id;
               
                if($request->hasFile('logo') && $request->file("logo")!='')
                {
                    if ($request->file("logo")->isValid())
                    {
                        $destinationPath=public_path('uploads/employee');

                        $extension=strtolower($request->file("logo")->getClientOriginalExtension());
                        $array= $this->image_extensions();
                        if(in_array($extension,$array))
                        {
                            $fileName=uniqid().'.'.$extension;
                            $request->file("logo")->move($destinationPath, $fileName);
                        }else{
                            return response()->json(['message'=> 'file:jpg,png,jpeg,gif,bmp,pdf', 'code'=>201 , 'status'=>false]);
                        }
                    }
                }
                if(isset($fileName)){$item->logo='uploads/employee/'.$fileName;}


                $item->save();


                $message ="success opearation";
                return mainResponse(true, $message , $item, 200, 'items','');
       
        }
    }



    public function edit(Request $request)
    {
         $id = auth()->id();

        $item = Employee::query()->findOrFail($request->Item_id);


        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'code' => 'required|alpha_num|unique:employees,code,' . $item->id, 
            'mobile'=>'required|numeric|min:8|unique:employees,mobile,'. $item->id, 
            'id_number'=>'required|numeric|min:8|unique:employees,id_number,'. $item->id, 
            'position_id' => 'required' ,
            'logo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048'
           
        ]); 




        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

                $item = Employee::findOrFail($request->Item_id);
                $item->company_id = company_auth_id();
                $item->code = $request->code;
                $item->mobile = $request->mobile;
                $item->first_name = $request->first_name;
                $item->middle_name = $request->middle_name;
                $item->last_name = $request->last_name;
                $item->full_name = $request->first_name .' '.$request->middle_name.' '. $request->last_name ;
                $item->id_number = $request->id_number;
                $item->position_id = $request->position_id;
                $item->created_by = $id;
               
                if($request->hasFile('logo') && $request->file("logo")!='')
                {
                    if ($request->file("logo")->isValid())
                    {
                        $destinationPath=public_path('uploads/employee');

                        $extension=strtolower($request->file("logo")->getClientOriginalExtension());
                        $array= $this->image_extensions();
                        if(in_array($extension,$array))
                        {
                            $fileName=uniqid().'.'.$extension;
                            $request->file("logo")->move($destinationPath, $fileName);
                        }else{
                            return response()->json(['message'=> 'file:jpg,png,jpeg,gif,bmp,pdf', 'code'=>201 , 'status'=>false]);
                        }
                    }
                }
                if(isset($fileName)){$item->logo='uploads/employee/'.$fileName;}


                $item->save();

            }
                $message ="success opearation";
                return mainResponse(true, $message , $item, 200, 'items','');
    }
 


    public function getAll(Request $request)
        {
            $id = auth('sanctum')->id();

            $items = Employee::with('position')->where('company_id', company_auth_id());

            if ($request->has('search') && !empty($request->search)) {
                $search = '%' . $request->search . '%';

                $items->where(function ($query) use ($search) {
                    $query->where('code', 'like', $search)  
                          ->orWhere('first_name','like', $search)
                          ->orWhere('middle_name','like', $search)
                          ->orWhere('last_name','like', $search)
                          ->orWhere('mobile','like', $search);
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
        $items = Employee::with('position')->where('id',$request->ID)->first();
        $message ="success return";
        return mainResponse(true, $message , $items, 200, 'items',''); 
    }

    public function delete($id)
    {   
        Employee::where('id',$id)->delete();
        $message ="Ddeleted Item successfully";
        return mainResponse(true, $message , '', 200, 'items','');  
    
    }

    

}