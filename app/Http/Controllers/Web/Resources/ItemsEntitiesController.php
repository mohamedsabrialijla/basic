<?php

namespace App\Http\Controllers\Web\Resources;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Language;
use App\Models\ItemsCategories;
use App\Models\ItemsTypes;
use App\Models\ItemsClassesResource;
use App\Models\ItemsTypesResource;
use App\Models\ItemsModelsResource;
use App\Models\ItemsEntitiesResource;



class ItemsEntitiesController extends Controller
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
                'type' => 'required',
                'model_id' => 'required',
                'units_of_measurement_id' => 'required',
                'manufacture_id' => 'required',
                'date_of_production' => 'required',
                'quantity' => 'required|integer',
                'logo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
             
            ];

            if ($request->type == 'equipments') {
                $rules['serial_no'] = 'required';
                $rules['plat_no'] = 'required';
                $rules['body_no'] = 'required';
                $rules['rent'] = 'required';
                $rules['used'] = 'required';
                $rules['hours'] = 'required';
                $rules['capacity'] = 'required';
                $rules['size'] = 'required';
            }


         $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

               $class_id = null;
               $category_id = null;

               $model = ItemsModelsResource::where('id',$request->model_id)->first();

               if(isset($model) && $model != ''){

                $category_id = $model->category_id;
                $type_resource_id = $model->type_id ;
                $class_id = $model->class_id ;
                $type_id = $model->type_id ;
               }

 
                
                $item = New ItemsEntitiesResource;
                $item->company_id = company_auth_id();
                $item->type_id = $type_id;
                $item->category_id = $category_id ? $category_id: null;
                $item->class_id = $class_id ? $class_id: null;
                $item->type_resource_id = $type_resource_id ? $type_resource_id: null;
                $item->model_id = $request->model_id;
                $item->units_of_measurement_id = $request->units_of_measurement_id;
                $item->manufacture_id = $request->manufacture_id;
                $item->quantity = $request->quantity;
                $item->date_of_production = $request->date_of_production;
                $item->comment = $request->comment;
                if($request->type == 'equipments'){

                    $item->serial_no = $request->serial_no;
                    $item->plat_no = $request->plat_no;
                    $item->body_no = $request->body_no;
                    $item->rent = $request->rent;
                    $item->used = $request->used;
                    $item->hours = $request->hours;
                    $item->capacity = $request->capacity;
                    $item->size = $request->size;
                    $item->created_by = $id;


                      if($request->hasFile('logo') && $request->file("logo")!='')
                    {
                        if ($request->file("logo")->isValid())
                        {
                            $destinationPath=public_path('uploads/items_entities_resources/'.$request->type);

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
                    if(isset($fileName)){$item->logo='uploads/items_entities_resources/'.$request->type.'/'.$fileName;}

                

                }
                
             

                $item->save();

                $message ="تمت العملية بنجاح";
                return mainResponse(true, $message , $item, 200, 'items','');

               

       
        }
    }
 


    public function edit(Request $request)
    {

        $id = auth('sanctum')->id();

      $rules = [
                'type' => 'required',
                'model_id' => 'required',
                'units_of_measurement_id' => 'required',
                'manufacture_id' => 'required',
                'date_of_production' => 'required',
                'quantity' => 'required|integer',
                'logo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
             
            ];

            if ($request->type == 'equipments') {
                $rules['serial_no'] = 'required';
                $rules['plat_no'] = 'required';
                $rules['body_no'] = 'required';
                $rules['rent'] = 'required';
                $rules['used'] = 'required';
                $rules['hours'] = 'required';
                $rules['capacity'] = 'required';
                $rules['size'] = 'required';
            }


         $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

               $class_id = null;
               $category_id = null;

               $model = ItemsModelsResource::where('id',$request->model_id)->first();

               if(isset($model) && $model != ''){

                $category_id = $model->category_id;
                $type_resource_id = $model->type_id ;
                $class_id = $model->class_id ;
                $type_id = $model->type_id ;
               }

 
                
                $item = ItemsEntitiesResource::findOrFail($request->Item_id);
                $item->company_id = company_auth_id();
                $item->type_id = $type_id;
                $item->category_id = $category_id ? $category_id: null;
                $item->class_id = $class_id ? $class_id: null;
                $item->type_resource_id = $type_resource_id ? $type_resource_id: null;
                $item->model_id = $request->model_id;
                $item->units_of_measurement_id = $request->units_of_measurement_id;
                $item->manufacture_id = $request->manufacture_id;
                $item->quantity = $request->quantity;
                $item->date_of_production = $request->date_of_production;
                $item->comment = $request->comment;
                if($request->type == 'equipments'){

                    $item->serial_no = $request->serial_no;
                    $item->plat_no = $request->plat_no;
                    $item->body_no = $request->body_no;
                    $item->rent = $request->rent;
                    $item->used = $request->used;
                    $item->hours = $request->hours;
                    $item->capacity = $request->capacity;
                    $item->size = $request->size;
                    $item->created_by = $id;


                      if($request->hasFile('logo') && $request->file("logo")!='')
                    {
                        if ($request->file("logo")->isValid())
                        {
                            $destinationPath=public_path('uploads/items_entities_resources/'.$request->type);

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
                    if(isset($fileName)){$item->logo='uploads/items_entities_resources/'.$request->type.'/'.$fileName;}

                

                }
                
             

                $item->save();

                $message ="تمت العملية بنجاح";
                return mainResponse(true, $message , $item, 200, 'items','');
            }
    }


    public function getAll(Request $request)
    {

         $id = auth('sanctum')->id();

            $items = ItemsEntitiesResource::with('model','type_resource')->where('company_id', company_auth_id());


            if($request->has('search') && !empty($request->search)) {
                $items->where(function($query) use ($request) {
                    $query->whereTranslationLike('name','%'.$request->search.'%')
                          ->orWhereTranslationLike('description', '%' . $request->search . '%');
                });
            }


            if($request->has('type') && !empty($request->type)) {
                $items->whereHas('type', function($query) use ($request) {
                    $query->where('name',$request->type);
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
        $items = ItemsEntitiesResource::with('type','model','unit_of_measurement','manufacture')->where('id',$request->ID)->first();
        $message ="success return";
        return mainResponse(true, $message , $items, 200, 'items',''); 
    }

    public function delete($id)
    {
        if(ItemsEntitiesResource::where('id',$id)->delete()){
            $message ="success return";
            return mainResponse(true, $message , '', 200, 'items','');
        }else{
            $message ="Error happens";
            return mainResponse(false, $message , '', 203, 'items','');
        }
        
    }

    

}