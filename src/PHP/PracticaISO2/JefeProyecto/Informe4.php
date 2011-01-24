<?php
//session_start();
//$login = $_SESSION['tipoUsuario'];
//if ($login != "T") {
//    header("location: ../index.php");
//}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

    <head>

        <title>[SIGESTPROSO] Seguimiento Integrado de la GESTi&oacute;n Temporal de PROyectos de Software</title>

        <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
        <meta name="description" content="studio7designs" />
        <meta name="keywords" content="#" />
        <meta name="googlebot" content="index, follow" />
        <meta name="language" content="en-us, english" />
        <meta name="classification" content="#" />
        <meta name="author" content="www.studio7designs.com" />
        <meta name="copyright" content="#" />
        <meta name="location" content="#" />
        <meta name="zipcode" content="#" />


        <link rel="stylesheet" type="text/css" href="../stylesheet.css" media="screen, projection, tv " />
        <link rel="stylesheet" type="text/css" href="../ResponsablePersonal/estiloTablas.css" media="screen, projection, tv " />
        <?php
        include_once("../Utiles/funciones.php");
        include_once ('../Persistencia/conexion.php');
        $conexion = new conexion();

        $proyecto = 5;    //esta variable tiene que se de sesion
        $estaSemana = semanaActual();
        $hoy = date('Y-m-d');

//////// consulta que muestra los trabajadores con informes pendientes de aceptacion /////////

        /*      SELECT t.nombre, t.apellidos, i.semana, a.actividad
         *      FROM Trabajador t, TrabajadorActividad ta, Actividad a, InformeTareas i, TrabajadorProyecto tp
         *      WHERE (t.dni=ta.Trabajador_dni)
         *          AND (ta.Actividad_idActividad=a.idActividad)
         *          AND (i.Trabajador_dni=t.dni)
         *          AND (i.Actividad_idActividad=a.idActividad)
         *          AND (tp.Trabajador_dni=t.dni)
         *          AND (tp.Proyecto_idProyecto=5)
         *          AND (i.estado!=Aceptado)
         *      ORDER BY t.nombre;
         */

        /* Estas son las actividades activas en la semana actual para el proyecto seleccionado */
        $sql = "SELECT t.dni, t.nombre, t.apellidos, i.semana, a.nombre actividad
        FROM Trabajador t, TrabajadorActividad ta, Actividad a, InformeTareas i, TrabajadorProyecto tp
        WHERE (t.dni=ta.Trabajador_dni)
            AND (ta.Actividad_idActividad=a.idActividad)
            AND (i.Trabajador_dni=t.dni)
            AND (i.Actividad_idActividad=a.idActividad)
            AND (tp.Trabajador_dni=t.dni)
            AND (tp.Proyecto_idProyecto=5)
            AND (i.estado!='Aceptado')
        ORDER BY t.nombre;";
        $result = mysql_query($sql);
        $totInf = mysql_num_rows($result);
        $dniAnterior = "";
        $imprimir = "";
        if ($totInf > 0) {
            while ($rowInf = mysql_fetch_assoc($result)) {
                if ($rowInf['dni'] != $dniAnterior) {
                    if ($dniAnterior != "") {
                        $imprimir = $imprimir . "</table></div>";
                    }
                    $imprimir = $imprimir . "<a href='#' onclick=\"ocultarR('oculto" . $rowInf['dni'] . "')\">" . $rowInf['nombre'] . " " . $rowInf['apellidos'] . "</a>" .
                            "<br/><div id='oculto" . $rowInf['dni'] . "' style=\"display:none\"><table class=\"tablaVariable\"><tr><td><img src='../images/iProyecto.png' alt='Actividad' border='0' style='width: auto; height: 12px;'>&nbsp;&nbsp;&nbsp;&nbsp;Actividad: " . $rowInf['actividad'] . "</img></td><td>Semana: " . $rowInf['semana'] . "</td></tr>";
                    $dniAnterior = $rowInf['dni'];
                } else {
                    $imprimir = $imprimir . "<tr><td>Actividad: " . $rowInf['actividad'] . "</td><td>Semana: " . $rowInf['semana'] . "</td></tr>";
                    $dniAnterior = $rowInf['dni'];
                }
            }
            if ($imprimir != "") {
                $imprimir = $imprimir . "</table></div>";
            }
        }

        $conexion->cerrarConexion();
        ?>
        <script>
            function ocultarR(x){

                if(document.getElementById(x).style.display=="none"){
                    document.getElementById(x).style.display="inline";
                }else{
                    document.getElementById(x).style.display="none"
                }

            }
        </script>

    </head>

    <body>
        <!--        <form name="formulario" action="" enctype="text/plain">-->
        <div id="blogtitle">
            <div id="small">Jefe de Proyecto - Informes - Trabajadores con informes pendientes de envio</div>
            <div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
        </div>
        <div id="page">


            <div id="leftcontent">
                <img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />

                <h3 align="left">Men&uacute;</h3>


                <div align="left">
                    <ul class="BLUE">
                        <li><a href="planIteracion.php">Planificar iteraci&oacute;n</a></li>
                        <li><a href="../Comun/selecVacaciones.php">Escoger vacaciones</a></li>
                    </ul>
                </div>


                <p><img src= "../images/Logo2.jpg" alt="#" border="0" style="width: 180px; height: auto;"/></p>


                <!-- You have to modify the "padding-top: when you change the content of this div to keep the footer image looking aligned -->

                <img style="padding-top:2px; margin-left:-12px; margin-bottom:-4px;" src="../images/specs_bottom.jpg" alt="" />



            </div>

            <!-- start content -->

            <div id="centercontent">


                <h1>SIGESTPROSO </h1>
                <p><br /></p>
                <p>

                <div id="formulario">
                    <form action="" method="POST" name="obtenerInformes">
                        <table>
                            <tr>
                                <td>
                                    <div class="tituloFormulario">
                                        <h2>Informes del proyecto</h2>
                                    </div>
                                    <div class="infoFormulario">
		Relación de trabajadores con informes de actividad pendientes de aprobación y fechas de los mismos.
                                    </div>

                                    <div class="centercontentleft">
                                        <?php
                                        echo $imprimir;
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>



                        <br>

                    </form>
                </div>
            </div>
        </div>


        <!-- end content -->
        <!-- start footer -->

        <div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>




        </div>

        <!-- end footer -->




    </body>
</html>