<?php

include_once ('../Persistencia/conexion.php');

//crear la conexion
$conexion = new conexion();

//datos recibidos del form
$rol = $_POST['rol'];
$categoria = $_POST['selectCategorias'];


//insertar en la base de datos A LA ESPERA DE LA TABLA DE PATRICIA
//$result = mysql_query("INSERT INTO `grupo01`.`proyectos` (`id`, `usuario`, `password`, `descripcion`, `fecha`) VALUES (NULL, '" . $usuario . "' , '" . $contrasena . "', '" . $categoria . "', '".$fecha."');");


echo'<script type="text/javascript">
        document.location.href="cargarDatos.php?creadoProyecto=true";
    </script>';

//cierre de la conexion
$conexion->cerrarConexion();
?>
