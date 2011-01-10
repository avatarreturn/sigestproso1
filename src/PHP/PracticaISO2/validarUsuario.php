<?php

include_once('Persistencia/conexion.php');
include_once('Negocio/Usuario.php');
include_once('Negocio/Trabajador.php');

session_start();

//crear la conexion
$conexion = new conexion();

if (trim($_POST['login']) != "" && trim($_POST['password']) != "") {
    $loginIntroducido = $_POST['login'];
    $passwordIntroducido = $_POST['password'];

    //comprobar login y tipo de usuario
    //el dni solo si es trabajador, no para administrador y responsable de personal
    $result = mysql_query("SELECT login FROM Usuario WHERE (login= '" . $loginIntroducido . "')");

    if ($row = mysql_fetch_array($result)) {
        //hay resultados, el usuario existe
        $usuarioExistente = Usuario::getUsuario($row[0]);
        $_SESSION['login'] = $usuarioExistente->getLogin();
        $_SESSION['password'] = $usuarioExistente->getPassword();
        $_SESSION['tipoUsuario'] = $usuarioExistente->getTipo();

        if ($_SESSION['password'] == $passwordIntroducido) {
            //el usuario es valido, se trata de un trabajador


            if ($_SESSION['tipoUsuario'] == "A") {
                //ADMINISTRADOR
                echo'<script type="text/javascript">
                document.location.href="Administrador/crearProyecto.php";
                </script>';
            } else {
                if ($_SESSION['tipoUsuario'] == "R") {
                    //RSPONSABLE PERSONAL
                    echo'<script type="text/javascript">
                    document.location.href="ResponsablePersonal/iniResponsablePersonal.php";
                    </script>';
                } else {
                    //JEFE PROYECTO - DESARROLLADOR
                    $datos = mysql_query("SELECT dni FROM trabajador WHERE (Usuario_login= '" . $_SESSION['login'] . "')");
                    while ($resultado = mysql_fetch_array($datos)) {
                        $dniObtenido = $resultado[0];
                    }
                    $trabajadorExistente = Trabajador::getTrabajador($dniObtenido);
                    $_SESSION['dni'] = $dniObtenido;
                    $_SESSION['nombre'] = $trabajadorExistente->getNombre();
                    $_SESSION['apellidos'] = $trabajadorExistente->getApellidos();
                    $_SESSION['fechaNac'] = $trabajadorExistente->getFechaNac();
                    $_SESSION['categoria'] = $trabajadorExistente->getCategoria();
                    echo'<script type="text/javascript">
                    document.location.href="Comun/selecProyecto.php";
                    </script>';
                }
            }
        } else {
            //el usuario no es valido, no es un trabajador
            echo 'Password incorrecto';
        }
    } else {
        //no hay resultados, el usuario no existe
        echo 'Usuario no existente en la base de datos';
    }
    mysql_free_result($result);
} else {
    echo 'Debe especificar un usuario y password';
}
$conexion->cerrarConexion();
?>