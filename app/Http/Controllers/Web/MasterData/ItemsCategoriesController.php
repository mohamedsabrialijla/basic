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
use App\Models\ItemsTypes;



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
            // 'code' => [
            // 'required',
            // 'alpha_num',
            //     Rule::unique('items_categories')->where(function ($query) use ($request) {
            //         return $query->where('type_id', $request->type_id);
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

 
                
                $item = New ItemsCategories;
                $item->type_id  = ItemsTypes::where('name',$request->type)->pluck('id')->first();;
                $item->created_by = $id;
                
             
                foreach ($this->locales as $locale) {
                    $item->translateOrNew($locale->lang)->name = $request->get('name_' . $locale->lang);
                }


                $item->save();

                $message ="تمت العملية بنجاح";
                return mainResponse(true, $message , $item, 200, 'items','');

               

       
        }
    }



    public function edit(Request $request)
    {
      
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
                $item->created_by = $id;
                
             
                foreach ($this->locales as $locale) {
                    $item->translateOrNew($locale->lang)->name = $request->get('name_' . $locale->lang);
                    // $item->translateOrNew($locale->lang)->description = $request->get('description_' . $locale->lang);
                }


                $item->save();

                $message ="تمت العملية بنجاح";
                return mainResponse(true, $message , $item, 200, 'items','');

               

       
        }
    }


    public function getAll(Request $request)
    {

         $id = auth('sanctum')->id();

            $items = ItemsCategories::query();


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
        $items = ItemsCategories::where('id',$request->ID)->first();
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