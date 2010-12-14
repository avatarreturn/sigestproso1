<?php

include_once ('../Persistencia/conexion.php');

//crear la conexion
$conexion = new conexion();

//datos recibidos del form
$jefeProyecto = $_POST['jefesProyecto'];
$nombre = $_POST['nombre'];
$fecha = date('d-m-Y');
$descripcion = $_POST['descripcion'];

//insertar en la base de datos A LA ESPERA DE LA TABLA DE PATRICIA
//$result = mysql_query("INSERT INTO `grupo01`.`proyectos` (`id`, `usuario`, `password`, `descripcion`, `fecha`) VALUES (NULL, '" . $usuario . "' , '" . $contrasena . "', '" . $categoria . "', '".$fecha."');");

echo'<script type="text/javascript">
        alert("Nuevo proyecto creado con exito");
        document.location.href="crearProyecto.php";
    </script>';

//cierre de la conexion
$conexion->cerrarConexion();
?>
