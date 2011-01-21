<?php
$dni = $_GET['id'];

include_once('../Persistencia/conexion.php');
        $conexion = new conexion();

        $result = mysql_query("SELECT fechaInicio, fechaFin FROM Vacaciones WHERE\n"
            . "Trabajador_dni = \"".$dni. "\"");



        $totEmp = mysql_num_rows($result);
        if ($totEmp >0) {
            $fechasF1= array();
            $fechasFFin = array();
            $fechasFFinVal = array();
            while ($rowEmp = mysql_fetch_assoc($result)) {
                // Extraer las dos fechas
                // Generar las fechas de por medio e ir metiendolas en un array
                if (in_array($rowEmp['fechaInicio'], $fechasF1)) {
                }else{  $fechasF1[] = $rowEmp['fechaInicio'];}
                $fechaInicio = $rowEmp['fechaInicio'];
                while ( $fechaInicio != $rowEmp['fechaFin']) {
                $can_dias = 1;
                $fec_vencimi= date("Y-m-d", strtotime("$fechaInicio + $can_dias days"));
                $fechaInicio = $fec_vencimi;

                if(in_array($fec_vencimi, $fechasF1)){}
                else{  $fechasF1[] = $fec_vencimi; }
                }
            }
            for($i=0;$i<count($fechasF1);$i++){
                $fechasFFin[]=date("n-j-Y",strtotime($fechasF1[$i]));
                $fechasFFinVal[]=date("Y-m-d",strtotime($fechasF1[$i]));
               }
        }
        $fechas = "[";
        $fechasVal = "[";
        for($i=0;$i<count($fechasFFin);$i++){
                $fechas = $fechas . "\"" . $fechasFFin[$i] ."\",";
                $fechasVal = $fechasVal . "\"" . $fechasFFinVal[$i] ."\",";
               }

        $fechas  = $fechas . "]";
        $fechasVal = $fechasVal ."]";

         $result = mysql_query("SELECT nombre, apellidos FROM Trabajador WHERE\n"
            . "dni = \"".$dni. "\"");

        $totEmp = mysql_num_rows($result);
        if ($totEmp >0) {

            while ($rowEmp = mysql_fetch_assoc($result)) {
                $nombreVac = "Aqu&iacute; puede visualizar las fechas de vacaciones del trabajador:<br/><b>"
                . $rowEmp['nombre'] . " ". $rowEmp['apellidos'] ."</b>, con el fin de no escoger"
                . " un trabajador cuyas vacaciones interfieran en el desarrollo de la actividad.";
            }
        }


        echo $fechas ."[BRK]". utf8_decode($nombreVac);

        $conexion->cerrarConexion();

?>
