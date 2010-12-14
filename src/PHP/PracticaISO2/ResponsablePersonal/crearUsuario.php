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
$date = getdate();
$fecha = $date['year']."-".$date["mon"]."-".$date[mday];

$result = mysql_query('SELECT usuario FROM usuarios;');
//$row = mysql_fetch_array($result);
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

if ($existe) {
    if ($contrasena == $recontrasena) {
        if ($contrasena != "") {
            $result = mysql_query("INSERT INTO `grupo01`.`usuarios` (`id`, `usuario`, `password`, `descripcion`, `fecha`) VALUES (NULL, '" . $usuario . "' , '" . $contrasena . "', '" . $categoria . "', '".$fecha."');");
            echo'<script type="text/javascript">
                alert("Nuevo usuario introducido con exito");
            document.location.href="iniResponsablePersonal.php";
            </script>';
        } else {
            echo'<script type="text/javascript">
            alert("Debe introducir una contraseña");
            document.location.href="iniResponsablePersonal.php";
            </script>';
        }
    } else {
        echo'<script type="text/javascript">
            alert("Los dos campos de contraseña deben ser iguales");
            document.location.href="iniResponsablePersonal.php";
            </script>';
    }
}
$conexion->cerrarConexion();
//mysql_close();
?>
