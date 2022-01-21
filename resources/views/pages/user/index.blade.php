@extends('layouts.app')
@section('title')
<h1 class="nav-title text-white"><a class="nav-link" href="{{ route('user.index') }}" role="tab" aria-controls="v-pills-all" id="users"><i class="icon icon-home2"></i>{{ __('Usuarios') }}</a></h1>
@endsection

@section('maincontent')
{{-- modal create --}}
@include('pages.user.create')
{{-- modal edit --}}
@include('pages.user.edit')
{{-- modal show --}}
@include('pages.user.show')
<div class="page  height-full">
    {{-- alerts --}}
    <div>
        @include('alerts.toastr')
    </div>

    <div class="container-fluid animatedParent animateOnce my-3">
        <div class="animated fadeInUpShort">
            <div class="card">
            
                <div class="card-body">
                    <div id="table" class=" table-responsive">
                        <table id="example3" class="table table-bordered table-hover table-sm" data-order='[[ 0, "desc" ]]' data-page-length='100' style="width: 100%;border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th class="text-center" style="display:none;"><b>#</b></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"><b>{{ __('NOMBRE') }}</b></th>
                                    <th class="text-center"><b>{{ __('APELLIDO') }}</b></th>
                                    <th class="text-center"><b>{{ __('CORREO') }}</b></th>
                                    <th class="text-center"><b>{{ __('PERFIL') }}</b></th>
                                    <th class="text-center"><b>{{ __('ESTADO') }}</b></th>
                                    <th class="text-center"><b>{{ __('OPCIONES') }}</b></th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach ($users as $user)
                                <tr class="tbody">
                                    <td class="text-center"  style="display:none;"> {{$user->id}} </td>
                                    <td class="w-10 text-center">
                                        @if(isset($user->image))
                                        <a class="avatar avatar-lg">
                                            {{ Html::image('img/avatar/'.$user->image, 'a picture', array('alt'=>'Logo','class'=>'img-responsive')) }}
                                        </a>
                                        @else
                                        <a class="avatar avatar-lg">
                                            {{ Html::image('img/avatar/default.png', 'a picture', array('alt'=>'Logo','class'=>'img-responsive')) }}
                                        </a>
                                        @endif

                                    </td>
                                    <td class="text-center"> {{ $user->fullname }} </td>
                                    <td class="text-center"> {{ $user->last_name ?? null }} </td>
                                    <td class="text-center"> {{ $user->email }} </td>

                                    <td class="text-center">
                                        @foreach ($user->roles as $element) <span class="badge badge-primary r-5">{{ $element->name }}</span>@endforeach
                                    </td>
                                    <td class="text-center">
                                        @if ($user->status == '1')
                                        <span class="icon icon-circle s-12  mr-2 text-success"></span> {{ $user->estado->name ?? '' }}</td>
                                        @endif
                                        @if($user->status == '2')
                                        <span class="icon icon-circle s-12  mr-2 text-danger"></span> {{ $user->estado->name ?? '' }}</td>
                                        @endif
                                        @if($user->status == '3')
                                        <span class="icon icon-circle s-12  mr-2 text-warning"></span> {{ $user->estado->name ?? '' }} </td>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('user.show',$user->id) }}" class="btn btn-default btn-sm" title="Editar">
                                            <i class="icon-pencil text-info"></i>
                                        </a>
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
<!--Add New Message Fab Button-->
<a href="#" class="btn-fab btn-fab-md fab-right fab-right-bottom-fixed shadow btn-primary" data-toggle="modal" data-target="#create" title="Add User">
    <i class="icon-add"></i>
</a>
@endsection
@section('js')
<script src={{asset('assets/plugins/bootstrap-fileinput/js/fileinput.js')}}></script>
<script src={{asset('assets/plugins/bootstrap-fileinput/js/plugins/piexif.js')}}></script>
<script src={{asset('assets/plugins/bootstrap-fileinput/js/plugins/sortable.js')}}></script>
<script src={{asset('assets/plugins/bootstrap-fileinput/js/locales/es.js')}}></script>
<script src={{asset('assets/plugins/bootstrap-fileinput/themes/gly/theme.js')}}></script>
<script>
    var title = 'Users';
    var colunms = [0,1,2,3,4];

    $(".file").fileinput({
        // theme: 'gly',
        // uploadUrl: '#',
        showCaption: false,
        showRemove: false,
        showUpload: false,
        showBrowse: false,
        browseOnZoneClick: true,
    });

    dataTableExport(title,colunms);

    $(document).ready(function() {
        $('#users').addClass('active');
    });
</script>
@endsection
