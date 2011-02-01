<?php session_start();

$idAct = $_GET['idAct'];
$planificado = $_GET['pl'];

include_once('../Persistencia/conexion.php');
$conexion = new conexion();

$fecha_actual=date("Y-m-d");

// Sacar iteración, fase y proyecto actual
$result = mysql_query("SELECT i.idIteracion as idIteracion, i.numero as numIteracion, f.idFase as idFase, f.nombre as nomFase, p.idProyecto as idProyecto "
        . "FROM Actividad a, Iteracion i, Fase f, Proyecto p "
        . "WHERE a.idActividad = ".$idAct
        . " AND a.Iteracion_idIteracion = i.idIteracion "
        . "AND i.Fase_idFase = f.idFase "
        . "AND f.Proyecto_idProyecto = p.idProyecto");
$totEmp = mysql_num_rows($result);
if ($totEmp == 1) {
    while ($rowEmp = mysql_fetch_assoc($result)) {
        $idP = $rowEmp['idProyecto'];
        $idFase = $rowEmp['idFase'];
        $nomFase = $rowEmp['nomFase'];
        $idIt = $rowEmp['idIteracion'];
        $numIt = $rowEmp['numIteracion'];
    }
}

// Cálculo de si existen informes pendientes
$result23 = mysql_query("SELECT * FROM InformeTareas "
        ." WHERE Actividad_idActividad=".$idAct
        ." AND estado in ('Pendiente','Cancelado')");
$totEmp23 = mysql_num_rows($result23);

if ($totEmp23 == 0){// ok

    // Calculo si la actividad es la última de la iteracion
    $result20 = mysql_query("SELECT idActividad, Iteracion_idIteracion, fechaInicio, fechaFin"
                . " FROM Actividad a \n"
                . " WHERE a.Iteracion_idIteracion=".$idIt
                . " AND a.fechaFin IS NULL");
    $totEmp20 = mysql_num_rows($result20);

    // Sí es la última
    if ($totEmp20 == 1) {
        $ultima = 1;
    // No lo es
    } else {
        $ultima = 0;
    }

    // Terminamos solo si no es la última actividad de la iteración o si, siéndolo, la siguiente está planificada
    if (($ultima == 1 && $planificado == 1) || ($ultima == 0)) {

        $finProyecto = 0;

        // Terminar actividad actual
        $result2 = mysql_query("UPDATE Actividad SET fechaFin='"
                .$fecha_actual
                ."' WHERE idActividad="
                .$idAct);

        // ¿Hay que cerrar también la iteración? [actividades de la iteración sin fechaFin]
        $result3 = mysql_query("SELECT idActividad, Iteracion_idIteracion, fechaInicio, fechaFin"
                . " FROM Actividad a \n"
                . " WHERE a.Iteracion_idIteracion=".$idIt
                . " AND a.fechaFin IS NULL");
        $totEmp3 = mysql_num_rows($result3);

        // CASO A: cerrar actividad y empezar actividades siguientes
        if ($totEmp3 > 0) {
                // Actividades que tienen como predecesora a la que cerramos
                $result6 = mysql_query("SELECT Actividad_idActividad as idActividad FROM ActividadPredecesora"
                        ." WHERE Actividad_idActividadP=".$idAct);
                $totEmp6 = mysql_num_rows($result6);

                if ($totEmp6 > 0) {
                    while ($rowEmp6 = mysql_fetch_assoc($result6)) {
                        // Actividades predecesoras de las anteriores sin fechaFin
                        $result7 = mysql_query("SELECT idActividad FROM Actividad"
                                ." WHERE idActividad IN (SELECT Actividad_idActividadP FROM ActividadPredecesora"
                                ." WHERE Actividad_idActividad=".$rowEmp6['idActividad'].")"
                                ." AND fechaFin IS NULL");
                        $totEmp7 = mysql_num_rows($result7);

                        // Si no hay, empezamos esa actividad
                        if ($totEmp7 == 0) {
                            $result8 = mysql_query("UPDATE Actividad SET fechaInicio='"
                                    .$fecha_actual
                                    ."' WHERE idActividad="
                                    .$rowEmp6['idActividad']);
                        }
                    }
                }

        // Hay que cerrar también la iteración
        } else {
            // Terminar iteración actual
            $result9 = mysql_query("UPDATE Iteracion SET fechaFin='"
                .$fecha_actual
                ."' WHERE idIteracion="
                .$idIt);

            // ¿Hay que cerrar también la fase? [iteraciones de la fase sin fechafin]
            $result4 = mysql_query("SELECT idIteracion, Fase_idFase, numero, fechaInicio, fechaFin"
                    ." FROM Iteracion"
                    ." WHERE Fase_idFase=".$idFase
                    ." AND fechaFin IS NULL");
            $totEmp4 = mysql_num_rows($result4);


            // CASO B: cerrar actividad e iteración. Empezar iteración y sus actividades
            if ($totEmp4 > 0) {

                    // Actualizamos $idItS e $numItS a la siguiente iteración
                    $numItS = $numIt + 1;
                    $result13 = mysql_query("SELECT idIteracion"
                            ." FROM Iteracion WHERE numero=".$numItS
                            ." AND Fase_idFase=".$idFase);
                    $totEmp13 = mysql_num_rows($result13);
                    if ($totEmp13 == 1) {
                        while ($rowEmp13 = mysql_fetch_assoc($result13)) {
                            $idItS = $rowEmp13['idIteracion'];
                        }
                    }

                    // Empezar iteración siguiente
                    $result12 = mysql_query("UPDATE Iteracion SET fechaInicio='"
                            .$fecha_actual
                            ."' WHERE idIteracion =".$idItS);

                    // Empezar actividades iniciales de la iteración siguiente
                    $result22 = mysql_query("SELECT idActividad FROM Actividad WHERE idActividad NOT IN"
                            ." (SELECT Actividad_idActividad FROM ActividadPredecesora)"
                            ." AND Iteracion_idIteracion=".$idItS);
                    $totEmp22 = mysql_num_rows($result22);

                    if ($totEmp22 > 0) {
                        while ($rowEmp22 = mysql_fetch_assoc($result22)){
                            $result14 = mysql_query("UPDATE Actividad SET fechaInicio='"
                            .$fecha_actual
                            ."' WHERE idActividad=".$rowEmp22['idActividad']);
                        }
                    }

            // Hay que cerrar también la fase
            } else {

                // Terminar fase actual
                $result10 = mysql_query("UPDATE Fase SET fechaFinR='"
                    .$fecha_actual
                    ."' WHERE idFase="
                    .$idFase);

                // ¿Hay que cerrar también el proyecto? [fases sin fechaFin]
                $result5 = mysql_query("SELECT idFase, Proyecto_idProyecto, nombre, fechaInicioE, fechaFinE, fechaInicioR, fechaFinR"
                        ." FROM Fase"
                        ." WHERE Proyecto_idProyecto =".$idP
                        ." AND fechaFinR IS NULL");
                $totEmp5 = mysql_num_rows($result5);

                // CASO C: cerrar actividad, iteración y fase. Empezar fase, iteración y sus actividades
                if ($totEmp5 > 0) {

                    // Actualizamos $idFaseS a la siguiente fase
                    if ($nomFase == 'Inicio') {$nomFaseS = 'Elaboracion';}
                    else if ($nomFase == 'Elaboracion') {$nomFaseS = 'Construccion';}
                    else if ($nomFase == 'Construccion') {$nomFaseS = 'Transicion';}

                    $result15 = mysql_query("SELECT idFase"
                            ." FROM Fase"
                            ." WHERE Proyecto_idProyecto=".$idP
                            ." AND nombre='".$nomFaseS."'");
                    $totEmp15 = mysql_num_rows($result15);
                        if ($totEmp15 == 1) {
                            while ($rowEmp15 = mysql_fetch_assoc($result15)) {
                                $idFaseS = $rowEmp15['idFase'];
                            }
                        }

                     $result16 = mysql_query("UPDATE Fase SET fechaInicioR='"
                        .$fecha_actual
                        ."' WHERE idFase =".$idFaseS);

                    // Actualizamos $idItS a la siguiente iteración
                    $result17 = mysql_query("SELECT idIteracion"
                            ." FROM Iteracion WHERE numero=1"
                            ." AND Fase_idFase=".$idFaseS);
                    $totEmp17 = mysql_num_rows($result17);
                    if ($totEmp17 == 1) {
                        while ($rowEmp17 = mysql_fetch_assoc($result17)) {
                            $idItS = $rowEmp17['idIteracion'];
                        }
                    }

                    $result18 = mysql_query("UPDATE Iteracion SET fechaInicio='"
                            .$fecha_actual
                            ."' WHERE idIteracion =".$idItS);

                    $result21 = mysql_query("SELECT idActividad FROM Actividad WHERE idActividad NOT IN"
                            ." (SELECT Actividad_idActividad FROM ActividadPredecesora)"
                            ." AND Iteracion_idIteracion=".$idItS);
                    $totEmp21 = mysql_num_rows($result21);

                    if ($totEmp21 > 0) {
                        while ($rowEmp21 = mysql_fetch_assoc($result21)){
                            $result19 = mysql_query("UPDATE Actividad SET fechaInicio='"
                            .$fecha_actual
                            ."' WHERE idActividad=".$rowEmp21['idActividad']);
                        }
                    }


                // CASO D: cerrar actividad, iteración, fase y proyecto
                } else {
                    // Terminar proyecto actual
                    $result11 = mysql_query("UPDATE Proyecto SET fechaFin='"
                        .$fecha_actual
                        ."' WHERE idProyecto="
                        .$idP);

                    $finProyecto = 1;

                }

            }
        }
        echo 0 ."[BRK]". utf8_decode($finProyecto); // ok
    } else {
        echo 1 ."[BRK]". utf8_decode($finProyecto); // error por siguiente iteración no planificada
    }
} else { // error por informes pendientes
    echo 2 ."[BRK]". utf8_decode($finProyecto);
}

$conexion->cerrarConexion();

?>