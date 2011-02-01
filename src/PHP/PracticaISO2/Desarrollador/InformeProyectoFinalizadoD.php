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



        $proyecto = $_GET['idP'];

//////////////// nombre del proyecto y del jefe de proyecto, fecha de inicio y fecha de fin //////////////////////
        $sql = "SELECT p.nombre proyecto, p.descripcion, p.fechaInicio, p.fechaFin, t.nombre, t.apellidos
                FROM Trabajador t, Proyecto p
                WHERE (t.dni = p.jefeProyecto)
                    AND (p.idProyecto=".$proyecto.");";
        $result = mysql_query($sql);
        $rowProy=mysql_fetch_assoc($result);

/////////////////// nombre apellidos y dni de los trabajadores ///////////////////
        $sql2 = "SELECT t.dni, t.nombre, t.apellidos
                FROM Trabajador t, TrabajadorProyecto tp
                WHERE (t.dni = tp.Trabajador_dni)
                    AND (tp.Proyecto_idProyecto=".$proyecto.");";
        $result2 = mysql_query($sql2);

///////////


        $imprimir = "<div class=\"centercontentleft\"><table><tr><td><a>Nombre: </a>".$rowProy['proyecto']."<a>&nbsp;&nbsp;&nbsp;&nbsp;Descripcion:</a> ". $rowProy['descripcion']."</td></tr>"
                    ."<tr><td><a>Jefe de proyecto: </a>".$rowProy['nombre']." ".$rowProy['apellidos']."</td></tr>"
                    ."<tr><td><a>Fecha de inicio: </a>".$rowProy['fechaInicio']."&nbsp;&nbsp;&nbsp;&nbsp;<a>Fecha de fin: </a>".$rowProy['fechaFin']."</td></tr>";
        $imprimir = $imprimir . "<tr><td><a>Trabajadores que participaron en el proyecto:</a></td></tr>";
        while ($rowTra=  mysql_fetch_assoc($result2)){
            $imprimir = $imprimir . "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;".$rowTra['nombre']." ".$rowTra['apellidos']." (".$rowTra['dni'].")</td></tr>";
        }
        $imprimir=$imprimir."</table></div>";



//        $totAct = mysql_num_rows($result);
//        $imprimir = "";
//        if ($totAct > 0) {
//            $imprimir = "<table>";
//            $imprimir = $imprimir . "<tr><td><a>Actividad&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td><td><a>Estado</a></td><tr>";
//            while ($rowAct = mysql_fetch_assoc($result)) {
//                if ($rowAct['duracionEstimada'] < $rowAct['horas']) {
//                    if ($rowAct['fechaFin'] != null) {
//                        $imprimir = $imprimir . "<tr><td>" . $rowAct['actividad'] . "</td><td>Finalizada</td><tr>";
//                    } else {
//                        $imprimir = $imprimir . "<tr><td>" . $rowAct['actividad'] . "</td><td>Activa</td><tr>";
//                    }
//                }
//            }
//            if ($imprimir == "<table><tr><td><a>Actividad&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td><td><a>Estado</a></td><tr>") {
//                $imprimir = "<a>No existen actividades con consumo de tiempo superior al estimado</a>";
//            }else{
//                $imprimir = $imprimir . "</table>";
//            }
//        }else{
//            $imprimr="<a href='#'>NO EXISTEN ACTIVIDADES CON MAYOR CONSUMO DE TIEMPO DEL PLANIFICADO</a>";
//        }


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

            <div id="small">Resumen proyecto finalizado -(<?php echo $_SESSION['login'];?>)- </div>
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
		Principales datos del proyecto finalizado.
                                    </div>

                                    <div>
                                        <?php
                                        echo utf8_decode($imprimir);
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
