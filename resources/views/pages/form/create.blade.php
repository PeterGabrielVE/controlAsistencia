@extends('layouts.app')
@section('title')
<h1 class="nav-title text-white">Formularios</h1>
@endsection
@section('maincontent')

<div class="page height-full">

    {{-- alerts --}}
    <div class="container-fluid animatedParent animateOnce my-3">
        <div class="animated fadeInUpShort">
            <div class="card">
                
                <div class="card-body">
                        <div class="col-md-12 text-right">
                            <div class="form-group">

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
 $(document).ready(function() {


    var table = $('#mydatatable').DataTable( {
                dom: '<"top"if>rt<"bottom"lp><"clear">',
                orderCellsTop: true,
                fixedHeader: true,
                // dom: 'Blrtip ',
                buttons: [],
                info:true,
                bLengthChange: true,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
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





$(".file").fileinput({
// theme: 'gly',
// uploadUrl: '#',
showCaption: false,
showRemove: false,
showUpload: false,
showBrowse: false,
browseOnZoneClick: true,
});
</script>
@endsection
