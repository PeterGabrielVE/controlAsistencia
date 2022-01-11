@extends('layouts.app')
@section('title')
<h1 class="nav-title text-white"> <i class="icon icon-documents3 text-blue s-18"></i>
JORNADA</h1>
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
                        <div class="col-md-12 text-right">
                            <div class="form-group">

                            </div>
                        </div>
                    {{-- </div> --}}
                    <form method="GET" action="{{ route('report.filters.jorn') }}">
                        <div class="row mb-4">
                        <div class="form-group col-3 m-0">
                                        {!! Form::label('user', 'Usuario', ['class'=>'col-form-label s-12']) !!}
                                        {!! Form::select('user_id',$users,$user_id ?? null, ['class'=>'form-control r-0 light s-12','id'=>'user_id']) !!}
                                        <span class="descripcion_span"></span>
                                    </div>
                                    <div class="form-group col-3 m-0">
                                        {!! Form::label('since', 'Desde', ['class'=>'col-form-label s-12']) !!}
                                        {!! Form::date('since', $since ?? null, ['class'=>'form-control r-0 light s-12','id'=>'since']) !!}
                                        <span class="descripcion_span"></span>
                                    </div>
                                    <div class="form-group col-3 m-0">
                                        {!! Form::label('until', 'Hasta', ['class'=>'col-form-label s-12']) !!}
                                        {!! Form::date('until', $until ?? null, ['class'=>'form-control r-0 light s-12','id'=>'until']) !!}
                                        <span class="descripcion_span"></span>
                                    </div>
                                    <div class="form-group col-3 m-0 p-2">
                                        <button class="btn btn-info form-control s-12 mt-4" type="submit">Buscar</button>
                                    
                                    </div>
                            
                        </div>
                    </form>
                    <div class="row"> 
                        <div class=" col-12 text-right">
                        <a class="col-sm-2 btn btn-default btn-sm" onclick="exportar(1)" ><img src="{{ asset('/img/excel-ico.png') }}" alt="" heigth= "" style="padding:0px !important" /> {{ __('Exportar Excell') }}</a>
                                <a class="col-sm-2 btn btn-default btn-sm" onclick="exportar(2)"><img src="{{ asset('/img/pdf-icon.png') }}" alt="" heigth= "" style="padding:0px !important" /> {{ __('Exportar PDF') }}</a>
                        </div>
                    </div>
                    <div id="table" class="m-auto table-responsive">
                    <table id="mydatatable" class="table table-bordered table-hover table-sm text-12" data-page-length='100' style="font-size:14px; width: 100%;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th><b>FECHA</b></th>
                                    <th><b>DESDE</b></th>
                                    <th><b>HASTA</b></th>
                                    <th><b>NOMBRE</b></th>
                                    <th><b>IDENTIFICACIÓN</b></th>
                                    <th><b>TURNO</b></th>
                                    <th><b>ENTRADA</b></th>
                                    <th><b>ATRASO</b></th>
                                    <th><b>SALIDA</b></th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @for($i=$inicio; $i<=$final; $i+=86400)

                                        @foreach ($asistencia as $a)

                                            @if(date("d-m-Y", $i) === Carbon\Carbon::parse($a->fecha)->format('d-m-Y'))
                                                <tr class="tbody" @if($a->fecha_entrada == '' || $a->fecha_entrada == null) style="background: #ffe6e6;" @endif>
                                                    <td>{{ date("d-m-Y", $i) }}</td>
                                                    <td>{{ Carbon\Carbon::parse($a->since)->format('d-m-Y') }}</td>
                                                    <td>{{ Carbon\Carbon::parse($a->until)->format('d-m-Y') }}</td>
                                                    <td>{{ $a->first_name }} {{ $a->last_name }}</td>
                                                    <td>{{ $a->rut }}</td>
                                                    <td> @isset($a->turno){{ check_turn($i,$a->turno) }} @endif</td>
                                                    <td>@if($a->fecha_entrada != '')<a target="_blank" href="{{ route('asistencia.edit',$a->marca) }}" class="enlace_marca" title="Mostrar">
                                                        {{ Carbon\Carbon::parse($a->fecha_entrada)->format('g:i:s A') ?? null }}
                                                    </a> @endif </td>
                                                    <td>@if($a->fecha_entrada != ''  && $a->fecha_entrada != null){{ obtener_atraso($i,$a->turno,$a->fecha_entrada) ?? null }} @endif </td>
                                                    <td>@if(isset($a->marca) && $a->marca != '' && $a->marca != null)<a target="_blank"  class="enlace_marca" href="{{ route('asistencia.edit',$a->marca) }}" title="Mostrar">
                                                        {{ obtener_salida($a->marca) }}
                                                    </a>@endif </td>
                                                </tr>

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

function exportar(option){

let urlAjax = {!! json_encode(url('exportJornadaReportPDF')) !!};

if(option == 2){
    urlAjax = {!! json_encode(url('exportJornadaReportPDF')) !!};
}else{
    urlAjax ={!! json_encode(url('exportJornadaReportExcel')) !!};
}


let user_id = $('#user_id').val();
let since = $('#since').val();
let until = $('#until').val();

if(user_id == '' || user_id == null){
    user_id = 0;
}

if(since == '' || since == null){
    since = '01-01-2021';
}

if(until == '' || until == null){
    until = '01-01-2021';
}
window.location.href = `${urlAjax}/${user_id}/${since}/${until}`;

}
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
                   buttons:[],
                   info:true,
                   bLengthChange: true,
                   lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100,"Todos"]],
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
                   },
               } );

   });


</script>
@endsection
