<?php

include_once("../Utiles/funciones.php");
include_once ('../Persistencia/conexion.php');
$conexion = new conexion();

$proyecto = $_GET['proyecto'];
$fechaFin = $_GET['fechaF'];

//////// consulta que muestra las actividades planificadas hasta una fecha dada y sus trabajadores /////////////

/*      SELECT a.idActividad, a.nombre actividad, t.nombre, t.apellido
        FROM Actividad a, TrabajadorActividad ta, Iteracion it, Fase f, Trabajador t
        WHERE (a.idActividad=i.Actividad_idActividad)
            AND (a.fechaInicio <= '2010-02-07')
            AND (a.fechaInicio > $hoy)
            AND (a.Iteracion_idIteracion=it.idIteracion)
            AND (it.Fase_idFase=f.idFase)
            AND (f.Proyecto_idProyecto=3)
            AND (ta.Actividad_idActividad=a.idActividad)
            AND (ta.Trabajador_dni=t.dni)
        GROUP BY a.idActividad;
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
