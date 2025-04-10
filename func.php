<?php                                   
/* Funciones para una interfaz de base de datos simple  */
/* ---------------------------------------------------- */

function send_sql($conexion, $sql) 
	{
		 if (! $res = mysqli_query( $conexion, $sql ))
	{
		   echo mysql_error();
		   exit;
	}
		   return $res;
	}

function tab_out($result) 
	{
		//calcula el numero de campos de la consulta
		$cant=mysqli_num_fields($result);
		//define el ancho de cada columna, en base al numero de campos calculados
		$ancho=100/$cant."%";
		//define los colores y el tamaño para las celdas con el nombre de los campos
		echo "<table width=100% border=0 cellpadding='2' cellspacing='2'>";
		echo "<tr bgcolor=#D0D0D0>";
		//obtiene los e imprime los nombre de cada campo
		for ($i=0;$i<$cant;$i++)
	 	{
			echo "<th width='$ancho'><font size='1'> ";
			echo mysqli_fetch_field_direct($result,$i)->name;
			echo "</font> </th>";
		}
		echo "</tr>";
		echo "<tr>";
		//obtiene el numero de registros de la consulta
		$num = mysqli_num_rows($result);
		for ($j = 0; $j < $num; $j++) 
		{
			//guarda en un arreglo, los valores del registro actual
			$row = mysqli_fetch_array($result);
			echo "<table width=100% border=0 cellpadding='2' cellspacing='2'>";
			echo "<tr bgcolor=#00FFFF>";
			//marca el campo del registro actual
			for ($k=0;$k<$cant;$k++)
			{
				//obtiene el valor del campo del registro actual
				$fn=mysqli_fetch_field_direct($result,$k)->name;
				//imprime el valor del campo
				echo " <td width='$ancho'> <font size='1'> $row[$fn] </font> </td> " ;
			}
			echo "<tr>";
			echo "</tr>";
			}
			echo "</table>";
		}
 
?>
