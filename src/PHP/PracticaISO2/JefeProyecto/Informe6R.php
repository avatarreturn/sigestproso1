<?php

include_once("../Utiles/funciones.php");
include_once ('../Persistencia/conexion.php');
$conexion = new conexion();

$proyecto=$_GET['proyecto'];
$fecha=$_GET['fechaI'];

//////// consulta que muestra los trabajadores con informes pendientes de aceptacion /////////

/*      SELECT a.idActividad, a.nombre actividad, a.duracionEstimada, a.fechaInicio, a.fechaFin, sum(tp.horas) horas
               FROM Actividad a, InformeTareas i, TareaPersonal tp, Iteracion it, Fase f
               WHERE (a.idActividad=i.Actividad_idActividad)
                   AND (tp.InformeTareas_idInformeTareas=i.idInformeTareas)
                   AND (a.Iteracion_idIteracion=it.idIteracion)
                   AND (it.Fase_idFase=f.idFase)
                   AND (f.Proyecto_idProyecto=3)
                   AND (i.semana<='2010-02-22')
               GROUP BY a.idActividad
 */

$sql = "SELECT a.idActividad, a.nombre actividad, a.duracionEstimada, a.fechaInicio, a.fechaFin, sum(tp.horas) horas
               FROM Actividad a, InformeTareas i, TareaPersonal tp, Iteracion it, Fase f
               WHERE (a.idActividad=i.Actividad_idActividad)
                   AND (tp.InformeTareas_idInformeTareas=i.idInformeTareas)
                   AND (a.Iteracion_idIteracion=it.idIteracion)
                   AND (it.Fase_idFase=f.idFase)
                   AND (f.Proyecto_idProyecto=".$proyecto.")
                   AND (i.semana<='".$fecha."')
               GROUP BY a.idActividad;";

$fechaform = '2010-02-22';
$result = mysql_query($sql);
$totAct = mysql_num_rows($result);
$imprimir = "";
if ($totAct > 0) {
    $imprimir = $imprimir . "<table><tr><a><td><a>Actividad</td><td><a>Fecha de Inicio</a></td><td><a>Fecha de fin</a></td><td><a>Duracion estimada</a></td><td><a>Duracion real</a></td><td><a>Retraso</a></td></tr>";
    while ($rowAct = mysql_fetch_assoc($result)) {
        if ($rowAct['fechaFin'] == null or $rowAct['fechaFin'] > $fechaform) {
            $imprimir = $imprimir . "<tr><td>" . $rowAct['actividad'] . "</td><td>" . $rowAct['fechaInicio'] . "</td><td>" . "Activa" . "</td><td>" . $rowAct['duracionEstimada'] . "</td><td>" . $rowAct['horas'] . "</td>";
        } else {
            $imprimir = $imprimir . "<tr><td>" . $rowAct['actividad'] . "</td><td>" . $rowAct['fechaInicio'] . "</td><td>" . $rowAct['fechaFin'] . "</td><td>" . $rowAct['duracionEstimada'] . "</td><td>" . $rowAct['horas'] . "</td>";
        }
        $diferencia = -1 * ($rowAct['duracionEstimada'] - $rowAct['horas']);
        if ($diferencia > 0) {
            $imprimir = $imprimir . "<td style=\"color: red\">" . $diferencia . "</td></tr>";
        } else {
            $imprimir = $imprimir . "<td>" . $diferencia . "</td></tr>";
        }
    }
    if ($imprimir != "") {
        $imprimir = $imprimir . "</table>";
    }
}

$conexion->cerrarConexion();
echo $imprimir;
?>
