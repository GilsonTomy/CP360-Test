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
            <form action="{{ route('web.forms.store') }}" autocomplete="off" id="addForm" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row mg-b-20">
                    <div class="col-md-12">
                        <label>Name<span style="color: red">*</span></label>
                        <input class="form-control" required id="name" name="name" placeholder="Enter a form name" type="text" value="{{ old('name') }}">
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
                                    <div class="row mb-2">
                                        <div class="col-md-5 padd-top">
                                            <label>Field Type<span style="color: red">*</span></label>
                                            <select required class="form-control option-required" onchange="loadCategory(this.value,1);" name="field_type[]" id="field_type1">
                                                <option value="">Select one</option>
                                                <option value="1">Textbox</option>
                                                <option value="2">Textarea</option>
                                                <option value="3">Dropdown(Select box)</option>
                                                <option value="4">Number Field</option>
                                            </select>
                                        </div>
                                        <div class="col-md-5 padd-top">
                                            <label for="field_name1">Field Name<span style="color: red">*</span></label>
                                            <input required class="form-control" id="field_name1" name="field_name[]" placeholder="Enter field name" type="text" value="">
                                        </div>
                                        <div class="col-md-2"></div>
                                        <div class="row mt-2 dynamic-div" id="dynamic-div-1"></div>
                                        <input type="hidden" name="counter[]" id="counter1" value="1"/>
                                    </div>
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
        var x = 1;

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