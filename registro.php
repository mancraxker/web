<?php
include('conexion.php'); // Conexión a la base de datos

$mensaje = ""; // Variable para almacenar el mensaje
$error_username = "";
$error_email = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar si el nombre de usuario ya está registrado
    $sql_username = "SELECT * FROM administradores WHERE username = '$username'";
    $resultado_username = mysqli_query($conexion, $sql_username);
    if (mysqli_num_rows($resultado_username) > 0) {
        $error_username = "Este nombre de usuario ya está registrado.";
    }

	// Validar que el correo tenga uno de los dominios específicos
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_email = "Por favor, ingrese un correo electrónico válido.";
    } elseif (!preg_match('/@(gmail\.com|hotmail\.com)$/', $email)) {
        $error_email = "El correo debe ser de tipo @gmail.com o @hotmail.com.";
    }
	
    // Verificar si el correo electrónico ya está registrado
    $sql_email = "SELECT * FROM administradores WHERE email = '$email'";
    $resultado_email = mysqli_query($conexion, $sql_email);
    if (mysqli_num_rows($resultado_email) > 0) {
        $error_email = "Este correo electrónico ya está registrado.";
    }

    // Si no hay errores, encriptamos la contraseña y registramos el usuario
    if (empty($error_username) && empty($error_email)) {
        // Encriptar la contraseña con bcrypt
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insertar los datos del usuario en la base de datos
        $sql = "INSERT INTO administradores (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

        if (mysqli_query($conexion, $sql)) {
            $mensaje = "Usuario registrado con éxito.";
        } else {
            echo "Error: " . mysqli_error($conexion);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif; /* Fuente limpia y legible */
            background-color: white; /* Fondo atractivo y profesional */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh; /* Ocupa toda la altura de la ventana */
            margin: 0;
        }

		/* Logo fuera del contenedor */
        .logo {
    position: absolute;  /* Coloca el logo de forma libre */
    top: 144px;           /* Distancia desde la parte superior */
    left: 420px;          /* Distancia desde la izquierda */
    width: 157px;        /* Ancho del logo */
    height: 151px;        /* Mantiene la proporción */
    z-index: 10;         /* Asegura que el logo esté por encima del contenedor */
        }
		
        /* Título */
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 14px;
			font-size: 24px;
        }

        /* Contenedor del formulario */
        .login-container {
            background-color: white; /* Fondo blanco para el formulario */
            padding: 50px;
            border-radius: 10px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  Sombra suave */
            width: 100%;
            max-width: 400px; /* Limita el ancho máximo */
        }

        /* Estilo de las etiquetas y los campos de entrada */
        .form-group {
            display: flex;
            justify-content: space-between; /* Espacio entre la etiqueta y el input */
            margin-bottom: 15px;
            align-items: center;
        }

        .form-group label {
            font-size: 14px;
            font-weight: bold;
            color: #344;
            width: 35%; /* Ajusta el ancho del label */
        }

        .form-group input {
            width: 60%; /* Ajusta el ancho del input */
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
			border: 1px solid gray; /* color para los Bordes   */
            font-size: 14px;
            background-color: whitesmoke;
            color: black;
        }

        /* Estilos del botón */
        button, a {
            background-color: #002416;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            text-decoration: none; /* Elimina el subrayado en el enlace */
            margin-top: 15px; /* Margen superior */
        }

        /* Cambio de color en hover */
        button:hover, a:hover {
            background-color: #007690;
        }

        /* Estilo del mensaje */
        .mensaje {
            margin-top: 20px;
            padding: 10px;
            background-color: whitesmoke; /* Fondo verde claro */
            color: #007690; /* Texto verde oscuro */
            border: 1px solid whitesmoke; /* Borde verde más oscuro */
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
        }
		
		/* Estilo de los botones */
        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            gap: 10px; /* Agregar espacio entre los botones */
        }
		
		/* Estilo de los errores */
        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

	 <!-- Logo -->
    <img src="img/logosinfondo.png" alt="Logo de la empresa" width="148" height="137" class="logo">

	
<div class="login-container">
  <h1>Ingrese sus datos</h1>

        <form method="POST" action="registro.php">

            <!-- Mostrar mensaje debajo del formulario -->
            <?php if (!empty($mensaje)) { ?>
                <div class="mensaje"><?php echo $mensaje; ?></div>
            <?php } ?>

            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
                <?php if (!empty($error_username)) { ?>
                    <div class="error"><?php echo $error_username; ?></div>
                <?php } ?>
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>
                <?php if (!empty($error_email)) { ?>
                    <div class="error"><?php echo $error_email; ?></div>
                <?php } ?>
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-buttons">
                <button type="submit">Registrarse</button>
                <a href="index.html">Regresar</a>
            </div>

        </form>
    </div>

</body>
</html>
