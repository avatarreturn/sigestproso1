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
                . "GROUP BY Trabajador_dni))\n"
                . "and \n"
                . "dni not in \n"
                . "(SELECT distinct t.Trabajador_dni FROM TrabajadorProyecto t WHERE\n"
                . "100 <= \n"
                . "(SELECT SUM(porcentaje) as \"porcentaje\" FROM TrabajadorProyecto p WHERE\n"
                . "t.Trabajador_dni = p.Trabajador_dni\n"
                . "AND\n"
                . "Proyecto_idProyecto in \n"
                . "(SELECT idProyecto FROM Proyecto WHERE\n"
                . "fechaFin is NULL)))\n"
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

        $result3 = mysql_query("SELECT nombre FROM Rol WHERE idRol='".$rol."'");
        while ($rowEmp3 = mysql_fetch_assoc($result3)) {
               $nombreRol = $rowEmp3['nombre'];
            }

        $result3 = mysql_query("SELECT nombre, apellidos FROM Trabajador WHERE dni='".$dniInsertar."'");
        while ($rowEmp3 = mysql_fetch_assoc($result3)) {
               $personal = $personal ."[BRK]". $rowEmp3['nombre']." ".$rowEmp3['apellidos']." (".$nombreRol . ")";
            }
            echo  utf8_encode($personal);
        $conexion->cerrarConexion();

?>
