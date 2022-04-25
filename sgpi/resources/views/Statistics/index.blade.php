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








<div id="wrapper" class="container">
    <form class="form" action="{{ route('statistics.store')}}" method="POST">
        @csrf
        <fieldset>
            <div class="row"> 
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="latitud">Latitud</label>
                        <input name="latitud" type="text" id="latitud" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="longitud">Longitud</label>
                        <input name="longitud" type="text" id="longitud" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10"></div>
                        <div class="col-md-2">
                            <button type="submit" id="Cargar coordenadas" class="btn btn-primary">Cargar</button>
                        </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="mapa" style="width: 50%; height: 500px;"></div>
    </div>
</div>

<script>
    function iniciarMapa(){
        var latitud = 21.169039292053693;
        var longitud = -86.84992262268078;

        coordenadas = {
            lng: longitud,
            lat: latitud
        }
 
        generarMapa(coordenadas);
    }

    function generarMapa(coordenadas){
        var mapa = new google.maps.Map(document.getElementById('mapa'),
        {
            zoom: 12,
            center: new google.maps.LatLng(coordenadas.lat, coordenadas.lng)
        });

        marcador= new google.maps.Marker({
            map:mapa,
            draggable: true,
            position: new google.maps.LatLng(coordenadas.lat, coordenadas.lng)
        });

        marcador.addListener('dragend', function(event){
            document.getElementById('latitud').value = this.getPosition().lat();
            document.getElementById('longitud').value = this.getPosition().lng();
        })
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkeBjVUoOZFBL8HiLSJVIEZAghk5-Tn3g&callback=iniciarMapa"></script>
@endsection