<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$dniInsertar = $_GET['dni'];
include_once('../Persistencia/conexion.php');
        $conexion = new conexion();

        $result3 = mysql_query(
                "SELECT nombre, idRol FROM Rol WHERE categoria >= "
                . "(SELECT categoria FROM Trabajador WHERE "
                . "dni = '".$dniInsertar ."')"
                );

        $totEmp3 = mysql_num_rows($result3);

        if ($totEmp3 >0) {
            $rol = "<br/><select id='RolPersonal'><option value='-1'>- Escoja un rol -</option>";
            while ($rowEmp3 = mysql_fetch_assoc($result3)) {
                if(strcasecmp($rowEmp3['nombre'],"Jefe de proyecto") == 0){}else{
                $rol = $rol . "<option value='".$rowEmp3['idRol']."'>". $rowEmp3['nombre']."</option>";}
            }
        }
        $rol = $rol ."</select>";

        // Calculamos participacion
        $result1 = mysql_query(
                "SELECT SUM(porcentaje) as \"porc\" FROM TrabajadorProyecto WHERE\n"
                . "Trabajador_dni = \"".$dniInsertar ."\"\n"
                . "AND\n"
                . "Proyecto_idProyecto in \n"
                . "(SELECT idProyecto FROM Proyecto WHERE\n"
                . "fechaFin is NULL)"
                );

        $totEmp1 = mysql_num_rows($result1);

        if ($totEmp1 ==1) {
            $rol = $rol . "<br/><br/><p>Participaci&oacute;n <input type='text' id='porcentaje' size='3' maxlength='3'> MAX(";
            while ($rowEmp1 = mysql_fetch_assoc($result1)) {
                if($rowEmp1['porc']== "NULL"){
                    $porc= "100";
                }else{ $porc= 100 - $rowEmp1['porc'];}
                $rol = $rol . $porc."%)</p>";
            }
        }

        
        
        $rol = $rol ."<br/><center><input type='button' value='A&ntilde;adir' onclick=\"Anadir(".$porc.")\"></center>";
        echo utf8_decode($rol);
        $conexion->cerrarConexion();

?>
