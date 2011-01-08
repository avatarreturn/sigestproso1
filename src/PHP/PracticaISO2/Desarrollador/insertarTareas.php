<?php session_start();

$cambiar = $_GET['cambio'];
$Tarea = array();
for ($i = 1; $i <= $_SESSION['nTareas']; $i++) {
         $Tarea[] = $_GET['T'.$i];
     }

$semana= $_GET['semana'];

include_once('../Persistencia/conexion.php');
        $conexion = new conexion();


        if ($cambiar == 0){ // si no abia informe
     //comprobamos si tiene informe
     $result2 = mysql_query("SELECT idInformeTareas, estado FROM InformeTareas WHERE\n"
            . "Actividad_idActividad = \"".$_SESSION['ActividadEscogida']. "\" AND "
             . "Trabajador_dni=\"".$_SESSION['dni']. "\" AND "
            . "semana=\"".$semana."\"");

        $totEmp2 = mysql_num_rows($result2);
        if ($totEmp2 >0) { // existen informes para esta actividad
                
        }else{//creamos un primer informe

            $result1= mysql_query("INSERT INTO InformeTareas VALUES(NULL,'"
                    . $_SESSION['ActividadEscogida']."','"
                    . $_SESSION['dni']. "','"
                    . $semana ."','Pendiente');");

            $IdGenerado = mysql_insert_id();
        }



        //Insertamos en Tarea personal


        $result = mysql_query("SELECT * FROM CatalogoTareas ORDER BY descripcion");

        $totEmp = mysql_num_rows($result);
        if ($totEmp >0) {
            $i=0;
                        while ($rowEmp = mysql_fetch_assoc($result)) {
                            $result1= mysql_query("INSERT INTO TareaPersonal VALUES(NULL,'"
                            . $IdGenerado."','"
                            . $rowEmp['idTareaCatalogo']. "','"
                            . $Tarea[($i)] ."');");
                            $i++;
                        }
        }
        }else{// si esta cancelado o pendiente, se puede actualizar
            $result2 = mysql_query("SELECT idInformeTareas FROM InformeTareas WHERE\n"
            . "Actividad_idActividad = \"".$_SESSION['ActividadEscogida']. "\" AND "
             . "Trabajador_dni=\"".$_SESSION['dni']. "\" AND "
            . "semana=\"".$semana."\"");

        $totEmp2 = mysql_num_rows($result2);
        if ($totEmp2 ==1) { // existen informes para ESTA SEMANA

            while ($rowEmp2 = mysql_fetch_assoc($result2)) { //booramos lo que habia
            $result6 = mysql_query("DELETE FROM TareaPersonal WHERE InformeTareas_idInformeTareas = \"".$rowEmp2['idInformeTareas']."\"");
            $result6= mysql_query("UPDATE InformeTareas SET estado ='Pendiente'"
             . " WHERE idInformeTareas ='"
                 . $rowEmp2['idInformeTareas'] ."'");
            // Insertamos de nuevo las tareasPersonales

            $result = mysql_query("SELECT * FROM CatalogoTareas ORDER BY descripcion");

        $totEmp = mysql_num_rows($result);
        if ($totEmp >0) {
            $i=0;
                        while ($rowEmp = mysql_fetch_assoc($result)) {
                            $result1= mysql_query("INSERT INTO TareaPersonal VALUES(NULL,'"
                            . $rowEmp2['idInformeTareas']."','"
                            . $rowEmp['idTareaCatalogo']. "','"
                            . $Tarea[($i)] ."');");
                            $i++;
                        }
        }

        }
        }

        }
     echo ("Tarea 2 =".$Tarea[1] . " Tarea 10 =".$Tarea[9]. "fecha=".$semana." dSem=".$dSemana);



 $conexion->cerrarConexion();
?>
