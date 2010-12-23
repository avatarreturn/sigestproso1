<?php

session_start();
//datos para establecer la conexion con la base de mysql.
include_once('Persistencia/conexion.php');
$conexion = new conexion();

if (trim($_POST['usuario']) != "" && trim($_POST['password']) != "") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $result = mysql_query('SELECT u.password, u.tipoUsuario, t.dni FROM usuario u, trabajador t WHERE (login=\'' . $usuario . '\') and (u.login=t.Usuario_login)');
    if ($row = mysql_fetch_array($result)) {
        //hay resultados, el usuario existe
        if ($row['password'] == $password) {
            //el usuario es valido

            $_SESSION['dni'] = $row['dni'];
            $tipoUsuario=$row['tipoUsuario'];
            if ($tipoUsuario == "A") {
                //administrador
                echo'<script type="text/javascript">
                document.location.href="Administrador/crearProyecto.php";
                </script>';
            } else {
                if ($tipoUsuario == "R") {
                    //responsable personal
                    echo'<script type="text/javascript">
                    document.location.href="ResponsablePersonal/iniResponsablePersonal.php";
                    </script>';
                } else {
                    //jefe proyecto-desarrollador
                    echo'<script type="text/javascript">
                    document.location.href="Comun/selecProyecto.php";
                    </script>';
                }
            }
        } else {
            //el usuario no es valido
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