<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    // Si no está logueado, redirige al login
    header('Location: index.html');
    exit();
}
?>

<?php 
  include("conexion.php"); // Incluye el archivo de conexión a la base de datos
?>

<html>
<head>
    <title>EDITAR ALUMNOS DE INGENIERÍA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 1000px; /* Aumentamos el ancho para caber los elementos horizontalmente */
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap; /* Permite que los elementos se ajusten en varias líneas si es necesario */
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
            width: 150px; /* Establecemos un ancho para las etiquetas */
        }

        input[type="text"], input[type="tel"], select {
            width: 200px; /* Establecemos un ancho para los campos de texto */
            padding: 10px;
            margin: 8px 0 15px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            flex-direction: column; /* Organiza los formularios en columnas */
            align-items: center;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            gap: 3px;
            margin-top: 20px;
            width: 100%; /* Asegura que los botones se ajusten correctamente */
        }

		/* Selecciona el campo de correo por su atributo name */
input[name="mail"] {
    width: 100%; /* Puedes ajustar el ancho al 100% o cualquier valor que prefieras */
    padding: 12px; /* Aumenta el padding para hacerlo más grande */
    font-size: 14px; /* Aumenta el tamaño de la fuente */
}
		
        input[type="submit"], a.button {
            background-color: #007690;
            color: white;
            padding: 8px 16px; /* Disminuir el padding para hacer los botones más pequeños */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 40%;
            text-align: center;
            font-size: 14px;
        }

        input[type="submit"]:hover, a.button:hover {
            background-color: blue;
        }

        a.button {
			
            text-decoration: none;
            display: inline-block;
            line-height: 1.5;
            color: white;
            text-align: center;
        }

        a.button:hover {
            text-decoration: underline;
        }
    </style>
	

	
	
</head>
<body>
    <?php
    if (isset($_POST['enviar'])) {
        // Si se ha enviado el formulario, obtenemos los datos y los actualizamos en la base de datos
        $id = $_POST['id'];
        $nombre = strtoupper($_POST['nombre']);
        $app = strtoupper($_POST['app']);
        $apm = strtoupper($_POST['apm']);
        $dir = strtoupper($_POST['dir']);
        $num = strtoupper($_POST['num']);
        $col = strtoupper($_POST['col']);
        $telefono = $_POST['telefono'];
        $mail = $_POST['mail'];
        $cuatrimestre = $_POST['cuatrimestre'];

        // Comando SQL para actualizar los datos del alumno
        $sql = "UPDATE derecho SET nombre='$nombre', app='$app', apm='$apm', dir='$dir', num='$num', col='$col', telefono='$telefono', mail='$mail', cuatrimestre='$cuatrimestre' WHERE id='$id'";

        $resultado = mysqli_query($conexion, $sql);
        
        if ($resultado) {
            // Si la actualización fue exitosa, muestra una alerta y redirige
            echo "<script language='JavaScript'>
                     alert('Los datos se actualizaron');
                     location.assign('derecho.php');
                  </script>";
        } else {
            // Si no fue exitosa, muestra una alerta de error
            echo "<script language='JavaScript'>
                     alert('Los datos NO se actualizaron');
                     location.assign('editar_der.php');
                  </script>";
        }
        mysqli_close($conexion);
    } else {
        // Si el formulario no ha sido enviado, obtenemos los datos del alumno que se quieren editar
        $id = $_GET['id'];
        $sql = "SELECT * FROM derecho WHERE id='$id'";
        $resultado = mysqli_query($conexion, $sql);

        $fila = mysqli_fetch_assoc($resultado);
        $nombre = $fila["nombre"];
        $app = $fila["app"];
        $apm = $fila["apm"];
        $dir = $fila["dir"];
        $num = $fila["num"];
        $col = $fila["col"];
        $telefono = $fila["telefono"];
        $mail = $fila["mail"];
        $cuatrimestre = $fila["cuatrimestre"];

        mysqli_close($conexion);
    ?>
    <div class="form-container">
        <h1>EDITAR ALUMNO</h1>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                <!-- Los elementos de formulario ahora se colocarán en una fila -->
                <div>
                    <label>Nombre:</label>
                    <input type="text" style="text-transform: uppercase" name="nombre" required value="<?= $nombre; ?>">
                </div>
                <div>
                    <label>Apellido Paterno:</label>
                    <input type="text" style="text-transform: uppercase" name="app" required value="<?= $app; ?>">
                </div>
                <div>
                    <label>Apellido Materno:</label>
                    <input type="text" style="text-transform: uppercase" name="apm" required value="<?= $apm; ?>">
                </div>
                <div>
                    <label>Dirección:</label>
                    <input type="text" style="text-transform: uppercase" name="dir" required value="<?= $dir; ?>">
                </div>
                <div>
                    <label>Número:</label>
                    <input type="text" name="num" required value="<?= $num; ?>">
                </div>
                <div>
                    <label>Colonia:</label>
                    <input type="text" style="text-transform: uppercase" name="col" required value="<?= $col; ?>">
                </div>
                <div>
                    <label>Teléfono:</label>
                    <input type="tel" name="telefono" required value="<?= $telefono; ?>">
                </div>
                <div>
                    <label>Correo:</label>
                    <input type="text" name="mail" required value="<?= $mail; ?>">
                </div>
                <div>
                    <label>Cuatrimestre:</label>
                    <select name="cuatrimestre">
                        <option value="1" <?= $cuatrimestre == 1 ? 'selected' : ''; ?>>1</option>
                        <option value="2" <?= $cuatrimestre == 2 ? 'selected' : ''; ?>>2</option>
                        <option value="3" <?= $cuatrimestre == 3 ? 'selected' : ''; ?>>3</option>
                        <option value="4" <?= $cuatrimestre == 4 ? 'selected' : ''; ?>>4</option>
                        <option value="5" <?= $cuatrimestre == 5 ? 'selected' : ''; ?>>5</option>
                        <option value="6" <?= $cuatrimestre == 6 ? 'selected' : ''; ?>>6</option>
                        <option value="7" <?= $cuatrimestre == 7 ? 'selected' : ''; ?>>7</option>
                    </select>
                </div>
            </div>

            <input type="hidden" name="id" value="<?= $id; ?>">

            <div class="button-container">
                <input type="submit" name="enviar" value="ACTUALIZAR">
                <a href="derecho.php" class="button">REGRESAR</a>
            </div>
        </form>
    </div>
    <?php
    }
    ?>
</body>
</html>
