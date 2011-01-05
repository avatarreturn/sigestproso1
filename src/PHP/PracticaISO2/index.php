<?php
include_once('Persistencia/conexion.php');

session_start();

//se crea la conexion
$conexion = new conexion();
//se realiza la consulta
$consulta = mysql_query('SELECT numMaxProyectos FROM configuracion');
$row2 = mysql_fetch_array($consulta);
$numMaxProyectos = $row2[0];


if ($numMaxProyectos != null) {
    //ya se ha introducido el numero maximo de proyectos
    $_SESSION['numMaxProyectos'] = $numMaxProyectos;
    echo'<script type="text/javascript">
    document.location.href="logearse.php";
    </script>';
} else {
    //no se ha introducido el numero maximo de proyectos
    echo'<script type="text/javascript">
    document.location.href="insertarNumMaxProyectos.php";
    </script>';
}
?>
