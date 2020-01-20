@extends('layouts.app')
@inject('donation','App\Models\DonationRequest')
@section('page_title')
    التبرعات
@endsection

@section('content')


    <section class="content">

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">كل التبرعات</h3>

            </div>
            <div class="box-body">
                <div class="filter">
                    {!! Form::open([
                        'method' => 'get'
                    ]) !!}

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::text('keyword',request('keyword'),[
                                    'class' => 'form-control',
                                    'placeholder' => ' بحث بالاسم ورقم الهاتف واسم المستشفى والمدينة'
                                ]) !!}
                            </div>
                        </div>
                        @inject('bloodType','App\Models\BloodType')
                        <div class="col-sm-3">
                            {!! Form::select('blood_type_id',$bloodType->pluck('name','id')->toArray(),request('blood_type_id'),[
                                    'class' => 'select2 form-control',
                                    'placeholder' => 'بحث بفصيلة الدم'
                                ]) !!}
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">بحث</button>
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>

                <div class="box-body">

                    @include('flash::message')
                    @if(count($records))
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead style="background-color: #3C8DBC; color:#ffffff;">
                                <tr>
                                    <th>#</th>
                                    <th>اسم المريض</th>
                                    <th>العمر</th>
                                    <th>عدد أكياس الدم</th>
                                    <th>اسم المستشفى</th>
                                    <th>عنوان المستشفى</th>
                                    <th>الهاتف</th>
                                    <th>المدينة</th>
                                    <th>فصيلة الدم</th>
                                    <th class="text-center">تعديل</th>
                                    <th class="text-center">حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($records as $record)
                                    <tr id="removable{{$record->id}}">
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td class="text-center">{{$record->patient_name}}</td>
                                        <td class="text-center">{{$record->patient_age}}</td>
                                        <td class="text-center">{{$record->bags_num}}</td>
                                        <td class="text-center">{{$record->hospital_name}}</td>
                                        <td class="text-center">{{$record->hospital_address}}</td>
                                        <td class="text-center">{{$record->phone}}</td>
                                        <td class="text-center">{{optional($record->city)->name}}</td>
                                        <td class="text-center">{{optional($record->bloodType)->name}}</td>
                                        <td class="text-center">
                                            <a href="{{url(route('donations.edit',$record->id))}}"
                                               class="btn btn-success btn-xs"><i class="fa fa-edit"></i></a>
                                        </td>
                                        <td class="text-center">
                                            <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                    data-route="{{URL::route('donations.destroy',$record->id)}}"
                                                    type="button" class="destroy btn btn-danger btn-xs"><i
                                                    class="fa fa-trash-o"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                {!! $records->links() !!}
                            </div>
                        </div>
                    @else
                        <div class="col-md-4 col-md-offset-4 text-center alert alert-info bg-blue">
                            لاتوجد اى بيانات
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </section>
@endsection
