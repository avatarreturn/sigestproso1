<?php
include_once("../Utiles/funciones.php");
include_once ('../Persistencia/conexion.php');
$conexion = new conexion();

$proyecto=$_GET['proyecto'];
$fechaInicio=$_GET['fechaI'];
$fechaFin=$_GET['fechaF'];

//////// consulta que muestra los trabajadores con actividades asignadas en el intervalo dadao /////////

/*      SELECT a.idActividad, t.nombre, t.apellidos, a.fechaInicio, a.fechaFin
        FROM Actividad a, Trabajador t, TrabajadorActividad ta, TareaPersonal tp, Iteracion it, Fase f
        WHERE (a.idActividad=ta.Actividad_idActividad)
           AND (ta.Trabajador_dni=t.dni)
           AND ((a.fechaFin >= '2010-01-14') OR (a.fechaFin IS NULL))
           AND (a.fechaInicio <= '2010-01-21')
           AND (a.Iteracion_idIteracion=it.idIteracion)
           AND (it.Fase_idFase=f.idFase)
           AND (f.Proyecto_idProyecto=3)
        GROUP BY t.nombre
 */
$sql="SELECT a.idActividad, a.nombre actividad, a.fechaInicio, a.fechaFin, t.nombre, t.apellidos
        FROM Actividad a, TrabajadorActividad ta, Iteracion it, Fase f, Trabajador t
        WHERE ((a.fechaFin >= '".$fechaInicio."') OR (a.fechaFin IS NULL))
           AND (a.fechaInicio <= '".$fechaFin."')
           AND (a.Iteracion_idIteracion=it.idIteracion)
           AND (it.Fase_idFase=f.idFase)
           AND (f.Proyecto_idProyecto=".$proyecto.")
           AND (ta.Actividad_idActividad=a.idActividad)
           AND (t.dni=ta.Trabajador_dni)
        GROUP BY t.nombre,a.idActividad
        ORDER BY t.nombre";
$result=mysql_query($sql);
$totTra=mysql_num_rows($result);
$imprimir = "<table>";
if ($totTra>0){
    while($rowTra=  mysql_fetch_assoc($result)){
        $imprimir=$imprimir."<tr><td><img src='../images/iJefeProyecto.gif' alt='Actividad' border='0' style='width: auto; height: 12px;'>&nbsp;&nbsp;&nbsp;&nbsp;" . $rowTra['nombre'] . " " . $rowTra['apellidos'] . "</img></td></tr>";
    }
    $imprimir=$imprimir."</table>";
}

$conexion->cerrarConexion();
echo utf8_decode($imprimir);
?>
