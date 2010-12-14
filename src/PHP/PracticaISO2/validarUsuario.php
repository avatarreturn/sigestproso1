<?php

session_start();
//datos para establecer la conexion con la base de mysql.
$conexion = mysql_connect('localhost', 'grupo01', '0F9RLuM8') or die('ERROR EN LA CONEXION: ' . mysql_error());
mysql_select_db('grupo01') or die('ERROR AL ESCOJER LA BD: ' . mysql_error());

if (trim($_POST['usuario']) != "" && trim($_POST['password']) != "") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $result = mysql_query('SELECT password, descripcion FROM usuarios WHERE usuario=\'' . $usuario . '\'');
    if ($row = mysql_fetch_array($result)) {
        //hay resultados, el usuario existe
        if ($row['password'] == $password) {
            //el usuario es valido
            $_SESSION['k_username'] = $row['usuario'];

            if ($row['descripcion'] == "administrador") {
                //administrador
                echo'<script type="text/javascript">
            document.location.href="Administrador/crearProyecto.php";
            </script>';
            } else {
                if ($row['descripcion'] == "jefeProyecto") {
                    //jefe proyecto
                    echo'<script type="text/javascript">
                document.location.href="iniJefeProyecto.php";
                </script>';
                } else {
                    if ($row['descripcion'] == "desarrollador") {
                        //jefe desarrollador
                        echo'<script type="text/javascript">
                    document.location.href="iniDesarrollador.php";
                    </script>';
                    } else {
                        //responsable de personal
                        echo'<script type="text/javascript">
                    document.location.href="ResponsablePersonal/iniResponsablePersonal.php";
                    </script>';
                    }
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

mysql_close();
?>