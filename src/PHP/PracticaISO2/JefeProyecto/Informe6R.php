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

$result = mysql_query($sql);
$totAct = mysql_num_rows($result);
$imprimir = "";
$fecha=strtotime($fecha,0);
if ($totAct > 0) {
    $imprimir = $imprimir . "<table><tr><td><a>Actividad</a></td><td><a>Fecha de Inicio</a></td><td><a>&nbsp;&nbsp;Fecha de fin</a></td><td><a>&nbsp;&nbsp;Duracion estimada</a></td><td><a>&nbsp;&nbsp;Duracion real</a></td></tr>";
    while ($rowAct = mysql_fetch_assoc($result)) {
        $fechaAux=strtotime($rowAct['fechaFin'],0);
        if ($rowAct['fechaFin'] == null or $fechaAux > $fecha) {
            $imprimir = $imprimir . "<tr align=\"center\"><td align=\"left\">" . $rowAct['actividad'] . "</td><td>" . $rowAct['fechaInicio'] . "</td><td>" . "Activa" . "</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $rowAct['duracionEstimada'] . "</td><td>" . $rowAct['horas'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
        } else {
            $imprimir = $imprimir . "<tr align=\"center\"><td align=\"left\">" . $rowAct['actividad'] . "</td><td>" . $rowAct['fechaInicio'] . "</td><td>" . $rowAct['fechaFin'] . "</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $rowAct['duracionEstimada'] . "</td><td>" . $rowAct['horas'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
        }
    }
    if ($imprimir != "") {
        $imprimir = $imprimir . "</table>";
    }
}

$conexion->cerrarConexion();
echo utf8_decode($imprimir);
?>
