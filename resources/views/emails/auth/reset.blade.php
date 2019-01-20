@component('mail::message')
# Introduction
Blood Bank Reset Password.
<p>Hello {{$user->name}}</p>

<p>Your reset code is : {{$user->pin_code}}</p>
{{--@component('mail::button', ['url' => 'http://ipda3.com','color' => 'success'])--}}
    {{--Reset--}}
{{--@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
