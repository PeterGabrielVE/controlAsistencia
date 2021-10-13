<div class="page has-sidebar-left">
    <div class="pos-f-t">
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-dark pt-2 pb-2 pl-4 pr-2">
                <div class="search-bar">
                    <input class="transparent s-24 text-white b-0 font-weight-lighter w-128 height-50" type="text"
                    placeholder="start typing...">
                </div>
                <a href="#" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-expanded="false"
                aria-label="Toggle navigation" class="paper-nav-toggle paper-nav-white active "><i></i></a>
            </div>
        </div>
    </div>
    <div class="has-sidebar-left navbar navbar-expand navbar-dark justify-content-between bd-navbar blue accent-3 fixed-top">
    {{-- <div class="navbar navbar-expand d-flex navbar-dark justify-content-between bd-navbar blue accent-3 shadow"> --}}
        <div class="relative">
            <div class="d-flex">
                <div>
                    <a href="#" data-toggle="push-menu" class="paper-nav-toggle pp-nav-toggle">
                        <i></i>
                    </a>
                </div>
                <div class="d-none d-md-block">
                    @yield('title')
                </div>
            </div>
        </div>
        <!--Top Menu Start -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- User Account-->
                <li class="dropdown custom-dropdown user user-menu ">
                   <a href="#" class="nav-link" data-toggle="dropdown">
                        {{ Html::image('assets/img/dummy/u1.png', 'a picture', array('class'=>'user-image','alt'=>'a picture')) }}

                        <i class="icon-more_vert "></i>
                    </a>
                    <div class="dropdown-menu p-4 dropdown-menu-right">


                        <div class="row box justify-content-between my-4">
                            <div class="col"><a href="{{ route('passwordReset') }}">
                                <i class="icon-beach_access pink lighten-1 avatar  r-5"></i>
                                <div class="pt-1">{{ __('Perfil') }}</div>
                            </a></div>
                            <div class="col">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="icon-power-off red avatar  r-5"></i>
                                    <div class="pt-1">{{ __('Salir') }}</div>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>

                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class=" position-fixed d-block pt-5 mt-3" style="z-index:1; width:100%;">
        @yield('top-menu')
    </div>
    <div>
        @yield('maincontent')
    </div>
</div>
