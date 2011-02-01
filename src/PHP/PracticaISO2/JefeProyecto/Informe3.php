<?php
session_start();
//$login = $_SESSION['tipoUsuario'];
//if ($login != "T") {
//    header("location: ../index.php");
//}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

    <head>

        <title>[SIGESTPROSO]-Seguimiento Integrado de la GEStion Temporal de PROyectos de SOftware</title>

        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
//////////////////////// Algoritmo para la busqueda de informes pendiente de envio ///////////
//                                                                                          //
//      Selecciono las actividades activas en este momento.                                 //
//      Para cada una{                                                                      //
//          Compruebo la fecha de inicio.                                                   //
//          Obtengo los trabajadores asociados a ella                                       //
//          Calulo la semana de inicio de la actividad                                      //
//          Mientras la semana sea inferior o igual a la semana actual{                     //
//              Para cada trabajdor asociado{                                               //
//                  Busco su informe de esa semana.                                         //
//                  Si no existe{ guardo dni del trabajador y semana}                       //
//              }                                                                           //
//              Sumo una semana mas.                                                        //
//          }                                                                               //
//      }                                                                                   //
//////////////////////////////////////////////////////////////////////////////////////////////
//        $proyecto = 5;    //esta variable tiene que se de sesion
        $proyecto = $_SESSION['proyectoEscogido'];
        $estaSemana = semanaActual();
        $hoy = date('Y-m-d');
        $arrayActividades;
        $informesPendientes;
        /* Estas son las actividades activas en la semana actual para el proyecto seleccionado */
        $sql = "SELECT a.idActividad, a.fechaInicio, a.nombre actividad
            FROM actividad a, Iteracion it, Fase f, Proyecto p 
            WHERE (a.fechaInicio<='" . $hoy . "')
                AND (a.fechaFin IS NULL)
                AND (a.Iteracion_idIteracion=it.idIteracion)
                AND (it.Fase_idFase=f.idFase)
                AND (f.Proyecto_idProyecto=p.idProyecto)
                AND (p.idProyecto=" . $proyecto . ")
            ORDER BY a.fechaInicio;";
        $result = mysql_query($sql);
        $totInf = mysql_num_rows($result);
        if ($totInf > 0) {
            while ($rowAct = mysql_fetch_assoc($result)) {
                $arrayActividades[$rowAct['idActividad']] = array(fechaInicio => $rowAct['fechaInicio'], actividad => $rowAct['actividad']);
            }
        }

        foreach ($arrayActividades as $aid => $a) {
            $trabajadores = NULL;
            $semana = calculaLunes($a['fechaInicio']);
            /* Trabajadores vinculados a esta actividad */
            $sql = "SELECT nombre, apellidos, dni FROM Trabajador, TrabajadorActividad WHERE (Actividad_idActividad=" . $aid . ") and (Trabajador_dni=dni);";
            $result = mysql_query($sql);
            while ($rowTra = mysql_fetch_assoc($result)) {
                $trabajadores[$rowTra['dni']] = array(nombre => $rowTra['nombre'], apellidos => $rowTra['apellidos']);
            }
            while ($semana <= $estaSemana) {
                foreach ($trabajadores as $d => $NombApell) {
                    /* Informes enviados en la semana $semana */
                    $sqlInf = "SELECT idInformeTareas FROM InformeTareas WHERE Actividad_idActividad=" . $aid . " AND semana='" . $semana . "';";
                    $resultInf = mysql_query($sqlInf);
                    $totInf = mysql_num_rows($resultInf);
                    if ($totInf == 0) {
                        $informesPendientes[] = array(trabajador => $d, semana => $semana, actividad => $a['actividad'], nombre => $NombApell['nombre'], apellidos => $NombApell['apellidos']);
                    }
                }
                ///Aqui calculo el lunes de la semana siguiente
                $semana = sumaDia($semana, 7);
            }
            unset($trabajadores);
        }

        /* En el array $informesPendientes tengo todos los datos. Ahora los imprimo */
        $traAnterior = "";
        $imprimir = "<div class=\"centercontentleft\">";
        if ($informesPendientes != null) {
            foreach ($informesPendientes as $informe) {
                if ($informe['trabajador'] != $traAnterior) {
                    if ($traAnterior != "") {
                        $imprimir = $imprimir . "</table></div>";
                    }
                    $imprimir = $imprimir . "<a href='#' onclick=\"ocultarR('oculto" . $informe['trabajador'] . "')\">" . $informe['nombre'] . " " . $informe['apellidos'] . "</a>" .
                            "<br/><div id='oculto" . $informe['trabajador'] . "' style=\"display:none\"><table class=\"tablaVariable\"><tr><td><img src='../images/iProyecto.png' alt='Actividad' border='0' style='width: auto; height: 12px;'>&nbsp;&nbsp;&nbsp;&nbsp;Actividad: " . $informe['actividad'] . "</img></td><td>Semana: " . $informe['semana'] . "</td></tr>";
                    $traAnterior = $informe['trabajador'];
                } else {
                    $imprimir = $imprimir . "<tr><td><img src='../images/iProyecto.png' alt='Actividad' border='0' style='width: auto; height: 12px;'>&nbsp;&nbsp;&nbsp;&nbsp;Actividad: " . $informe['actividad'] . "</td><td>Semana: " . $informe['semana'] . "</td></tr>";
                    $traAnterior = $informe['trabajador'];
                }
            }
        }
        if ($imprimir != "<div class=\"centercontentleft\">") {
            $imprimir = $imprimir . "</table></div></div>";
        }else{
            $imprimir="<div class=\"centercontentleft\"><a>No hay trabajadores con informes de actividad pendientes</a></div>";
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
            <div id="small">Jefe de proyecto (<u><?php echo $_SESSION['login'] ?></u>) - Informes - Informes de actividad pendientes de recibir</div>
            <div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
        </div>
        <div id="page">


            <div id="leftcontent">
                <img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />

                <h3 align="left">Men&uacute;</h3>


                <div align="left">
                    <ul class="BLUE">
                        <li><a href="../Comun/selecProyecto.php">Seleccionar proyecto</a></li>
                        <li><a href="../JefeProyecto/revisarInformesAct.php">Revisar actividades activas</a></li>
                        <li><a href="../JefeProyecto/planIteracion.php">Planificar iteraci&oacute;n</a></li>
                        <!--                            Quitad el enlace de la pagina en la que se esta(como aqui planificar iteracion)
                                                    y añadid el enlace de esta:
                                                    href="../JefeProyecto/planIteracion.php" -->
                        <li><a href="../JefeProyecto/InformesProyecto.php">Informes</a></li>
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
		Relaci&oacute;n de trabajadores con informes de actividad pendientes de env&iacute;o y fechas de los mismos.
                                    </div>

<!--                                    <div class="centercontentleft" style="display: none">-->
<?php
        echo $imprimir;
?>
<!--                                    </div>-->
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