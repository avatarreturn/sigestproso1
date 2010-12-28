<?php session_start();

$dniInsertar = $_GET['dni'];
$porcentaje = $_GET['porcentaje'];
$rol = $_GET['rol'];
include_once('../Persistencia/conexion.php');
        $conexion = new conexion();

        //Insertamos el trabajador en cuestion a ese proyecto
         $result1= mysql_query("INSERT INTO TrabajadorProyecto VALUES('"
                    . $dniInsertar."','"
                    . $_SESSION['proyectoEscogido']. "','"
                    . $porcentaje."','"
                    . $rol ."')");
         $result2 = mysql_query(
                "SELECT nombre, dni, apellidos FROM Trabajador WHERE\n"
                . "dni in\n"
                . "(SELECT Trabajador_dni FROM TrabajadorProyecto\n"
                . "GROUP BY Trabajador_dni\n"
                . "HAVING COUNT(*) <3\n"
                . "UNION\n"
                . "SELECT dni FROM Trabajador WHERE\n"
                . "dni not in\n"
                . "(SELECT Trabajador_dni FROM TrabajadorProyecto\n"
                . "GROUP BY Trabajador_dni))"
                . "and \n"
                . "dni not in \n"
                . "(SELECT Trabajador_dni FROM TrabajadorProyecto WHERE\n"
                . "Proyecto_idProyecto = \"".$_SESSION['proyectoEscogido']."\")\n"
                . "and dni <> \"".$_SESSION['dni']."\""
                );

        $totEmp2 = mysql_num_rows($result2);
        $personal = "<select id='SelPersonal' onchange='datosPersonal()'><option value='-1'>- Empleado -</option>";
        if ($totEmp2 >0) {
            
            while ($rowEmp2 = mysql_fetch_assoc($result2)) {
                $personal = $personal . "<option value='".$rowEmp2['dni']."'>". $rowEmp2['nombre']." ".$rowEmp2['apellidos']."</option>";
            }
        }

//        
        $personal = $personal ."</select>";
        
        

        $result3 = mysql_query("SELECT nombre, apellidos FROM Trabajador WHERE dni='".$dniInsertar."'");
        while ($rowEmp3 = mysql_fetch_assoc($result3)) {
               $personal = $personal ."[BRK]". $rowEmp3['nombre']." ".$rowEmp3['apellidos'];
            }
            echo  utf8_encode($personal);
        $conexion->cerrarConexion();

?>
