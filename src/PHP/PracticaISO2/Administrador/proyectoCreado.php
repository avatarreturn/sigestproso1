<?php

include_once ('../Persistencia/conexion.php');

//crear la conexion
$conexion = new conexion();

//datos recibidos del form
$jefeProyecto = $_POST['jefesProyecto'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];

//insertar en la base de datos A LA ESPERA DE LA TABLA DE PATRICIA
$result = mysql_query('INSERT INTO grupo01.proyecto (idProyecto, nombre, fechaInicio, fechaFin, descripcion, jefeProyecto) VALUES (NULL, \' '.$nombre.' \' , NULL, NULL, \' '.$descripcion.' \', \' '.$jefeProyecto.' \' ');

echo'<script type="text/javascript">
        document.location.href="crearProyecto.php?creadoProyecto=true";
    </script>';

//cierre de la conexion
$conexion->cerrarConexion();
?>
