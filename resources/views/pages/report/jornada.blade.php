@extends('layouts.app')
<script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKA5z9mjBp51OKJ0Ub2rEZmOf2TDliAnk&libraries=places">
</script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
@section('title')
<h1 class="nav-title text-white"> <i class="icon icon-documents3 text-blue s-18"></i>
MARCAS</h1>
@endsection
@section('maincontent')

@include('pages.report.details')

<div class="page height-full">

    {{-- alerts --}}
    <div class="container-fluid animatedParent animateOnce my-3">
        <div class="animated fadeInUpShort">
            <div class="card">
                <div class="form-group">
                    <div class="card-header white">
                        <h6> LISTA DE MARCAS </h6>
                    </div>
                </div>
                <div class="card-body">
                    {{-- <div class="row text-right"> --}}
                        <div class="col-md-12 text-right">
                            <div class="form-group">

                            </div>
                        </div>
                    {{-- </div> --}}
                    <div id="table" class=" table-responsive">
                    <table id="mydatatable" class="table table-bordered table-hover table-sm text-12" data-page-length='10' style="font-size:14px;">
                            <thead>
                                <tr>
                                    <th><b>FECHA</b></th>
                                    <th><b>DESDE</b></th>
                                    <th><b>HASTA</b></th>
                                    <th><b>NOMBRE</b></th>
                                    <th><b>IDENTIFICACIÓN</b></th>
                                    <th><b>TURNO</b></th>
                                    <th><b>ENTRÓ</b></th>
                                    <th><b>ATRASO</b></th>
                                    <th><b>SALIDA</b></th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @for($i=$inicio; $i<=$final; $i+=86400)

                                        @foreach ($asistencia as $key => $a)

                                                        @if(check_day(date("d-m-Y", $i),$a['user_id']) == true)
                                                        @if(date("d-m-Y", $i) === Carbon\Carbon::parse($a['fecha'])->format('d-m-Y'))
                                                        <tr class="tbody">
                                                            <td>{{ date("d-m-Y", $i) }}</td>
                                                            <td>@isset($a['since']){{ Carbon\Carbon::createFromFormat('Y-m-d', $a['since'])->format('d-m-Y')  }} @endisset</td>
                                                            <td>@isset($a['until']){{ Carbon\Carbon::createFromFormat('Y-m-d',$a['until'])->format('d-m-Y') }}  @endisset</td>
                                                            <td>{{ $a['first_name'] ?? null }} {{ $a['last_name'] ?? null}}</td>
                                                            <td>{{ $a['rut'] ?? null }}</td>
                                                            <td>{{ check_turn($i,$a['planificacion']) ?? null }}</td>
                                                            <td>{{ Carbon\Carbon::parse($a['entrada'])->format('g:i:s A') ?? null }}</td>
                                                            <td>{{ obtener_atraso($i,$a['planificacion'],$a['entrada']) ?? null }}</td>
                                                            <td>{{ Carbon\Carbon::parse($a['salida'])->format('g:i:s A') ?? null }}</td>
                                                        </tr>
                                                        @endif
                                                        @else

                                                        <tr class="tbody">
                                                            <td>{{ date("d-m-Y", $i) }}</td>
                                                            <td>@isset($a['since']){{ Carbon\Carbon::createFromFormat('Y-m-d', $a['since'])->format('d-m-Y')  }} @endisset</td>
                                                            <td>@isset($a['until']){{ Carbon\Carbon::createFromFormat('Y-m-d',$a['until'])->format('d-m-Y') }}  @endisset</td>
                                                            <td>{{ $a['first_name'] ?? null }} {{ $a['last_name'] ?? null}}</td>
                                                            <td>{{ $a['rut'] ?? null }}</td>
                                                            <td>{{ check_turn($i,$a['planificacion']) ?? null }}</td>
                                                            <td>No Trabajo</td>
                                                            <td></td>
                                                            <td>No Trabajo</td>
                                                        </tr>
                                                        @break
                                                        @endif
                                        @endforeach
                                @endfor

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Add New Message Fab Button-->

@endsection
@section('js')
<script>
$(document).ready(function() {

    $('#mydatatable thead tr').clone(true).appendTo( '#mydatatable thead' );
            $('#mydatatable thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );
                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table.column(i).search( this.value ).draw();
                    }
                } );
            } );

       var table = $('#mydatatable').DataTable( {
                   dom: "<'row'><'row'<'col-md-10'l><'col-md-2'B>r>t<'row'<'col-md-4'i>><'row'<'#colvis'>p>",
                   orderCellsTop: true,
                   fixedHeader: true,
                   //dom: 'Blrtip ',
                   buttons: ['excel'],
                   info:true,
                   bLengthChange: true,
                   lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                   order: [],
                   language: {
                       "decimal": "",
                       "emptyTable": "No hay información",
                       "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                       "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                       "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                       "infoPostFix": "",
                       "thousands": ",",
                       "lengthMenu": "Mostrar _MENU_ Entradas",
                       "loadingRecords": "Cargando...",
                       "processing": "Procesando...",
                       "search": "Buscar:",
                       "zeroRecords": "Sin resultados encontrados",
                       "paginate": {
                           "first": "Primero",
                           "last": "Ultimo",
                           "next": "Siguiente",
                           "previous": "Anterior"
                       }
                   }
               } );

   });


</script>
@endsection
