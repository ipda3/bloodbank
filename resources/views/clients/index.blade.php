@extends('layouts.app')

@section('page_title')
    العملاء
@endsection
@section('content')


    <section class="content">

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">كل العملاء</h3>

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
                                    'placeholder' => ' بحث بالاسم ورقم الهاتف والايميل والمدينة'
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
                @include('flash::message')
                @if(count($records))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead style="background-color: #3C8DBC; color:#ffffff;">
                            <tr>
                                <th>#</th>
                                <th>الإسم</th>
                                <th>الإيميل</th>
                                <th>تاريخ الميلاد</th>
                                <th>الهاتف</th>
                                <th>فصيلة الدم</th>
                                <th>اخر تاريخ تبرع بالدم</th>
                                <th>المدينة</th>
                                <th class="text-center">تفعيل / الغاء التفعيل</th>
                                <th class="text-center">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr id="removable{{$record->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$record->name}}</td>
                                    <td>{{$record->email}}</td>
                                    <td>{{$record->birth_date}}</td>
                                    <td>{{$record->phone}}</td>
                                    <td class="text-center"
                                        style="direction: ltr">{{optional($record->bloodType)->name}}</td>
                                    <td>{{$record->donation_last_date}}</td>
                                    <td>{{optional($record->city)->name}}</td>
                                    <td class="text-center">
                                        @if($record->is_active)
                                            <a href="{{url(route('clients.toggle-activation',$record->id))}}"
                                               class="btn btn-danger btn-xs">إلغاء
                                                التفعيل</a>
                                        @else
                                            <a href="{{url(route('clients.toggle-activation',$record->id))}}"
                                               class="btn btn-success btn-xs">تفعيل</a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                data-route="{{URL::route('clients.destroy',$record->id)}}"
                                                type="button" class="destroy btn btn-danger btn-xs"><i
                                                class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <
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


    </section>
@endsection
