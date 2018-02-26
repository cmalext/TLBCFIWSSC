@extends('user')
@section('content')
@if($sub == 'create')
@include('template.user_create')
@elseif($sub == 'list' || $sub == 'archive')
@include('template.user')
@elseif($sub == 'edit')
@include('template.user_edit')
@elseif($sub == 'password')
@include('template.all_password')
@else
@include('template.user_profile')
@endif
@stop