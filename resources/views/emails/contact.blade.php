<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Mensaje de Contacto</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>¡Hola Marcos! Has recibido un nuevo mensaje.</h2>
    
    <p><strong>Nombre:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    
    <h3>Mensaje:</h3>
    <div style="background-color: #f4f4f4; padding: 15px; border-radius: 5px;">
        <p>{{ $data['message'] }}</p>
    </div>
</body>
</html>