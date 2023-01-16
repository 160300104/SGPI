@extends('dash.index');

@section('styles')
  <link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
ESTADÍSTICAS
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <form class="form-inline" method="GET">
                <div class="form-group mb-2">
                    <label>Laboratorio</label>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <select name="laboratorio" class="form-control" id="listaLaboratorios">
                        <option  value="">Todos...</option>
                        <?php $i = 1; ?>
                        @foreach($labs_arr as $lab)
                            <option value="{{$i}}">{{$lab}}</option>
                            <?php $i++; ?>
                        @endforeach
                    </select>
                    <input type="submit" value="enviar" class="btn btn-primary ml-2">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <a href="">{{$labsel}}</a>
    {{-- Fila 1 --}}
    <div class="row mb-3">
        {{-- Tarjeta 1 --}}
        <div class="col">
            <div class="card bg-success text-white">
                <div class="font-weight-normal card-header text-center bg-success">Materiales Almacenados</div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col text-center">
                            <i class="fa fa-box fa-4x"></i>
                        </div>
                        <div class="col">
                            <h5 class="h1 card-title mb-0"><span id="id_vendidos"><?= $metrica_mats_almacenados ?></span></h5>
                            {{-- <p class="card-text">Materiales Almacenados</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 2 --}}
        <div class="col">
            <div class="card bg-primary text-white">
                <div class="font-weight-normal card-header text-center bg-primary">Préstamos Activos</div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col text-center">
                            <i class="fa fa-user-clock fa-4x"></i>
                        </div>
                        <div class="col">
                            <h5 class="h1 card-title mb-0"><span id="id_vendidos"><?= $metrica_prestamos_activos ?></span></h5>
                            {{-- <p class="card-text">Préstamos Activos</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 3 --}}
        <div class="col">
            <div class="card bg-info text-white">
                <div class="font-weight-normal card-header text-center bg-info">Materiales en Préstamo</div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col text-center">
                            <i class="fa fa-hand-holding fa-4x"></i>
                        </div>
                        <div class="col">
                            <h5 class="h1 card-title mb-0"><span id="id_vendidos"><?= $metrica_mats_prestamo ?></span></h5>
                            {{-- <p class="card-text">Materiales en Préstamo</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card bg-danger text-white">
                <div class="font-weight-normal card-header text-center bg-danger">Material más solicitado</div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm-3 text-center">
                            <i class="fa fa-star fa-4x"></i>
                        </div>
                        <div class="col">
                            <h6 class="card-title ml-2 mb-1 text-center"><span id="id_vendidos"><?= $mat_destacado ?></span></h5>
                            {{-- <p class="card-text">Material más solicitado</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Fila 2 --}}
    <div class="row mb-3">
        {{-- Gráfica Inventario por Categorías --}}
        <div class="col-md-6">
            <div class="w-100" id="grafica1"></div>
        </div>

        {{-- Gráfica Inventario por Laboratorio --}}
        <div class="col-md-6">
            <div class="w-100" id="grafica2"></div>
        </div>
    </div>

    <div class="row">
        <div id="grafica3"></div>
    </div>
</div>
@endsection

@section('script')
{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

{{-- chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Highcharts --}}
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#listaLaboratorios')
    });
</script>

<script>
Highcharts.chart('grafica1', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Inventario por Categorías'
    },
    colors: ["#90DDF0", "#2C666E"],
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: 'Total',
        colorByPoint: true,
        data: <?= $data ?>
    }]
});

Highcharts.chart('grafica2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Inventario por Laboratorio'
    },
    xAxis: {
        categories: <?= $labs_name ?>
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total'
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -140,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true
            }
        }
    },
    series: [{
        name: 'Herramientas',
        data: <?= $herr_mat_arr ?>
    }, {
        name: 'Consumibles',
        data: <?= $cons_mat_arr ?>
    }]
});

Highcharts.chart('grafica3', {
    title: {
        text: 'Cantidad de Préstamos'
    },
    xAxis: {
        title: {
            text: 'Días'
        },
        categories: <?= $x_pred ?>,
        min: 0,
        max: <?= $x_days+4 ?>,
    },
    yAxis: {
        title: {
        text: 'Total de préstamos'
        },
        min: 0
    },
    tooltip: {
        headerFormat: '<b>Observaciones</b><br/>',
        pointFormat: 'Préstamos: {point.y}'
    },
    series: [{
        type: 'line',
        name: 'Línea de regresión',
        data: <?= $datosPrediccion ?>,
        marker: {
            enabled: true
        },
        states: {
            hover: {
                lineWidth: 0
            }
        },
        enableMouseTracking: true
    }, {
        type: 'scatter', //area
        name: 'Observaciones',
        data: <?= $y ?>,
        // color: '#FF0000',
        marker: {
            radius: 4
        }
    }]
});
</script>
@endsection
