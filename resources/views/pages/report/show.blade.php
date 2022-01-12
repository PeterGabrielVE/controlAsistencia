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

<div class="page height-full">

    {{-- alerts --}}
    <div class="container-fluid animatedParent animateOnce my-3">
        <div class="animated fadeInUpShort">
            <div class="card">
                <div class="form-group">
                    <div class="card-header white">
                        <h6> DETALLES DE LA MARCA </h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                    <div class="form-group col-3 m-0">
                            {!! Form::label('name', 'Nombre', ['class'=>'col-form-label s-12']) !!}
                            {!! Form::text('name', $asistencia->user->fullname.' '. $asistencia->user->last_name ?? null, ['class'=>'form-control r-0 light s-12','id'=>'name','disabled']) !!}
                            <span class="descripcion_span"></span>
                        </div>
                        <div class="form-group col-3 m-0">
                            
                            {!! Form::label('name', 'RUT', ['class'=>'col-form-label s-12']) !!}
                            {!! Form::text('name', $asistencia->user->rut ?? null, ['class'=>'form-control r-0 light s-12','id'=>'rut','disabled']) !!}
                            <span class="descripcion_span"></span>
                        </div>
                        <div class="form-group col-3 m-0">
                            {!! Form::label('since', 'IP Entrada', ['class'=>'col-form-label s-12']) !!}
                            {!! Form::text('since', $asistencia->ip ?? null, ['class'=>'form-control r-0 light s-12','id'=>'ip_entrada','disabled']) !!}
                            <span class="descripcion_span"></span>
                        </div>
                        <div class="form-group col-3 m-0">
                            {!! Form::label('since', 'IP Salida', ['class'=>'col-form-label s-12']) !!}
                            {!! Form::text('ip_salida', $asistencia->ip_salida ?? null, ['class'=>'form-control r-0 light s-12','id'=>'ip_salida','disabled']) !!}
                            <span class="descripcion_span"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 mr-2">
                            <div  id="mapid" style="height:400px; width:400px;"></div>
                        </div>
                        <div class="col-5">
                            {{ Html::image('img/avatar/'.$asistencia->image, 'a picture', array('alt'=>'Logo','class'=>'img-responsive')) }}


                        </div>
                    </div>
                    {!! Form::hidden('latitude', $asistencia->latitude ?? null, ['class'=>'form-control r-0 light s-12', 'id'=>'latitude']) !!}
                    {!! Form::hidden('longitude', $asistencia->longitude ?? null, ['class'=>'form-control r-0 light s-12', 'id'=>'longitude']) !!}
                    {!! Form::hidden('image', $asistencia->image ?? null, ['class'=>'form-control r-0 light s-12', 'id'=>'image']) !!}

                </div>

            </div>
        </div>
    </div>
</div>
<!--Add New Message Fab Button-->

@endsection
@section('js')
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<script>

var map;
var myLatLng;

var lat = $('#latitude').val();
var long = $('#longitude').val();
var img = $('#image').val();

details(img,lat,long);

function details(image, latitude, longitude){

    if(latitude != 0 && longitude != 0){
        //createMap2(myLatLng);
        console.log(longitude+"-"+latitude)
        var mymap = L.map('mapid').setView([latitude, longitude], 15);
        //$('#map').show();

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mymap);
        var marker = L.marker([latitude, longitude]).addTo(mymap);


    }

}



</script>
@endsection
