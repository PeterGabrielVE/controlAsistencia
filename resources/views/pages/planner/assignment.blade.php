@extends('layouts.app')
@section('title')
<h1 class="nav-title text-white"> <i class="icon icon-documents3 text-blue s-18"></i>PLANIFICADORES</h1>
@endsection
@section('maincontent')

@include('pages.planner.edit_assignment')

<div class="page height-full">

    {{-- alerts --}}
    <div class="container-fluid animatedParent animateOnce my-3">
        <div class="animated fadeInUpShort">
            <div class="card">
                <div class="form-group">
                    <div class="card-header white">
                        <h6>ASIGNACIÓN</h6>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['route'=>'assignment.store','method'=>'POST']) !!}
                    @csrf
                        <div class="form-row m-2">
                            <div class="col-3">
                                {!! Form::label('lbl_user', 'Usuario', ['class'=>'col-form-label s-12']) !!}
							    {!! Form::select('user_id',$users, null, ['class'=>'form-control r-0 s-12 select2','id'=>'user_id', 'onclick'=>'inputClear(this.id)','onchange'=>'check_date("since"),check_date("until")','required']) !!}
                            </div>
                            <div class="col-3">
                                {!! Form::label('lbl_planner', 'Planificador', ['class'=>'col-form-label s-12']) !!}
                                {!! Form::select('planner_id',$planners, null, ['class'=>'form-control r-0 light s-12 select2','id'=>'planner_id', 'onclick'=>'inputClear(this.id)','required','style'=>'padding:20px !important;']) !!}
                            </div>
                            <div class="col-2">
                                {!! Form::label('since', 'Desde', ['class'=>'col-form-label s-12']) !!}
							    {!! Form::date('since',null, ['class'=>'form-control r-0 light s-12',  'id'=>'since', 'onchange'=>'validate_date(),check_date("since")','required']) !!}
                            </div>
                            <div class="col-2">
                                {!! Form::label('until', 'Hasta', ['class'=>'col-form-label s-12']) !!}
                                {!! Form::date('until',null, ['class'=>'form-control r-0 light s-12',  'id'=>'until', 'onchange'=>'validate_date(),check_date("until")','required']) !!}
                                <span class="text-danger m-0 p-0" id="span_until" style="display: none;font-size: 12px;">{{__('La fecha no puede ser menor que la inicial.')}}</span>
                            </div>
                            <div class="col-2 pt-1">
                                <button type="submit" class="btn btn-primary mt-4" id="save"><i class="icon-save mr-2"></i>Guardar</button>
                            </div>
						</div>
                    {!! Form::close() !!}
                    <div class="form-row mt-2">
                        <div id="table" class=" table-responsive">
                            <table id="mydatatable" class="table table-bordered table-hover table-sm"
                                        data-order='[[ 2, "asc" ]]' data-page-length='100' style="width: 100%;border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th><b>USUARIO</b></th>
                                            <th><b>PLANIFICADOR</b></th>
                                            <th><b>DESDE</b></th>
                                            <th><b>HASTA</b></th>
                                            <th><b>OPCIONES</b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                        @foreach ($assignments as $a)
                                        <tr class="tbody">
                                            <td>{{ $a->user->fullname ?? null }} {{ $a->user->last_name ?? null }}</td>
                                            <td>{{ $a->planner->descripcion ?? null }}</td>
                                            <td>{{ Carbon\Carbon::parse($a->since)->format('d-m-Y') ?? null }}</td>
                                            <td>{{ Carbon\Carbon::parse($a->until)->format('d-m-Y') ?? null }}</td>
                                            <td class="text-center">
                                            {!! Form::open(['route'=>['assignment.destroy',$a->id],'method'=>'DELETE', 'class'=>'formlDinamic','id'=>'eliminarRegistro']) !!}
                                                <a href="#" class="btn btn-default btn-sm" title="Editar" data-toggle="modal" data-target="#update"
                                                    data-user_id="{{ $a->user_id }}" data-planner_id="{{ $a->planner_id }}" data-since="{{ $a->since }}" data-until="{{ $a->until }}" data-id="{{ $a->id }}">
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
    </div>
</div>

@endsection
@section('js')
<script>

$('#update').on('show.bs.modal', function(event){
    let button = $(event.relatedTarget);
    let modal = $(this);
    $("#_user_id").val(button.data('user_id')).trigger('change');
    $("#_planner_id").val(button.data('planner_id')).trigger('change');
    $("#_since").val(button.data('since'));
    $("#_until").val(button.data('until'));
    $("#id_assignment").val(button.data('id'));

})

function check_date(input){

    let formData = {'date': $('#'+input).val(),
             'field': input,'planner_id':$('#planner_id').val(),'user_id':$('#user_id').val()}

    url = route('check_date_assign');

    $.ajax({
        url: url,
        type: 'GET',
        data: formData,
        async: true,
        beforeSend: function () {
            $(".btn_asistencia").prop("disabled",true);
            //$("#loader-icon").fadeIn(60);
        },
        success: function(data)
        {
            if(data == 'false'){
                toastr.error('¡Ya existe una planificación asignada con esa fecha!');
                $('#save').attr('disabled','disabled');

                if(input === 'since'){
                    $('#until').attr('disabled','disabled');
                }else{
                    $('#since').attr('disabled','disabled');
                }
            }else{
                $('#save').removeAttr('disabled');
                if(input === 'since'){
                    $('#until').removeAttr('disabled','disabled');
                }else{
                    $('#since').removeAttr('disabled','disabled');
                }

            }

        },
        error: function (data){
            toastr.error('¡Ocurrió un error!');
        },
    }).done(function() {
        setTimeout(function(){
        $("#overlay").fadeOut(300);
        },500);
    });

}

function check_date_edit(input){

let formData = {'date': $('#_'+input).val(),
         'field': input,'planner_id':$('#_planner_id').val(),'user_id':$('#_user_id').val()}

url = route('check_date_assign');

$.ajax({
    url: url,
    type: 'GET',
    data: formData,
    async: true,
    beforeSend: function () {
        $(".btn_asistencia").prop("disabled",true);
        //$("#loader-icon").fadeIn(60);
    },
    success: function(data)
    {
        if(data == 'false'){
            toastr.error('¡Ya existe una planificación asignada con esa fecha!');
            $('#saveEdit').attr('disabled','disabled');

            if(input === 'since'){
                $('#_until').attr('disabled','disabled');
            }else{
                $('#_since').attr('disabled','disabled');
            }
        }else{
            $('#saveEdit').removeAttr('disabled');
            if(input === 'since'){
                $('#_until').removeAttr('disabled','disabled');
            }else{
                $('#_since').removeAttr('disabled','disabled');
            }

        }

    },
    error: function (data){
        toastr.error('¡Ocurrió un error!');
    },
}).done(function() {
    setTimeout(function(){
    $("#overlay").fadeOut(300);
    },500);
});

}

function validate_date(){
        let f1 = new Date($("#since").val());
        let f2 = new Date($("#until").val());

        if(f1 != '' || f2 != ''){

            if (f1 > f2){
                $("#span_until").show();
                $('#save').attr('disabled','disabled');
            }else{
                $("#span_until").hide();
                $('#save').removeAttr('disabled');
            }
        }
    }

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
        });

        var table = $('#mydatatable').DataTable( {
                dom: '<"top"i>rt<"bottom"lp><"clear">',
                orderCellsTop: true,
                fixedHeader: true,
                // dom: 'Blrtip ',
                buttons: [],
                info:true,
                bLengthChange: true,
                lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100,"Todos"]],
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
