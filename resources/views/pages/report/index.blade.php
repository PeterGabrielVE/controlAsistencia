@extends('layouts.app')

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
                <div class="card-body">
                    {{-- <div class="row text-right"> --}}
                        <form method="GET" action="{{ route('report.filters.marcas') }}">
                        <div class="row text-right mb-4">
                                    <div class="form-group col-3 m-0">
                                        {!! Form::label('user', 'Usuario', ['class'=>'col-form-label s-12']) !!}
                                        {!! Form::select('user_id',$users, null, ['class'=>'form-control r-0 light s-12','id'=>'users']) !!}
                                        <span class="descripcion_span"></span>
                                    </div>
                                    <div class="form-group col-3 m-0">
                                        {!! Form::label('since', 'Desde', ['class'=>'col-form-label s-12']) !!}
                                        {!! Form::date('since', null, ['class'=>'form-control r-0 light s-12','id'=>'since']) !!}
                                        <span class="descripcion_span"></span>
                                    </div>
                                    <div class="form-group col-3 m-0">
                                        {!! Form::label('until', 'Hasta', ['class'=>'col-form-label s-12']) !!}
                                        {!! Form::date('until', null, ['class'=>'form-control r-0 light s-12','id'=>'until']) !!}
                                        <span class="descripcion_span"></span>
                                    </div>
                                    <div class="form-group col-3 m-0 p-2">
                                        <button class="btn btn-info form-control s-12 mt-4" type="submit">Buscar</button>
                                      
                                    </div>
                            
                        </div>
                        </form>
                    {{-- </div> --}}
                    <div id="table" class="table-responsive" style="overflow-x:auto;">
                    <table id="mydatatable" class="table table-bordered table-hover table-sm text-12" data-page-length='100' style="font-size:14px;width: 100%;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th><b>NOMBRE</b></th>
                                    <th><b>IDENTIFICACIÓN</b></th>
                                    <th><b>GRUPO</b></th>
                                    <th><b>ENTRADA</b></th>
                                    <th><b>SALIDA</b></th>
                                    <th><b>NOTA</b></th>
                                    @if(Auth::user()->hasRole('super') || Auth::user()->hasRole('jefe')  || Auth::user()->hasRole('supervisor'))
                                        <th></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach ($asistencia as $a)
                                @if(isset($a->fecha))
                                <tr class="tbody">
                                    <td>{{ $a->user->fullname ?? null }} {{ $a->user->last_name ?? null}}</td>
                                    <td>{{ $a->user->rut ?? null }}</td>
                                    <td>{{ $a->user->grupo->group->group ?? null}}</td>
                                    <td>{{ Carbon\Carbon::parse($a->fecha)->format('d-m-Y h:i:s A') ?? null }}</td>
                                    <td>@if(isset($a->fecha_salida)){{ Carbon\Carbon::parse($a->fecha_salida)->format('d-m-Y h:i:s A') }} @endif</td>
                                    <td>{{ $a->note ?? null }}</td>
                                    @if(Auth::user()->hasRole('super') || Auth::user()->hasRole('jefe')  || Auth::user()->hasRole('supervisor'))
                                    <td class="text-center">

                                        {!! Form::open(['route'=>['asistencia.destroy',$a->id],'method'=>'DELETE', 'class'=>'formlDinamic','id'=>'eliminarRegistro']) !!}
                                            <a target="_blank" href="{{ route('asistencia.show',$a->id) }}" class="btn btn-default btn-sm" title="Mostrar">
                                                <i class="icon-eye text-info"></i>
                                            </a>
                                            <a href='{{ route('asistencia.edit',$a->id)}}'class="btn btn-default btn-sm" title="Editar">
                                                <i class="icon-pencil text-info"></i>
                                            </a>
                                            <button class="btn btn-default btn-sm" onclick="return confirm('¿Realmente deseas borrar el registro?')">
                                                    <i class="icon-trash-can3 text-danger"></i>
                                            </button>
                                            {!! Form::close() !!}

                                    </td>
                                    @endif
                                </tr>
                                @endif

                                @endforeach
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

    $('#until').on('click, change', function(){
        $('#since').attr('required', true)
    })

    $('#since').on('click, change', function(){
        $('#until').attr('required', true)
    })

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
                   lengthMenu: [[5, 10, 25, 50,100, -1], [5, 10, 25, 50,100, "Todos"]],
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
