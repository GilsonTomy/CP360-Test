<?php

namespace App\Http\Controllers\Web;

use App\Models\FormMaster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Validator;

class FormsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('publicForm');;
    }

    public function index(Request $request)
    {
        $whereData = [];
        $resultData = FormMaster::where($whereData)->orderBy('display_order', 'asc')->paginate(10);
        $data = [
            'resultData' => $resultData,
            'pageName' => 'List Forms',
            'active' => 2,
        ];
        return view('web.forms.index', $data);
    }

    public function create()
    {

        $data = [
            'pageName' => 'Create Forms',
            'active' => 3,

        ];
        return view('web.forms.add', $data);

    }

    public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
            'reference_id' => 'nullable',
            'field_type.*' => 'required',
            'field_name.*' => 'required',
        ];

        $messages = [
            'name.required' => Lang::get('validation.required',['attribute'=>'name']),
            'field_type.required' => Lang::get('validation.required',['attribute'=>'field_type']),
            'field_name.required' => Lang::get('validation.required',['attribute'=>'field_name']),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->all());
        }
        $displayOrder = FormMaster::where([])->count();
        $displayOrder++;
        $resultInsrt = FormMaster::create([
            'name' => $request->name,
            'user_id' => Auth::user()->id,
            'status' =>1,
            'display_order' => $displayOrder
        ]);

        if ($resultInsrt) {
            $encryptedFormCode = md5($resultInsrt->id);
            FormMaster::where(['id'=>$resultInsrt->id])->update([
                'form_code' => $encryptedFormCode
            ]);
            if($request->field_type){
                $ordr=1;
                for($i=0;$i<count($request->field_type);$i++){
                    $fieldValuesString = NULL;
                    if(isset($_POST['field_values_'.$request->counter[$i]])){
                        $fieldValuesString = $_POST['field_values_'.$request->counter[$i]];
                    }
                    
                    FormDetail::create([
                        'form_master_id'=>$resultInsrt->id,
                        'field_name' => $request->field_name[$i],
                        'field_type' => $request->field_type[$i],
                        'field_values' => $fieldValuesString ? $fieldValuesString : NULL,
                    ]);
                }
            }
            return redirect()->route('web.forms')->with('successMsg', 'Successfully created.');
        }
        return redirect()->back()->withInput($request->all())->with('errorMsg', 'Unable to process your request. Please try again.');
    }

    public function edit($id)
    {
        $form = FormMaster::where(['id'=>$id])->first();
        if($form){
            $data = [
                'pageName' => 'Edit Forms',
                'resultData' => $form,
                'active' => 3,
    
            ];
            return view('web.forms.edit', $data);
        }else{
            abort('404');
        }
        
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'reference_id' => 'nullable',
            'field_type.*' => 'required',
            'field_name.*' => 'required',
        ];

        $messages = [
            'name.required' => Lang::get('validation.required',['attribute'=>'name']),
            'field_type.required' => Lang::get('validation.required',['attribute'=>'field_type']),
            'field_name.required' => Lang::get('validation.required',['attribute'=>'field_name']),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->all());
        }

        $update_array = [
            'name' => $request->name,
        ];
        $formUpdate = FormMaster::where(['id'=>$id])->update($update_array);
        if ($formUpdate) {
            
            if($request->field_type){
                FormDetail::where(['form_master_id'=>$id])->delete();
                $ordr=1;
                for($i=0;$i<count($request->field_type);$i++){
                    $fieldValuesString = NULL;
                    if(isset($_POST['field_values_'.$request->counter[$i]])){
                        $fieldValuesString = $_POST['field_values_'.$request->counter[$i]];
                    }
                    FormDetail::create([
                        'form_master_id'=>$id,
                        'field_name' => $request->field_name[$i],
                        'field_type' => $request->field_type[$i],
                        'field_values' => $fieldValuesString ? $fieldValuesString : NULL,
                    ]);
                }
            }
            
            return back()->with('successMsg', 'Successfully updated.');
        }
        return redirect()->back()->withInput($request->all())->with('errorMsg', 'Unable to process your request. Please try again.');
    }

    public function destroy($id)
    {
        FormMaster::destroy($id);
        return back()->with('successMsg', 'Successfully deleted.');
    }

    function changeStatus(Request $request){
        $update_array = [
            'status' => $request->status
        ];
        $userData = FormMaster::where(['id'=>$request->id])->update($update_array);
        if ($userData) {
            $request->session()->flash('successMsg', 'Successfully updated.');
        }
    }

    function updateOrder(Request $request){
        $update_array = [
            'display_order' => $request->order
        ];
        $result = FormMaster::where(['id'=>$request->id])->update($update_array);
        if ($result) {
            $request->session()->flash('successMsg', 'Successfully updated.');
        }
    }
}
