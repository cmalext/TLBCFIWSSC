@extends('user')
@section('content')
@if($sub == 'add')
@include('template.client_form')
@elseif($sub == 'view')
@include('template.client_profile')
@elseif($sub == 'password')
@include('template.all_password')
@elseif($sub == 'edit')
@include('template.client_edit')
@elseif($sub == 'result')
@include('template.client_result')
@else
@include('template.client')
@endif
@stop