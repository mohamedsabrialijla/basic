<?php

namespace App\Http\Controllers\Web\MasterData;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Language;
use App\Models\ItemsCategories;
use App\Models\CategoryTitle;
use App\Models\CategoryFeature;
use App\Models\ItemsTypes;
use Illuminate\Support\Str;



class ItemsCategoriesController extends Controller
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
       


        $id = auth('sanctum')->id();

        $validator = Validator::make($request->all(), [
          
            'type' => 'required',
        ]);

        foreach ($this->locales as $locale) {
            $roles['name_' . $locale->lang] = 'required';
            // $roles['description_' . $locale->lang] = 'required';
        }


 

        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

 
                
                $item = New ItemsCategories;
                $item->type_id  = ItemsTypes::where('name',$request->type)->pluck('id')->first();;
                $item->created_by = $id;
                $item->slug = Str::slug($request->name_en);
                $item->order = $request->order;
                if($request->users){
                    $item->users = json_encode($request->users);
                }
                
                
             
                foreach ($this->locales as $locale) {
                    $item->translateOrNew($locale->lang)->name = $request->get('name_' . $locale->lang);
                }


                $item->save();

 

                if ($request->type == 'te-criteria') {
                    foreach ($request->forms as $index => $form) {
                        // حفظ العنوان
                        $title = new CategoryTitle();
                        $title->items_category_id = $item->id;
                        $title->title = $form['title'];
                        $title->order = $item->order . '.' . ($index + 1);
                        $title->save(); 

                        // حفظ features
                        foreach ($form['features'] as $key => $featureData) {
                            $feature = new CategoryFeature();
                            $feature->items_category_id = $item->id;
                            $feature->title_id = $title->id;
                            $feature->name= $featureData['name']; 
                            $feature->value = $form['features_value'][$key]['number'] ?? null; 
                            $feature->save();
                        }
                    }
                }


                $message ="success Doing";
                return mainResponse(true, $message , $item, 200, 'items','');

               

       
        }
    }



    public function edit(Request $request)
    {
        // dd($request->all());
      
        $id = auth('sanctum')->id();
        $item = ItemsCategories::query()->findOrFail($request->Item_id);


        $validator = Validator::make($request->all(), [
            // 'code' => [
            // 'required',
            // 'alpha_num',
            // Rule::unique('items_categories', 'code')
            //     ->ignore($item->id) // استثناء العنصر الحالي
            //     ->where(function ($query) use ($request) {
            //         return $query->where('type_id', $request->type_id); // التحقق من type_id
            //     }),
            // ],
            'type' => 'required',
        ]);

        foreach ($this->locales as $locale) {
            $roles['name_' . $locale->lang] = 'required';
            // $roles['description_' . $locale->lang] = 'required';
        }




        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

 
                
                $item = ItemsCategories::findOrFail($request->Item_id);
                $item->type_id = ItemsTypes::where('name',$request->type)->pluck('id')->first();
                if($request->users){
                    $item->users = json_encode($request->users);
                }
                
                $item->created_by = $id;
                $item->order = $request->order;
                $item->slug = Str::slug($request->name_en);
                
             
                foreach ($this->locales as $locale) {
                    $item->translateOrNew($locale->lang)->name = $request->get('name_' . $locale->lang);
                    // $item->translateOrNew($locale->lang)->description = $request->get('description_' . $locale->lang);
                }


                $item->save();



                 if ($request->type == 'te-criteria' && $request->forms || $request->type == 'te-criteria' &&  $request->forms != '') {

                    CategoryTitle::where('items_category_id',$item->id)->delete();
                    CategoryFeature::where('items_category_id',$item->id)->delete();
                    
                    foreach ($request->forms as $index => $form) {

                        $title = new CategoryTitle();
                        $title->items_category_id = $item->id;
                        $title->title = $form['title'];
                        $title->critiera = $form['critiera'];
                        $title->order = $item->order . '.' . ($index + 1);
                        $title->save(); 


                        if(isset($form['features']) && $form['features'] != ''){
                            foreach ($form['features'] as $key => $featureData) {
                                $feature = new CategoryFeature();
                                $feature->items_category_id = $item->id;
                                $feature->title_id = $title->id;
                                $feature->name= $featureData['name']; 
                                $feature->value = $form['features_value'][$key]['number'] ?? null; 
                                $feature->save();
                            }
                        }
                    }
                }




                $message ="success Doing";
                return mainResponse(true, $message , $item, 200, 'items','');

               

       
        }
    }


    public function getAll(Request $request)
    {

         $id = auth('sanctum')->id();

            $items = ItemsCategories::query()->with('type','features.features_value');


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
                $items = $items->orderBy('order','ASC')->paginate(10); 
            } else {
                $items = $items->orderBy('order','ASC')->get();
            }

            $message = "success return";

            return mainResponse(true, $message, $items, 200, 'items', '');
    }


    public function getAllItemsByType(Request $request)
    {

         $id = auth('sanctum')->id();

            $items = ItemsCategories::query()->with('type');



            if($request->has('type') && !empty($request->type)) {
                $items->whereHas('type', function($query) use ($request) {
                    $query->where('name',$request->type);
                });
            }



                $items = $items->orderBy('order','ASC')->get();
            

            $message = "success return";

            return mainResponse(true, $message, $items, 200, 'items', '');
    }



    public function getById(Request $request)
    {
        $items = ItemsCategories::with('features.features_value')->where('id',$request->ID)->with('type')->first();
        $message ="success return";
        return mainResponse(true, $message , $items, 200, 'items',''); 
    }

    public function delete($id)
    {
        if(ItemsCategories::where('id',$id)->delete()){
            $message ="success return";
            return mainResponse(true, $message , '', 200, 'items','');
        }else{
            $message ="Error happens";
            return mainResponse(false, $message , '', 203, 'items','');
        }
        
    }

    

}