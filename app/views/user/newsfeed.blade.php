@extends('user')
@section('content')
@if($sub == 'create')
@include('template.newsfeed_create')
@elseif($sub == 'list')
@include('template.newsfeed')
@else
@include('template.billing_filter')
@endif
@stop