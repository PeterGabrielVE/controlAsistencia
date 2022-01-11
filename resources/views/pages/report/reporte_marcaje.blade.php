<table>
                    <thead>
                    <tr>
                    <th><b>NOMBRE</b></th>
                        <th><b>IDENTIFICACIÓN</b></th>
                        <th><b>GRUPO</b></th>
                        <th><b>ENTRADA</b></th>
                        <th><b>SALIDA</b></th>
                        <th><b>NOTA</b></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($asistencia as $a)
                    @if(isset($a->fecha))
                    @foreach ($asistencia as $a)
                                @if(isset($a->fecha))
                                <tr class="tbody">
                                    <td>{{ $a->user->fullname ?? null }} {{ $a->user->last_name ?? null}}</td>
                                    <td>{{ $a->user->rut ?? null }}</td>
                                    <td>{{ $a->user->grupo->group->group ?? null}}</td>
                                    <td>{{ Carbon\Carbon::parse($a->fecha)->format('d-m-Y h:i:s A') ?? null }}</td>
                                    <td>@if(isset($a->fecha_salida)){{ Carbon\Carbon::parse($a->fecha_salida)->format('d-m-Y h:i:s A') }} @endif</td>
                                    <td>{{ $a->note ?? null }}</td>
                                </tr>
                                @endif

                    @endforeach
                    @endif
                @endforeach
        </tbody>
</table>