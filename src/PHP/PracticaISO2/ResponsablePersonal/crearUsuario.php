<?php

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

$result = mysql_query('SELECT login FROM Usuario;');
$existe = true;
while ($row = mysql_fetch_array($result)) {
    if ($row['login'] == $usuario) {
        $existe = false;
        echo'<script type="text/javascript">
            alert("El usuario ya existe");
            document.location.href="iniResponsablePersonal.php";
            </script>';
    }
}

    $result = mysql_query('SELECT dni FROM Trabajador;');
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
    $result = mysql_query("INSERT INTO `grupo01`.`Usuario` (`login`, `password`, `tipoUsuario`) VALUES ('" . utf8_encode($usuario) . "' , '" . utf8_encode($contrasena) . "', 'T');");
    $result = mysql_query("INSERT INTO `grupo01`.`Trabajador` (`dni`, `nombre`, `apellidos`, `fechaNac`, `categoria` , `Usuario_login`) VALUES ('".utf8_encode($dni)."', '" . utf8_encode($nombre) . "' , '" . utf8_encode($apellidos) . "', '" . $fechanac . "', '" . utf8_encode($categoria) . "', '" . utf8_encode($usuario) . "');");
    echo'<script type="text/javascript">
            document.location.href="iniResponsablePersonal.php?creadoUsuario=true";
            </script>';
}
$conexion->cerrarConexion();
?>
