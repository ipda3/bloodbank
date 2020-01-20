@extends('layouts.app')
@section('content')
    <div class="box box-danger">
        <div class="box-body">
            <div class="pull-right">
                <a href="{{url('admin/user/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> مستخدم جديد
                </a>
            </div>
            <div class="clearfix"></div>
            <br>
            @include('flash::message')
            @if(!empty($users))
                <div class="table-responsive">
                    <table class="data-table table table-bordered">
                        <thead style="background-color: #3C8DBC; color:#ffffff;">
                        <th>#</th>
                        <th>اسم المستخدم</th>
                        <th>الايميل</th>
                        <th>الرتبة</th>
                        <th class="text-center">تعديل</th>
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($users as $user)
                            <tr id="removable{{$user->id}}">
                                <td>{{$count}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="label label-success">{{optional($role)->display_name}}</span>
                                    @endforeach
                                </td>
                                <td class="text-center"><a href="user/{{$user->id}}/edit"
                                                           class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                </td>
                                <td class="text-center">
                                    <button id="{{$user->id}}" data-token="{{ csrf_token() }}"
                                            data-route="{{URL::route('user.destroy',$user->id)}}"
                                            type="button" class="destroy btn btn-danger btn-xs"><i
                                                class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    {!! $users->render() !!}
                </div>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
@stop
