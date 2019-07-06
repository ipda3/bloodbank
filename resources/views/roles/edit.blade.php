@extends('layouts.app')
@section('page_title')
   تعديل رتبة
@endsection

@section('content')


    <section class="content">

        <div class="box">
            <div class="box-body">
                {!! Form::model($model,[
                'action' => ['RoleController@update',$model->id],
                'method' => 'put'
                ]) !!}
                @include('flash::message')
                @include('partials.validation_errors')
                @include('roles.form')

                {!! Form::close () !!}
            </div>

        </div>
    </section>
@endsection
