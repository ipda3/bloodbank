@extends('layouts.app')
@section('page_title')
   إعدادات الموقع
@endsection

@section('content')


    <section class="content">

        <div class="box">

            <div class="box-header with-border">

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                {!! Form::model($model,[
                'action' => ['SettingController@update',$model->id],
                'method' => 'put'
                ]) !!}
                @include('partials.validation_errors')
                @include('flash::message')
                <div class="form-group">
                    <label for="name">رابط فيس بوك</label>
                    {!! Form::text('facebook_url',null,[
                    'class' => 'form-control'
                 ]) !!}

                    <label for="name">رابط تويتر</label>
                    {!! Form::text('twitter_url',null,[
                    'class' => 'form-control'
                 ]) !!}

                    <label for="name">رابط يوتيوب</label>
                    {!! Form::text('youtube_url',null,[
                    'class' => 'form-control'
                 ]) !!}

                    <label for="name">رابط انستجرام</label>
                    {!! Form::text('instagram_url',null,[
                    'class' => 'form-control'
                 ]) !!}

                    <label for="name">رابط جوجل بلس</label>
                    {!! Form::text('google_url',null,[
                    'class' => 'form-control'
                 ]) !!}

                    <label for="name">واتس اب</label>
                    {!! Form::text('whatsapp',null,[
                    'class' => 'form-control'
                 ]) !!}

                    <hr>

                    <label for="name">الهاتف</label>
                    {!! Form::text('phone',null,[
                    'class' => 'form-control'
                 ]) !!}

                    <label for="name">الإيميل</label>
                    {!! Form::text('email',null,[
                    'class' => 'form-control'
                 ]) !!}

                    <label for="name">عن التطبيق</label>
                    {!! Form::textarea('about_app',null,[
                    'class' => 'form-control'
                 ]) !!}

                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">تعديل</button>
                </div>

                {!! Form::close () !!}
            </div>

        </div>
    </section>
@endsection
