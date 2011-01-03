<?php
include_once('Persistencia/conexion.php');

//crear la conexion
$conexion = new conexion();

//datos recibidos del form
$numMaxProyectos = $_POST['numMaxProyect'];

//insertar en la base de datos
$result = mysql_query('INSERT INTO grupo01.configuracion (idConfiguracion, numMaxProyectos, categoriaMaxima) VALUES (NULL, \' '.$numMaxProyectos.' \' , NULL');


//cierre de la conexion
$conexion->cerrarConexion();
?>
