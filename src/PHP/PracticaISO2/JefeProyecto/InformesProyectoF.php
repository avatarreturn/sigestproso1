<?php
session_start();
//$login = $_SESSION['tipoUsuario'];
//if ($login != "T") {
//    header("location: ../index.php");
//}
$proyecto=$_SESSION['proyectoFinalizado'];
//$proyecto=3;
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


    </head>

    <body>
        <!--        <form name="formulario" action="" enctype="text/plain">-->
        <div id="blogtitle">
            <div id="small">Jefe de Proyecto - Informes</div>
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
                            <li><a href="#">Informes</a></li>
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
                                        <h2>Informes del proyecto finalizado</h2>
                                    </div>
                                    <div class="infoFormulario">
		En esta pantalla podr&aacute; escoger el tipo de informe que desea obtener
                                    </div>
                                    <div class="centercontentleft">
                                        <table>
                                            <tr>
                                                <td>
                                                    <a href="Informe1_1.php?idP='<?php echo $proyecto; ?>'">Trabajadores con actividades asignadas</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="Informe2_1.php?idP='<?php echo $proyecto; ?>'">Trabajadores y sus actividades</a>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td>
                                                    <a href="Informe5_1.php?idP='<?php echo $proyecto; ?>'">Actividades activas</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="Informe6_1.php?idP='<?php echo $proyecto; ?>'">Estado de actividades</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="Informe7_1.php?idP='<?php echo $proyecto; ?>'">Actividades con retraso</a>
                                                </td>
                                            </tr>
                                            
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>



                        <br>

                    </form>
                </div>
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