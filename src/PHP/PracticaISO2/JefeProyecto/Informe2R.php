<?php

include_once("../Utiles/funciones.php");
include_once ('../Persistencia/conexion.php');
$conexion = new conexion();

$proyecto = $_GET['proyecto'];
$fechaInicio = $_GET['fechaI'];
$fechaFin = $_GET['fechaF'];

//////// consulta que muestra los trabajadores con actividades asignadas en el intervalo dadao /////////

/*      SELECT a.idActividad, a.nombre actividad, a.fechaInicio, a.fechaFin, t.nombre, t.apellidos
  FROM Actividad a, Trabajador t, TrabajadorActividad ta, TareaPersonal tp, Iteracion it, Fase f
  WHERE (a.idActividad=ta.Actividad_idActividad)
  AND (ta.Trabajador_dni=t.dni)
  AND ((a.fechaFin >= '2010-02-01') OR (a.fechaFin IS NULL))
  AND (a.fechaInicio <= '2010-02-07')
  AND (a.Iteracion_idIteracion=it.idIteracion)
  AND (it.Fase_idFase=f.idFase)
  AND (f.Proyecto_idProyecto=3)
  GROUP BY a.idActividad, t.nombre
 */
$sql = "SELECT a.idActividad, a.nombre actividad, a.fechaInicio, a.fechaFin, t.nombre, t.apellidos, t.dni
        FROM Actividad a, Trabajador t, TrabajadorActividad ta, Iteracion it, Fase f
        WHERE (a.idActividad=ta.Actividad_idActividad)
           AND (ta.Trabajador_dni=t.dni)
           AND ((a.fechaFin >= '" . $fechaInicio . "') OR (a.fechaFin IS NULL))
           AND (a.fechaInicio <= '" . $fechaFin . "')
           AND (a.Iteracion_idIteracion=it.idIteracion)
           AND (it.Fase_idFase=f.idFase)
           AND (f.Proyecto_idProyecto=" . $proyecto . ")
        GROUP BY a.idActividad, t.nombre
        ORDER BY t.nombre;";
$result = mysql_query($sql);
$totTra = mysql_num_rows($result);
$imprimir = "";
$dniAnterior = "";
if ($totTra > 0) {
    while ($rowTra = mysql_fetch_assoc($result)) {
        if ($rowTra['dni'] != $dniAnterior) {
            if($dniAnterior!=""){
                $imprimir=$imprimir."<br/></div></td></tr>";
            }else{
                $imprimr=$imprimir."<table>";
            }
            $imprimir = $imprimir . "<tr><td><a href='#' onclick=\"ocultarR('oculto" . $rowTra['dni'] . "')\"><img src='../images/iJefeProyecto.gif' alt='Actividad' border='0' style='width: auto; height: 12px;'>&nbsp;&nbsp;&nbsp;&nbsp;" . $rowTra['nombre'] . " " . $rowTra['apellidos'] . "<br/></img></a>"
            ."<div id=\"oculto" . $rowTra['dni'] . "\" style=\"display:none\">&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/iActividad4.gif' alt='Actividad' border='0' style='width: auto; height: 12px;'>&nbsp;&nbsp;&nbsp;&nbsp;Actividad: ".$rowTra['actividad']."<br/>";
            $dniAnterior=$rowTra['dni'];
        }else{
            $imprimir=$imprimir."&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/iActividad4.gif' alt='Actividad' border='0' style='width: auto; height: 12px;'>&nbsp;&nbsp;&nbsp;&nbsp;Actividad: ".$rowTra['actividad']."<br/>";
        }
    }

    if($imprimir!=""){
                $imprimir=$imprimir."</div></td></tr></table>";
            }
}

$conexion->cerrarConexion();
echo $imprimir;
?>
