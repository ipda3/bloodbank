@extends('layouts.app')

@section('page_title')
   العملاء
@endsection
@section('content')


    <section class="content">

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">كل العملا</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @include('flash::message')
                @if(count($records))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الإسم</th>
                                <th>الإيميل</th>
                                <th>تاريخ الميلاد</th>
                                <th>الهاتف</th>
                                <th>فصيلة الدم</th>
                                <th>اخر تاريخ تبرع بالدم</th>
                                <th>المدينة</th>
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
                                    <td>{{optional($record->BloodType)->name}}</td>
                                    <td>{{$record->donation_last_date}}</td>
                                    <td>{{optional($record->city)->name}}</td>

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
                    </div>
                @else
                   <p class="text-center"> لا يوجد عملاء !!</p>
                @endif
            </div>

        </div>


    </section>
@endsection
