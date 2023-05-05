@extends('buyer::layouts.master')
@section('title',$page->page_name )
@section('content')
<div class="container">
   <div class="mt-2 mb-2">
      <p class="text-center mb-3 h3">{{ @$page->page_name }}</p>
      <div class="mt-2 mb-2">
       {!! @$page->page_description !!}
      </div>
    </div>
</div>

    
@endsection
@section('js')

@endsection
