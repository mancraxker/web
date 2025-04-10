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
   $id=$_GET['id'];
  include("conexion.php");
  
   $sql="delete from derecho where id='".$id."'";
   $resultado=mysqli_query($conexion,$sql);

   if($resultado){
     echo "<script language='JavaScript'>
             alert ('los datos se eliminaron');
	      location.assign('derecho.php');
	      </script>";
  }else{
	  echo "<script language='JavaScript'>
		  alert ('los datos NO se eliminaron');
	      location.assign('index.php');
	      </script>";
  }
    mysqli_close($conexion);
  
   
?>
