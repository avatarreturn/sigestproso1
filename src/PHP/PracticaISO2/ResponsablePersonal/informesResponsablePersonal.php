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

        <title>Nautica08</title>

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
        include_once("funciones.php");

        include_once ('../Persistencia/conexion.php');
        $conexion = new conexion();
        //Calculamos el lunes de la semana actual
        $dSemana = date(N);
        $semana = date("Y-m-d");
        if ($dSemana != 1) {
            while ($dSemana != 1) {
                $semana = date("Y-m-d", strtotime(date("Y-m-d", strtotime($semana)) . " -1 day"));
                $dSemana = date('N', strtotime($semana));
            }
        }
        //fin calculo del lunes
        //
        //Esta es la consulta que tengo que poner
        //SELECT t.dni, t.nombre, t.apellidos, i.idInformeTareas, ta.idTareaPersonal, ta.horas, c.descripcion FROM trabajador t, informetareas i, tareapersonal ta, catalogotareas c where (i.semana='2011-01-10') AND (t.dni=i.Trabajador_dni) AND (ta.CatalogoTareas_idTareaCatalogo=c.idTareaCatalogo) ORDER BY t.nombre
        $result = mysql_query('SELECT t.dni, t.nombre, t.apellidos, i.idInformeTareas, ta.idTareaPersonal, ta.horas, c.descripcion FROM trabajador t, informetareas i, tareapersonal ta, catalogotareas c where (i.semana=\'' . $semana . '\') AND (t.dni=i.Trabajador_dni) AND (ta.CatalogoTareas_idTareaCatalogo=c.idTareaCatalogo) AND (i.idInformeTareas=ta.InformeTareas_idInformeTareas) ORDER BY t.nombre;');

        $totTraProy = mysql_num_rows($result);
        if ($totTraProy > 0) {
            $trabajador = "";
            $dniAnterior = "";
            $arrayDnis[] = "";
            $cont = 1;
            $cont2 = 1;
            $sumaHoras = 0;
            $contD[] = 0;   //Array que almacena el numero de veces que aparece cada DNI
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $tabla[$cont2] = $rowEmp;
                if ($rowEmp['dni'] != $dniAnterior) {
                    array_push($contD, 1);
                    array_push($arrayDnis, $rowEmp['dni']);
                    $dniAnterior = $rowEmp['dni'];
                } else {
                    $contD[count($contD) - 1]++;
                }
                $cont2++;
            }
            for ($i = 1; $i < count($contD); $i++) {
                $sumaHoras = 0;
                $trabajador = $trabajador . "<a href='#' onclick=\"ocultarR('oculto" . $i . "')\">"
                        . "<img src= '../images/iJefeProyecto.gif' alt='#' border='0' style='width: auto; height: 12px;'/>"
                        . "&nbsp;&nbsp;" . utf8_encode($tabla[$cont]['nombre']) . " " . utf8_encode($tabla[$cont]['apellidos']) . "&nbsp;&nbsp;&nbsp;&nbsp;" . $tabla[$cont]['dni'] . "</a>"
                        . "<br/><div id=\"oculto" . $i . "\" style=\"display:none\">";
                if (vacacionesSiNo($tabla[$cont]['dni'], $semana)) {
                    $trabajador = $trabajador . "<table class=\"tablaVariable\"><tr><td><label>Esta de vacaciones</label></td></a></tr></table>";
                }
                for ($j = $contD[$i]; $j >= 1; $j--) {
                    $trabajador = $trabajador . "<a href='#'><table class=\"tablaVariable\"><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/iTarea.png' alt='Actividad' border='0' style='width: auto; height: 12px;'>"
                            . "</img>&nbsp;&nbsp;&nbsp;&nbsp;<label>" . utf8_encode($tabla[$cont]['descripcion']) . " </label></td><td><label>" . $tabla[$cont]['horas'] . " horas</label></td></a></tr></table>";
                    $cont++;
                    $sumaHoras = $sumaHoras + $tabla[$cont - 1]['horas'];
                }
                $trabajador = $trabajador . "<label>Horas totales: " . $sumaHoras . "</label><br/><br/></div>";
            }
        }

        //aqui calculo los trabajadores sin informacion de horas trabajadas
        $sql = "select dni, nombre, apellidos from trabajador where";
        if (count($arrayDnis) > 1) { //si el array de dni encontrados tiene contenido
            $sql = $sql . " (dni != '" . $arrayDnis[1] . "')"; //excluyo de la consulta el primer dni
            for ($i = 1; $i < count($arrayDnis); $i++) {    //repito para cada dni
                $sql = $sql . " and (dni != '" . $arrayDnis[$i] . "')"; //para excluir de la consulta los dni ya encontrados
            }
            $sql = $sql . ";"; //cierro la consulta sql
        }
        $result = mysql_query($sql);
        $restoTrabaj = "";
        while ($rowEmp = mysql_fetch_assoc($result)) {
            $restoTrabaj = $restoTrabaj . "<a href='#'>"
                    . "<img src= '../images/iJefeProyecto.gif' alt='#' border='0' style='width: auto; height: 12px;'/>"
                    . "&nbsp;&nbsp;" . utf8_encode($rowEmp['nombre']) . " " . utf8_encode($rowEmp['apellidos']) . "&nbsp;&nbsp;&nbsp;&nbsp;" . $rowEmp['dni'] . "</a>";
            if (vacacionesSiNo($rowEmp['dni'], $semana)) {
                //$restoTrabaj = $restoTrabaj . "<label style=\"color: red\"> Actualmente de vacaciones</label>";
                $restoTrabaj = $restoTrabaj . "<a href='#'>&nbsp;&nbsp;<img src= '../images/vacaciones.jpg' alt='#' border='0' style='width: auto; height: 12px;'/></a>";
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

        <div id="blogtitle">
            <div id="small">Responsable de Personal</div>
            <div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
        </div>
        <div id="page">
            <div id="topmenu">


                <ul class="BLUE">
                    <li><a href="iniResponsablePersonal.php" title="Crear trabajadores"><span>Ultima semana</span></a></li>
                    <li><a href="informesResponsablePersonal.php" title="Obtener informes"><span>Elegir intervalo</span></a></li>
                </ul>
            </div>

            <!-- end top menu and blog title-->

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
                <p>
                <table>
                    <tr>
                        <td>
                            <div id="formulario">
                                <form action="" method="POST" name="obtenerInformes">
                                    <div class="tituloFormulario">
                                        <h2>Informes de los proyectos</h2>
                                    </div>
                                    <div class="infoFormulario">
		A trav&eacute;s de esta pantalla el Responsable de Personal podr&aacute; obtener todo tipo de informes.
                                    </div>
                                    <div id="listaTrabajadores" class="centercontentleft">
                                        <?php
                                        echo $trabajador;
                                        ?>
                                        <br/>

                                        <label>Trabajadores sin informacion esta semana: </label>
                                        <br/><br/>
                                        <?php
                                        echo $restoTrabaj;
                                        ?>
                                    </div>


                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <a href='#'>&nbsp;&nbsp;<img src= '../images/vacaciones.jpg' alt='#' border='0' style='width: auto; height: 12px;'/></a>
                            <label>Este trabajador est&aacute; de vacaciones en este momento</label>
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

