<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    // Si no está logueado, redirige al login
    header('Location: index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Alumno</title>
    <style>
        body {
            font-family: MV BOLI;  /* Establece la fuente del cuerpo a Arial */
            background-color: #f4f7fc;  /* Establece un fondo de color gris claro */
            color: #333;  /* Establece el color de texto a gris oscuro */
            margin: 0;  /* Elimina los márgenes por defecto */
            padding: 0;  /* Elimina el padding por defecto */
        }

      

        h1 {
            margin: 0;  /* Elimina el margen del título */
			text-align: center;
            color: #333;
			font-size: 24px;
        }

        .container {
            width: 100%;  /* Establece el contenedor al 100% del ancho disponible */
            max-width: 600px;  /* Limita el ancho máximo del formulario a 800px */
            margin: 40px auto;  /* Centra el contenedor con margen superior de 40px */
            background-color: #fff;  /* Establece el fondo del formulario a blanco */
            padding: 20px;  /* Agrega padding alrededor del formulario */
            border-radius: 8px;  /* Redondea las esquinas del formulario */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  /* Agrega una sombra sutil al formulario */
        }

        form {
            display: flex;  /* Aplica un diseño flexible al formulario */
            flex-direction: column;  /* Organiza los elementos en una columna */
        }

        label {
            margin-bottom: 2px;  /* Reduce el espacio inferior entre el label y el input */
            font-weight: bold;  /* Establece el texto de la etiqueta en negrita */
            font-size: 14px;  /* Establece el tamaño de la fuente de las etiquetas */
        }
		
		/* Estilo de los botones */
        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            gap: 10px; /* Agregar espacio entre los botones */
        }
		
		input, select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            flex: 1;
            width: 100%;
            box-sizing: border-box;
			
		}

        input[type="text"] {
            padding: 6px;  /* Reduce el padding dentro de los campos de texto */
            font-size: 14px;  /* Establece el tamaño de la fuente dentro de los campos */
            border: 1px solid #ccc;  /* Establece el borde de los campos a gris claro */
            border-radius: 2px;  /* Redondea las esquinas de los campos */
            margin-bottom: 2px;  /* Agrega un pequeño margen inferior para separar los campos */
            width: 100%;  /* Asegura que los campos de entrada ocupen todo el ancho disponible */
        }

        input[type="submit"],
		input[type="button"]{
            background-color: #007bff;  /* Establece el fondo del botón a verde */
            color: white;  /* Establece el color del texto del botón a blanco */
            border: none;  /* Elimina el borde por defecto del botón */
            padding: 10px 20px;  /* Agrega padding dentro del botón */
            font-size: 16px;  /* Establece el tamaño de la fuente del botón */
            border-radius: 5px;  /* Redondea las esquinas del botón */
            cursor: pointer;  /* Cambia el cursor al pasar por encima del botón */
            transition: background-color 0.3s ease;  /* Agrega una transición suave al cambiar el color del fondo */
        }

		/* Estilo para el botón reset */
        input[type="reset"] {
            background-color: #007bff;
            color: white;
            border: none;
			cursor: pointer;  /* Cambia el cursor al pasar por encima del botón */
            transition: background-color 0.3s ease;  /* Agrega una transición suave al cambiar el color del fondo */
        }
		
		input[type="submit"]:hover {
    background-color: red;  /* Color de fondo más oscuro */
}
		input[type="reset"]:hover {
    background-color: red;  /* Color de fondo más oscuro */
}
		
          input[type="button"]:hover {
    background-color: red;  /* Color de fondo más oscuro */
}

        a {
            text-decoration: none;  /* Elimina el subrayado del enlace */
            color: #4CAF50;  /* Establece el color del enlace a verde */
            font-weight: bold;  /* Establece el texto del enlace en negrita */
            text-align: center;  /* Centra el enlace */
            margin-top: 10px;  /* Agrega margen superior al enlace */
            display: block;  /* Hace que el enlace ocupe todo el ancho disponible */
        }

        a:hover {
            color: #45a049;  /* Cambia el color del enlace cuando el usuario pasa el cursor */
        }

        table {
            width: 100%;  /* Establece el ancho de la tabla al 100% */
            margin-top: 10px;  /* Agrega margen superior a la tabla */
        }

        td {
            padding: 8px;  /* Agrega padding dentro de las celdas de la tabla */
            text-align: left;  /* Alinea el texto de las celdas a la izquierda */
        }

        td input[type="text"] {
            width: 100%;  /* Asegura que los campos dentro de las celdas ocupen todo el ancho disponible */
        }

    </style>
</head>
<body>



<div class="container">
	<h1>Nuevo Alumno de ingenieria</h1>
    <?php
    if(isset($_POST['enviar'])){  /* Verifica si el formulario fue enviado */
        $nombre = strtoupper($_POST['nombre']);  /* Convierte el nombre a mayúsculas */
        $app = strtoupper($_POST['app']);  /* Convierte el apellido paterno a mayúsculas */
        $apm = strtoupper($_POST['apm']);  /* Convierte el apellido materno a mayúsculas */
        $dir = strtoupper($_POST['dir']);  /* Convierte la dirección a mayúsculas */
        $num = strtoupper($_POST['num']);  /* Convierte el número a mayúsculas */
        $col = strtoupper($_POST['col']);  /* Convierte la colonia a mayúsculas */
        $telefono = $_POST['telefono'];  /* Obtiene el número de teléfono */
        $mail = $_POST['mail'];  /* Obtiene el correo electrónico */
        $cuatrimestre = $_POST['cuatrimestre'];  /* Obtiene el cuatrimestre */
        
        include("conexion.php");  /* Incluye la conexión a la base de datos */
        $sql = "INSERT INTO ingenieria(nombre, app, apm, dir, num, col, telefono, mail, cuatrimestre)
                VALUES ('$nombre', '$app', '$apm', '$dir', '$num', '$col', '$telefono', '$mail', '$cuatrimestre')";
        
   

        // Verificar si el teléfono ya está registrado
        $sql_telefono = "SELECT * FROM ingenieria WHERE telefono = '$telefono'";
        $resultado_telefono = mysqli_query($conexion, $sql_telefono);
        if (mysqli_num_rows($resultado_telefono) > 0) {
            echo "<p style='color:red;'>Este teléfono ya está registrado.</p>";
        } else {
            // Verificar si el correo ya está registrado
            $sql_mail = "SELECT * FROM ingenieria WHERE mail = '$mail'";
            $resultado_mail = mysqli_query($conexion, $sql_mail);
            if (mysqli_num_rows($resultado_mail) > 0) {
                echo "<p style='color:red;'>Este correo electrónico ya está registrado.</p>";
            } else {
                // Si el teléfono y el correo no están registrados, insertamos los datos
                $sql = "INSERT INTO ingenieria(nombre, app, apm, dir, num, col, telefono, mail, cuatrimestre)
                        VALUES ('$nombre', '$app', '$apm', '$dir', '$num', '$col', '$telefono', '$mail', '$cuatrimestre')";
                
                $resultado = mysqli_query($conexion, $sql);
                if ($resultado) {
                    echo "<script language='JavaScript'>
                            alert('Los datos se agregaron correctamente.');
                            location.assign('ingenieria.php');
                          </script>";
                } else {
                    echo "<script language='JavaScript'>
                            alert('Hubo un error al agregar los datos.');
                            location.assign('index.php');
                          </script>";
                }
            }
        }

        mysqli_close($conexion);
    } else {
    ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <table>
                <tr>
                    <td><label for="nombre">Nombre</label></td>
                    <td><input type="text" style="text-transform: uppercase" name="nombre" id="nombre" required /></td>
                </tr>
                <tr>
                    <td><label for="app">Apellido Paterno</label></td>
                    <td><input type="text" style="text-transform: uppercase" name="app" id="app" required /></td>
                </tr>
                <tr>
                    <td><label for="apm">Apellido Materno</label></td>
                    <td><input type="text" style="text-transform: uppercase" name="apm" id="apm" required /></td>
                </tr>
                <tr>
                    <td><label for="dir">Dirección</label></td>
                    <td><input type="text" style="text-transform: uppercase" name="dir" id="dir" required /></td>
                </tr>
                <tr>
                    <td><label for="numero">Número de casa</label></td>
                    <td><input type="text" name="num" id="num" required />
                        <span id="mensaje-error-numero" style="color:red; display:none;">El número de casa debe ser entre 1 y 3 dígitos o 'S/N'.</span>
                    </td>
                </tr>
                <tr>
                    <td><label for="col">Colonia</label></td>
                    <td><input type="text" style="text-transform: uppercase" name="col" id="col" required /></td>
                </tr>
                <tr>
                    <td><label for="telefono">Teléfono</label></td>
                    <td><input type="tel" name="telefono" id="telefono" required pattern="\d{10}" maxlength="10" />
                        <span id="mensaje-error" style="color:red; display:none;">El teléfono debe tener 10 dígitos y no puede ser negativo.</span>
                    </td>
                </tr>
                <tr>
                    <td><label for="mail">Correo Electrónico</label></td>
                    <td><input type="text" name="mail" id="mail" required /></td>
                </tr>
                <tr>
                    <td><label for="cuatrimestre">Cuatrimestre</label></td>
                    <td><select name="cuatrimestre" required>
                        <option value="">Seleccione el cuatrimestre</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                    </select></td>
                </tr>
            </table>

			<input type="submit" name="enviar" value="Agregar Alumno" />
			
            <div class="form-buttons">
                <input type="reset" value="Cancelar">
                <input type="button" value="Ver lista" onclick="window.location.href='ingenieria.php';" />
				<input type="button" value="Regresar" onclick="window.location.href='principal.php';" />
            </div>
    
        </form>
    <?php } ?>
</div>
  
	<script>
    document.getElementById('num').addEventListener('input', function(event) {
        var numero = event.target.value;
        var mensajeError = document.getElementById('mensaje-error-numero');

        // Validar que el número de casa sea entre 1 y 3 dígitos o "S/N"
        if (!/^[0-9]{1,3}$/.test(numero) && numero !== "S/N") {
            mensajeError.style.display = 'block'; // Mostrar mensaje de error
        } else {
            mensajeError.style.display = 'none'; // Ocultar mensaje de error
        }
    });
</script>
	
	
	
	<script>
    document.getElementById('telefono').addEventListener('input', function(event) {
        var telefono = event.target.value;
        var mensajeError = document.getElementById('mensaje-error');

        // Validar que el teléfono tenga exactamente 10 dígitos
        if (telefono.length !== 10 || telefono < 0 || !/^\d{10}$/.test(telefono)) {
            mensajeError.style.display = 'block'; // Mostrar mensaje de error
        } else {
            mensajeError.style.display = 'none'; // Ocultar mensaje de error
        }
    });
</script>
	
	
	
</body>
</html>
