@extends('user')
@section('content')
@if($action == 'view')
@include('template.user_profile')
@elseif($action == 'edit')
@include('template.user_edit')
@else
@include('template.all_password')
@endif
@stop