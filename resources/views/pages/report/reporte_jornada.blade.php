<table>
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
                    <tbody>
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
                                                    <td>@if($a->fecha_entrada != '')
                                                        {{ Carbon\Carbon::parse($a->fecha_entrada)->format('g:i:s A') ?? null }}
                                                        @endif 
                                                    </td>
                                                    <td>@if($a->fecha_entrada != ''  && $a->fecha_entrada != null){{ obtener_atraso($i,$a->turno,$a->fecha_entrada) ?? null }} @endif </td>
                                                    <td> {{ obtener_salida($a->marca) }}</td>
                                                </tr>

                                            @endif
                                        @endforeach
                                @endfor

                            </tbody>
                    </tbody>
</table>