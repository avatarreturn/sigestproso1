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

     
         $result2 = mysql_query("SELECT nombre FROM Actividad WHERE\n"
            . "Iteracion_idIteracion = \"".$IterNext. "\"");

            $IdGenerado = mysql_insert_id();

        $totEmp2 = mysql_num_rows($result2);
        if ($totEmp2 >0) {
            $actividades= "<br/><b>Actividades asignadas:</b><br/>";
            while ($rowEmp2 = mysql_fetch_assoc($result2)) {
                $actividades = $actividades . "&nbsp; <i>".$rowEmp2['nombre']."</i><br/>"; }
        }


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
