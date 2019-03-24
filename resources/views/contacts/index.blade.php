@extends('layouts.app')
@section('page_title')
    تواصل معنا
@endsection

@section('content')


    <section class="content">

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">كل الرسائل</h3>

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
                                <th class="text-center">العنوان</th>
                                <th class="text-center">الرسالة</th>
                                <th class="text-center">اسم العميل</th>
                                <th class="text-center">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr id="removable{{$record->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td class="text-center">{{$record->title}}</td>
                                    <td class="text-center">{{$record->message}}</td>
                                    <td class="text-center">{{optional($record->client)->name}}</td>

                                    <td class="text-center">
                                        <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                data-route="{{URL::route('contacts.destroy',$record->id)}}"
                                                type="button" class="destroy btn btn-danger btn-xs"><i
                                                class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class='text-center h3'>لا توجد رسائل !!</p>
                @endif
            </div>

        </div>


    </section>
@endsection
