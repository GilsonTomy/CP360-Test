<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\FormMaster;
use Illuminate\Http\Request;
use App\Models\FormDetail;
use Illuminate\Support\Facades\Lang;
use Validator;

class PublicController extends Controller
{
    function index($slug){
        if($slug){
            $whereData = [
                ['form_code','=',$slug],
                ['status','=',1]
            ];
        }
        $resultData = FormMaster::where($whereData)->orderBy('display_order', 'asc')->first();
        if($resultData){
            $data = [
                'resultData' => $resultData,
                'pageName' => $resultData->name,
                'resultFormFields' => $resultData->form_details()->orderBy('id','asc')->get()
            ];
            return view('web.forms.output-form', $data);
        }else{
            return view('web.forms.not-available');
        }
    }
}
