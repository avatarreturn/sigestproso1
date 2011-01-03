<?php

//si el valor es null, no existe y hay q meterlo, si tiene valor ejecucion normal
//datos para establecer la conexion con la base de mysql.
include_once('Persistencia/conexion.php');
include_once('Negocio/Usuario.php');
include_once('Negocio/Trabajador.php');

$conexion = new conexion();
$consulta = mysql_query('SELECT numMaxProyectos FROM configuracion');
$row2 = mysql_fetch_array($consulta);
$numMaxProyectos = $row2[0];


/*
 * ATENCION: CAMBIAR EL SIGNO DE LA COMPARACION
 * DE MOMENTO ESTA PUESTO ASI PARA QUE FUNCIONE
 */
if ($numMaxProyectos == null) {
    //ya se ha introducido el numero maximo de proyectos
    session_start();

    if (trim( $_POST['login']) != "" && trim($_POST['password']) != "") {
        $loginIntroducido = $_POST['login'];
        $passwordIntroducido = $_POST['password'];

        //$usuarioSinComprobar=Usuario::ExisteUsuario($loginIntroducido,$passwordIntroducido);

        $result = mysql_query('SELECT u.login, u.password, t.dni FROM usuario u, trabajador t WHERE (login=\'' . $loginIntroducido . '\') and (u.login=t.Usuario_login)');
        
        if ($row = mysql_fetch_array($result)) {
            //hay resultados, el usuario existe
            $usuarioExistente = Usuario::getUsuario($row['login']);
            $_SESSION['login'] = $usuarioExistente->getLogin();
            $_SESSION['password'] = $usuarioExistente->getPassword();
            $_SESSION['tipoUsuario'] = $usuarioExistente->getTipo();

            if ($row['password'] == $passwordIntroducido) {
                //el usuario es valido, se trata de un trabajador
                $trabajadorExistente = Trabajador::getTrabajador($row['dni']);
                $_SESSION['dni'] = $trabajadorExistente->getDni();
                $_SESSION['nombre'] = $trabajadorExistente->getNombre();
                $_SESSION['apellidos'] = $trabajadorExistente->getApellidos();
                $_SESSION['fechaNac'] = $trabajadorExistente->getFechaNac();
                $_SESSION['categoria'] = $trabajadorExistente->getCategoria();

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
} else {
    //no se ha introducido el numero maximo de proyectos
    echo'<script type="text/javascript">
    document.location.href="numMaxProyectos.php";
    </script>';
    $_SESSION['numMaxProyectos'] = $numMaxProyectos;
}
$conexion->cerrarConexion();
?>