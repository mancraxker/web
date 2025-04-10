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
include("conexion.php"); // Conexión a la base de datos

// Verifica si se seleccionó un cuatrimestre
$cuatrimestreSeleccionado = isset($_GET['cuatrimestre']) ? $_GET['cuatrimestre'] : '';
$sql = "SELECT * FROM derecho";

// Consulta por cuatrimestre si se seleccionó uno
if (!empty($cuatrimestreSeleccionado)) {
    $sql .= " WHERE cuatrimestre = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $cuatrimestreSeleccionado);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
} else {
    $resultado = mysqli_query($conexion, $sql);
}

// Manejo de búsqueda por nombre o teléfono
if (isset($_POST['enviar'])) {
    $nombre = $_POST['nombre']; // Obtenemos el valor del campo nombre
    $telefono = $_POST['telefono']; // Obtenemos el valor del campo teléfono

    // Validación para asegurar que al menos uno de los campos esté lleno
    if (empty($nombre) && empty($telefono)) {
        echo "<script language='JavaScript'>
                alert('Ingresa el nombre o el teléfono');
                location.assign('cer_der.php');
              </script>";
    } else {
        // Inicia la consulta básica
        $sql = "SELECT * FROM derecho WHERE 1=1";

        // Si el nombre no está vacío, realizamos una búsqueda por nombre con LIKE
        if (!empty($nombre)) {
            $sql .= " AND nombre LIKE ?";
        }

        // Si el teléfono no está vacío, realizamos una búsqueda por teléfono con LIKE
        if (!empty($telefono)) {
            $sql .= " AND telefono LIKE ?";
        }

        // Preparamos la sentencia
        $stmt = mysqli_prepare($conexion, $sql);

        // Variables para almacenar las cadenas con los comodines
        $nombre_concatenado = $nombre . '%';
        $telefono_concatenado = $telefono . '%';

        // Si ambos campos están presentes, los vinculamos a los parámetros de la consulta
        if (!empty($nombre) && !empty($telefono)) {
            mysqli_stmt_bind_param($stmt, "ss", $nombre_concatenado, $telefono_concatenado); // Agregamos el "%" para que busque coincidencias parciales
        } elseif (!empty($nombre)) {
            mysqli_stmt_bind_param($stmt, "s", $nombre_concatenado); // Solo el nombre
        } elseif (!empty($telefono)) {
            mysqli_stmt_bind_param($stmt, "s", $telefono_concatenado); // Solo el teléfono
        }

        // Ejecutamos la consulta
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
    }
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de alumnos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       /* Estilos generales del body */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
		  
		 /* Estilo del título */
        h1 {
            text-align: center;
            font-size: 28px;
            color: #333;
        }
		
		.titulo-contenedor {
        display: inline-flex;
        align-items: center; /* Centra verticalmente los elementos */
        justify-content: center; /* Centra horizontalmente los elementos */
      }

.titulo-contenedor h1 {
    margin-right: 820px; /* Espacio entre el título y el icono */
	font-family: Mv Boli;
}
		
		 .home-link i {
         font-size: 1.9rem;  /* Tamaño del icono */
         color: #007690;  /* Cambia el color del icono a azul */
        }

      .home-link:hover i {
       color: #28a745;  /* Cambia el color cuando se pasa el cursor */
      }
		
        /* Estilo para las tablas */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 0px;
        }

        /* Estilo para las celdas de la tabla */
        th, td {
            text-align: center;
            padding: 8px;
            font-size: 14px;
        }

        /* Color de fondo para las cabeceras */
        th {
            background-color: #007690;
            color: white;
        }

        /* Estilo para las filas alternas */
        tr:nth-child(even) {
            background-color: cadetblue;
        }
        
        tr:nth-child(odd) {
            background-color: #e0f7fa;
        }

        /* Estilo para los labels y los inputs */
        label {
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            margin-right: 10px; /* Espacio entre el label y el input */
            width: 100px; /* Ancho fijo para los labels */
        }

        input[type="text"], input[type="number"], input[type="tel"], select, input[type="submit"] {
            padding: 8px;
            margin: 8px 0;
            width: calc(100% - 20px); /* Para que el input se ajuste al contenedor */
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        /* Estilo para el botón de enviar */
        input[type="submit"] {
            background-color: #002416;
            color: white;
            border: none;
            cursor: pointer;
			width: auto;
        }

        /* Efecto hover para el botón de enviar */
        input[type="submit"]:hover {
            background-color: #007690;
        }

        /* Estilos para los enlaces de acción */
        .btn, .editar, .eliminar{
            padding: 6px 12px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            display: inline-block;
            margin: 4px 2px;
            transition: background-color 0.3s;
        }
		

        /* Estilos para el enlace de mostrar todos los alumnos */
        a.mostrar-todos {
            background-color: #002416;
        }

        a.mostrar-todos:hover {
            background-color: #007690;
        }

        /* Estilos para el enlace de nuevo alumno */
        a.nuevo-alumno {
            background-color: #002416;
        }

        a.nuevo-alumno:hover {
            background-color: #007690;
        }

        /* Estilos para el enlace de regresar */
        a.regresar {
            background-color: #002416;
        }

        a.regresar:hover {
            background-color: #007690;
        }
		
		.actions a {
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .actions a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="titulo-contenedor">
        <h1>Generar diplomas - Derecho</h1>
        <a href="principal.php" title="Volver a la página inicial" class="home-link">
            <i class="fas fa-home"></i>
        </a>    
    </div>

    <form method="POST" action="Cer_der.php">
        <table>
            <tr>
                <td>
                    <label for="nombre">Nombre:</label>
                    <input type="text" style="text-transform: uppercase" id="nombre" name="nombre" >
                </td>
                <td>
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" >
                </td>
                <td>
                    <input type="submit" name="enviar" value="BUSCAR">
                </td>
                <td>
                    <a class="btn mostrar-todos" href="Cer_der.php">Mostrar todos los alumnos</a>
                </td>
               <!-- Botón para generar certificados para todos los alumnos -->
            <td>
                <a href="Certificado_der_todos.php?cuatrimestre=<?= $cuatrimestreSeleccionado ?>" class="btn" style="background-color: #28a745;">Generar Certificados por cuatrimestre</a>
            </td>
				
				<td>
                <a href="Certificado_der_todos.php" class="btn" style="background-color: #28a745;">Generar Certificados para todos</a>
            </td>
				
            </td>
            </tr>
        </table>
    </form>

    <form method="GET" action="">
        <label for="cuatrimestre">Cuatrimestre:</label>
        <select name="cuatrimestre" id="cuatrimestre" onchange="this.form.submit()">
            <option value="">Todos los cuatrimestres</option>
            <option value="1" <?= $cuatrimestreSeleccionado == '1' ? 'selected' : '' ?>>1° Cuatrimestre</option>
            <option value="2" <?= $cuatrimestreSeleccionado == '2' ? 'selected' : '' ?>>2° Cuatrimestre</option>
            <option value="3" <?= $cuatrimestreSeleccionado == '3' ? 'selected' : '' ?>>3° Cuatrimestre</option>
            <option value="4" <?= $cuatrimestreSeleccionado == '4' ? 'selected' : '' ?>>4° Cuatrimestre</option>
            <option value="5" <?= $cuatrimestreSeleccionado == '5' ? 'selected' : '' ?>>5° Cuatrimestre</option>
            <option value="6" <?= $cuatrimestreSeleccionado == '6' ? 'selected' : '' ?>>6° Cuatrimestre</option>
            <option value="7" <?= $cuatrimestreSeleccionado == '7' ? 'selected' : '' ?>>7° Cuatrimestre</option>
			
        </select>
	
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>A. Paterno</th>
                <th>A. Materno</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Cuatrimestre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultado && mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id']}</td>
                            <td>{$fila['nombre']}</td>
                            <td>{$fila['app']}</td>
                            <td>{$fila['apm']}</td>
                            <td>{$fila['dir']}</td>
                            <td>{$fila['telefono']}</td>
                            <td>{$fila['mail']}</td>
                            <td>{$fila['cuatrimestre']}</td>
                           <td class='actions'>
                                <a href='Certificado_der.php?id={$fila['id']}'>Generar Certificado</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No existe alumno</td></tr>";
            }
            mysqli_close($conexion);
            ?>
        </tbody>
    </table>
</body>
</html>
