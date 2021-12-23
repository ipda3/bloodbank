@extends('layouts.app')
@section('page_title')
    المحافظات
@endsection

@section('content')


    <section class="content">

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">كل المحافظات</h3>

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
                <div class="box-header">
                    {!! Form::open([
                    'method' => 'get'
                    ]) !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::text('name',request()->input('name'),[
                                'placeholder' => 'اسم المحافظة',
                                'class' => 'form-control'
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="box-header">
                    <a href="{{url(route('governorates.create'))}}" class="btn btn-primary"><i class="fa fa-plus"> </i>
                        إضافة محافظة </a>
                </div>
                @include('flash::message')
                @if(count($records))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead style="background-color: #3C8DBC; color:#ffffff;">
                            <tr>
                                <th>#</th>
                                <th>الإسم</th>
                                <th class="text-center">تعديل</th>
                                <th class="text-center">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr id="removable{{$record->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$record->name}}</td>
                                    <td class="text-center">
                                        <a href="{{url(route('governorates.edit',$record->id))}}"
                                           class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                data-route="{{URL::route('governorates.destroy',$record->id)}}"
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


    </section>
@endsection
