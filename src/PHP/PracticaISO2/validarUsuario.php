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
                $conexion->cerrarConexion();
                echo'<script type="text/javascript">
                document.location.href="Administrador/crearProyecto.php";
                </script>';
            } else {
                if ($_SESSION['tipoUsuario'] == "R") {
                    //RSPONSABLE PERSONAL
                    $conexion->cerrarConexion();
                    echo'<script type="text/javascript">
                    document.location.href="ResponsablePersonal/iniResponsablePersonal.php";
                    </script>';
                } else {
                    //JEFE PROYECTO - DESARROLLADOR
                    $datos = mysql_query("SELECT dni FROM Trabajador WHERE (Usuario_login= '" . $_SESSION['login'] . "')");
                    while ($resultado = mysql_fetch_array($datos)) {
                        $dniObtenido = $resultado[0];
                    }
                    $trabajadorExistente = Trabajador::getTrabajador($dniObtenido);
                    $_SESSION['dni'] = $dniObtenido;
                    $_SESSION['nombre'] = $trabajadorExistente->getNombre();
                    $_SESSION['apellidos'] = $trabajadorExistente->getApellidos();
                    $_SESSION['fechaNac'] = $trabajadorExistente->getFechaNac();
                    $_SESSION['categoria'] = $trabajadorExistente->getCategoria();
                    $conexion->cerrarConexion();
                    echo'<script type="text/javascript">
                    document.location.href="Comun/selecProyecto.php";
                    </script>';
                }
            }
        } else {
            //el usuario no es valido, no es un trabajador
            $conexion->cerrarConexion();
            echo'<script type="text/javascript">
            document.location.href="login.php?passwordIncorrecto=true";
            </script>';
        }
    } else {
        //no hay resultados, el usuario no existe
        $conexion->cerrarConexion();
        echo'<script type="text/javascript">
            document.location.href="login.php?usuarioNoExistente=true";
            </script>';
    }
    $conexion->cerrarConexion();
    mysql_free_result($result);
} else {
    //alguno esta vacio
    if (trim($_POST['login']) == "" && trim($_POST['password']) == "") {
        //ambos estan vacios
        $conexion->cerrarConexion();
        echo'<script type="text/javascript">
        document.location.href="login.php?noLoginNoPassword=true";
        </script>';
    } else {
        if (trim($_POST['login']) != "") {
            //login vacio
            $conexion->cerrarConexion();
            echo'<script type="text/javascript">
            document.location.href="login.php?noPassword=true";
            </script>';
        } else {
            //password vacio
            $conexion->cerrarConexion();
            echo'<script type="text/javascript">
            document.location.href="login.php?noLogin=true";
            </script>';
        }
    }
}
?>