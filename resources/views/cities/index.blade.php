@extends('layouts.app')
@section('page_title')
    المدن
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
                <a href="{{url(route('cities.create'))}}" class="btn btn-primary"><i class="fa fa-plus"> </i>أضف مدينة</a>
                @include('flash::message')
                @if(count($records))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">المدينة</th>
                                <th class="text-center">المحافظة</th>
                                <th class="text-center">تعديل</th>
                                <th class="text-center">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr id="removable{{$record->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td class="text-center">{{$record->name}}</td>
                                    <td class="text-center">{{$record->governorate->name}}</td>
                                    <td class="text-center">
                                        <a href="{{url(route('cities.edit',$record->id))}}" class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                data-route="{{URL::route('cities.destroy',$record->id)}}"
                                                type="button" class="destroy btn btn-danger btn-xs"><i
                                                class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                       لا توجد بيانات
                    </div>
                @endif
            </div>

        </div>


    </section>
@endsection
