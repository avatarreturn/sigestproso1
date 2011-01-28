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
$sql = "SELECT a.idActividad, a.nombre actividad, a.duracionEstimada, t.dni, t.nombre, t.apellidos
        FROM Actividad a, TrabajadorActividad ta, Trabajador t, TrabajadorProyecto tp
        WHERE (a.fechaInicioE <= '".$fechaFin."')
            AND (a.fechaInicioE > '".$hoy."')
            AND (ta.Actividad_idActividad=a.idActividad)
            AND (t.dni=ta.Trabajador_dni)
            AND (tp.Trabajador_dni=t.dni)
            AND (tp.Proyecto_idProyecto=".$proyecto.")
        ORDER BY t.dni;";
$result = mysql_query($sql);
$totAct = mysql_num_rows($result);
$imprimir = "";
$dniAnterior="";
if ($totAct > 0) {
            while ($rowInf = mysql_fetch_assoc($result)) {
                if ($rowInf['dni'] != $dniAnterior) {
                    /***duracion estimada de la actividad/nº trabajadores***/
                    $sql = "SELECT t.dni
                            FROM TrabajadorActividad ta, Trabajador t, TrabajadorProyecto tp
                            WHERE (ta.Actividad_idActividad=".$rowInf['idActividad'].")
                                AND (t.dni=ta.Trabajador_dni)
                                AND (tp.Trabajador_dni=t.dni)
                                AND (tp.Proyecto_idProyecto=".$proyecto.");";
                    $resTra = mysql_query($sql);
                    $totTra = mysql_num_rows($resTra);
                    $horas = $rowInf['duracionEstimada'] / $totTra;
                    /*******************************************************/
                    if ($dniAnterior != "") {
                        $imprimir = $imprimir . "</table></div>";
                    }
                    $imprimir = $imprimir . "<a href='#' onclick=\"ocultarR('oculto" . $rowInf['dni'] . "')\"><img src= '../images/iActividad.png' alt='#' border='0' style='width: auto; height: 12px;'/>&nbsp;&nbsp;" . $rowInf['nombre'] . " ".$rowInf['apellidos']."</img></a>" .
                            "<br/><div id='oculto" . $rowInf['dni'] . "' style=\"display:none\"><table class=\"tablaVariable2\"><tr><td><img src='../images/iJefeProyecto.gif' alt='Actividad' border='0' style='width: auto; height: 12px;'>&nbsp;&nbsp;&nbsp;&nbsp;Actividad: " . $rowInf['actividad'] ."</img></td><td>Horas: ".$horas."</td></tr>";
                    $dniAnterior = $rowInf['dni'];
                } else {
                    /***duracion estimada de la actividad/nº trabajadores***/
                    $sql = "SELECT t.dni
                            FROM TrabajadorActividad ta, Trabajador t, TrabajadorProyecto tp
                            WHERE (ta.Actividad_idActividad=".$rowInf['idActividad'].")
                                AND (t.dni=ta.Trabajador_dni)
                                AND (tp.Trabajador_dni=t.dni)
                                AND (tp.Proyecto_idProyecto=".$proyecto.");";
                    $resTra = mysql_query($sql);
                    $totTra = mysql_num_rows($resTra);
                    $horas = $rowInf['duracionEstimada'] / $totTra;
                    /*******************************************************/
                    $imprimir = $imprimir . "<tr><td><img src='../images/iJefeProyecto.gif' alt='Actividad' border='0' style='width: auto; height: 12px;'>&nbsp;&nbsp;&nbsp;&nbsp;Actividad: " . $rowInf['actividad'] ."</img></td><td>Horas: ".$horas."</td></tr>";
                    $dniAnterior = $rowInf['dni'];
                }
            }
            if ($imprimir != "") {
                $imprimir = $imprimir . "</table></div>";
            }
        }else{
            $imprimir="<a href='#'>NO HAY REPARTO DE TRABAJO PARA LA FECHA INTRODUCIDA</a>";
        }

$conexion->cerrarConexion();
echo utf8_decode($imprimir);
?>
