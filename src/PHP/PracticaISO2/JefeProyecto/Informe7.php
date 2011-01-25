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

//consulta que muestra las actividades que han consumido o estan consumiendo mas tiempo del planificado ///////////
        /*  SELECT a.idActividad, a.nombre actividad, a.duracionEstimada, sum(tp.horas) horas
          FROM Actividad a, TareaPersonal tp, Iteracion it, Fase f, InformeTareas i
          WHERE (a.idActividad=i.Actividad_idActividad)
          AND (a.Iteracion_idIteracion=it.idIteracion)
          AND (it.Fase_idFase=f.idFase)
          AND (f.Proyecto_idProyecto=3)
          AND (i.idInformeTareas=tp.InformeTareas_idInformeTareas)
          GROUP BY a.idActividad
         *
         */
//////////////////////////////////////////////////////////////////////////////////////////////     


        $proyecto = 5;    //esta variable tiene que se de sesion
//        $proyecto=$_SESSION['proyecto'];

        $sql = "SELECT a.idActividad, a.nombre actividad, a.fechaFin, a.duracionEstimada, sum(tp.horas) horas
                FROM Actividad a, TareaPersonal tp, Iteracion it, Fase f, InformeTareas i
                WHERE (a.idActividad=i.Actividad_idActividad)
                    AND (a.Iteracion_idIteracion=it.idIteracion)
                    AND (it.Fase_idFase=f.idFase)
                    AND (f.Proyecto_idProyecto=3)
                    AND (i.idInformeTareas=tp.InformeTareas_idInformeTareas)
                GROUP BY a.idActividad;";
        $result = mysql_query($sql);
        $totAct = mysql_num_rows($result);
        $imprimir = "";
        if ($totAct > 0) {
            $imprimir = "<table>";
            $imprimir = $imprimir . "<tr align=\"center\"><td><a>Actividad</a></td><td><a>Esetado</a></td><tr>";
            while ($rowAct = mysql_fetch_assoc($result)) {
                if ($rowAct['duracionEstimada'] < $rowAct['horas']) {
                    if ($rowAct['fechaFin'] == null) {
                        $imprimir = $imprimir . "<tr><td><a>" . $rowAct['actividad'] . "</a></td><td><a>Finalizada</a></td><tr>";
                    } else {
                        $imprimir = $imprimir . "<tr><td><a>" . $rowAct['actividad'] . "</a></td><td><a>Activa</a></td><tr>";
                    }
                }
            }
            $imprimir=$imprimir="";
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
            <div id="small">Jefe de Proyecto - Informes - Actividades con retraso</div>
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
		Relación de actividades que han consumido o están consumiendo m&aacute;acutes tiempo del planificado.
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