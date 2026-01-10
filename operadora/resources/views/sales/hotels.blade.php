@extends('layouts.app')

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js" integrity="sha256-Uv9BNBucvCPipKQ2NS9wYpJmi8DTOEfTA/nH2aoJALw=" crossorigin="anonymous"></script>

@section('content')

    <div class="section">
        <div class="container">

            <div class="row">
                <div class="col s12 m5">
                    <input type="text" id="date1" class="datepicker report-dates">
                </div>
                <div class="col s12 m5">
                    <input type="text" id="date2" class="datepicker report-dates2">
                </div>
                <div class="col s12 m2">
                    <div class="input-field">
                        <a href="#!" id="resend" class="btn teal">Enviar</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <h5>Reporte de ventas por Hoteles <br><small>(Se muestran únicamente los 10 hoteles que han tenido mayores ventas  )</small> </h5>
                    <h5>{{ Carbon\Carbon::parse(Illuminate\Support\Facades\Input::get("date1"))->toFormattedDateString() }} - {{ Carbon\Carbon::parse(Illuminate\Support\Facades\Input::get("date2"))->toFormattedDateString() }}</h5>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <canvas id="myChart"></canvas>
                </div>
            </div>

            <div class="row">
                <div class="col s12">

                </div>
            </div>
        </div>
    </div>

    <script>

        (function($){
            $(function(){
                $('.report-dates').datepicker({
                  format: 'yyyy-mm-dd',
                  defaultDate: new Date('{{ Illuminate\Support\Facades\Input::get("date1")  }}'.replace(/-/g, '\/')),
                  setDefaultDate: true,
                  i18n: {
                            months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                            monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                            weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                            weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                            weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"]
                        }
                });
                $('.report-dates2').datepicker({
                  format: 'yyyy-mm-dd',
                  defaultDate: new Date('{{ Illuminate\Support\Facades\Input::get("date2")  }}'.replace(/-/g, '\/')),
                  setDefaultDate: true,
                  i18n: {
                            months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                            monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                            weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                            weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                            weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"]
                        }
                });
            });
        })(jQuery);

        $("#resend").on('click', function(){
            console.log("date 1 "+$("#date1").val());
            console.log("date 2 "+$("#date2").val());
            window.location = "{{ route('sales_hotels') }}"+"?date1="+$("#date1").val()+"&date2="+$("#date2").val();
        });
    </script>
    <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        aspectRatio: 1.5,
        data: {
            // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            labels: {!! $hotels !!},
            datasets: [{
                label: 'Ventas de reservas por hoteles en periodo de tiempo',
                // data: [12, 14, 3, 5, 2],
                data: {!! $totals !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>

@endsection
