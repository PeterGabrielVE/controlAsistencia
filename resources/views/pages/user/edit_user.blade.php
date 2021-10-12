@extends('layouts.app')
@section('title')
<h1 class="nav-title text-white"><a href="{{ route('user.index') }}" role="tab" aria-controls="v-pills-all"
        id="users"><i class="icon icon-home2"></i>{{ __('Usuarios') }}</a> > {{ $user->fullname ?? '' }}</h1>
@endsection

@section('maincontent')

<div class="page  height-full">
    {{-- alerts --}}
    <div>
        @include('alerts.toastr')
    </div>

    <div class="container-fluid animatedParent animateOnce my-3">
        <div class="animated fadeInUpShort">
            <div class="card">
                <div class="form-group">
                    <div class="card-header white">
                        <div class="form-group row">
                            <div class="col-sm-10" style="margin-top: 5px;">
                                <h6> {{ __('EDITAR USUARIO') }} </h6>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update',$user->id) }}" method="POST" autocomplete="off"
                        enctype='multipart/form-data' files='true'>
                        @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-row">
                                        <div class="form-group m-0 col-6 has-feedback" id="fullname_group">
                                            <i class="icon-person mr-2"></i>
                                            {!! Form::label('name', '* Nombres', ['class'=>'col-form-label s-12']) !!}
                                            {!! Form::text('fullname', $user->fullname ?? '', ['class'=>'form-control
                                            r-0 light s-12', 'placeholder'=>'Enter User Name', 'id'=>'_fullname',
                                            'onclick'=>'inputClear(this.id)']) !!}
                                            {!! Form::hidden('id', $user->id ?? '', ['class'=>'form-control r-0 light
                                            s-12', 'placeholder'=>'Enter User Name', 'id'=>'_id',
                                            'onclick'=>'inputClear(this.id)']) !!}
                                            <span class="fullname_span"></span>
                                        </div>
                                        <div class="form-group m-0 col-6 has-feedback" id="last_name_group">
                                            <i class="icon-person mr-2"></i>
                                            {!! Form::label('last_name', '* Apellidos', ['class'=>'col-form-label
                                            s-12']) !!}
                                            {!! Form::text('last_name', $user->last_name ?? null,
                                            ['class'=>'form-control r-0 light s-12', 'id'=>'user_last_name']) !!}
                                            <span class="last_name_span"></span>
                                        </div>
                                        <div class="form-group col-4 m-0" id="rol_group">
                                            {!! Form::label('rut', '* Identificación', ['class'=>'col-form-label s-12'])
                                            !!}
                                            {!! Form::text('rut', $user->rut ?? null, ['class'=>'form-control r-0 light
                                            s-12', 'id'=>'rut', 'onclick'=>'inputClear(this.id)','required']) !!}
                                            <span class="rol_span"></span>
                                        </div>
                                        <div class="form-group col-4 m-0">
                                            {!! Form::label('position', '* Cargo', ['class'=>'col-form-label s-12']) !!}
                                            {!! Form::select('position',$positions, $user->position ?? null,
                                            ['class'=>'form-control r-0 light s-12', 'id'=>'position',
                                            'onclick'=>'inputClear(this.id)']) !!}
                                        </div>
                                        <div class="form-group m-0 col-4 has-feedback" id="fullname_group">
                                            <i class="icon-envelope-o mr-2"></i>
                                            {!! Form::label('email', '* Correo', ['class'=>'col-form-label s-12']) !!}
                                            {!! Form::email('email', $user->email ?? '', ['class'=>'form-control r-0
                                            light s-12 ', 'placeholder'=>'user@email.com', 'id'=>'_email',
                                            'onclick'=>'inputClear(this.id)']) !!}

                                            <span class="fullname_span"></span>
                                        </div>
                                        <div class="form-group col-6 m-0" id="password_group">
                                            <i class="icon-key3 mr-2"></i>
                                            {!! Form::label('password', '* Contraseña', ['class'=>'col-form-label
                                            s-12','placeholder'=>'Password', 'onclick'=>'inputClear(this.id)']) !!}
                                            {!! Form::password('password', ['class'=>'form-control r-0 light
                                            s-12','id'=>'password', 'onclick'=>'inputClear(this.id)']) !!}
                                            <span class="password_span"></span>
                                        </div>
                                        <div class="form-group col-6 m-0">
                                            <i class="icon-key4 mr-2"></i>
                                            {!! Form::label('passwordConfirm', '* Confirma Contraseña',
                                            ['class'=>'col-form-label s-12','placeholder'=>'Password Confirm']) !!}
                                            {!! Form::password('password_confirmation', ['class'=>'form-control r-0
                                            light s-12', 'id'=>'password_confirmation',
                                            'onclick'=>'inputClear(this.id)']) !!}
                                        </div>
                                        <div class="form-group col-4 m-0" id="_rol_group">
                                            {!! Form::label('role', '* Perfil', ['class'=>'col-form-label s-12']) !!}
                                            {!! Form::select('rol', $roles, $user->rol_user->rol->slug ?? '',
                                            ['class'=>'form-control r-0 light s-12', 'id'=>'_rol',
                                            'onclick'=>'inputClear(this.id)','required']) !!}
                                            <span class="_rol_span"></span>
                                        </div>
                                        <div class="form-group col-4 m-0" id="status_group">
                                            {!! Form::label('status', '* Estado', ['class'=>'col-form-label s-12']) !!}
                                            {!! Form::select('status', $status, $user->status ?? '',
                                            ['class'=>'form-control r-0 light s-12', 'placeholder'=>'Select',
                                            'id'=>'_status', 'onclick'=>'inputClear(this.id)','required']) !!}
                                            <span class="status_span"></span>
                                        </div>
                                        <div class="form-group col-4 m-0">
                                            <i class="icon-phone mr-2"></i>
                                            {!! Form::label('phone1', 'Teléfono', ['class'=>'col-form-label s-12']) !!}
                                            {!! Form::text('phone1', $user->phone1 ?? '', ['class'=>'form-control r-0
                                            light s-12','id'=>'_phone1', 'onclick'=>'inputClear(this.id)']) !!}
                                        </div>
                                        <div class="form-group col-4 m-0" id="rol_group">
                                            {!! Form::label('fecha_contrato', 'FECHA DE CONTRATO',
                                            ['class'=>'col-form-label s-12']) !!}
                                            {!! Form::date('fecha_contrato', $user->fecha_contrato ?? null,
                                            ['class'=>'form-control r-0 light s-12', 'id'=>'fecha_contrato',
                                            'onclick'=>'inputClear(this.id)']) !!}
                                            <span class="rol_span"></span>
                                        </div>
                                        <div class="form-group col-4 m-0" id="rol_group">
                                            {!! Form::label('fecha_fin_contrato', 'FECHA FIN DE CONTRATO',
                                            ['class'=>'col-form-label s-12']) !!}
                                            {!! Form::date('fecha_fin_contrato', $user->fecha_fin_contrato ?? '',
                                            ['class'=>'form-control r-0 light s-12', 'id'=>'fecha_fin_contrato',
                                            'onclick'=>'inputClear(this.id)']) !!}
                                            <span class="rol_span"></span>
                                        </div>
                                        <div class="form-group col-4 m-0" id="status_group">
                                            {!! Form::label('grupo', '* Grupo', ['class'=>'col-form-label s-12']) !!}
                                            {!! Form::select('id_group', $grupos, $user->grupo->id_group ?? '',
                                            ['class'=>'form-control r-0 light s-12', 'id'=>'id_group',
                                            'onclick'=>'inputClear(this.id)','required']) !!}
                                            <span class="status_span"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="col-md-12 offset-md-1">
                                        <div class="form-group">
                                            <input id="file" class="file" name="file" type="file"
                                                onchange="ValidarTamaño(this);" size="15" value="">
                                            {!! Form::hidden('file', $user->image ?? '', ['class'=>'form-control r-0
                                            light s-12', 'id'=>'_file']) !!}
                                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12 m-0">
                                    {!! Form::label('address', 'Dirección', ['class'=>'col-form-label s-12']) !!}
                                    {!! Form::textarea('address',$user->address ?? null, ['class'=>'form-control r-0
                                    light s-12', 'id'=>'address', 'onclick'=>'inputClear(this.id)','row'=>'2']) !!}
                                </div>
                            </div>
                            <div class="row text-right">
                                <div class="col-md-12 mt-4">
                                    <a href="{{ route('user.index') }}" class="btn btn-default"
                                        data-dismiss="modal">{{__('Atrás')}}</a>
                                    <button type="submit" id="editar" class="btn btn-primary"><i
                                            class="icon-save mr-2"></i>{{__('Guardar Datos')}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-inline col-8 m-0" id="status_group">
                               <div class="col-4">
                                    {!! Form::label('lbl_group', 'Grupos', ['class'=>'col-form-label s-12']) !!}
                                       {!! Form::select('id_grupo', $grupos, null, ['class'=>'form-control r-0 light s-12 select2', 'placeholder'=>'Seleccione', 'id'=>'id_grupo']) !!}
                                       <span class="status_span"></span>
                               </div>
                                <div class="col-2">
                                    {!! Form::label('', '', ['class'=>'col-form-label s-12']) !!}
                                     <a class="btn btn-primary btn-sm mt-3" onclick="addGrupo()"><i class="icon icon-plus" style="font-size: 12px;padding: .10rem .4rem;"></i></a>
                                       <span class="status_span"></span>
                                </div>
                            </div>
                             <div class="form-group col-12 mt-4" id="status_group">
                                <table id="table_grupo" class="table table-bordered table-hover table-sm" data-order='[[ 0, "desc" ]]' data-page-length='10' style="width: 100%">
                                    <thead>
                                           <tr>
                                               <th class="text-center"><b>{{ __('Grupo') }}</b></th>
                                               <th>Opción</th>
                                           </tr>
                                       </thead>

                                </table>
                            </div>
                        </div>

                </div>


                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
@section('js')
<script src={{asset('assets/plugins/bootstrap-fileinput/js/fileinput.js')}}></script>
<script src={{asset('assets/plugins/bootstrap-fileinput/js/plugins/piexif.js')}}></script>
<script src={{asset('assets/plugins/bootstrap-fileinput/js/plugins/sortable.js')}}></script>
<script src={{asset('assets/plugins/bootstrap-fileinput/js/locales/es.js')}}></script>
<script src={{asset('assets/plugins/bootstrap-fileinput/themes/gly/theme.js')}}></script>
<script>
    grupos();


    var title = 'Users';
    var colunms = [0,1,2,3,4];
    var namefile = $('#_file').val();

        var url = '../img/avatar/' +namefile;

        $(".file").fileinput({
            allowedFileExtensions: ['jpg','jpge','png', 'gif'],
            initialPreview: [url],
            initialPreviewAsData: true,
            showCaption: false,
            showRemove: false,
            showUpload: false,
            showCancel: false,
            showBrowse: false,
            browseOnZoneClick: true,
            overwriteInitial: true
        });

        $('#file').on('fileclear', function(event) {
            var ruta = $('#_url_imagen').val("");
        });

        $('#file').change(function () {
                $('#_url_imagen').val($(this).val());
            });

    dataTableExport(title,colunms);

    $(document).ready(function() {
        $('#users').addClass('active');

        $("#password_confirmation").on("change", function( event ) {
         var password = $("#password").val();
         var confirmation = $("#password_confirmation").val();
         console.log(password +"-"+confirmation);
         if( password != confirmation){
            toastr.error('No coinciden con la contraseña ingresada');
            $("#editar").attr('disabled',true);
         }else{
            $("#editar").attr('disabled',false);
         }
        });

        $('#status').on('change',function(e){
          let select = this.value;

          if(select == 4){
            $('#div_dias').show();
          }else{
            $('#div_dias').hide();
          }
	    });

    });


  function soloNumeros(e){
    var key = window.Event ? e.which : e.keyCode
    return (key >= 48 && key <= 57)
  }

  function grupos(){


    var id = "{{ $user->id }}";

    $('#table_grupo').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthChange": false,
        "bFilter": false,
        "bSort" : false,
        "bPaginate": false,
        "pageLength": 12,
        "bInfo": false,
        "ajax": {
                url: "{{ url('groupByUser') }}/"+id,
                type:'GET',
                'headers': {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            'data': function (d) {
                                }
                 },
                 columns: [

                            {
                            "mRender": function ( data, type, row ) {
                              return '<div><p style="font-size:12px;">'+row['group']+'</p></div>'
                                },
                                className: 'text-center'
                            },
                           {
                            "mRender": function ( data, type, row ) {
                              return '<a onclick=deleteGroup('+row['id_group']+') class="btn btn-default btn-sm" style="padding: .10rem .4rem;" title="Edit"><i class="icon-trash text-danger"></i></a>'
                                },
                                className: 'text-center'
                            }
                        ]
 });



}


  function addGrupo(){
     var id = "{{ $user->id }}";
     var id2 = $('#id_grupo').val();

        var formData = {
                "id_usuario" : id,
                "id_grupo" : id2
        }
         var url ="{{url('agregaGroupUser')}}";


          $.ajax({
            type : 'POST',
            url  : url,
            data : formData,
            success:function(data){

             toastr.success('Registro añadido correctamente!');

             $('#table_grupo').DataTable().clear().destroy();

             grupos();
             refrescarSelect(id);

            }
          });
  }

 function deleteGroup(id2){
    var id = "{{ $user->id }}";

    var formData = {
            "id_usuario" : id,
            "id_grupo" : id2
    }
    var url ="{{url('deleteGroupUser')}}";


          $.ajax({
            type : 'POST',
            url  : url,
            data : formData,
            success:function(data){

             toastr.success('Registro eliminado correctamente!');

              $('#table_grupo').DataTable().clear().destroy();
              grupos();
              refrescarSelect(id);

            }
          });
  }

    function refrescarSelect(id){

        var formData = {
                "id_usuario" : id
        }

        var url ="{{url('getGroupUser')}}";

          $.ajax({
            type : 'GET',
            url  : url,
            data : formData,
            success:function(data){

            $("#id_grupo").find('option').remove();
             var options = [];
             $.each(data, function(key, value) {
                        options.push($("<option/>", {
                        value: key,
                        text: value
                        }));
            });


            $('#id_grupo').append(options);
            }
          });
  }

</script>
@endsection
