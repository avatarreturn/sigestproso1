<?php

include_once ('../Persistencia/conexion.php');

//crear la conexion
$conexion = new conexion();

//datos recibidos del form
$numMaxCategoria=$_GET['categoria'];


//LA CATEGORÍA MÁXIMA SE ALMACENA EN LA TABLA CONFIGURACIÓN COMO UN UPDATE
$categoriaMaxima=mysql_query("UPDATE Configuracion SET categoriaMaxima='".$numMaxCategoria."' where idConfiguracion='1'");


//cierre de la conexion
$conexion->cerrarConexion();
?>
