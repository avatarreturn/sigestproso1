<?php

//session_start();
include_once ('../Persistencia/conexion.php');

//datos para establecer la conexion con la base de mysql.
//$conexion = mysql_connect('localhost', 'grupo01', '0F9RLuM8') or die('ERROR EN LA CONEXION: ' . mysql_error());
$conexion = new conexion();
//mysql_select_db('grupo01') or die('ERROR AL ESCOJER LA BD: ' . mysql_error());
$usuario = $_POST['nick'];
$contrasena = $_POST['password'];
$categoria = $_POST['categoria'];
$recontrasena = $_POST['repassword'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$dni = $_POST['dni'];
$fechanac = $_POST['anio']."-".$_POST['mes']."-".$_POST['dias'];
$date = getdate();
$fecha = $date['year'] . "-" . $date["mon"] . "-" . $date[mday];

$result = mysql_query('SELECT usuario FROM usuarios;');
$existe = true;
while ($row = mysql_fetch_array($result)) {
    if ($row['usuario'] == $usuario) {
        $existe = false;
        echo'<script type="text/javascript">
            alert("El usuario ya existe");
            document.location.href="iniResponsablePersonal.php";
            </script>';
    }
}

    $result = mysql_query('SELECT dni FROM trabajador;');
$existet = true;
while ($row = mysql_fetch_array($result)) {
    if ($row['dni'] == $dni) {
        $existet = false;
        echo'<script type="text/javascript">
            alert("Ya existe otro trabajador con este DNI");
            document.location.href="iniResponsablePersonal.php";
            </script>';
    }

}

if ($existe && $existet) {
    $result = mysql_query("INSERT INTO `grupo01`.`usuarios` (`id`, `usuario`, `password`, `descripcion`, `fecha`) VALUES (NULL, '" . $usuario . "' , '" . $contrasena . "', '" . $categoria . "', '" . $fecha . "');");
    $result = mysql_query("INSERT INTO `grupo01`.`trabajador` (`dni`, `nombre`, `apellidos`, `fechaNacimiento`, `categoria`) VALUES ('".$dni."', '" . $nombre . "' , '" . $apellidos . "', '" . $fechanac . "', '" . $categoria . "');");
    echo'<script type="text/javascript">
                alert("Nuevo usuario introducido con exito");
            document.location.href="iniResponsablePersonal.php?creadoUsuario=true";
            </script>';
}
$conexion->cerrarConexion();
?>
