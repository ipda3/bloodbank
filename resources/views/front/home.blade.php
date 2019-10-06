@extends('front.master')
@section('content')
    <!-- Header-->
    <header id="header">
        <div class="container-fluid">
            <div class="header-text">
                <h1 class="head-text">بنك الدم نمضى قدماً لصحة افضل</h1>
                <p class="follow-text">هذا النص هو مثال لنص يمكن أن يستبدل
                    في نفس المساحة،<br> لقد تم توليد هذا النص
                    من مولد النص العرب</p>
                <a href="#">
                    <button class="btn login-btn">المزيد</button>
                </a>
            </div>
        </div>
    </header>
    <section id="about">
        <div class="container-fluid">
            <p class="about-text">بنك الدم هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من
                مولد
                النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى
                يولدها التطبيق.
                يطلع على صورة حقيقية لتصميم الموقع
            </p>
        </div>
    </section>

    <!-- articles -->
    <section id="articles">
        <h2 class="articles-head">المقالات </h2>
        <div class="container custom" style="direction: ltr">
            <div class="owl-carousel owl-theme" id="owl-articles">
                @foreach($posts as $post)
                    <div class="item">
                        <div class="card" style="width: 22rem;">
                            <i id="{{$post->id}}" onclick="toggleFavourite(this)" class="fab fa-gratipay
{{$post->is_favourite ? 'second-heart' : 'first-heart'}}
"></i>
                            <!---<i  class="fab fa-gratipay second-heart"></i>-->

                            <img class="card-img-top" src="{{asset($post->thumbnail)}}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">{{$post->title}}</h5>
                                <p class="card-text">{{$post->content}}</p>
                                <a href="{{url('post/'.$post->id)}}">
                                    <button class="btn details-btn">التفاصيل</button>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
    <h2 class="donations-head horizntal-line">طلبات التبرع </h2>

    <!-- Donations offers  -->
    <section id="donations">
        <div class="container custom-position">
            <div class="row  dropdown">
                <div class="col-md-5">
                    <select class="custom-select">
                        <option selected>اختر فصيلة الدم</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <select class="custom-select">
                        <option selected>اختر المدينة</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="col-md-2 search">
                    <div class="circle search-icon"><i class="fas fa-search search-icon"></i></div>

                </div>

            </div>
            <div class="row background-div ">
                <div class="col-lg-2">
                    <div class="blood-type border-circle">
                        <div class="blood-txt">
                            AB+
                        </div>

                    </div>
                </div>
                <div class="col-lg-7">
                    <ul class="order-details">
                        <li class="cutom-display"> اسم الحالة:</li>
                        <span class="cutom-display">محمد محروس</span> <br>

                        <li class="cutom-display custom-padding"> مستشفي:</li>
                        <span class="cutom-display custom-padding">طوارئ المنصورة</span> <br>
                        <div class="adjust-position">
                            <li class="cutom-display "> المدينة:</li>
                            <span class="cutom-display ">المنصورة</span></div>


                    </ul>

                </div>
                <div class="col-lg-3">
                    <a href="donation-details.html">
                        <button class="btn more2-btn">التفاصيل</button>
                    </a>
                </div>

            </div>
            <div class="row background-div ">
                <div class="col-lg-2">
                    <div class="blood-type border-circle">
                        <div class="blood-txt">
                            AB+
                        </div>

                    </div>
                </div>
                <div class="col-lg-7">
                    <ul class="order-details">
                        <li class="cutom-display"> اسم الحالة:</li>
                        <span class="cutom-display">محمد محروس</span> <br>

                        <li class="cutom-display custom-padding"> مستشفي:</li>
                        <span class="cutom-display custom-padding">طوارئ المنصورة</span> <br>
                        <div class="adjust-position">
                            <li class="cutom-display "> المدينة:</li>
                            <span class="cutom-display ">المنصورة</span></div>


                    </ul>

                </div>
                <div class="col-lg-3">
                    <a href="#">
                        <button class="btn more2-btn">التفاصيل</button>
                    </a>
                </div>

            </div>
            <div class="row background-div ">
                <div class="col-lg-2">
                    <div class="blood-type border-circle">
                        <div class="blood-txt">
                            AB+
                        </div>

                    </div>
                </div>
                <div class="col-lg-7">
                    <ul class="order-details">
                        <li class="cutom-display"> اسم الحالة:</li>
                        <span class="cutom-display">محمد محروس</span> <br>

                        <li class="cutom-display custom-padding"> مستشفي:</li>
                        <span class="cutom-display custom-padding">طوارئ المنصورة</span> <br>
                        <div class="adjust-position">
                            <li class="cutom-display "> المدينة:</li>
                            <span class="cutom-display ">المنصورة</span></div>


                    </ul>

                </div>
                <div class="col-lg-3">
                    <a href="#">
                        <button class="btn more2-btn">التفاصيل</button>
                    </a>
                </div>

            </div>


            <div class="row background-div ">
                <div class="col-lg-2">
                    <div class="blood-type border-circle">
                        <div class="blood-txt">
                            AB+
                        </div>

                    </div>
                </div>
                <div class="col-lg-7">
                    <ul class="order-details">
                        <li class="cutom-display"> اسم الحالة:</li>
                        <span class="cutom-display">محمد محروس</span> <br>

                        <li class="cutom-display custom-padding"> مستشفي:</li>
                        <span class="cutom-display custom-padding">طوارئ المنصورة</span> <br>
                        <div class="adjust-position">
                            <li class="cutom-display "> المدينة:</li>
                            <span class="cutom-display ">المنصورة</span></div>


                    </ul>

                </div>
                <div class="col-lg-3">
                    <a href="#">
                        <button class="btn more2-btn">التفاصيل</button>
                    </a>
                </div>

            </div>
            <a href="donations.html">
                <button class="btn more3-btn">المزيد</button>
            </a>
        </div>
    </section>

    <!-- call us section  -->
    <section id="call-us">
        <h3 class="call-us-head">اتـــصل بنا</h3>
        <P class="call-us-follow-text">يمكنكم الاتصال بنا للاستفسار عن المعلومات وسيتم التواصل معكم فوراً </P>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="whatsup">
                        <p id="number">+002 0124545454</p>
                        <img class="whats-logo" src="{{asset('front/imgs/whats.png')}}">


                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- mobile app   -->
    <section id="mobile-app">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <P class="app-head">تطبيق بنك الدم</P>
                    <P class="app-text">هذا النص هو مثال لنص يمكن ان يستبدل فى نفس المساحه, لقد تم توليد هذا النص من
                        مولد
                        النص العربى</P>
                    <p class="availbale">متـــوفر علي </p>
                    <div class="stores">
                        <img src="{{asset('front/imgs/google.png')}}">
                        <img src="{{asset('front/imgs/ios.png')}}">


                    </div>
                </div>
                <div class="col-md-6">
                    <img class="app image-responsive" src="{{asset('front/imgs/App.png')}}">
                </div>

            </div>

        </div>
    </section>
    @push('scripts')
        <script>
            function toggleFavourite(heart) {
                var post_id = heart.id;
                $.ajax({
                    url : '{{url(route('toggle-favourite'))}}',
                    type: 'post',
                    data: {_token:"{{csrf_token()}}",post_id:post_id},
                    success: function (data) {
                        if (data.status == 1)
                        {
                            console.log(data);
                            var currentClass = $(heart).attr('class');
                            if (currentClass.includes('first')) {
                                $(heart).removeClass('first-heart').addClass('second-heart');
                            } else {
                                $(heart).removeClass('second-heart').addClass('first-heart');
                            }
                        }
                    },
                    error: function (jqXhr, textStatus, errorMessage) { // error callback
                        alert(errorMessage);
                    }
                });
            }
        </script>
    @endpush
@stop