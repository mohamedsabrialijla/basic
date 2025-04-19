<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Language;
use App\Models\User;
use App\Models\Role;
use App\Models\model_has_roles;
use App\Models\Permission;
use App\Models\role_has_permissions;


use DB;



class LanguageController extends Controller
{
  
     public function __construct() {

        $this->locales = Language::all();
        view()->share([
            'locales' => $this->locales,

        ]);
    }

    

    public function getAllItems(Request $request)
    {
        $items = Language::where('status','active')->get();  
        
        $message ="success return";
        return mainResponse(true, $message , $items, 200, 'items','');
    }


      
    
   
 
        
        
    

    

}