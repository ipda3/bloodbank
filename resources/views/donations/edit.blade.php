@extends('layouts.app')
@section('page_title')
   تعديل التبرع
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
                @include('partials.validation_errors')
                {!! Form::model($model,[
                'action' => ['DonationController@update',$model->id],
                'method' =>'put'
                ]) !!}
                <div class="form-group">
                    <label for="patient_name">اسم المريض</label>
                    {!! Form::text('patient_name',null,[
                        'class'=>'form-control'
                    ]) !!}
                </div>
                <div class="form-group">
                    <label for="patient_age">العمر</label>
                    {!! Form::number('patient_age',null,[
                        'class'=>'form-control'
                    ]) !!}
                </div>

                <div class="form-group">
                    <label for="phone">الهاتف</label>
                    {!! Form::text('phone',null,[
                        'class'=>'form-control'
                    ]) !!}

                    <div class="form-group">
                        <label for="hospital_name">اسم المستشفى</label>
                        {!! Form::text('hospital_name',null,[
                            'class'=>'form-control'
                        ]) !!}
                    </div>

                    <div class="form-group">
                        <label for="hospital_address">عنوان المستشفى</label>
                        {!! Form::text('hospital_address',null,[
                            'class'=>'form-control'
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <label for="notes">ملاحظات</label>
                        {!! Form::textarea('notes',null,[
                            'class'=>'form-control'
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <label for="blood_bags">أكياس الدم</label>
                        {!! Form::number('bags_num',null,[
                            'class'=>'form-control'
                        ]) !!}
                    </div>

                    <div class="form-group">
                        <label for="blood_type">فصيلة الدم</label>
                        {!! Form::select('blood_type_id',$bloodtypes,[],[
                            'class'=>'form-control'
                        ]) !!}
                    </div>

                    <div class="form-group">
                        <label for="city">المدينة</label>
                        {!! Form::select('city_id',$cities,[],[
                            'class'=>'form-control'
                        ]) !!}
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit"> تحديث</button>
                    </div>
                </div>


                {!! Form::close () !!}
            </div>

        </div>
    </section>
@endsection
