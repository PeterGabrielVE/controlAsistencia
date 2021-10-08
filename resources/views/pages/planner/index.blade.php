@extends('layouts.app')
@section('title')
<h1 class="nav-title text-white"> <i class="icon icon-documents3 text-blue s-18"></i>PLANIFICADORES</h1>
@endsection
@section('maincontent')

{{-- modal show --}}
@include('pages.position.show')
{{-- modal edit --}}
@include('pages.position.edit')
<div class="page height-full">

    {{-- alerts --}}
    <div class="container-fluid animatedParent animateOnce my-3">
        <div class="animated fadeInUpShort">
            <div class="card">
                <div class="form-group">
                    <div class="card-header white">
                        <h6> LISTA DE PLANIFICADORES </h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row text-right">
                        <div class="col-md-12 text-right">
                            <div class="form-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                AGREGAR NUEVO
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('planificador.create','semanal') }}">Semanal</a>
                                    <a class="dropdown-item" href="{{ route('planificador.create','mensual') }}">Mensual</a>
                                    <a class="dropdown-item" href="{{ route('planificador.create','personalizado') }}">Personalizado</a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="table" class=" table-responsive">
                    <table id="mydatatable" class="table table-bordered table-hover table-sm"
                                data-order='[[ 0, "desc" ]]' data-page-length='100' style="width: 100%;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th><b>DESCRIPCIÓN</b></th>
                                    <th><b>TIPO DE PLANIFICADOR</b></th>
                                    <th><b>ESTADO</b></th>
                                    <th><b>OPCIONES</b></th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach ($planners as $p)
                                <tr class="tbody">
                                    <td>{{ $p->descripcion ?? '' }}</td>
                                    <td>{{ $p->tipo->nombre ?? '' }}</td>
                                    <td>{{ $p->estado($p->Estado) }}</td>
                                    <td class="text-center">
                                    {!! Form::open(['route'=>['planificador.destroy',$p->id],'method'=>'DELETE', 'class'=>'formlDinamic','id'=>'eliminarRegistro']) !!}
                                        <a class="btn btn-default btn-sm" title="Editar" href="{{ route('planificador.edit',$p->id) }}">
                                            <i class="icon-pencil text-info"></i>
                                        </a>
                                        <button class="btn btn-default btn-sm" onclick="return confirm('¿Realmente deseas borrar el registro?')">
                                                <i class="icon-trash-can3 text-danger"></i>
                                            </button>
                                            {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
$(document).ready(function() {
    var table = $('#mydatatable').DataTable( {
                dom: '<"top"i>rt<"bottom"lp><"clear">',
                orderCellsTop: true,
                fixedHeader: true,
                // dom: 'Blrtip ',
                buttons: [],
                info:true,
                bLengthChange: true,
                lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Todos"]],
                order: [[7, 'desc']],
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
