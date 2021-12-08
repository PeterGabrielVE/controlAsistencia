<!DOCTYPE html>
<html>
<head>
    <title>ADMYCOM</title>
</head>
<body>
	<div>
		 <h5>*DATOS DEL ANUNCIO*</h5>
		 <p>Anuncio NO: #{{ $student_detail['id_anuncio'] }}</p>
		 <p>Edificio: {{ $student_detail['name_edificio'] }}</p>
		 <p>Solicitado por: {{ $student_detail['nombre_solicitante'] }}</p>
    </div>
    <br>
    <div>
    	 <h5>*DATOS DEL PROVEEDOR*</h5>
		 <p>Nombre: {{ $student_detail['nombre'] }}</p>
		 <p>Teléfono: {{ $student_detail['telefono'] }}</p>
		 <p>Empresa: {{ $student_detail['empresa'] }}</p>
		 <p>Mensaje: {{ $student_detail['mensaje'] }}</p>
		 <br>
		 <p>Este es un correo automatizado generado desde la plataforma ADMYCOM.cl</p>
    </div>
</body>
</html>