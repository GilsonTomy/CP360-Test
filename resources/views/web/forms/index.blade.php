{{-- Load app layout --}}
@extends('web.layouts.app')

{{-- Exetrnal CSS section for the page --}}
@section('externalstyles')
@endsection

{{-- Main content of the pages --}}
@section('main-content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Forms</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">List All Forms</li>
    </ol>
    <div class="card mb-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> Forms List
            </div>
            <div class="card-body">
                <div class="no-footer sortable searchable fixed-columns">
                    <div class="dataTable-top">
                        <div class="dataTable-search">
                            <a href="{{ route('web.forms.create') }}"><button class="btn btn-success">Create Form</button></a>
                        </div>
                    </div>
                    <div class="table">
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
                        <table class="dataTable-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Date Created</th>
                                    <th>Display Order</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(!$resultData->isEmpty())
                                    @php
                                        $i = ($resultData->currentpage()-1)* $resultData->perpage() + 1;

                                    @endphp
                                    @foreach($resultData as $result)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                <b>{{ $result->name }}</b>
                                                <br><a class="btn btn-info" target="_blank" href="{{ route('web.forms.public',['slug'=>$result->form_code]) }}">View Form</a>
                                            </td>
                                            <td>{{ date('d-M-Y H:i A',strtotime($result->created_at)) }}</td>
                                            <td>
                                                <b>Order</b>: <input type="text" value="{{$result->display_order}}" class="form-control table-inputs" name="displayorder{{$i}}" id="displayorder{{$i}}"><a href="#" class="badge bg-danger" onclick="updateOrder({{ $result->id }},{{$i}})">&nbsp;Save</a><br>
                                            </td>
                                            <td>
                                                <b>Status</b>: <input @if($result->status==1){{ 'checked=checked' }}@endif type="radio" id="status{{$result->id}}" name="status{{$result->id}}" onchange="updateStatus({{$result->id}},1)">Active
                                                <input @if($result->status==0){{ 'checked=checked' }}@endif type="radio" id="status{{$result->id}}" name="status{{$result->id}}" onchange="updateStatus({{$result->id}},0)">Inactive
                                            </td>
                                            <td>
                                                <a target="_blank" href="{{ route('web.forms.public',['slug'=>$result->form_code]) }}"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('web.forms.edit',['id'=>$result->id]) }}" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="Edit Form"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('web.forms.delete',['id'=>$result->id]) }}" data-bs-placement="bottom" data-bs-toggle="tooltip-primary" title="Delete Form"><i class="far fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">
                                            <div class="alert bg-danger alert-danger text-white mg-b-0" role="alert">
                                                No records available..
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="dataTable-bottom">
                        @if(!$resultData->isEmpty()){{ $resultData->appends(request()->query())->links('vendor.pagination.simple-bootstrap-4') }}@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Exetrnal scripts for the page --}}
@section('externalscripts')
<script>
    
    function updateStatus(id, status) {
        if (confirm('Are you sure you want to change status?')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post("{{ route('web.forms.status') }}", {
                id: id,
                status: status
            })
            .done(function (data) {
                console.log(data);
                location.reload();
            });
        }else{
            location.reload();
        }
    }

    function updateOrder(id, element) {
        if (confirm('Are you sure you want to update the order?')) {
            var order = $('#displayorder' + element).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                dataType: 'html',
                url: '{{route('web.forms.order')}}',
                data: {'id': id, 'order': order},
                success: function (data) {
                    location.reload();
                }

            });
        }else{
            location.reload();
        }

    }
</script>
@endsection