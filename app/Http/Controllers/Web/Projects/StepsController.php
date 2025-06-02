<?php

namespace App\Http\Controllers\Web\Projects;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Language;
use App\Models\ItemsTypes;
use App\Models\Step;
use Carbon\Carbon;


 
class StepsController extends Controller
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
                // 'selectedValues' => 'required',  
            
            ];

      

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    return mainResponse(false, '', null, 203, 'items', $validator);
                }

                $project_id = $request->input('project_id');
                $step = $request->input('step');
                $data_json = json_encode($request->all());

                $item = Step::where('project_id', $project_id)->where('step', $step)->first();
                // dd($item);

                if (!$item) {
                    $item = new Step;
                }

                $item->project_id = $project_id;
                $item->step = $step;
                $item->data_json = $data_json;

                $item->save();

                $message ="The Operation Done successfully";
                return mainResponse(true, $message , $item, 200, 'items','');

               

       
        }

    



   


    public function getById(Request $request)
    {
        $items = Step::query()->where('project_id',$request->project_id)->where('step',$request->step)->first();
        $message ="success return";
        return mainResponse(true, $message , $items, 200, 'items',''); 
    }

    

    

}