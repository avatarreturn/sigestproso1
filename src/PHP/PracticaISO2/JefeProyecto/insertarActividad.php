<?php session_start();

$IterNext = $_GET['INext'];
$nombre = $_GET['nombreA'];
$rol = $_GET['rolA'];
$duracion= $_GET['duracion'];
$primeraI = $_GET['primeraI'];
$predec = $_GET['predec'];


if ($primeraI != -1){
    $IterNext = $primeraI;
}
include_once('../Persistencia/conexion.php');
        $conexion = new conexion();

        //Insertamos la actividad en cuestion
         $result1= mysql_query("INSERT INTO Actividad VALUES(NULL,'"
                    . $IterNext."','"
                    . utf8_decode($nombre). "','"
                    . $duracion ."',NULL,NULL,'"
                    . utf8_decode($rol) ."')");

     $IdGenerado = mysql_insert_id();
         


        // Insertamos predecesoras
        $IdAcPred = explode("[BRK]", $predec);
        $tamano = count($IdAcPred)-1;
        $i= 0;
        while ( $i < $tamano) {
            $result1= mysql_query("INSERT INTO ActividadPredecesora VALUES('"
                    .$IdGenerado . "','"
                    . $IdAcPred[$i]. "')");
            $i++;
        }


        // mostramos la lista de las ya asignadas
        $result2 = mysql_query("SELECT nombre, idActividad FROM Actividad WHERE\n"
            . "Iteracion_idIteracion = \"".$IterNext. "\"");



        $totEmp2 = mysql_num_rows($result2);
        if ($totEmp2 >0) {
            $actividades= "<br/><b>Actividades asignadas:</b><br/>";
            while ($rowEmp2 = mysql_fetch_assoc($result2)) {

                $result5 = mysql_query("SELECT nombre FROM Actividad WHERE"
                        ." idActividad in(SELECT Actividad_idActividadP FROM ActividadPredecesora WHERE\n"
            . "Actividad_idActividad = \"".$rowEmp2['idActividad']. "\")");

                $totEmp5 = mysql_num_rows($result5);
        if ($totEmp5 >0) {// si tiene predecesoras
                    $actividades = $actividades . "&nbsp; <i>".$rowEmp2['nombre']."</i><br/>";
                    while ($rowEmp5 = mysql_fetch_assoc($result5)) {
                        $actividades = $actividades . "&nbsp;&nbsp;&nbsp; <tt style='color:grey'>-".$rowEmp5['nombre']."</tt><br/>";
                    }
                }
                else{
                    $actividades = $actividades . "&nbsp; <i>".$rowEmp2['nombre']."</i><br/>";
                }
        }
        }





        // sacamos las predecesoras
     $result= mysql_query("SELECT nombre, idActividad FROM Actividad WHERE\n"
    . "Iteracion_idIteracion =\"".$IterNext."\"");

    $totEmp = mysql_num_rows($result);
        if ($totEmp >0) {
        $predecesora = "<p>Seleccione actividades predecesoras si corresponde<br/>";
        $i = 0;
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $predecesora = $predecesora . "<input type='checkbox' name='OP".$i."' value='".$rowEmp['idActividad']."'> ". $rowEmp['nombre']."<br>";
                $i = $i+1;
        }
            $predecesora = $predecesora . "</p>";
               
        }

        
            echo  utf8_encode($actividades ."[BRK]". $predecesora);
        $conexion->cerrarConexion();

?>
