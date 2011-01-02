<?php

//si el valor es null, no existe y hay q meterlo, si tiene valor ejecucion normal
//datos para establecer la conexion con la base de mysql.
include_once('Persistencia/conexion.php');
include_once('Negocio/Usuario.php');

$conexion = new conexion();
$cosulta = mysql_query('SELECT numMaxProyectos FROM configuracion');

/*
 * ATENCION: CAMBIAR EL SIGNO DE LA COMPARACION
 * DE MOMENTO ESTA PUESTO ASI PARA QUE FUNCIONE
 */
if ($consulta == null) {
    //ya se ha introducido el numero maximo de proyectos
    session_start();

    if (trim($_POST['usuario']) != "" && trim($_POST['password']) != "") {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        $result = mysql_query('SELECT u.password, u.tipoUsuario, t.dni FROM usuario u, trabajador t WHERE (login=\'' . $usuario . '\') and (u.login=t.Usuario_login)');
        if ($row = mysql_fetch_array($result)) {
            //hay resultados, el usuario existe

            /*AKÍ SE PONEN LAS COSAS DEL USUARIO*/


            if ($row['password'] == $password) {
                //el usuario es valido

                /*AKÍ SE PONEN LAS COSAS DEL TRABAJADOR*/

                $_SESSION['dni'] = $row['dni'];
                $tipoUsuario = $row['tipoUsuario'];
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
} else {
    //no se ha introducido el numero maximo de proyectos
    echo 'aquí poner un formulario para modificar el numero maximo de proyectos';
}

$conexion->cerrarConexion();
?>