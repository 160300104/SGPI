@extends('dash.index');

@section('styles')
<link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('title')
MATERIALES
@endsection

@section('content')

@can('materials.create')
<div class="seccion_proveedor">
  <a href="{{route('materials.create')}}" class="btn btn-primary proveedor">
    <i class="fa fa-plus"></i>Agregar un Material
  </a>
</div>
<br>
@endcan

<div class="">
  <div class="row">
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-6">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect01">Laboratorio</label>
            </div>
            <select class="custom-select" id="select_std">
              <option value="">Elegir...</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect01">Categoría</label>
            </div>
            <select class="custom-select" id="select_res">
              <option value="">Elegir...</option>
            </select>
          </div>
        </div>
      </div>
      <div>
        <button id="filter" class="btn btn-sm btn-outline-info">Filter</button>
        <button id="reset" class="btn btn-sm btn-outline-warning">Reset</button>
      </div>
      <div class="row">
        <div class="col-md-12 mt-3 mb-3">
          <!-- Table -->
          <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered rounded" id="record_table">
              <thead class="tabla">
                <tr>
                  <th style="width: 10%" scope="col" class="col-1">Imagen</th>
                  <th style="width: 10%" scope="col">Nombre</th>
                  <th style="width: 5%" scope="col">Cantidad</th>
                  <th style="width: 10%" scope="col">Fecha de registro</th>
                  <th style="width: 10%" scope="col">Laborario</th>
                  <th style="width: 10%" scope="col">Categoria</th>
                  <th style="width: 5%" scope="col">Acciones</th>
                </tr>
              </thead>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

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

<script>
  function fetch_std() {
    $.ajax({
      url: "{{ route('standards') }}",
      type: "GET",
      dataType: "json",
      success: function(data) {
        var stdBody = "";
        for (var key in data) {
          stdBody +=
            // `<option value="${data[key]['id_lab']}">${data[key]['id_lab']}</option>`;
            `<option value="${data[key]['id']}">${data[key]['name']}</option>`;
        }
        $("#select_std").append(stdBody);
      }
    });
  }
  fetch_std();

  function fetch_res() {
    $.ajax({
      url: "{{ route('results') }}",
      type: "GET",
      dataType: "json",
      success: function(data) {
        var resBody = "";
        for (var key in data) {
          resBody += `<option value="${data[key]['id']}">${data[key]['name']}</option>`;
        }
        $("#select_res").append(resBody);
      }
    });
  }
  fetch_res();

  // Fetch Records
  function fetch(std, res) {
    $.ajax({
      url: "{{ route('records') }}",
      type: "GET",
      data: {
        std: std,
        res: res
      },
      dataType: "json",
      success: function(data) {
        var i = 1;
        $('#record_table').DataTable({
          "data": data.students,
          "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
          "buttons": [
            {
              extend: 'pdf',
              exportOptions: {
                alignment: 'center',
                columns: [1,2,3,4,5]
              }
            },
            {
              extend: 'csv',
              exportOptions: {
                columns: [1,2,3,4,5]
              }
            },
            {
              extend: 'excel',
              exportOptions: {
                columns: [1,2,3,4,5]
              }
            },
            {
              extend: 'print',
              exportOptions: {
                columns: [1,2,3,4,5]
              }
            },
            {
              extend: 'copy',
              exportOptions: {
                columns: [1,2,3,4,5]
              }
            }
          ],
          "responsive": true,
          "columns": [{
              "data": "Imagen",
              "render": function(data, type, row, meta) {
                return `<img src="/img/materials/${row.image}" width="100%">`;
                // return i++;
              }
            },
            {
              "data": "Nombre",
              "render": function(data, type, row, meta) {
                return `${row.name}`;
                // return i++;
              }
            },
            {
              "data": "Cantidad",
              "render": function(data, type, row, meta) {
                return `${row.quantity}`;
                // return i++;
              }
            },
            {
              "data": "Fecha de registro",
              "render": function(data, type, row, meta) {
                return `${row.register_date}`;
                // return i++;
              }
            },
            {
              "data": "Laborario",
              "render": function(data, type, row, meta) {
                return `${row.lab.name}`;
              }
            },
            {
              "data": "Categoria",
              "render": function(data, type, row, meta) {
                return `${row.category.name}`;

              }
            },
            {
              "data": "Acciones",
              "render": function(data, type, row, meta) {
                var route = `materials/${row.id}`;
                var route2 = `materials/${row.id}/edit`;
                return `
                      @can('materials.edit')
                      <a href="${route2}" class="btn btn-info block">Editar</a> 
                      @endcan
                      
                      @can('materials.destroy')
                      <form action="${route}" method="POST" class="formEliminar">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger block" >Eliminar</button>
                      </form>
                      @endcan`;
              }
            }
          ]
        });
      }
    });
  }
  fetch();

  // Filter
  $(document).on("click", "#filter", function(e) {
    e.preventDefault();
    var std = $("#select_std").val();
    var res = $("#select_res").val();
    if (std !== "" && res !== "") {
      $('#record_table').DataTable().destroy();
      fetch(std, res);
    } else if (std !== "" && res == "") {
      $('#record_table').DataTable().destroy();
      fetch(std, '');
    } else if (std == "" && res !== "") {
      $('#record_table').DataTable().destroy();
      fetch('', res);
    } else {
      $('#record_table').DataTable().destroy();
      fetch();
    }
    console.log("Funciona");
  });

  // Reset
  $(document).on("click", "#reset", function(e) {
    e.preventDefault();
    $("#select_std").html(`<option value="">Elegir...</option>`);
    $("#select_res").html(`<option value="">Elegir...</option>`);
    $('#record_table').DataTable().destroy();
    fetch();
    fetch_std();
    fetch_res();
  });
</script>
@endsection