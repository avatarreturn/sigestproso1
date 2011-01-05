<?php
include_once('Persistencia/conexion.php');

session_start();

//crear la conexion
$conexion = new conexion();

//datos recibidos del form
$numMaxProyectos = $_POST['numMaxProyect'];

//insertar en la base de datos
mysql_query("INSERT INTO configuracion (idConfiguracion, numMaxProyectos, categoriaMaxima) VALUES ('NULL', '".$numMaxProyectos."' , 'NULL')");

//cierre de la conexion
$conexion->cerrarConexion();

//lo guardo como vairable de sesion
$_SESSION['numMaxProyectos'] = $numMaxProyectos;

//redireccion a la pagina de validacion de usuario
echo'<script type="text/javascript">
    document.location.href="logearse.php";
    </script>';
?>
