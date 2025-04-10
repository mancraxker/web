<?php
include("conexion.php"); // Conexión a la base de datos
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    // Si no está logueado, redirige al login
    header('Location: index.html');
    exit();
}

// Obtener los datos del usuario logueado
$username = $_SESSION['usuario'];
$sql = "SELECT * FROM administradores WHERE username = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$resultado = $stmt->get_result();
$user = $resultado->fetch_assoc();

if (!$user) {
    // Si no se encuentra el usuario, redirigir al login
    header("Location: index.html");
    exit();
}

?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Desplegable</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: MV Boli;
        }

        body {
            background-color: white;
            background-size: cover;
			
        }

        /* Estilos para el icono de usuario */
        .user-profile {
            position: absolute;
            top: 30px;
            right: 20px;
            display: flex;
            align-items: center;
            background-color: white;
            padding: 5px;
            border-radius: 5px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
			font-family: century;
        }

        .user-profile:hover {
            background-color: #005b73;
        }

        .user-profile i {
            font-size: 1rem;
            margin-right: 10px;
        }

        .user-profile span {
            font-size: 1.1rem;
            color: black;
        }

        .user-dropdown {
            display: none;
            position: absolute;
            top: 40px;
            right: 0;
            background-color: #fff;
            color: #333;
            border-radius: 5px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
            width: 200px;
            padding: 15px;
			font-family: century;
            z-index: 100;
        }

        .user-profile:hover .user-dropdown {
            display: block;
        }

        .user-dropdown p {
            margin-bottom: 10px;
            font-size: 12px;
        }

        .user-dropdown strong {
            font-weight: 600;
        }

        .user-dropdown a {
            display: block;
            text-decoration: none;
            color: #007690;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .user-dropdown a:hover {
            background-color: #f1f1f1;
        }

        /* Logo fuera del contenedor */
        .logo {
    position: absolute;
    top: 207px;
    left: 450px;
    width: 456px;
    height: 394px;
    z-index: 10;
        }

        /* Estilos del encabezado */
        header {
            width: 100%;
            background-color: #007690;
            color: white;
            padding: 30px 50px;
            text-align: center;
        }

        /* Estilos del pie de página */
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 66px;
            background-color: #007690;
            color: white;
            text-align: center;
            padding: 5px;
            z-index: 5;
        }

        nav {
            max-width: 210px;
            background-color: cornflowerblue;
            font-size: 28px;
            margin-top: 50px;
			margin-left: 70px;  /*centra en formulario - izquierda*/ 
        }

    /* Menú Principal Vertical */
.menu-horizontal {
    list-style: none;
    display: block; /* Menú en columna */
    padding: 0;
    margin: 0;
    background-color: cornflowerblue;
    font-size: 20px;
	font-family: MV Boli;
}

.menu-horizontal > li {
    position: relative;
    margin-bottom: 10px; /* Espaciado entre los elementos */
}

.menu-horizontal > li > a {
    display: block;
    padding: 10px 22px;
    color: white;
    text-decoration: none;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

/* Efecto hover: cambiar el color de fondo y añadir sombra */
.menu-horizontal > li:hover > a {
    background-color: #F72024;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
}

.menu-horizontal > li:hover {
    background-color: #F72024; /* Cambiar color al pasar sobre el ítem */
}

/* Indicador de flecha para los submenús */
.menu-horizontal > li > a:after {
    content: " ▼";
    font-size: 12px;
    color: white;
    margin-left: 10px;
    transition: transform 0.3s ease;
}

/* Cambio de flecha cuando el submenú está visible */
.menu-horizontal > li:hover > a:after {
    transform: rotate(180deg); /* Rotar la flecha */
}

/* Submenú Vertical */
.menu-vertical {
    display: none;
    list-style: none;
    background-color: rgba(0, 0, 0, 0.8);
    transition: opacity 0.3s ease-in-out, transform 0.3s ease;
    opacity: 0;
    visibility: hidden;
    position: absolute;
    top: 0;
    left: 100%; /* Posiciona los submenús a la derecha del menú principal */
    white-space: nowrap;
    display: block; /* Submenú en columna */
    transform: translateX(10px); /* Desplazamiento hacia la derecha para el efecto de deslizamiento */
}

/* Mostrar submenús al pasar el ratón */
.menu-horizontal li:hover .menu-vertical {
    display: block;
    opacity: 1;
    visibility: visible;
    transform: translateX(0); /* Desplazar el submenú hacia la izquierda */
}

/* Submenú: Efecto hover */
.menu-vertical li {
    margin-bottom: 0; /* Eliminar márgenes para alineamiento vertical */
}

.menu-vertical li a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    font-size: 16px;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

/* Efecto hover en los submenús */
.menu-vertical li:hover {
    background-color: lightslategray;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Sombra en submenú */
}

/* Efecto de desvanecimiento en los submenús */
.menu-vertical li a:hover {
    background-color: #444;
}

/* Menú Usuario: Efecto hover en la imagen */
.user-profile:hover {
    background-color: #005b73;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

/* Sombra sutil en el menú principal */
.menu-horizontal > li > a:hover {
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
}


        i {
            font-size: 1.2rem;
            margin: 0 10px;
            color: black;
            transition: color 0.3s ease;
        }

        a:hover i {
            color: #007bff;
        }

      

        #html {
            margin: auto;
            padding: 20px;
            max-width: 50px;
            background: white;
        }

        a {
            text-decoration: none;
            color: white;
            font-family: GINEBRA;
            font-size: 16px;
        }
		
		h1{
		  font-family: GINEBRA;
		}
    </style>
</head>

<body>

    <!-- Logo -->
    <img src="img/logosinfondo.png" alt="Logo de la empresa" height="141" class="logo">

    <header>
      <h1>PCR SOLUTION</h1>
    </header>

    <nav>
        <ul class="menu-horizontal">
            <li>
                <a href="#">Carrera</a>
                <ul class="menu-vertical">
                    <li><a href="ingenieria.php">Ingenieria</a></li>
                    <li><a href="derecho.php">Derecho</a></li>
                    <li><a href="sociales.php">Sociales</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Catedráticos</a>
                <ul class="menu-vertical">
                    <li><a href="catedraticos.php">Catedrático de Ingeniería</a></li>
                    <li><a href="catedraticos_der.php">Catedrático de Derecho</a></li>
                    <li><a href="catedraticos_sol.php">Catedrático de Sociales</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Agregar</a>
                <ul class="menu-vertical">
                    <li><a href="agregar_ing.php">Alumno de Ingeniería</a></li>
                    <li><a href="agregar_der.php">Alumno de Derecho</a></li>
                    <li><a href="agregar_sol.php">Alumno de Sociales</a></li>
                    <li><a href="agregar_cat_ing.php">Catedrático de Ingeniería</a></li>
                    <li><a href="agregar_cat_der.php">Catedrático de Derecho</a></li>
                    <li><a href="agregar_cat_sol.php">Catedrático de Sociales</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Generar lista</a>
                <ul class="menu-vertical">
                    <li><a href="lista_ing.php">Lista de Ingeniería</a></li>
                    <li><a href="lista_der.php">Lista de Derecho</a></li>
                    <li><a href="lista_sol.php">Lista de Sociales</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Generar Diploma</a>
                <ul class="menu-vertical">
                    <li><a href="Cer_ing.php">Ingeniería</a></li>
                    <li><a href="Cer_der.php">Derecho</a></li>
                    <li><a href="Cer_sol.php">Sociales</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Usuario Icono y Desplegable -->
    <div class="user-profile">
        <i class="fas fa-user"></i>
        <span><?php echo isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Invitado'; ?></span>
        <div class="user-dropdown">
            <p><strong>Nombre:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Correo:</strong> <?php echo $user['email']; ?></p>
            <a href="../PCR/cerrar_sesion.php">Cerrar sesión</a>
        </div>
    </div>

    <footer>
        <a href="principal.php">© PCR. Todos los derechos reservados 2025</a>
        <br>
        <a href="https://www.facebook.com/profile.php?id=61575096358856" target="_blank" title="Facebook"><i class="fab fa-facebook"></i></a>
        <a href="https://www.instagram.com/pcr_solution?igsh=YzljYTk1ODg3Zg==" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://youtube.com/@esmeraldadiaz1183?si=kb2Y6E6vdGZQ_5t-" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
    </footer>
<!-- 
/* Menú Principal Vertical */
.menu-horizontal {
    list-style: none;
    display: block; /* Menú en columna */
    padding: 0;
    margin: 0;
    background-color: cornflowerblue;
    font-size: 20px;
}

.menu-horizontal > li {
    position: relative;
    margin-bottom: 10px; /* Espaciado entre los elementos */
}

.menu-horizontal > li > a {
    display: block;
    padding: 10px 22px;
    color: white;
    text-decoration: none;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

/* Efecto hover: cambiar el color de fondo y añadir sombra */
.menu-horizontal > li:hover > a {
    background-color: #F72024;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
}

.menu-horizontal > li:hover {
    background-color: #F72024; /* Cambiar color al pasar sobre el ítem */
}

/* Indicador de flecha para los submenús */
.menu-horizontal > li > a:after {
    content: " ▼";
    font-size: 12px;
    color: white;
    margin-left: 10px;
    transition: transform 0.3s ease;
}

/* Cambio de flecha cuando el submenú está visible */
.menu-horizontal > li:hover > a:after {
    transform: rotate(180deg); /* Rotar la flecha */
}

/* Submenú Vertical */
.menu-vertical {
    display: none;
    list-style: none;
    background-color: rgba(0, 0, 0, 0.8);
    transition: opacity 0.3s ease-in-out, transform 0.3s ease;
    opacity: 0;
    visibility: hidden;
    position: absolute;
    top: 0;
    left: 100%; /* Posiciona los submenús a la derecha del menú principal */
    white-space: nowrap;
    display: block; /* Submenú en columna */
    transform: translateX(10px); /* Desplazamiento hacia la derecha para el efecto de deslizamiento */
}

/* Mostrar submenús al pasar el ratón */
.menu-horizontal li:hover .menu-vertical {
    display: block;
    opacity: 1;
    visibility: visible;
    transform: translateX(0); /* Desplazar el submenú hacia la izquierda */
}

/* Submenú: Efecto hover */
.menu-vertical li {
    margin-bottom: 0; /* Eliminar márgenes para alineamiento vertical */
}

.menu-vertical li a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    font-size: 16px;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

/* Efecto hover en los submenús */
.menu-vertical li:hover {
    background-color: lightslategray;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Sombra en submenú */
}

/* Efecto de desvanecimiento en los submenús */
.menu-vertical li a:hover {
    background-color: #444;
}

/* Menú Usuario: Efecto hover en la imagen */
.user-profile:hover {
    background-color: #005b73;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

/* Sombra sutil en el menú principal */
.menu-horizontal > li > a:hover {
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
}

-->
</body>

</html>



