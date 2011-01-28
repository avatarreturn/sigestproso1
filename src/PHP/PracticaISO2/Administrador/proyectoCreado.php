<?php

include_once ('../Persistencia/conexion.php');

//crear la conexion
$conexion = new conexion();

//datos recibidos del form
$jefeProyecto = $_POST['jefeProyecto'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];

//ver si el proyecto existe
$consulta = mysql_query("SELECT * FROM Proyecto WHERE nombre like '" . $nombre . "'");
$numeroResultados = mysql_num_rows($consulta);
if ($numeroResultados > 0) {
    //ya existe, dar error
    echo'<script type="text/javascript">
        window.location.href="crearProyecto.php?proyectoNoCreado=true";
    </script>';
} else {
    //no existe
    //insertar en la base de datos
    $result = mysql_query("INSERT INTO Proyecto (idProyecto, nombre, fechaInicio, fechaFin, descripcion, jefeProyecto) VALUES (NULL, '" . utf8_encode($nombre) . "' , NULL, NULL, '" . utf8_encode($descripcion) . "', '" . utf8_encode($jefeProyecto) . "') ");

    //cierre de la conexion
    $conexion->cerrarConexion();

    echo'<script type="text/javascript">
        window.location.href="crearProyecto.php?proyectoCreado=true";
    </script>';
}
?>

