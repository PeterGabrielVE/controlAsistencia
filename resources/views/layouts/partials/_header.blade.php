<aside class="main-sidebar fixed offcanvas shadow" data-toggle='offcanvas'>
    <section class="sidebar">
        <div class="w-150px mt-3 mb-3 ml-3">
            {{  Html::image('assets/img/basic/logoadm.png', 'a picture', array('alt'=>'Logo')) }}
        </div>
          <div class="relative">

            <div class="user-panel p-3 light mb-2">
                <div>
                    <div class="float-left image">
                        {{ Html::image('img/avatar/default.png', 'a picture', array('class'=>'user_avatar','alt'=>'a picture')) }}
                    </div>
                    <div class="float-left info">
                        <h6 class="font-weight-light mt-2 mb-1">&#161Hola {{ Auth::user()->fullname }}!</h6>
                        <a href="#"><i class="icon-circle text-primary blink"></i> Online</a>
                    </div>
                </div>
                <div class="clearfix"></div>

            </div>
        </div>

        <ul class="sidebar-menu">
        <li class="header"><strong>LIBRO DE ASISTENCIA</strong></li>
        @if(!Auth::user()->hasRole('fiscal')) 
          <li class="treeview"><a href="{{url('home')}}">
                <i class="icon icon-compass gray-text s-18"></i><span>{{ __('Dashboard') }}</span></a>
          </li>
       
        <li class="treeview"><a href="{{ route('reporte/marcas') }}">
              <i class="icon icon-compass gray-text s-18"></i><span>{{ __('Reporte de Marcas') }}</span></a>
        </li>
        @endif
        @if(Auth::user()->hasRole('jefe') || Auth::user()->hasRole('supervisor'))
          <li class="treeview"><a href="{{url('reporte/empleados')}}">
                <i class="icon icon-compass gray-text s-18"></i><span>{{ __('Reporte Empleados') }}</span></a>
          </li>
          <li class="treeview"><a href="{{url('jornada')}}">
            <i class="icon icon-compass gray-text s-18"></i><span>{{ __('Reporte Jornada') }}</span></a>
      </li>
        @endif

    @if(Auth::user()->hasRole('super'))

        <li class="header light mt-3"><strong>CONFIGURACIÓN</strong></li>
        <li class="treeview">
            <a href="#">
                <i class="icon icon-book gray-text s-18"></i> <span>{{ __('Configuración') }}</span>
                <i class="icon icon-angle-left s-18 pull-right"></i>
            </a>
            <ul class="treeview-menu">
            <li>
                    <a href="#">
                        <i class="icon icon-circle-o gray-text s-14"></i> <span>{{ __('Planificador') }}</span>
                        <i class="icon icon-angle-left s-18 pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview"><a href="{{ route('planificador.index') }}">
                            <i class="icon icon-widgets gray-text s-14"></i>
                            <span>{{ __('Planificador') }}</span></a>
                        </li>
                        <li><a href="{{ route('planificador.assignment') }}">
                                <i class="icon icon-plus-circle gray-text s-14"></i> <span>{{__('Asignación')}}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview"><a href="{{ route('posicion.index') }}">
                    <i class="icon icon-circle-o gray-text s-14"></i>
                    <span>{{ __('Posición') }}</span></a>
                </li>
                <li class="treeview"><a href="{{ route('grupo.index') }}">
                    <i class="icon icon-circle-o gray-text s-14"></i>
                    <span>{{ __('Grupo') }}</span></a>
                </li>

                <li class="treeview"><a href="{{ route('turn.index') }}">
                    <i class="icon icon-circle-o gray-text s-14"></i>
                    <span>{{ __('Turno') }}</span></a>
                </li>
                <li class="treeview">
                    <a href="{{ route('user.index') }}">
                        <i class="icon icon-equalizer gray-text s-18"></i>{{ __('Usuarios') }}
                    </a>
                </li>
            </ul>
        </li>
    
        @endif
        @if(Auth::user()->hasRole('fiscal') || Auth::user()->hasRole('super'))
        <li class="treeview ">
                <a href="#">
                    <i class="icon icon-circle-o gray-text s-18"></i> <span>{{ __('Reportes') }}</span>
                    <i class="icon icon-angle-left s-18 pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview"><a href="{{ route('report.index') }}">
                        <i class="icon icon-circle-o gray-text s-14"></i>
                        <span>{{ __('Marcaje') }}</span></a>
                    </li>
                    <li><a href="{{ route('report.jornada') }}">
                            <i class="icon icon-circle-o gray-text s-14"></i> <span>{{__('Jornada')}}</span>
                        </a>
                    </li>
                </ul>
         </li>
        @endif

    </ul>

</section>
</aside>
<script>
    $(document).ready(function() {

        $.ajaxSetup({
                  headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

        $('#search1').on('keyup',function(){

            $value=$(this).val();
            window.location.href = "{{URL::to('resultOperations')}}"
            $.ajax({
            type : 'get',
            url : "{{URL::to('search/operation')}}",
            data:{'search':$value},
            success:function(data){
                //$('tbody').html(data);

                //console.log(data);
                $('tbody').html(data);
                }
            });
        })


    });

    function SearchOperation(){
        var value = $("#search11").val();
        //console.log(value);
        $.ajaxSetup({
                  headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
            $.ajax({
                type: "POST",
                url:"{{ url('search/operation') }}/"+value,
                dataType:'json',
                success: function(data){
                    console.log(data);
                    // window.location.href = "{{URL::to('getAllLanguages')}}"

                }
            });

    }
</script>
<script type="text/javascript">

</script>


<!--Sidebar End-->
