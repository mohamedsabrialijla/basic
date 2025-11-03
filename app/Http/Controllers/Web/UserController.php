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

        if($request->user_type == 'vendor'){

            $validator = Validator::make($request->all(), [
            'company_name'     => 'required|string|max:255',
            'company_cr'       => 'required|string|max:255',
            'company_mobile'   => 'required|numeric|min:8',
            'unit_address'     => 'required|string|max:255',
            'street_address'   => 'required|string|max:255',
            'city_address'     => 'required|string|max:255',
            'zip_address'      => 'required|string|max:20',
            'country_address'  => 'required|string|max:255',
            'services'         => 'required|string|max:255',

            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,' . $item->id,
            'mobile'           => 'required|numeric|min:8|unique:users,mobile,' . $item->id,
            'signee_full_name' => 'required|string|max:255',
            'position'         => 'required|string|max:255',

            'logo'             => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        }else{

            $validator = Validator::make($request->all(), [
                
                'services'         => 'required|string|max:255',
                'name'             => 'required|string|max:255',
                'email'            => 'required|email|unique:users,email,' . $item->id,
                'mobile'           => 'required|numeric|min:8|unique:users,mobile,' . $item->id,
                'position'         => 'required|string|max:255',

                'logo'             => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            ]);

        }

        

        if ($validator->fails()) {
            return mainResponse(false, '', null, 203, 'items', $validator);
        }

        $item = new User;
        $item->company_id       = company_auth_id();
        $item->user_type        = $request->user_type;
        $item->created_by       = $id;

        // Company Info
        $item->company_name     = $request->company_name;
        $item->company_cr       = $request->company_cr;
        $item->company_mobile   = $request->company_mobile;
        $item->unit_address     = $request->unit_address;
        $item->street_address   = $request->street_address;
        $item->city_address     = $request->city_address;
        $item->zip_address      = $request->zip_address;
        $item->country_address  = $request->country_address;

        // Contact Person Info
        $item->name             = $request->name;
        $item->email            = $request->email;
        $item->mobile           = $request->mobile;
        $item->signee_full_name = $request->signee_full_name;
        $item->position         = $request->position;
        $item->services         = $request->services;

        // Password
        $item->password = bcrypt($request->password);
        $item->pwd      = $request->password;

        // Upload logo
        if ($request->hasFile('logo') && $request->file("logo")->isValid()) {
            $destinationPath = public_path('uploads/user');
            $extension = strtolower($request->file("logo")->getClientOriginalExtension());
            $array = $this->image_extensions();

            if (in_array($extension, $array)) {
                $fileName = uniqid() . '.' . $extension;
                $request->file("logo")->move($destinationPath, $fileName);
                $item->logo = 'uploads/user/' . $fileName;
            } else {
                return response()->json(['message' => 'file:jpg,png,jpeg,gif,bmp,pdf', 'code' => 201, 'status' => false]);
            }
        }

        $item->save();

        $message = "success operation";
        return mainResponse(true, $message, $item, 200, 'items', '');
    }


 

    public function edit(Request $request)
    {
        // dd($request->all());

        $id = auth()->id();

        $item = User::findOrFail($request->Item_id);


        if($request->user_type == 'vendor'){

            $validator = Validator::make($request->all(), [
            'company_name'     => 'required|string|max:255',
            'company_cr'       => 'required|string|max:255',
            'company_mobile'   => 'required|numeric|min:8',
            'unit_address'     => 'required|string|max:255',
            'street_address'   => 'required|string|max:255',
            'city_address'     => 'required|string|max:255',
            'zip_address'      => 'required|string|max:20',
            'country_address'  => 'required|string|max:255',
            'services'         => 'required|string|max:255',

            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,' . $item->id,
            'mobile'           => 'required|numeric|min:8|unique:users,mobile,' . $item->id,
            'signee_full_name' => 'required|string|max:255',
            'position'         => 'required|string|max:255',

            'logo'             => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        }else{

            $validator = Validator::make($request->all(), [
                
                'services'         => 'required|string|max:255',
                'name'             => 'required|string|max:255',
                'email'            => 'required|email|unique:users,email,' . $item->id,
                'mobile'           => 'required|numeric|min:8|unique:users,mobile,' . $item->id,
                'position'         => 'required|string|max:255',

                'logo'             => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            ]);

        }

        




        if ($validator->fails()) {
            return mainResponse(false, '', null, 203, 'items', $validator);
        }

        $item->company_id       = company_auth_id();
        $item->user_type        = $request->user_type;
        $item->created_by       = $id;

        // Company Info
        $item->company_name     = $request->company_name;
        $item->company_cr       = $request->company_cr;
        $item->company_mobile   = $request->company_mobile;
        $item->unit_address     = $request->unit_address;
        $item->street_address   = $request->street_address;
        $item->city_address     = $request->city_address;
        $item->zip_address      = $request->zip_address;
        $item->country_address  = $request->country_address;

        // Contact Person Info
        $item->name             = $request->name;
        $item->email            = $request->email;
        $item->mobile           = $request->mobile;
        $item->signee_full_name = $request->signee_full_name;
        $item->position         = $request->position;
        $item->services         = $request->services;

        // Upload logo
        if ($request->hasFile('logo') && $request->file("logo")->isValid()) {
            $destinationPath = public_path('uploads/user');
            $extension = strtolower($request->file("logo")->getClientOriginalExtension());
            $array = $this->image_extensions();

            if (in_array($extension, $array)) {
                $fileName = uniqid() . '.' . $extension;
                $request->file("logo")->move($destinationPath, $fileName);
                $item->logo = 'uploads/user/' . $fileName;
            } else {
                return response()->json(['message' => 'file:jpg,png,jpeg,gif,bmp,pdf', 'code' => 201, 'status' => false]);
            }
        }

        $item->save();

        $message = "success operation";
        return mainResponse(true, $message, $item, 200, 'items', '');
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
            $id = auth('sanctum')->id();

            $items = User::with('department');

            if($request->has('search') && !empty($request->search)) {
                $items->where(function($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                          ->orWhere('email', 'like', '%' . $request->search . '%')
                          ->orWhere('mobile', 'like', '%' . $request->search . '%');
                });
            }


            if($request->has('user_type') && $request->get('user_type') != '') {
                $items->where('user_type', $request->user_type);
                
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
        $items = User::with('department')->where('id',$request->ID)->first();
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