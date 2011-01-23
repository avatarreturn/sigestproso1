<?php session_start();

$idAct = $_GET['idAct'];

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

// Terminar actividad actual
$result2 = mysql_query("UPDATE Actividad SET fechaFin='"
        .$fecha_actual
        ."' WHERE idActividad="
        .$idAct);

// ¿Hay que cerrar también la iteración? [actividades de la iteración sin fechaFin]
$result3 = mysql_query("SELECT idActividad, Iteracion_idIteracion, fechaInicio, fechaFin"
        . " FROM Actividad a \n"
        . " WHERE a.Iteracion_idIteracion=".$idIt
        . " AND a.fechaFin IS NULL"
        );
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
            ." WHERE Fase.idFase=".$idFase
            ." AND fechaFin IS NULL");
    $totEmp4 = mysql_num_rows($result4);

    // CASO B: cerrar actividad e iteración. Empezar iteración y sus actividades
    if ($totEmp4 > 0) {

            // Actualizamos $idIt a la nueva iteración actual
            $result13 = mysql_query("SELECT idIteracion"
                    ." FROM Iteracion WHERE numero=".$numIt+1
                    ." AND Fase_idFase=".$idFase);
            $totEmp13 = mysql_num_rows($result13);
            if ($totEmp13 == 1) {
                while ($rowEmp13 = mysql_fetch_assoc($result13)) {
                    $idIt = $rowEmp13['idIteracion'];
                }
            }

            $result12 = mysql_query("UPDATE Iteracion SET fechaInicio='"
                    .$fecha_actual
                    ." WHERE idIteracion =".$idIt);

            $result14 = mysql_query("UPDATE Actividad SET fechaInicio='"
                    .$fecha_actual
                    ."' WHERE idActividad IN"
                    ." (SELECT idActividad FROM Actividad WHERE idActividad NOT IN"
                    ." (SELECT Actividad_idActividad FROM ActividadPredecesora)"
                    ." AND Iteracion_idIteracion=".$idIt
                    .")");
        
    // Hay que cerrar también la fase
    } else {
        // Terminar fase actual
        $result10 = mysql_query("UPDATE Fase SET fechaFin='"
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
            
            // Actualizamos $idFase a la nueva fase actual
            if ($nomFase == 'Inicio') {$nomFase = 'Elaboracion';}
            else if ($nomFase == 'Elaboracion') {$nomFase = 'Construccion';}
            else if ($nomFase == 'Construccion') {$nomFase = 'Transicion';}
            $result15 = mysql_query("SELECT idFase"
                    ." FROM Fase"
                    ." WHERE Proyecto_idProyecto=".$idP
                    ." AND nombre='".$nomFase."'");
            $totEmp15 = mysql_num_rows($result15);
                if ($totEmp15 == 1) {
                    while ($rowEmp13 = mysql_fetch_assoc($result13)) {
                        $idFase = $rowEmp15['idFase'];
                    }
                }

             $result16 = mysql_query("UPDATE Fase SET fechaInicio='"
                .$fecha_actual
                ." WHERE idIteracion =".$idFase);

            // Actualizamos $idIt a la nueva iteración actual
            $result17 = mysql_query("SELECT idIteracion"
                    ." FROM Iteracion WHERE numero=1"
                    ." AND Fase_idFase=".$idFase);
            $totEmp17 = mysql_num_rows($result17);
            if ($totEmp17 == 1) {
                while ($rowEmp17 = mysql_fetch_assoc($result17)) {
                    $idIt = $rowEmp17['idIteracion'];
                }
            }

            $result18 = mysql_query("UPDATE Iteracion SET fechaInicio='"
                    .$fecha_actual
                    ." WHERE idIteracion =".$idIt);

            $result19 = mysql_query("UPDATE Actividad SET fechaInicio='"
                    .$fecha_actual
                    ."' WHERE idActividad IN"
                    ." (SELECT idActividad FROM Actividad WHERE idActividad NOT IN"
                    ." (SELECT Actividad_idActividad FROM ActividadPredecesora)"
                    ." AND Iteracion_idIteracion=".$idIt
                    .")");


        // CASO D: cerrar actividad, iteración, fase y proyecto
        } else {
            // Terminar proyecto actual
            $result11 = mysql_query("UPDATE Proyecto SET fechaFin='"
                .$fecha_actual
                ."' WHERE idProyecto="
                .$idP);

        }

    }
}

$conexion->cerrarConexion();

?>
