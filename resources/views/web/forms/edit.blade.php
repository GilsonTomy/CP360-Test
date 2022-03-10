{{-- Load app layout --}}
@extends('web.layouts.app')

{{-- Exetrnal CSS section for the page --}}
@section('externalstyles')
<style>
    /* .dynamic-div{display: none;} */
</style>
@endsection

{{-- Main content of the pages --}}
@section('main-content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Forms</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Enter the form details</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i> Create Form
        </div>
        <div class="card-body">
            @if (session()->get('errorMsg'))
                <div class="alert bg-danger alert-danger text-white mg-b-0" role="alert">
                    {{-- <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button> --}}
                    {{ session()->get('errorMsg') }}
                </div>
            @endif
            @if (session()->get('successMsg'))
                <div class="alert bg-success alert-success text-white mg-b-0" role="alert">
                    {{-- <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button> --}}
                    {{ session()->get('successMsg') }}
                </div>
            @endif
            <form action="{{ route('web.forms.edit',['id'=>$resultData->id]) }}" autocomplete="off" id="editForm" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row mg-b-20">
                    <div class="col-md-12">
                        <label>Name<span style="color: red">*</span></label>
                        <input class="form-control" required id="name" name="name" placeholder="Enter a form name" type="text" value="{{ $resultData->name ? $resultData->name : old('name') }}">
                        @if ($errors->has('name'))
                            <div class="tags mt-1">
                                <span class="tag alert-danger">{{ $errors->first('name') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row mt-2" id="options-grid" >
                    <div class="col-md-12">
                        <div class="form-group">
                            <fieldset style="border: 1px solid #e5e5e5;padding: 0px 10px 15px 10px;background: #f5f5f5;margin-bottom: 5px;">
                                <legend style="font-size: 20px;margin-bottom: 5px;border-bottom:none;">Add Fields
                                    <button type="button" value="Delete" class="btn btn-success ml-2 mb-2 mt-2 add-new">Add<i class="fa fa-plus"></i></button>
                                </legend>
                                @if ($errors->has('options.*')||$errors->has('option_values.*')||$errors->has('quantity.*')||$errors->has('price.*'))
                                    <div class="alert alert-danger" role="alert">
                                        @if($errors->has('field_type.*'))<p>{{ $errors->first('field_type.*') }}</p>@endif
                                        @if($errors->has('field_name.*'))<p>{{ $errors->first('field_name.*') }}</p>@endif
                                        @if($errors->has('field_values.*'))<p>{{ $errors->first('field_values.*') }}</p>@endif
                                    </div>
                                @endif
                                <div id="items">
                                    @php
                                        $formFields = $resultData->form_details()->orderBy('id','asc')->get();
                                    @endphp
                                    @if($formFields)
                                        @php $inrg = 1; @endphp
                                        @foreach($formFields as $vals)
                                            <div class="row mb-2">
                                                <div class="col-md-5 padd-top">
                                                    <label>Field Type<span style="color: red">*</span></label>
                                                    <select required class="form-control option-required" onchange="loadCategory(this.value,{{ $inrg }});" name="field_type[]" id="field_type{{ $inrg }}">
                                                        <option value="">Select one</option>
                                                        <option @if($vals->field_type==1){{ 'selected="selected"' }}@endif value="1">Textbox</option>
                                                        <option @if($vals->field_type==2){{ 'selected="selected"' }}@endif value="2">Textarea</option>
                                                        <option @if($vals->field_type==3){{ 'selected="selected"' }}@endif value="3">Dropdown(Select box)</option>
                                                        <option @if($vals->field_type==4){{ 'selected="selected"' }}@endif value="4">Number Field</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-5 padd-top">
                                                    <label for="field_name{{ $inrg }}">Field Name<span style="color: red">*</span></label>
                                                    <input required class="form-control" id="field_name{{ $inrg }}" name="field_name[]" placeholder="Enter field name" type="text" value="{{ $vals->field_name ? $vals->field_name : NULL }}">
                                                </div>
                                                <div class="col-md-2 form-group padd-top" style="margin-bottom: 0px;margin-top: 25px;"><button type="button" value="Delete" class="btn btn-danger btn-sm icon-btn ml-2 mb-2 remove-item"><i class="fas fa-trash"></i></button></div>
                                                
                                                <div class="row mt-2 dynamic-div" id="dynamic-div-{{ $inrg }}">
                                                    @if($vals->field_type==3)
                                                        <div class="col-md-12 padd-top"><label for="field_values{{ $inrg }}">Option Values(Enter values in comma seperated format. Don't use space before and after each comma. Eg: Apple,Grape,Orange)</label>
                                                            <input required class="form-control" id="field_values_{{ $inrg }}_1" name="field_values_{{ $inrg }}" type="text" value="{{ $vals->field_values ? $vals->field_values : NULL }}">
                                                        </div>
                                                    @endif
                                                </div>
                                                <input type="hidden" name="counter[]" id="counter{{ $inrg }}" value="{{ $inrg }}"/>
                                            </div>
                                            @php $inrg++; @endphp
                                        @endforeach
                                    @endif
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- Exetrnal scripts for the page --}}
@section('externalscripts')
<script type="text/javascript">

    function loadCategory(value,id)
    {
        var optionsVals = '';
        if(value==3){
            optionsVals +='<div class="col-md-12 padd-top"><label for="field_values1">Option Values(Enter values in comma seperated format. Don\'t use space before and after each comma. Eg: Apple,Grape,Orange)</label>'+
                    '<input required class="form-control" id="field_values_'+id+'_1" name="field_values_'+id+'" placeholder="Enter option values" type="text" >'+
                '</div>';
        }

        $('#dynamic-div-'+id).html(optionsVals);

    }
</script>
<script>
    $(document).ready(function () {
        var avail_ingr = '{{ $inrg-1 }}';
        if(avail_ingr>0){
            var x = avail_ingr;
        }else{
            var x = 1; //initlal text box count
        }

        $(".add-new").click(function(e){
            x++;//on add input button click
            e.preventDefault();
            $("#items").append('<div class="row mb-2"><div class="col-md-5 padd-top"><label>Field Type<span style="color: red">*</span></label>'+
                '<select required class="form-control option-required" onchange="loadCategory(this.value,'+x+');" name="field_type[]" id="field_type'+x+'">'+
                    '<option value="">Select one</option><option value="1">Textbox</option><option value="2">Textarea</option><option value="3">Dropdown(Select box)</option><option value="4">Number Field</option>'+
                '</select></div>'+
                '<div class="col-md-5 padd-top"><label for="field_name'+x+'">Field Name<span style="color: red">*</span></label>' +
                '<input type="text" id="field_name'+x+'" class="form-control" name="field_name[]" placeholder="Enter field name">'+
                '</div>' +
                '<div class="col-md-2 form-group padd-top" style="margin-bottom: 0px;margin-top: 25px;"><button type="button" value="Delete" class="btn btn-danger btn-sm icon-btn ml-2 mb-2 remove-item"><i class="fas fa-trash"></i></button></div>' +
                '<div class="row mt-2 dynamic-div" id="dynamic-div-'+x+'"></div>'+
                '<input type="hidden" name="counter[]" id="counter'+x+'" value="'+x+'"/>'+
                '</div>'
            );
        });

        $("#items").on("click",".remove-item", function(e){ //user click on remove field
            e.preventDefault(); $(this).parent().parent('div').remove(); x--;
        });

        
    });
</script>
@endsection