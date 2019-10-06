@extends('front.master')
@section('content')

    <!-- breedcrumb-->
    <section id="breedcrumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="Home.html">الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">انشاء حساب جديد</li>
                        </ol>
                    </nav>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12 signup-form">
                    <form class="needs-validation" novalidate>
                        <div class="form-row">


                            <input type="text" class="form-control" id="validationCustom01" placeholder="الاسم"
                                   required>
                            <div class="invalid-feedback">
                                Please provide a valid name.
                            </div>
                            <input type="text" class="form-control" id="validationCustom02"
                                   placeholder="البريد الاكتروني"
                                   value="mazenanwer47@yahoo.com" required>

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="form-row">


                            <input type="text" id="BD" class="form-control" id="validationCustom03"
                                   placeholder="تاريخ الميلاد" required>
                            <span class="calendar-btn"
                                  onclick="pureJSCalendar.open('dd/MM/yyyy',-10, -10, 1, '1800-5-5', '2019-8-20', 'BD', 20)">
                        <i class="fas fa-calendar-alt first-icon"></i>
                        <div id="my-calendar"></div>  
                      </span>

                            <div class="invalid-feedback">
                                Please provide a valid city.
                            </div>


                            <input type="text" class="form-control" id="validationCustom04" placeholder="فصيلة الدم"
                                   required>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                            @inject('governorate','App\Models\Governorate')
                            {!! Form::select('governorate_id',$governorate->pluck('name','id')->toArray(),null,[
                                'class' => 'custom-select custom-select-lg mb-3 mt-3 custom-width',
                                'id' => 'governorates',
                                'placeholder' => 'اختر محافظة'
                            ]) !!}

                            {!! Form::select('city_id',[],null,[
                                'class' => 'custom-select custom-select-lg mb-3 mt-3 custom-width',
                                'id' => 'cities',
                                'placeholder' => 'اختر مدينة'
                            ]) !!}


                            <input type="text" class="form-control" id="validationCustom05" placeholder="رقم الهاتف"
                                   required>
                            <div class="invalid-feedback">
                                Please provide a valid phone number .
                            </div>


                            <input type="text" id="ddd" class="form-control" id="validationCustom03"
                                   placeholder=" اخر تاريخ تبرع" required>
                            <span class="calendar-btn"
                                  onclick="pureJSCalendar.open('dd/MM/yyyy',-10, -10, 1, '1800-5-5', '2019-8-20', 'ddd', 20)">
                        <i class="fas fa-calendar-alt second-icon"></i>
                        <div id="my-calendar"></div>  
                      </span>


                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                                <label class="form-check-label" for="invalidCheck">
                                    Agree to terms and conditions
                                </label>
                                <div class="invalid-feedback">
                                    You must agree before submitting.
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-create shadow" type="submit">انــشاء</button>
                    </form>

                    <script>
                        // Example starter JavaScript for disabling form submissions if there are invalid fields
                        (function () {
                            'use strict';
                            window.addEventListener('load', function () {
                                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                var forms = document.getElementsByClassName('needs-validation');
                                // Loop over them and prevent submission
                                var validation = Array.prototype.filter.call(forms, function (form) {
                                    form.addEventListener('submit', function (event) {
                                        if (form.checkValidity() === false) {
                                            event.preventDefault();
                                            event.stopPropagation();
                                        }
                                        form.classList.add('was-validated');
                                    }, false);
                                });
                            }, false);
                        })();
                    </script>

                </div>

            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            $("#governorates").change(function (e) {
                e.preventDefault();
                // get gov
                // send ajax
                // append cities
                var governorate_id = $("#governorates").val();
                if (governorate_id)
                {
                    $.ajax({
                        url : '{{url('api/v1/cities?governorate_id=')}}'+governorate_id,
                        type: 'get',
                        success: function (data) {
                            if (data.status == 1)
                            {
                                $("#cities").empty();
                                $("#cities").append('<option value="">اختر مدينة</option>');
                                $.each(data.data, function (index, city) {
                                    $("#cities").append('<option value="'+city.id+'">'+city.name+'</option>');
                                });
                            }
                        },
                        error: function (jqXhr, textStatus, errorMessage) { // error callback
                            alert(errorMessage);
                        }
                    });
                }else{
                    $("#cities").empty();
                    $("#cities").append('<option value="">اختر مدينة</option>');
                }
            });
        </script>
    @endpush
@stop