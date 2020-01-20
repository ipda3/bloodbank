@extends('layouts.app')
@section('page_title')
    تعديل مقال
@endsection
@inject('categories','App\Models\Category')
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
                {!! Form::model($model,[
                'action' => ['PostController@update',$model->id],
                'method' => 'put',
                'files'=>   true,
                ]) !!}

                @include('partials.validation_errors')
                <div class="form-group">
                    <div class="form-group">
                        <label for="name">العنوان</label>
                        {!! Form::text('title',null,[
                        'class' => 'form-control'
                     ]) !!}
                    </div>
                    <div class="form-group">
                        <label for="name">المحتوى</label>
                        {!! Form::text('content',null,[
                        'class' => 'form-control'
                     ]) !!}
                    </div>
                    <div class="form-group">
                        <label> اختر صورة : </label><br>
                        <img src="<?php echo asset("$model->thumbnail")?>"/>
                        {!! Form::file('thumbnail',null,[
                        'class' => 'form-control file_upload_preview'
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <label>القسم :</label>
                        {!! Form::select('category_id',$categories->pluck('name','id')->toArray(),null,[
                            'class' => 'form-control'
                         ]) !!}
                    </div>
                    <div class="form-group">
                        <label>تاريخ النشر : </label>
                        {{ Form::date('publish_date', null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit"> حفظ</button>
                </div>

                {!! Form::close () !!}
            </div>

        </div>
    </section>
@endsection
