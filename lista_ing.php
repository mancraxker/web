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
// Conectar a la base de datos
include("conexion.php"); // Asegúrate de que "conexion.php" esté configurado correctamente

// Consulta para obtener los catedráticos
$query_catedratico = "SELECT id, nombre, app, apm FROM catedraticos"; // Asegúrate de que el nombre de la tabla y columnas coincidan
$result_catedratico = mysqli_query($conexion, $query_catedratico);

// Consulta para obtener los cuatrimestres (esto depende de cómo tengas organizados los cuatrimestres)
$query_cuatrimestre = "SELECT id, nombre FROM cuatrimestres"; // Asegúrate de que el nombre de la tabla y columnas coincidan
$result_cuatrimestre = mysqli_query($conexion, $query_cuatrimestre);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Lista de Asistencia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-top: 50px;
            color: #333;
        }
        form {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        label {
            font-size: 16px;
            margin-bottom: 10px;
            display: block;
            color: #555;
        }
        select, input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        select:focus, input[type="date"]:focus {
            border-color: #4CAF50;
            outline: none;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #002416;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #007690;
        }
		
		a {
          width: 100%;
            padding: 10px;
            background-color: #002416;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
	     text-decoration: none;
			text-align: center;
       }

         a:hover {
        background-color: #007690; /* Cambia el color al pasar el cursor */
       }
		/* Estilo de los botones */
        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            gap: 10px; /* Agregar espacio entre los botones */
        }
    </style>
</head>
<body>

<h2>Generar Lista de Asistencia</h2>

<form method="GET" action="lista_ingenieria.php">
  <label for="catedratico">Catedrático:</label>
  <select name="catedratico" id="catedratico">
    <?php
    while ($row = mysqli_fetch_assoc($result_catedratico)) {
        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . '  ' . $row['app'] . '  '. $row['apm'] . "</option>";
    }
    ?>
  </select>

  <label for="cuatrimestre">Cuatrimestre:</label>
  <select name="cuatrimestre" id="cuatrimestre">
    <?php
    while ($row = mysqli_fetch_assoc($result_cuatrimestre)) {
        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
    }
    ?>
  </select>

  <label for="fecha">Fecha:</label>
  <select name="fecha" id="fecha">
    <option value="1">Enero - Abril</option>
    <option value="2">Mayo - Agosto</option>
    <option value="3">Septiembre - Diciembre</option>
  </select>
  
<div class="form-buttons">
  <button type="submit">Generar lista de asistencia</button>
  <a href="principal.php">Regresar</a> 
	</div> 	
	
</form>

	</body>
</html>