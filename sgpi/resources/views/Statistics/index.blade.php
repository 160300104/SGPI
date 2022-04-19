@extends('dash.index');

@section('styles')
  <link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
ESTADÍSTICAS
@endsection

@section('content')
<div class="grid">
    <div class="container">
        <div class="row">
            <div class="col">
                <div id="grafica1"></div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <div id="grafica2"></div>
            </div>
        </div>
    </div>
</div>

<style>
    .grid{
        display: grid;
        grid-template-columns: 2fr 2fr;
    }
</style>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    Highcharts.chart('grafica1', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Inventario por categorías'
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
        data: <?= $data2 ?>
    }]
});
</script>

<script>
Highcharts.chart('grafica2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Inventario por Laboratorio'
    },
    colors: ["#90DDF0", "#2C666E", "#07393C", "#0A090C"],
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
    },

    series: [
        {
            name: "Labs",
            colorByPoint: true,
            data: <?= $data ?>
        }
    ],
    drilldown: {
        breadcrumbs: {
            position: {
                align: 'right'
            }
        },
        series: [
        {
            name: "Browsers",
            colorByPoint: true,
            data: <?= $data ?>
        }
        ]
    }
});
</script>
@endsection
