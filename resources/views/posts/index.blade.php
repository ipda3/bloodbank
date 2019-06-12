@extends('layouts.app')
@section('page_title')
    المقالات
@endsection

@section('content')


    <section class="content">

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">إضافة مقال</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <a href="{{url(route('posts.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i> أضف مقال</a>
                @include('flash::message')
                @if(count($records))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">العنوان</th>
                                <th class="text-center">القسم</th>
                                <th class="text-center">المحتوى</th>
                                <th class="text-center">الصورة</th>
                                <th class="text-center">تعديل </th>
                                <th class="text-center">حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr id="removable{{$record->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td class="text-center">{{$record->title}}</td>
                                    <td class="text-center">{{$record->category->name}}</td>
                                    <td class="text-center">{{$record->content}}</td>
                                    <td>
                                        <img src="{{asset('/uploads/' . $record->thumbnail)}}" style="width:200px; height:100px">
                                    </td>

                                    <td class="text-center">
                                        <a href="{{url(route('posts.edit',$record->id))}}" class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        <button id="{{$record->id}}" data-token="{{ csrf_token() }}"
                                                data-route="{{URL::route('posts.destroy',$record->id)}}"
                                                type="button" class="destroy btn btn-danger btn-xs"><i
                                                class="fa fa-trash-o"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center"> لا يوجد اى مقالات</p>
                @endif
            </div>
            <div class="text-center "> {!! $records->links() !!}</div>
        </div>


    </section>
@endsection
