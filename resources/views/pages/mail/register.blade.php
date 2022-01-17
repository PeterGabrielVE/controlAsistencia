<!DOCTYPE html>
<html>
<head>
    <title>OPSONTIME</title>
</head>
<body>
	<div>
		 <h5>*DATOS DE LA MARCA*</h5>
		 <p>Usuario: {{ $user_detail['nombre'] }}</p>
		 <p>Sistema: {{ $user_detail['sistema'] }}</p>
		 <p>Fecha: {{ \Carbon\Carbon::parse($user_detail['fecha'])->format('d/m/Y') }}</p>
		 <p>Hora de Marcación: {{ \Carbon\Carbon::parse($user_detail['fecha'])->format('H:i:s') }}</p>
		 <p>TIPO: {{ $user_detail['tipo'] }}</p>
    </div>
    <br>
    <div>
		 <p>Este es un correo automatizado generado desde la plataforma OPSONTIME</p>
    </div>
</body>
</html>