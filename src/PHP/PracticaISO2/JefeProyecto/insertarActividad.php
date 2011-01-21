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
$IdAcPred = explode("[BRK]", $predec);
        $tamano = count($IdAcPred)-1;

include_once('../Persistencia/conexion.php');
        $conexion = new conexion();

        $bandera = 0; // 0 sin conflictos, 1 cuando ai conflictos
        if($esPrimera==0 || $predec!= ""){
            //sacamos la fecha en la que empieza de manera estimada
            // si es la primera tieracion
            if($predec!= ""){
                 $i= 0;
                 $predecesorasF = "";
                while ( $i < $tamano) {
                        if($predecesorasF == ""){
                         $predecesorasF = $predecesorasF . $IdAcPred[$i];
                        }else{
                            $predecesorasF = $predecesorasF .",". $IdAcPred[$i];
                        }
                    $i++;
                }
                $result= mysql_query("SELECT MAX(fechaFinE) as fecha FROM Actividad WHERE\n"
                . "idActividad in (".$predecesorasF.")");
                $totEmp = mysql_num_rows($result);
                if ($totEmp >0) {
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $fechaInicioAct = $rowEmp['fecha'];

            }
            }
            }else if($esPrimera==0 && $predec== ""){ // si es de otra iteracion

                 $result= mysql_query("SELECT MAX(fechaFinE) as fecha FROM Actividad WHERE\n"
                . "Iteracion_idIteracion = '".$_SESSION['IdIterActual']."'");
                $totEmp = mysql_num_rows($result);
                if ($totEmp >0) {
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $fechaInicioAct = $rowEmp['fecha'];
            }
            }

            }
           


            // calculamos la fecha find e la nueva iteracion
            $can_dias = ceil($duracion/8) ;
            $fechaFinEst= date("Y-m-d", strtotime("$fechaInicioAct + $can_dias days"));

            //validamos sobre el calendario de vacaciones
            for($i=0;$i<count($_SESSION['trabActividad']);$i++){
             $result = mysql_query("SELECT fechaInicio, fechaFin FROM Vacaciones WHERE\n"
            . "Trabajador_dni = \"".$_SESSION['trabActividad'][$i]. "\"");

             $totEmp = mysql_num_rows($result);
                if ($totEmp >0) {
            while ($rowEmp = mysql_fetch_assoc($result)) {

             if ( strtotime("$fechaInicioAct + 1 days") >= strtotime($rowEmp['fechaInicio']) && strtotime($fechaFinEst) <= strtotime($rowEmp['fechaFin']) // actividad dentro de vacaciones
                     ||  strtotime($rowEmp['fechaInicio']) >= strtotime("$fechaInicioAct + 1 days") && strtotime($rowEmp['fechaFin']) <= strtotime($fechaFinEst)
                     ||  strtotime($rowEmp['fechaInicio']) >= strtotime("$fechaInicioAct + 1 days") && strtotime($rowEmp['fechaInicio']) <= strtotime($fechaFinEst)
                     ||  strtotime($rowEmp['fechaFin']) >= strtotime("$fechaInicioAct + 1 days") && strtotime($rowEmp['fechaFin']) <= strtotime($fechaFinEst)
                             ){
                         $bandera=1;
                         break;
                    }
            }// fin while
             }
            }// fin for
        //Insertamos la actividad en cuestion
            if($bandera==0){
         $result1= mysql_query("INSERT INTO Actividad VALUES(NULL,'"
                    . $IterNext."','"
                    . utf8_encode($nombre). "','"
                    . $duracion ."','"
                    . $fechaFinEst ."',NULL,NULL,'"
                    . utf8_encode($rol) ."')");

     $IdGenerado = mysql_insert_id();
            }// fin bandera == 0
        }else if($esPrimera==1 && $predec== ""){

            $result= mysql_query("SELECT fechaInicio FROM Proyecto WHERE idProyecto ='".$_SESSION['proyectoEscogido']."'");
            $totEmp = mysql_num_rows($result);
        if ($totEmp >0) {
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $fechaInicioP= $rowEmp['fechaInicio'];

            }}
            $can_dias = ceil($duracion/8) -1;
            $fechaFinEst= date("Y-m-d", strtotime("$fechaInicioP + $can_dias days"));
            //validamos sobre el calendario de vacaciones
            for($i=0;$i<count($_SESSION['trabActividad']);$i++){
             $result = mysql_query("SELECT fechaInicio, fechaFin FROM Vacaciones WHERE\n"
            . "Trabajador_dni = \"".$_SESSION['trabActividad'][$i]. "\"");

             $totEmp = mysql_num_rows($result);
                if ($totEmp >0) {
            while ($rowEmp = mysql_fetch_assoc($result)) {

             if ( strtotime($fechaInicioP) >= strtotime($rowEmp['fechaInicio']) && strtotime($fechaFinEst) <= strtotime($rowEmp['fechaFin']) // actividad dentro de vacaciones
                     ||  strtotime($rowEmp['fechaInicio']) >= strtotime($fechaInicioP) && strtotime($rowEmp['fechaFin']) <= strtotime($fechaFinEst)
                     ||  strtotime($rowEmp['fechaInicio']) >= strtotime($fechaInicioP) && strtotime($rowEmp['fechaInicio']) <= strtotime($fechaFinEst)
                     ||  strtotime($rowEmp['fechaFin']) >= strtotime($fechaInicioP) && strtotime($rowEmp['fechaFin']) <= strtotime($fechaFinEst)
                             ){
                         $bandera=1;
                         break;
                    }
            }// fin while
             }
            }// fin for
            if($bandera==0){
            $result1= mysql_query("INSERT INTO Actividad VALUES(NULL,'"
                    . $IterNext."','"
                    . utf8_encode($nombre). "','"
                    . $duracion ."','"
                    . $fechaFinEst ."','"
                    .$fechaInicioP."',NULL,'"
                    . utf8_encode($rol) ."')");

     $IdGenerado = mysql_insert_id();
            }//fin bandera 0



        }

        if($bandera==0){ // si todo es correcto seguimos haciendo inserts
        //************ VALIDAMOS FECHAS TRABAJAdoRES
        // Insertamos trabajadores
        for($i=0;$i<count($_SESSION['trabActividad']);$i++){
        $result1= mysql_query("INSERT INTO TrabajadorActividad VALUES('"
                    . $_SESSION['trabActividad'][$i]."','"
                    . $IdGenerado ."')");
        }

        // Insertamos predecesoras
        
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

        }// Fin de bandera == 0

        $_SESSION['trabActividad'] = array();

        if($bandera==0){
            echo  utf8_decode($actividades ."[BRK]". $predecesora . "[BRK]" . "0");
        }else{
            echo 1;
        }
        $conexion->cerrarConexion();

?>
