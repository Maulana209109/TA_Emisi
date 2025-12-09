@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen bg-gray-100">
        @include("components.admin.aside")
        <div class="flex-1 flex flex-col">
            @include("components.admin.header")
            @include("components.admin.main-content")
        </div>
    </div>  
@endsection
