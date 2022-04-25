@extends('dash.index');

@section('styles')
<link href="{{asset('css/provider/style.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('title')
PRESTAMO DE MATERIALES
@endsection

@section('content')

@can('materials.create')
<div class="seccion_proveedor">
  <a href="{{route('loans.create')}}" class="btn btn-primary proveedor">
    <i class="fa fa-plus"></i>  Realizar un prestamo
  </a>
</div>
<br>
@endcan

<div class="">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12 mt-3 mb-3">
          <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered tickets_table">
              <thead class="tabla">
                <tr>
                  <th style="width: 10%" scope="col">Fecha del prestamo</th>
                  <th style="width: 10%" scope="col">Nombre</th>
                  <th style="width: 10%" scope="col">Laborario</th>
                  <th style="width: 10%" scope="col">Encargado</th>
                  <th style="width: 10%" scope="col">Material</th>
                  <th style="width: 5%" scope="col">Cantidad</th>
                  <th style="width: 5%" scope="col">Estado</th>
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
    $(document).ready(function() {

        $('.tickets_table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{route('loans.index')}}",
            dataType: 'json',
            type: "POST",
            columns: [{
                    data: 'loan.loan_date',
                    name: 'loan.loan_date'
                },    
                {
                    data: 'loan.user.name',
                    name: 'loan.user.name'   
                },
                {
                    data: 'loan.lab.name',
                    name: 'loan.lab.name'   
                },
                {
                    data: 'loan.lab.user.name',
                    name: 'loan.lab.user.name'   
                },
                {
                    data: 'material.name',
                    name: 'material.name'   
                },
                {
                    data: 'quantity',
                    name: 'quantity'   
                },
                {
                    data: 'loan.status.name',
                    name: 'loan.status.name'   
                },
            ]           
        });
    })
</script>
@endsection