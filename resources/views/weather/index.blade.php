@extends('layouts.app')

@section('content');
    <div class="col-md-6 offset-md-3">
        <label class="text-white">Select City you want to know the weather forecast</label>
        <select class="form-control" id="cities">
            <option value="">Select City</option>
            <option value="Tokyo">Tokyo</option>
            <option value="Yokohama">Yokohama</option>
            <option value="Kyoto">Kyoto</option>
            <option value="Sapporo">Sapporo</option>
            <option value="Nagoya">Nagoya</option>
        </select>    

    </div>

    <div class="col-md-12" id="forecasts">
        <div class="row">
            
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('#cities').on('change', function(){
            let city = $(this).val()
            if(city != ''){
                $.ajax({
                    url: `/weather/forecast/${city}`,
                    type: 'get',
                    dataType: 'json',
                    success: function(response){
                        $('#forecasts .row').html(generateUI(response));
                    },
                    error: function(xhr){
                        console.log(xhr.responseText);
                    }
                });
            }else{
                $('#forecasts .row').html('');
            }
        });
    })

    function generateUI(response){
        let forecastCard = ''; 

        $.each(response.forecasts, function(key, value){
            forecastCard += `<div class="col">
                <div class="weather-card ${value.weather.type.toLowerCase()}">
                    <div class="top">
                        <div class="wrapper">
                            <!-- <div class="mynav">
                                <a href="javascript:;"><span class="lnr lnr-chevron-left"></span></a>
                                <a href="javascript:;"><span class="lnr lnr-cog"></span></a>
                            </div> -->
                            <h1 class="heading">${value.weather.type} day</h1>
                            <h3 class="location">${value.date}</h3>
                            <h3 class="location">${value.weather.description}</h3>
                            <h3 class="location">${response.city}</h3>
                            <p class="temp">
                                <span class="temp-value">${value.weather.temp.max}</span>
                                <span class="deg">0</span>
                                <a href="javascript:;"><span class="temp-type">C</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>`;
        });

        return forecastCard;

    }
</script>
@endpush
