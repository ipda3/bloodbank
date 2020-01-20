@extends('layouts.app')

@section('content')

<div class="box">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>'UserController@store',
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'POST'
                            ])!!}
    <div class="box-body">
        @include('users.form')
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">حفظ</button>
    </div>
    {!! Form::close()!!}
</div>
@stop