<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Language;
use App\Models\User;
use App\Models\ModelHasRole;

use DB;



class UserController extends Controller
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
        $user = User::query()->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'=>'required|email|unique:users',
            'mobile'=>'required|numeric|min:8|unique:users',
            'role_id' => 'required' ,
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
            'logo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048'
           
        ]);




        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

                $item = New User;
                $item->company_id = company_auth_id();
                $item->mobile = $request->mobile;
                $item->email = $request->email;
                $item->name = $request->name;
                $item->password = bcrypt($request->password);
                $item->pwd = $request->password;
                $item->role_id = $request->role_id;
                $item->created_by = $id;
               
                if($request->hasFile('logo') && $request->file("logo")!='')
                {
                    if ($request->file("logo")->isValid())
                    {
                        $destinationPath=public_path('uploads/user');

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
                if(isset($fileName)){$item->logo='uploads/user/'.$fileName;}


                $item->save();

                if(isset($request->role_id) && $request->role_id != ''){
                   $role = New ModelHasRole;
                    $role->model_id = $item->id;
                    $role->model_type = 'App\Model\User';
                    $role->role_id = $request->role_id;
                    $role->save(); 
                }
                

                $message ="success opearation";
                return mainResponse(true, $message , $item, 200, 'items','');
       
        }
    }



    public function edit(Request $request)
    {
         $id = auth()->id();
        $user = User::query()->findOrFail($request->Item_id);

       $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|numeric|min:8|unique:users,mobile,' . $user->id,
            'role_id' => 'required',
            // 'logo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048'
        ]);





        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

                $item = User::findOrFail($request->Item_id);
                $item->mobile = $request->mobile;
                $item->email = $request->email;
                $item->name = $request->name;
                $item->role_id = $request->role_id;
                $item->created_by = $id;
               
                if($request->hasFile('logo') && $request->file("logo")!='')
                {
                    if ($request->file("logo")->isValid())
                    {
                        $destinationPath=public_path('uploads/user');

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
                if(isset($fileName)){$item->logo='uploads/user/'.$fileName;}


                $item->save();

                if(isset($request->role_id) && $request->role_id != ''){
                    ModelHasRole::where('model_id',$item->id)->delete();
                   $role = New ModelHasRole;
                    $role->model_id = $item->id;
                    $role->model_type = 'App\Model\User';
                    $role->role_id = $request->role_id;
                    $role->save(); 
                }
                

                $message ="success opearation";
                return mainResponse(true, $message , $item, 200, 'items','');
       
        }
    }


     public function edit_password(Request $request)
    {
         $id = auth()->id();
        $user = User::query()->findOrFail($request->Item_id);

       $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ]);





        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

                $item = User::findOrFail($request->Item_id);
                $item->password = bcrypt($request->password);
                $item->pwd = $request->password;

                $item->save();

                

                $message ="success opearation";
                return mainResponse(true, $message , $item, 200, 'items','');
       
        }
    }


    public function getAll(Request $request)
        {
            // الحصول على ID المستخدم الحالي
            $id = auth('sanctum')->id();

            // استعلام الأساسي لجلب المستخدمين من نفس الشركة
            $items = User::query()->where('company_id', company_auth_id());

            // التحقق من وجود كلمة البحث في الطلب
            if($request->has('search') && !empty($request->search)) {
                // البحث في الحقول المطلوبة (الاسم، الإيميل، الموبايل)
                $items->where(function($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                          ->orWhere('email', 'like', '%' . $request->search . '%')
                          ->orWhere('mobile', 'like', '%' . $request->search . '%');
                });
            }

            // التحقق من وجود صفحة في الطلب (pagination)
            if(isset($request->pagination) && $request->pagination == 1) {
                $items = $items->orderBy('id','DESC')->paginate(10); 
            } else {
                $items = $items->orderBy('id','DESC')->get();
            }

            // رسالة النجاح
            $message = "success return";

            // إعادة النتيجة مع الرد العام
            return mainResponse(true, $message, $items, 200, 'items', '');
        }




    public function getById(Request $request)
    {
        $items = User::query()->where('id',$request->ID)->first();
        $message ="success return";
        return mainResponse(true, $message , $items, 200, 'items',''); 
    }

    public function delete($id)
    {   
        User::where('id',$id)->delete();
        $message ="Ddeleted Item successfully";
        return mainResponse(true, $message , '', 200, 'items','');  
    
    }




    public function getAuth(){

        $id = auth('sanctum')->id();
        $items = User::query()->findOrFail($id);
        $message ="Ddeleted Item successfully";
        return mainResponse(true, $message , $items, 200, 'items','');

    }

    

}