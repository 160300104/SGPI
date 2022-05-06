@extends('dash.index');

@section('styles')
<link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('title')
METODOLOGIA ABC
@endsection

@section('content')
  {{-- Fila 1 --}}
  <div class="row mb-3">
      {{-- Tarjeta 1 --}}
      <div class="col">
          <div class="card bg-success text-white">
              <div class="font-weight-normal card-header text-center bg-success h3">Categoria A </div>
              <div class="card-body">
                  <div class="row align-items-center">
                      <div class="col">
                          <p class=" card-title mb-0"><span id="id_vendidos">Materiales indispensables en almacen.</span></h5>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      {{-- Tarjeta 2 --}}
      <div class="col">
          <div class="card bg-primary text-white">
              <div class="font-weight-normal card-header text-center bg-primary h3">Categoria B</div>
              <div class="card-body">
                  <div class="row align-items-center">
                      <div class="col">
                          <p class=" card-title mb-0"><span id="id_vendidos">Materiales con consumo moderado.</span></h5>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      {{-- Tarjeta 3 --}}
      <div class="col">
          <div class="card bg-info text-white">
              <div class="font-weight-normal card-header text-center bg-info h3">Categoria C</div>
              <div class="card-body">
                  <div class="row align-items-center">
                      <div class="col">
                          <p class=" card-title mb-0"><span id="id_vendidos"></span>Materiales a considerar su rotacion por bajo consumo.</h5>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>


<div class="row mb-3">
  <div class="col-md-2">
    <label>Laborario</label>
    <select class="form-control id_lab" id="id_lab">
      <option value="">Seleccionar...</option>
      @foreach($labs as $lab)
        <option value="{{$lab->id}}">{{$lab->name}}</option>
      @endforeach
    </select>
  </div>  
  <div class="col-md-1 mt-4">
      <button id="filter" class="btn btn-danger">Filtrar</button>
  </div>
</div>


<div class="">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12 mt-3 mb-3">
          <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered tickets_table">
              <thead class="tabla">
                <tr>
                  <th style="width: 10%" scope="col">Materiales</th>
                  <th style="width: 10%" scope="col">Frecuencia de Prestamos</th>
                  <th style="width: 10%" scope="col">% Frec</th>
                  <th style="width: 10%" scope="col">Acumulado Prestamos</th>
                  <th style="width: 10%" scope="col">% Acum</th>
                  <th style="width: 10%" scope="col">Metodologia ABC</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/> -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/datatables.min.css"/> -->
 
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script> -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> -->
<!-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/datatables.min.js"></script> -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script> --}}

<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>

<!-- Datepicker -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- Datatables -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js">
</script>
<!-- Momentjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {

        $(".id_lab").select2();

      const table =  $('.tickets_table').DataTable({
            order: [[ 2, "desc" ]],
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
              url: "{{route('getMetodologia')}}",
              data: function(d){
                  d.id_lab = $('.id_lab').val()
              },

            },
            dataType: 'json',
            type: "POST",
            columns: [{
                    data: 'name',
                    name: 'name'
                },    
                {
                    data: 'frecuencia',
                    name: 'frecuencia'   
                },
                {
                    data: 'porcentaje',
                    name: 'porcentaje'   
                },
                {
                    data: 'acumulado',
                    name: 'acumulado'   
                },
                {
                    data: 'porcentaje_acumulado',
                    name: 'porcentaje_acumulado'   
                },
                {
                    data: 'clasificacion',
                    name: 'clasificacion'   
                },
            ]           
        })

        $('#filter').click(function(){
          table.draw();
        })
    })
</script>
@endsection