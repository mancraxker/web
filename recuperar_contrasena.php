<?php
session_start();
include('conexion.php'); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    // Preparar la consulta SQL para evitar inyecciones SQL
    $sql = "SELECT email FROM administradores WHERE username = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $username);  // "s" indica que el parámetro es un string
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verificamos si el usuario existe en la base de datos
    if ($user) {
        // Simulación de un mensaje de éxito (aquí puedes agregar la funcionalidad de enviar un correo si lo deseas)
        $email = $user['email']; // Obtener el correo del usuario
        
        // Aquí iría la lógica para enviar un correo real con la nueva contraseña
        // Por ejemplo, usando mail() o una librería de envío de correos (como PHPMailer)

        echo "<script language='JavaScript'>
                alert('Se ha enviado un correo a $email con la nueva contraseña.');
                location.assign('index.html'); // Redirige al login
              </script>";
        exit;
    } else {
        echo "<script language='JavaScript'>
                alert('El usuario no existe.');
                location.assign('recuperar_contrasena.php'); // Redirige a la página de recuperación de contraseña
              </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: white; /* Color de fondo */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

		/* Logo fuera del contenedor */
        .logo {
    position: absolute;  /* Coloca el logo de forma libre */
    top: 143px;           /* Distancia desde la parte superior */
    left: 435px;          /* Distancia desde la izquierda */
    width: 115px;        /* Ancho del logo */
    height: 119px;        /* Mantiene la proporción */
    z-index: 10;         /* Asegura que el logo esté por encima del contenedor */
        }
		
      /* Estilos para el contenedor del formulario */
        .container {
            background-color: #fff;
            padding: 40px; /* Aumentar el padding para hacerlo más grande */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px; /* Aumentar el ancho del formulario */
            height: auto;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
			border: 1px solid gray; /* color para los Bordes   */
            font-size: 14px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #002416;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #007690;
        }

        p {
            font-size: 14px;
            color: #555;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

	
<div class="container">
        <h2>Recuperar Contraseña</h2>
    <!-- Logo -->
  <img src="img/logosinfondo.png" alt="Logo de la empresa" class="logo">
		
    <form action="recuperar_contrasena.php" method="POST">
      <label for="username">Nombre de Usuario:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            
            <button type="submit">Recuperar Contraseña</button>
        </form>

        <p>¿Recuerdas tu contraseña? <a href="index.html">Inicia sesión</a></p>
    </div>

</body>
</html>
