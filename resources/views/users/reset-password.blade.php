@extends('layouts.app')
@section('page_title')
    تغيير كلمة المرور
@endsection

@section('content')


    <section class="content">

        <div class="box">

            <div class="box-header with-border">

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                {!! Form::open([
                        'action'=>'UserController@changePasswordSave',
                'id'=>'myForm',
                'role'=>'form',
                'method'=>'POST'
                ])!!}


                @include('flash::message')
                @include('partials.validation_errors')
                {{--@include('layouts.partials.validation-errors')--}}
                {{--{!! field()->password('old-password','كلمة المرور الحالية') !!}--}}
                <div class="form-group">
                    <label class="form-control"> كلمة المرور الحالية</label>
                    <input class="form-control" type="password" name="old-password"/>
                </div>
                <div class="form-group">
                    <label class="form-control">كلمة المرور الجديدة</label>
                    <input class="form-control" type="password" name="password"/>
                </div>
                <div class="form-group">
                    <label class="form-control">تأكيد كلمة المرور الجديدة</label>
                    <input class="form-control" type="password" name="password_confirmation"/>
                </div>
                </div>

            <!-- /.box -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
                {!! Form::close()!!}
            </div>
        </div>

    </section>
@endsection
