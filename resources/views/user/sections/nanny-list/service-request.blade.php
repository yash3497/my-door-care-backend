@extends('user.layouts.master')

@push('css')
    <style>
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <div class="body-wrapper ">
        <div class="service-request-area pb-120">
            <div class="row justify-content-center">
                <div class="col-lx-8 col-md-10">
                    <div class="service-request-warper">
                        <div class="baby-choice-area">
                            <div class="select-baby-header d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <h3 class="title">{{ __('Select') }}
                                        {{ $nanny->nannyProfession->profession_type == 1 ? __('Baby') : __('Pet') }}<span>*</span>
                                    </h3>
                                </div>
                                <div class="right">
                                    <a href="{{ route('user.add.baby.pet.create') }}" class="btn--base">+
                                        {{ $nanny->nannyProfession->profession_type == 1 ? __('Add Baby') : __('Add Pet') }}</a>
                                </div>
                            </div>
                            <div class="baby-item-area pt-3">
                                <form action="{{ route('user.user_request.submit', $nanny->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="add_baby_pet_id">

                                        @forelse ($myBabyPets as $myBabyPet)
                                            <div class="col-lg-6 col-md-6 pb-20">
                                                <a href="javascript:void(0)" data-id="{{ $myBabyPet->id }}"
                                                    class="get_type_id">
                                                    <div class="baby-item">
                                                        <div class="baby-img">
                                                            <img src="{{ get_image(@$myBabyPet->image, 'add-baby-pet') }}">
                                                        </div>
                                                        <div class="baby-name text-center pt-20">
                                                            <h3 class="title">
                                                                {{ @$myBabyPet->profession_type_details->baby_name ?? @$myBabyPet->profession_type_details->pet_name }}
                                                            </h3>
                                                            <p>{{ @$myBabyPet->profession_type_details->baby_age ?? @$myBabyPet->profession_type_details->pet_age }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @empty
                                            <div class="col-lg-12">
                                                <div class="baybs-data">
                                                    <p>{{ __('Data Not Found !') }}</p>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                            </div>
                            <div class="schedule-area ptb-30">
                                <div class="schedule-hearder ptb-20">
                                    <h3 class="title">{{ __('Schedule') }}<span>*</span></h3>
                                </div>
                                <div class="row">

                                    <div class="col-lg-6 pb-10">
                                        <div class="schedule-date" id="started_date">
                                            <label>{{ __('Start Date') }}<span>*</span></label>
                                            <input type="date" id="StartDate" class="form--control" name="started_date"
                                                min="{{ date('Y-m-d') }}">

                                        </div>
                                    </div>
                                    <div class="col-lg-6 pb-10">
                                        <div class="schedule-date">
                                            <label>{{ __('End Date') }}<span>*</span></label>
                                            <input type="date" name="end_date" id="endDate" class="form--control"
                                                min="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 pb-10">
                                        <div class="schedule-hour">
                                            <label>{{ __('Daily Working Hour') }}<span>*</span></label>
                                            <input type="number" name="daily_working_hour"
                                                class="form--control daily_working_hour" placeholder="Enter working time">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pb-10">
                                        <div class="schedule-time">
                                            <label>{{ __('Started Time') }}<span>*</span></label>
                                            <input type="time" name="started_time" class="form--control"
                                                placeholder="Enter Started Time">
                                        </div>
                                    </div>

                                    <div class="address-area ptb-30">
                                        <div class="address-header">
                                            <h3 class="title">{{ __('Address') }}<span>*</span></h3>
                                        </div>
                                        <div class="address-input">
                                            <textarea type="text" name="address" class="form--control"></textarea>
                                        </div>
                                    </div>
                                    <div class="receipt-area">
                                        <h3 class="title">{{ __('Receipt') }}</h3>
                                        <div class="receipt-item-area pt-2">
                                            <div class="receipt-item ptb-10 d-flex justify-content-between">
                                                <div class="left">
                                                    <h5 class="title">{{ __('Children') }}</h5>
                                                </div>
                                                <div class="right">
                                                    <h5 class="title">1
                                                        {{ $nanny->nannyProfession->profession_type == 1 ? 'Baby' : 'Pet' }}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="receipt-item ptb-10 d-flex justify-content-between">
                                                <div class="left">
                                                    <h5 class="title">{{ __('Service Day') }}</h5>
                                                </div>
                                                <div class="right">
                                                    <h5 class="title service_day">--</h5>
                                                </div>
                                            </div>
                                            <div class="receipt-item ptb-10 d-flex justify-content-between">
                                                <div class="left">
                                                    <h5 class="title">{{ __('Daily Working Hour') }}</h5>
                                                </div>
                                                <div class="right">
                                                    <h5 class="title daily_working_hour_show">--</h5>
                                                </div>
                                            </div>
                                            <div class="receipt-item ptb-10 d-flex justify-content-between">
                                                <div class="left">
                                                    <h5 class="title">{{ __('Total Hours') }}</h5>
                                                </div>
                                                <div class="right">
                                                    <h5 class="title total_hour">--</h5>
                                                </div>
                                            </div>


                                            <div class="receipt-item ptb-10 d-flex justify-content-between">
                                                <div class="left">
                                                    <h5 class="title">{{ __("Nanny's Charge") }}</h5>
                                                </div>
                                                <div class="right">
                                                    <h5 class="title nanny_charge">--</h5>
                                                </div>
                                            </div>

                                            <div class="receipt-item ptb-10 d-flex justify-content-between">
                                                <div class="left">
                                                    <h5 class="title">{{ __('Total') }}</h5>
                                                </div>
                                                <div class="right">
                                                    <h5 class="title total">--</h5>
                                                </div>
                                            </div>
                                            <div class="receipt-item ptb-10 d-flex justify-content-between">
                                                <div class="left">
                                                    <h5 class="title">{{ __('Service Charge') }}</h5>
                                                </div>
                                                <div class="right">
                                                    <h5 class="title service_charge">--</h5>
                                                </div>
                                            </div>

                                            <div class="receipt-item ptb-10 d-flex justify-content-between">
                                                <div class="left">
                                                    <h5 class="title">{{ __('Payable') }}</h5>
                                                </div>
                                                <div class="right">
                                                    <h5 class="title payable">--</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="nanny-request-btn pt-4">
                                        <button type="submit"
                                            class="btn--base w-100">{{ __('Service Request') }}</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('.get_type_id').on('click', function() {
            var id = $(this).data('id');
            $('input[name=add_baby_pet_id]').val(id);
        });

        $("#StartDate").on('change', function() {
            var startDateStr = $("#StartDate").val();
            $("#endDate").attr('min', startDateStr);
        });

        $(document).ready(function() {

            $(".service_day").text(0 + " Day");
            $('.daily_working_hour_show').text(0 + ' hr');
            $('.total_hour').text(0 + ' hr');

            //Default currency code
            let default_currency_code = '@json(get_default_currency_code())';
            default_currency_code = JSON.parse(default_currency_code);
            //Service fees and charge
            let service_charge = '@json($service_charge)';
            service_charge = JSON.parse(service_charge);
            //Nanny charge
            let nanny = '@json($nanny)';
            nanny = JSON.parse(nanny);

            //Culculate day
            function calculateDateDifference() {
                var startDateStr = $("#StartDate").val();
                var endDateStr = $("#endDate").val();

                var startDate = new Date(startDateStr);
                var endDate = new Date(endDateStr);

                if (!isNaN(startDate.getTime()) && !isNaN(endDate.getTime())) {
                    var timeDiff = endDate.getTime() - startDate.getTime();
                    var daysDiff = Math.floor(timeDiff / (1000 * 3600 * 24));
                    var daysDiff = daysDiff + 1;
                    if (daysDiff == 1) {
                        $(".service_day").text(daysDiff + " Day");
                    } else {
                        $(".service_day").text(daysDiff + " Days");
                    }

                } else {
                    $(".service_day").text("");
                }

            }
            $("#startDate, #endDate").on("change", calculateDateDifference);

            //Nanny charge

            //Monthly
            //Weekly
            //Daily
            //Hourly
            if (nanny.nanny_profession.charge == "Hourly") {
                var nanny_charge = nanny.nanny_profession.amount;
            } else if (nanny.nanny_profession.charge == "Daily") {
                var nanny_charge = 1 / nanny.nanny_profession.amount;
            } else if (nanny.nanny_profession.charge == "Weekly") {
                var nanny_charge = 7 / nanny.nanny_profession.amount;
            } else if (nanny.nanny_profession.charge == "Monthly") {
                var nanny_charge = 30 / nanny.nanny_profession.amount;
            }
            $('.nanny_charge').text(parseFloat(nanny_charge).toFixed(4) + "/hr " + default_currency_code);


            //service charge
            $('.service_charge').text(parseFloat(service_charge.fixed_charge).toFixed(4) + " " +
                default_currency_code);


            //Daily working hour
            $('.daily_working_hour').keyup(function() {

                let daily_working_hour = $('.daily_working_hour').val();
                if (isNaN(daily_working_hour) || daily_working_hour == '') {
                    daily_working_hour = 0;
                }
                $('.daily_working_hour_show').text(daily_working_hour + ' hr');
                daily_working_hour = $('.daily_working_hour').val();
                daily_working_hour = parseFloat(daily_working_hour);

                //Service day
                var service_day = $(".service_day").text();
                service_day = parseFloat(service_day)

                //Total hour
                var total_hours = daily_working_hour * service_day;
                total_hours = isNaN(total_hours) ? 0 : total_hours;
                $('.total_hour').text(total_hours + ' ' + 'hr');

                //Nanny charge

                //Monthly
                //Weekly
                //Daily
                //Hourly

                if (nanny.nanny_profession.charge == "Hourly") {
                    var nanny_charge = nanny.nanny_profession.amount;

                } else if (nanny.nanny_profession.charge == "Daily") {
                    var nanny_charge = 1 / nanny.nanny_profession.amount;
                    var nanny_charge = (daily_working_hour * service_day * nanny_charge)

                } else if (nanny.nanny_profession.charge == "Weekly") {
                    var nanny_charge = 7 / nanny.nanny_profession.amount;
                    var nanny_charge = (daily_working_hour * service_day * nanny_charge)

                } else if (nanny.nanny_profession.charge == "Monthly") {
                    var nanny_charge = 30 / nanny.nanny_profession.amount;
                    var nanny_charge = (daily_working_hour * service_day * nanny_charge)
                }
                $('.nanny_charge').text(parseFloat(nanny_charge).toFixed(4) + "/hr " +
                    default_currency_code);


                //Total amount
                var total = total_hours * nanny_charge;
                total = isNaN(total) ? 0 : total;
                $('.total').text(parseFloat(total).toFixed(4) + ' ' + default_currency_code)

                //Service percentage charge
                var service_percentage_charge = (parseFloat(service_charge.percent_charge) / 100) * total;
                //Service fix charge
                var fixed_charge = service_charge.fixed_charge;
                //Total service charge
                var total_charge = service_percentage_charge + parseFloat(fixed_charge);
                $('.service_charge').text(parseFloat(total_charge).toFixed(4) + ' ' +
                    default_currency_code);

                //Total payable
                var payable = total_charge + total;
                $('.payable').text(parseFloat(payable).toFixed(4) + ' ' + default_currency_code);

            });

        })
    </script>
@endpush
