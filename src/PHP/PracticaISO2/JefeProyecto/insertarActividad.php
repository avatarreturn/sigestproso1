<?php session_start();

$IterNext = $_GET['INext'];
$nombre = $_GET['nombreA'];
$rol = $_GET['rolA'];
$duracion= $_GET['duracion'];
$primeraI = $_GET['primeraI'];
$predec = $_GET['predec'];
$esPrimera = $_GET['esPrimera'];

if ($primeraI != -1){
    $IterNext = $primeraI;
}
include_once('../Persistencia/conexion.php');
        $conexion = new conexion();

        if($esPrimera==0 || $predec!= ""){
        //Insertamos la actividad en cuestion
         $result1= mysql_query("INSERT INTO Actividad VALUES(NULL,'"
                    . $IterNext."','"
                    . utf8_encode($nombre). "','"
                    . $duracion ."',NULL,NULL,'"
                    . utf8_encode($rol) ."')");

     $IdGenerado = mysql_insert_id();
        }else if($esPrimera==1 && $predec== ""){

            $result= mysql_query("SELECT fechaInicio FROM Proyecto WHERE idProyecto ='".$_SESSION['proyectoEscogido']."'");
            $totEmp = mysql_num_rows($result);
        if ($totEmp >0) {
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $fechaInicioP= $rowEmp['fechaInicio'];

            }}
            $result1= mysql_query("INSERT INTO Actividad VALUES(NULL,'"
                    . $IterNext."','"
                    . utf8_encode($nombre). "','"
                    . $duracion ."','".$fechaInicioP."',NULL,'"
                    . utf8_encode($rol) ."')");

     $IdGenerado = mysql_insert_id();



        }


        //************ VALIDAMOS FECHAS TRABAJAdoRES
        // Insertamos trabajadores
        for($i=0;$i<count($_SESSION['trabActividad']);$i++){
        $result1= mysql_query("INSERT INTO TrabajadorActividad VALUES('"
                    . $_SESSION['trabActividad'][$i]."','"
                    . $IdGenerado ."')");
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
        $_SESSION['trabActividad'] = array();
        
            echo  utf8_decode($actividades ."[BRK]". $predecesora . "[BRK]" . "0");
        $conexion->cerrarConexion();

?>
