<?php

include_once("../Utiles/funciones.php");
include_once ('../Persistencia/conexion.php');
$conexion = new conexion();

$proyecto = $_GET['proyecto'];
$fechaInicio = $_GET['fechaI'];
$fechaFin = $_GET['fechaF'];

//////// consulta que muestra las actividades activas en el intervalo dado /////////////

/*      SELECT a.idActividad, a.nombre actividad, a.duracionEstimada, sum(tp.horas)
  FROM Actividad a, TareaPersonal tp, Iteracion it, Fase f, InformeTareas i
  WHERE (a.idActividad=i.Actividad_idActividad)
  AND ((a.fechaFin >= '2010-02-01') OR (a.fechaFin IS NULL))
  AND (a.fechaInicio <= '2010-02-07')
  AND (i.semana < '2010-02-07')
  AND (a.Iteracion_idIteracion=it.idIteracion)
  AND (it.Fase_idFase=f.idFase)
  AND (f.Proyecto_idProyecto=3)
  AND (i.idInformeTareas=tp.InformeTareas_idInformeTareas)
  GROUP BY a.idActividad
 */
$sql = "SELECT a.idActividad, a.nombre actividad, a.duracionEstimada, sum(tp.horas) horas
        FROM Actividad a, TareaPersonal tp, Iteracion it, Fase f, InformeTareas i
        WHERE (a.idActividad=i.Actividad_idActividad)
            AND ((a.fechaFin >= '".$fechaInicio."') OR (a.fechaFin IS NULL))
            AND (a.fechaInicio <= '".$fechaFin."')
            AND (i.semana < '".$fechaFin."')
            AND (a.Iteracion_idIteracion=it.idIteracion)
            AND (it.Fase_idFase=f.idFase)
            AND (f.Proyecto_idProyecto=".$proyecto.")
            AND (i.idInformeTareas=tp.InformeTareas_idInformeTareas)
        GROUP BY a.idActividad;";
$result = mysql_query($sql);
$totAct = mysql_num_rows($result);
$imprimir = "";
if ($totAct > 0) {
    $imprimir = "<table>";
    $imprimir = $imprimir . "<tr align=\"center\"><td><a>Actividad</a></td><td><a>&nbsp;&nbsp;&nbsp;&nbsp;Duraci&oacute;n&nbsp;&nbsp;&nbsp;&nbsp;<br/>estimada</a></td><td><a>Tiempo &nbsp;&nbsp;<br/>realizado</a></td><tr>";
    while ($rowAct = mysql_fetch_assoc($result)) {
        $imprimir = $imprimir . "<tr><td>".$rowAct['actividad']."</td><td align=\"center\">".$rowAct['duracionEstimada']."</td><td align=\"center\">".$rowAct['horas']."</td><tr>";
    }
    $imprimir=$imprimir."</table>";
}

$conexion->cerrarConexion();
echo $imprimir;
?>
