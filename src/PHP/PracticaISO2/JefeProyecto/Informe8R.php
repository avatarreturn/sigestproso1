<?php

include_once("../Utiles/funciones.php");
include_once ('../Persistencia/conexion.php');
$conexion = new conexion();

$proyecto = $_GET['proyecto'];
$fechaFin = $_GET['fechaF'];
$hoy = date('Y-m-d');

//////// consulta que muestra las actividades planificadas hasta una fecha dada y sus trabajadores /////////////

/*      SELECT a.idActividad, a.nombre actividad, ta.Trabajador_dni, t.nombre
        FROM Actividad a, TrabajadorActividad ta, Trabajador t, TrabajadorProyecto tp
        WHERE (a.fechaInicioE <= '2011-01-24')
            AND (a.fechaInicioE > '2011-01-19')
            AND (ta.Actividad_idActividad=a.idActividad)
            AND (t.dni=ta.Trabajador_dni)
            AND (tp.Trabajador_dni=t.dni)
            AND (tp.Proyecto_idProyecto=2)
        ORDER BY a.idActividad;
 */
$sql = "SELECT a.idActividad, a.nombre actividad, ta.Trabajador_dni, t.nombre, t.apellidos
        FROM Actividad a, TrabajadorActividad ta, Trabajador t, TrabajadorProyecto tp
        WHERE (a.fechaInicioE <= '".$fechaFin."')
            AND (a.fechaInicioE > '".$hoy."')
            AND (ta.Actividad_idActividad=a.idActividad)
            AND (t.dni=ta.Trabajador_dni)
            AND (tp.Trabajador_dni=t.dni)
            AND (tp.Proyecto_idProyecto=".$proyecto.")
        ORDER BY a.idActividad;";
$result = mysql_query($sql);
$totAct = mysql_num_rows($result);
$imprimir = "";
$actAnterior="";
if ($totAct > 0) {
            while ($rowInf = mysql_fetch_assoc($result)) {
                if ($rowInf['idActividad'] != $actAnterior) {
                    if ($actAnterior != "") {
                        $imprimir = $imprimir . "</table></div>";
                    }
                    $imprimir = $imprimir . "<a href='#' onclick=\"ocultarR('oculto" . $rowInf['idActividad'] . "')\"><img src= '../images/iActividad.png' alt='#' border='0' style='width: auto; height: 12px;'/>&nbsp;&nbsp;" . $rowInf['actividad'] ."</img></a>" .
                            "<br/><div id='oculto" . $rowInf['idActividad'] . "' style=\"display:none\"><table><tr><td><img src='../images/iJefeProyecto.gif' alt='Actividad' border='0' style='width: auto; height: 12px;'>&nbsp;&nbsp;&nbsp;&nbsp;" . $rowInf['nombre'] . " ".$rowInf['apellidos']."</img></td></tr>";
                    $actAnterior = $rowInf['idActividad'];
                } else {
                    $imprimir = $imprimir . "<tr><td><img src='../images/iJefeProyecto.gif' alt='Actividad' border='0' style='width: auto; height: 12px;'>&nbsp;&nbsp;&nbsp;&nbsp;" . $rowInf['nombre'] . " ".$rowInf['apellidos']."</img></td></tr>";
                    $actAnterior = $rowInf['idActividad'];
                }
            }
            if ($imprimir != "") {
                $imprimir = $imprimir . "</table></div>";
            }
        }else{
            $imprimir="<a href='#'>NO HAY ACTIVIDADES CON PLANIFICADAS PARA LA FECHA INTRODUCIDA</a>";
        }

$conexion->cerrarConexion();
echo $imprimir;
?>
