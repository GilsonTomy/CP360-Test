{{-- Load app layout --}}
@extends('web.layouts.app')

{{-- Exetrnal CSS section for the page --}}
@section('externalstyles')
@endsection

{{-- Main content of the pages --}}
@section('main-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        
    </div>
@endsection

{{-- Exetrnal scripts for the page --}}
@section('externalscripts')
@endsection
