<?php

include_once ('../Persistencia/conexion.php');

//crear la conexion
$conexion = new conexion();

//datos recibidos del form
$rol = $_POST['rol'];
$categoria = $_POST['selectCategorias'];
$numMaxCategoria=$_POST['numMaxCategoria'];


//LA CATEGORÍA MÁXIMA SE ALMACENA EN LA TABLA CONFIGURACIÓN COMO UN UPDATE
$categoriaMaxima=mysql_query("UPDATE Configuracion SET categoriaMaxima='".$numMaxCategoria."' where idConfiguracion='1'");
//LA RELACIÓN CATEGORIA-ROL SE ALMACENA EN LA TABLA ROL COMO UN INSERT
$result = mysql_query("INSERT INTO Rol (`idRol`, `nombre`, `categoria`) VALUES (NULL, '".$rol."','".$categoria."');");

//cierre de la conexion
$conexion->cerrarConexion();

echo'<script type="text/javascript">
        document.location.href="cargarDatos.php?creadoProyecto=true";
    </script>';
?>
