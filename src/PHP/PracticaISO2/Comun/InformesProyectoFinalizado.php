<?php
//session_start();
//$login = $_SESSION['tipoUsuario'];
//if ($login != "T") {
//    header("location: ../index.php");
//}
session_start();
$proyecto = $_SESSION['proyectoEscogido'];
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

        <?php
        include_once ('../Persistencia/conexion.php');
        $conexion = new conexion();
        $sql="Select idProyecto, nombre, descripcion from Proyecto where fechaFin IS NOT NULL;";
        $result=  mysql_query($sql);
        $totProy= mysql_num_rows($result);
        $imprimir="";
        if ($totProy > 0){
            while($rowProy = mysql_fetch_assoc($result)){
                $imprimir=$imprimir."<a href='eraJefe.php?idPF=".$rowProy['idProyecto']."'><img src= '../images/iProyecto.png' alt='#' border='0' style='width: auto; height: 12px;'/>&nbsp;&nbsp;".$rowProy['nombre']."</a><label>&nbsp;&nbsp;".$rowProy['descripcion']."</label><br/>";
            }
        }else{
            $imprimir="<a href='#'>No existen proyectos antiguos</a>";
        }
        $conexion->cerrarConexion();
        ?>
    </head>

    <body>
        <!--        <form name="formulario" action="" enctype="text/plain">-->
        <div id="blogtitle">
            <div id="small">Trabajador (<u><?php echo $_SESSION['login'] ?></u>) - Informes de proyectos finalizados</div>
            <div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
        </div>
        <div id="page">


            <div id="leftcontent">
                <img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />

                <h3 align="left">Men&uacute;</h3>


                <div align="left">
                    <ul class="BLUE">
			<li><a href="selecProyecto.php">Seleccionar proyecto</a></li>
			<li><a href="selecVacaciones.php">Escoger vacaciones</a></li>
                        <li><a href="#">Informes proyectos finalizados</a></li>
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
		A continuaci&oacute;n se muestra la lista de proyectos finlizados por orden cronol&oacute;gico.
                                    </div>
                                    <div class="centercontentleft">
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
    </div>


    <!-- end content -->
    <!-- start footer -->

    <div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>




    </div>

    <!-- end footer -->




</body>
</html>