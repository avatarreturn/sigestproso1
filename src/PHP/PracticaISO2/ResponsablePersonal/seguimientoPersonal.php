<?php
session_start();
$login = $_SESSION['tipoUsuario'];
if ($login != "R") {
    header("location: ../index.php");
}
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
        <link rel="stylesheet" type="text/css" href="estiloTablas.css"/>

        <?php
////        //BORRAR
        $dniLogueado = $_SESSION['dni'];
        include_once ('../Persistencia/conexion.php');
        include_once("../Utiles/funciones.php");

        $conexion = new conexion();

        //Calculo del lunes de la semana actual
        $semana = semanaActual();
        //fin calculo del lunes
//        $result = mysql_query('SELECT t.dni, t.nombre, t.apellidos, tp.Trabajador_dni, tp.Proyecto_idProyecto, tp.porcentaje FROM trabajador t, trabajadorProyecto tp where (t.dni=tp.Trabajador_dni);');
        $result = mysql_query('SELECT t.dni, t.nombre, t.apellidos, tp.Trabajador_dni, tp.Proyecto_idProyecto, tp.porcentaje, p.idProyecto, p.nombre nombre_proy FROM Trabajador t, TrabajadorProyecto tp, Proyecto p WHERE (p.idProyecto=tp.Proyecto_idProyecto) AND (p.fechaFin IS NULL) AND (t.dni=tp.Trabajador_dni) ORDER BY t.dni;');


        $totTraProy = mysql_num_rows($result);
        $arrayDnis[] = "";
        if ($totTraProy > 0) {
            $trabajador = "";
            $dniAnterior = "";
            
            $cont = 0;
            $cont2 = 0;
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $cont = $cont + 1;
                if ($rowEmp['Trabajador_dni'] == $dniAnterior) {
                    $trabajador = $trabajador . "<a href='#'><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/iProyecto.png' alt='Actividad' border='0' style='width: auto; height: 12px;'>"
                            . "</img><label> Proyecto: " . $rowEmp['nombre_proy'] . "</label></td><td><label>&nbsp;&nbsp;&nbsp;&nbsp;Dedicación: " . $rowEmp['porcentaje'] . " %</label></td></a></tr>";
                } else {
                    array_push($arrayDnis, $rowEmp['dni']);
                    if ($cont != 0) {
                        $trabajador = $trabajador . "</table></div>";
                    }
                    $trabajador = $trabajador . "<a href='#' onclick=\"ocultarR('oculto" . $cont . "')\"><br/><img src= '../images/iJefeProyecto.gif' alt='#' border='0' style='width: auto; height: 12px;'/>"
                            . "&nbsp;&nbsp;" . utf8_encode($rowEmp['nombre']) . " " . utf8_encode($rowEmp['apellidos']) . "     " . $rowEmp['dni'] . "</a>";
                    //Compruebo si el trabajador esta de vacaciones
                    if (vacacionesSiNo($rowEmp['dni'], date("Y-m-d"))) {
                        $intervVaca = vacacionesPeriodo($rowEmp['dni'], $semana);
                        $trabajador = $trabajador . "<a href='#'>&nbsp;&nbsp;<img src= '../images/vacaciones.jpg' alt='#' border='0' style='width: auto; height: 12px;'/></a>"
                                . "<div id=\"oculto" . $cont . "\" style=\"display:none\"><br/><label>Est&aacute; de vacaciones desde el dia " . $intervVaca['fechaInicio'] . " hasta el dia " . $intervVaca['fechaFin'] . "</label>"
                                . "<a href='#'><table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/iProyecto.png' alt='Actividad' border='0' style='width: auto; height: 12px;'>"
                                . "</img><label> Proyecto: " . $rowEmp['nombre_proy'] . "</label></td><td><label>&nbsp;&nbsp;&nbsp;&nbsp;Dedicación: " . $rowEmp['porcentaje'] . " %</label></td></a></tr>";
                    } else {

                        $trabajador = $trabajador . "<div id=\"oculto" . $cont . "\" style=\"display:none\"><br/>"
                                . "<a href='#'><table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/iProyecto.png' alt='Actividad' border='0' style='width: auto; height: 12px;'>"
                                . "</img><label> Proyecto: " . $rowEmp['nombre_proy'] . "</label></td><td><label>&nbsp;&nbsp;&nbsp;&nbsp;Dedicación: " . $rowEmp['porcentaje'] . " %</label></td></a></tr>";
                    }
                }

                $dniAnterior = $rowEmp['dni'];
            }
            if ($trabajador != "") {
                $trabajador = $trabajador . "</table></div>";
            }
        } else {
            $trabajador = "<a href='#'><img src= '../images/iJefeProyecto.gif' alt='#' border='0' style='width: auto; height: 12px;'/>&nbsp;&nbsp;&nbsp;&nbsp;NO EXISTE NIGUN TRABAJADOR ASIGNADO A NINGUN PROYECTO</a>";
        }

        //Aqui calculo los trabajadores no asociados a ningun proyecto

        $sql = "select dni, nombre, apellidos from Trabajador where";
        if (count($arrayDnis) > 1) { //si el array de dni encontrados tiene contenido
            $sql = $sql . " (dni != '" . $arrayDnis[1] . "')"; //excluyo de la consulta el primer dni
            for ($i = 1; $i < count($arrayDnis); $i++) {    //repito para cada dni
                $sql = $sql . " and (dni != '" . $arrayDnis[$i] . "')"; //para excluir de la consulta los dni ya encontrados
            }
            $sql = $sql . " order by nombre;"; //cierro la consulta sql
        }else{
            $sql="select dni, nombre, apellidos from Trabajador";
        }
        $result = mysql_query($sql);
        $restoTrabaj = "<br/><br/><label>Trabajadores no asociados a ningun proyecto: </label><br/><br/>";
        while ($rowEmp = mysql_fetch_assoc($result)) {
            $restoTrabaj = $restoTrabaj . "<a href='#' onclick=\"ocultarR('oculto" . $rowEmp['dni'] . "')\">"
                    . "<img src= '../images/iJefeProyecto.gif' alt='#' border='0' style='width: auto; height: 12px;'/>"
                    . "&nbsp;&nbsp;" . utf8_encode($rowEmp['nombre']) . " " . utf8_encode($rowEmp['apellidos']) . "&nbsp;&nbsp;&nbsp;&nbsp;" . $rowEmp['dni'] . "</a>";

            if (vacacionesSiNo($rowEmp['dni'], $semana)) {
                $intervVaca = vacacionesPeriodo($rowEmp['dni'], $semana);
                $restoTrabaj = $restoTrabaj . "<a href='#'>&nbsp;&nbsp;<img src= '../images/vacaciones.jpg' alt='#' border='0' style='width: auto; height: 12px;'/></a>"
                        . "<div id=\"oculto" . $rowEmp['dni'] . "\" style=\"display:none\"><br/><label>Est&aacute; de vacaciones desde el dia " . $intervVaca['fechaInicio'] . " hasta el dia " . $intervVaca['fechaFin'] . "</label></div>";
            }
            $restoTrabaj = $restoTrabaj . "<br/>";
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

        <!-- start top menu and blog title-->

        <div id="blogtitle">
            <div id="small">Responsable de Personal</div>
            <div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
        </div>

        <div id="topmenu">


            <ul class="BLUE">
                <li><a href="iniResponsablePersonal.php" title="Crear trabajadores"><span>Crear trabajadores</span></a></li>
                <li><a href="informesResponsablePersonal.php" title="Obtener informes"><span>Obtener informes</span></a></li>
                <li><a href="seguimientoPersonal.php" title="Seguimiento Personal"><span>Seguimiento Personal</span></a></li>
            </ul>
        </div>

        <!-- end top menu and blog title-->
        <div id="page">

            <div id="leftcontent">
                <img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />

                <h3 align="left">Men&uacute;</h3>


                <div align="left">
                    <ul class="BLUE">
                        <li><a href="iniResponsablePersonal.php">Crear trabajadores</a></li>
                        <li><a href="seguimientoPersonal.php">Seguimiento Personal</a></li>
                        <li><a href="informesResponsablePersonal.php">Informes</a></li>
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
                <div id="formulario">
                    <!--                <form  action="crearUsuario.php" method="post">-->
                    <form method="POST" name="nuevo_usuario">
                        <div class="tituloFormulario">
                            <h2>Seguimiento Personal</h2>
                        </div>
                        <div class="infoFormulario">
		A trav&eacute;s de esta pantalla el Responsable de Personal podr&aacute; ver la situaci&oacute;n de cada trabajador dentro de la empresa.
                        </div>
                        <table>
                            <tr>
                                <td>
<?php
        echo $trabajador;
?>

<?php
        echo $restoTrabaj;
?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <br/>
                                    <a href='#'>&nbsp;&nbsp;<img src= '../images/vacaciones.jpg' alt='#' border='0' style='width: auto; height: 12px;'/></a>
                                    <label>Este trabajador est&aacute; de vacaciones en este momento</label>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

            </div>


            <!-- end content -->
        </div>
        <!-- start footer -->

        <div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>


        </div>

        <!-- end footer -->




    </body>
</html>