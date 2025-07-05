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

use App\Models\ItemsTechnicals;
use App\Models\CategoryTitleTechnical;
use App\Models\CategoryFeatureTechnical;
use App\Models\ItemsTypes;
use Illuminate\Support\Str;



class ItemsTechnicalsController extends Controller
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

 
                
                $item = New ItemsTechnicals;
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
                        $title = new CategoryTitleTechnical();
                        $title->items_category_id = $item->id;
                        $title->title = $form['title'];
                        $title->order = $item->order . '.' . ($index + 1);
                        $title->save(); 

                        // حفظ features
                        foreach ($form['features'] as $key => $featureData) {
                            $feature = new CategoryFeatureTechnical();
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
        // dd($request->forms);
      
        $id = auth('sanctum')->id();
        $item = ItemsTechnicals::query()->findOrFail($request->Item_id);


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
            // 'type' => 'required',
        ]);

        foreach ($this->locales as $locale) {
            $roles['name_' . $locale->lang] = 'required';
            // $roles['description_' . $locale->lang] = 'required';
        }




        if ($validator->fails()) {
            return mainResponse(false, '' , null, 203, 'items',$validator);
        }else{

 
                
                $item = ItemsTechnicals::findOrFail($request->Item_id);
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



                 if ($request->forms || $request->forms != '') {

                    CategoryTitleTechnical::where('items_technical_id',$item->id)->delete();
                    CategoryFeatureTechnical::where('items_technical_id',$item->id)->delete();
                    
                    foreach ($request->forms as $index => $form) {

                        $title = new CategoryTitleTechnical();
                        $title->items_technical_id = $item->id;
                        $title->title = $form['title'];
                        $title->critiera = $form['critiera'];
                        $title->order = $item->order . '.' . ($index + 1);
                        $title->save(); 


                        if(isset($form['features']) && $form['features'] != ''){
                            foreach ($form['features'] as $key => $featureData) {
                                $feature = new CategoryFeatureTechnical();
                                $feature->items_technical_id = $item->id;
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

            $items = ItemsTechnicals::where('rfp_id',$request->rfp_id)->with('features.features_value');


           


            if(isset($request->pagination) && $request->pagination == 1) {
                $items = $items->orderBy('order','ASC')->paginate(10); 
            } else {
                $items = $items->orderBy('order','ASC')->get();
            }

            $message = "success return";

            return mainResponse(true, $message, $items, 200, 'items', '');
    }


   


    public function getById(Request $request)
    {
        $items = ItemsTechnicals::with('features.features_value')->where('id',$request->ID)->first();
        $message ="success return";
        return mainResponse(true, $message , $items, 200, 'items',''); 
    }

    public function delete($id)
    {
        if(ItemsTechnicals::where('id',$id)->delete()){
            $message ="success return";
            return mainResponse(true, $message , '', 200, 'items','');
        }else{
            $message ="Error happens";
            return mainResponse(false, $message , '', 203, 'items','');
        }
        
    }


    public function withdrow(Request $request){

        $check = ItemsTechnicals::where('rfp_id',$request->ID)->count();

        if(isset($check) && $check > 0){

            return mainResponse(true, 'Founded' , '', 201, 'items',''); 

        }

        $items = ItemsCategories::with('features.features_value')->where('type_id',30)->get();


        foreach ($items as $key => $value) {
            $critiera = New ItemsTechnicals();
            $critiera->rfp_id = $request->ID;
            $critiera->order = $value['order'];
            $critiera->name = $value['name'];
            $critiera->slug = $value['slug'];
            $critiera->save();

            foreach ($value['features'] as $key => $value2) {
                

                $title = New CategoryTitleTechnical();
                $title->rfp_id = $request->ID;
                $title->items_technical_id = $critiera->id;
                $title->title = $value2['title'];
                $title->critiera = $value2['critiera'];
                $title->order = $value2['order'];
                $title->save();

                foreach ($value2['features_value'] as $key => $value3) {
                    
                    $feature = New CategoryFeatureTechnical();
                    $feature->rfp_id = $request->ID;
                    $feature->items_technical_id = $critiera->id;
                    $feature->title_id = $title->id ;
                    $feature->name = $value3['name'];
                    $feature->value = $value3['value'];
                    $feature->save();
                }
            }
        }



        $items = ItemsTechnicals::where('rfp_id',$request->ID)->with('features.features_value')->get();


        $message ="success return";
        return mainResponse(true, $message , $items, 200, 'items',''); 




    }

    

}