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



class ItemsProjectController extends Controller
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
                'code' => [
                    'required',
                    'alpha_num',
                    Rule::unique('items_projects')->where(function ($query) use ($request) {
                        return $query->where('type_id', $request->type_id);
                    }),
                ],
            ];

           



            if ($request->type == 'task') {
                $rules = array_merge($rules, [
                    'duration' => 'required',
                    'drawing_id' => 'required',
                    'standard_id' => 'required',
                    'units_of_measurement_id' => 'required',
                   
                ]);
            }


            if ($request->type == 'activity') {
                $rules = array_merge($rules, [
                    'color' => 'required',
                   
                ]);
            }

           



            foreach ($this->locales as $locale) {
                $rules['name_' . $locale->lang] = 'required';
                // $roles['description_' . $locale->lang] = 'required';
            }


         $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

              
                $item = New ItemsProject;
                $item->company_id = company_auth_id();
                $item->type_id = ItemsTypes::where('name',$request->type)->pluck('id')->first();
                $item->drawing_id = $request->drawing_id;
                $item->standard_id = $request->standard_id;
                $item->units_of_measurement_id = $request->units_of_measurement_id;
                $item->quantity = $request->quantity;
                $item->color = $request->color;
                $item->duration = $request->duration;
                $item->code = $request->code;
               
                $item->created_by = $id;


                 
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


      // dd($request->all());

 
        $id = auth('sanctum')->id();

        $item = ItemsProject::query()->findOrFail($request->Item_id);


      $rules = [
                'type' => 'required',
                 'code' => [
                    'required',
                    'alpha_num',
                    Rule::unique('items_classes_resources', 'code')
                        ->ignore($item->id) // استثناء العنصر الحالي
                        ->where(function ($query) use ($request) {
                            return $query->where('type_id', $request->type_id); // التحقق من type_id
                        }),
                    ],
            ];

            



            if ($request->type == 'task') {
                $rules = array_merge($rules, [
                    'duration' => 'required',
                    'drawing_id' => 'required',
                    'standard_id' => 'required',
                    'units_of_measurement_id' => 'required',
                   
                ]);
            }


            if ($request->type == 'activity') {
                $rules = array_merge($rules, [
                    'color' => 'required',
                   
                ]);
            }

           



            foreach ($this->locales as $locale) {
                $rules['name_' . $locale->lang] = 'required';
                // $roles['description_' . $locale->lang] = 'required';
            }


         $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

              
                $item = ItemsProject::findOrFail($request->Item_id);
                $item->company_id = company_auth_id();
                $item->type_id = ItemsTypes::where('name',$request->type)->pluck('id')->first();
                $item->drawing_id = $request->drawing_id;
                $item->standard_id = $request->standard_id;
                $item->units_of_measurement_id = $request->units_of_measurement_id;
                $item->quantity = $request->quantity;
                $item->color = $request->color;
                $item->duration = $request->duration;
                $item->code = $request->code;
               
                $item->created_by = $id;


                 
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

            $items = ItemsProject::with('type','drawing','standard','unit_of_measurement')->where('company_id', company_auth_id());


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
        $items = ItemsProject::with('type','drawing','standard','unit_of_measurement')->where('id',$request->ID)->first();
        $message ="success return";
        return mainResponse(true, $message , $items, 200, 'items',''); 
    }

    public function delete($id)
    {
        if(ItemsProject::where('id',$id)->delete()){
            $message ="success return";
            return mainResponse(true, $message , '', 200, 'items','');
        }else{
            $message ="Error happens";
            return mainResponse(false, $message , '', 203, 'items','');
        }
        
    }

    

}