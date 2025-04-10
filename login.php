<?php
session_start();
include('conexion.php'); // Conexión a la base de datos

// Inicializar el contador de intentos si no existe
if (!isset($_SESSION['intentos'])) {
    $_SESSION['intentos'] = 0;
}

// Verifica si los datos fueron enviados a través del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Preparar la consulta SQL para evitar inyecciones SQL
    $sql = "SELECT * FROM administradores WHERE username = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $username);  // "s" indica que el parámetro es un string
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verificar si el usuario existe y la contraseña es correcta
    if ($user && password_verify($password, $user['password'])) { // Usamos password_verify para comparar la contraseña encriptada
        // Almacenar el nombre de usuario en la sesión
        $_SESSION['usuario'] = $username;
	

        // Obtener el nombre completo del usuario (asegúrate de que esté almacenado en la base de datos)
        $nombre_completo = $user['username'];  // Aquí 'nombre' es el campo donde está el nombre completo del administrador en la base de datos

        // Reiniciar los intentos fallidos
        $_SESSION['intentos'] = 0;

        // Redirigir a la página principal con el mensaje de bienvenida que incluye el nombre del usuario
        echo "<script language='JavaScript'>
                alert('Bienvenido  " . $nombre_completo . "');
                location.assign('principal.php');
              </script>";
        exit; // Es importante usar exit después de una redirección
    } else {
        // Incrementar el contador de intentos fallidos
        $_SESSION['intentos']++;

        // Si el número de intentos es 3 o más, muestra el enlace para recuperar la contraseña
        if ($_SESSION['intentos'] >= 3) {
            echo "<script language='JavaScript'>
                    alert('Has alcanzado el límite de intentos fallidos. Por favor, recupera tu contraseña.');
                    location.assign('recuperar_contrasena.php'); // Redirige a la página de recuperación de contraseña
                  </script>";
            exit;
        } else {
            // Si el intento es incorrecto, redirigir al formulario de login con un mensaje de error
            echo "<script language='JavaScript'>
                    alert('Usuario o contraseña incorrectos. Intentos restantes: " . (3 - $_SESSION['intentos']) . "');
                    location.assign('index.html');
                  </script>";
            exit;
        }
    }
}
?>
