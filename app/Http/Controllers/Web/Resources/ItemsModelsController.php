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



class ItemsModelsController extends Controller
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
                'type_resource_id' => 'required',
                'unit_rate_price' => 'required',
                'logo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'code' => [
                    'required',
                    'alpha_num',
                    Rule::unique('items_models_resources')->where(function ($query) use ($request) {
                        return $query->where('type_id', $request->type_id);
                    }),
                ],
            ];

            // إضافة قواعد حسب نوع `type`
            if ($request->type == 'materials') {
                $rules['units_of_measurement_id'] = 'required';
            }

            if ($request->type != 'equipments') {
                $rules['vendor_id'] = 'required';
            }

            if (in_array($request->type, ['products', 'materials', 'consumables'])) {
                $rules['drawing_id'] = 'required';
            }

            if ($request->type == 'equipments') {
                $rules = array_merge($rules, [
                    'length' => 'required',
                    'weight' => 'required',
                    'calibration_interval' => 'required',
                    'source' => 'required',
                ]);
            }

            if (in_array($request->type, ['materials', 'consumables'])) {
                $rules['sa_supplied'] = 'required';
            }

           




            foreach ($this->locales as $locale) {
                $rules['name_' . $locale->lang] = 'required';
                // $roles['description_' . $locale->lang] = 'required';
            }


         $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

               $class_id = null;
               $category_id = null;

               $class_id = ItemsTypesResource::where('id',$request->type_resource_id)->pluck('class_id')->first();

               if(isset($class_id) && $class_id != ''){

                $category_id = ItemsClassesResource::where('id',$class_id)->pluck('category_id')->first();
               }

 
                
                $item = New ItemsModelsResource;
                $item->company_id = company_auth_id();
                $item->type_id = ItemsTypes::where('name',$request->type)->pluck('id')->first();
                $item->category_id = $category_id ? $category_id: null;
                $item->class_id = $class_id ? $class_id: null;
                $item->type_resource_id = $request->type_resource_id;
                $item->drawing_id = $request->drawing_id;
                $item->vendor_id = $request->vendor_id;
                $item->units_of_measurement_id = $request->units_of_measurement_id;
                $item->unit_rate_price = $request->unit_rate_price;
                $item->sa_supplied = $request->sa_supplied;
                $item->code = $request->code;
                $item->length = $request->length;
                $item->weight = $request->weight;
                $item->source = $request->source;
                $item->calibration_interval = $request->calibration_interval;
                $item->created_by = $id;


                  if($request->hasFile('logo') && $request->file("logo")!='')
                {
                    if ($request->file("logo")->isValid())
                    {
                        $destinationPath=public_path('uploads/items_models_resources/'.$request->type);

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
                if(isset($fileName)){$item->logo='uploads/items_models_resources/'.$request->type.'/'.$fileName;}

                
             
                foreach ($this->locales as $locale) {
                    $item->translateOrNew($locale->lang)->name = $request->get('name_' . $locale->lang);
                    $item->translateOrNew($locale->lang)->description = $request->get('description_' . $locale->lang);
                }


                $item->save();

                $message ="تمت العملية بنجاح";
                return mainResponse(true, $message , $item, 200, 'items','');

               

       
        }
    }
 


    public function edit(Request $request)
    {
      
        $id = auth('sanctum')->id();
        $item = ItemsModelsResource::query()->findOrFail($request->Item_id);



        $rules = [
                'type' => 'required',
                'type_resource_id' => 'required',
                'unit_rate_price' => 'required',
                'logo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                 'code' => [
                    'required',
                    'alpha_num',
                    Rule::unique('items_models_resources', 'code')
                        ->ignore($item->id) // استثناء العنصر الحالي
                        ->where(function ($query) use ($request) {
                            return $query->where('type_id', $request->type_id); // التحقق من type_id
                        }),
                    ],
            ];

            // إضافة قواعد حسب نوع `type`
            if ($request->type == 'materials') {
                $rules['units_of_measurement_id'] = 'required';
            }

            if ($request->type != 'equipments') {
                $rules['vendor_id'] = 'required';
            }

            if (in_array($request->type, ['products', 'materials', 'consumables'])) {
                $rules['drawing_id'] = 'required';
            }

            if ($request->type == 'equipments') {
                $rules = array_merge($rules, [
                    'length' => 'required',
                    'weight' => 'required',
                    'calibration_interval' => 'required',
                    'source' => 'required',
                ]);
            }

            if (in_array($request->type, ['materials', 'consumables'])) {
                $rules['sa_supplied'] = 'required';
            }

           




            foreach ($this->locales as $locale) {
                $rules['name_' . $locale->lang] = 'required';
                // $roles['description_' . $locale->lang] = 'required';
            }


        $validator = Validator::make($request->all(), $rules);
         



        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

                $class_id = ItemsTypesResource::where('id',$request->type_resource_id)->pluck('class_id')->first();

               if(isset($class_id) && $class_id != ''){

                $category_id = ItemsClassesResource::where('id',$class_id)->pluck('category_id')->first();
               }
                
                $item = ItemsModelsResource::findOrFail($request->Item_id);
                $item->company_id = company_auth_id();
                $item->type_id = ItemsTypes::where('name',$request->type)->pluck('id')->first();
                $item->category_id = $category_id ? $category_id: '';
                $item->class_id = $class_id ? $class_id: '';
                $item->type_resource_id = $request->type_resource_id;
                $item->drawing_id = $request->drawing_id;
                $item->vendor_id = $request->vendor_id;
                $item->units_of_measurement_id = $request->units_of_measurement_id;
                $item->unit_rate_price = $request->unit_rate_price;
                $item->sa_supplied = $request->sa_supplied;
                $item->code = $request->code;
                $item->length = $request->length;
                $item->weight = $request->weight;
                $item->source = $request->source;
                $item->calibration_interval = $request->calibration_interval;
                $item->created_by = $id;

                if($request->hasFile('logo') && $request->file("logo")!='')
                {
                    if ($request->file("logo")->isValid())
                    {
                        $destinationPath=public_path('uploads/items_models_resources/'.$request->type);

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
                if(isset($fileName)){$item->logo='uploads/items_models_resources/'.$request->type.'/'.$fileName;}




                
             
                foreach ($this->locales as $locale) {
                    $item->translateOrNew($locale->lang)->name = $request->get('name_' . $locale->lang);
                    $item->translateOrNew($locale->lang)->description = $request->get('description_' . $locale->lang);
                }


                $item->save();

                $message ="تمت العملية بنجاح";
                return mainResponse(true, $message , $item, 200, 'items','');

               

       
        }
    }


    public function getAll(Request $request)
    {

         $id = auth('sanctum')->id();

            $items = ItemsModelsResource::with('type','type_resource')->where('company_id', company_auth_id());


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
        $items = ItemsModelsResource::with('type','type_resource','vendor','unit_of_measurement','drawing')->where('id',$request->ID)->first();
        $message ="success return";
        return mainResponse(true, $message , $items, 200, 'items',''); 
    }

    public function delete($id)
    {
        if(ItemsModelsResource::where('id',$id)->delete()){
            $message ="success return";
            return mainResponse(true, $message , '', 200, 'items','');
        }else{
            $message ="Error happens";
            return mainResponse(false, $message , '', 203, 'items','');
        }
        
    }

    

}