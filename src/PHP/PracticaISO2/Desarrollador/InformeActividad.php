<?php
session_start();
//$login = $_SESSION['tipoUsuario'];
//if ($login != "T") {
//    header("location: ../index.php");
//}
$dniLogueado = '46547668R';   //Hay que cambiar estas variables
$proyecto = 2;                //por variables de sesion
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

        <?php
        include_once ('../Persistencia/conexion.php');
        $conexion = new conexion();
///////////////////////// Consulta para obtener las horas por semana y actividad////////////
//select i.semana, sum(tp.horas), a.nombre actividad
//from informetareas i, tareapersonal tp, actividad a, iteracion it, fase f, proyecto p
//where (i.Trabajador_dni='46547668R')
//    AND (i.idInformeTareas=tp.InformeTareas_idInformeTareas)
//    AND (i.Actividad_idActividad=a.idActividad)
//    AND (a.Iteracion_idIteracion=it.idIteracion)
//    AND (it.Fase_idFase=f.idFase)
//    AND (f.Proyecto_idProyecto=p.idProyecto)
//    AND (p.idProyecto=2)
//GROUP BY i.semana, a.nombre
////////////////////////////////////////////////////////////////////////////////////////////

        $sql = "select i.semana, sum(tp.horas) horas, a.nombre actividad
                from informetareas i, tareapersonal tp, actividad a, iteracion it, fase f, proyecto p
                where (i.Trabajador_dni='46547668R')
                    AND (i.idInformeTareas=tp.InformeTareas_idInformeTareas)
                    AND (i.Actividad_idActividad=a.idActividad)
                    AND (a.Iteracion_idIteracion=it.idIteracion)
                    AND (it.Fase_idFase=f.idFase)
                    AND (f.Proyecto_idProyecto=p.idProyecto)
                    AND (p.idProyecto=2)
                GROUP BY i.semana, a.nombre
                ORDER BY i.semana, a.nombre;";
        $result = mysql_query($sql);
        $totRes = mysql_num_rows($result);
        $informe = "";
        if ($totRes > 0) {
            $informe = "<div class='centercontentleft'><table>";
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $informe = $informe . "<tr><td>Semana " . $rowEmp['semana'] . "</td><td> Actividad " . $rowEmp['actividad'] . "</td><td> Horas " . $rowEmp['horas'] . "</td></tr>";
            }
            $informe = $informe . "</table></div>";
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
            function conmutar(x){

                if (x=="listaTrabajadores"){
                    document.getElementById(x).style.display="inline";
                    document.getElementById("listaTrabajadoresIntervalo").style.display="none";
                }
                if (x=="listaTrabajadoresIntervalo"){
                    document.getElementById(x).style.display="inline";
                    document.getElementById("listaTrabajadores").style.display="none";
                }
            }

            function recarga(){

                //alert(document.getElementById("trabajador").value);
                // formar fecha
                var fechaI;var fechaF; //coger los datos del formulario y hacer el string para cada fecha
                fechaI=document.obtenerInformes.anioi.value+"-"+document.obtenerInformes.mesi.value+"-"+document.obtenerInformes.diasi.value

                fechaF=document.obtenerInformes.aniof.value+"-"+document.obtenerInformes.mesf.value+"-"+document.obtenerInformes.diasf.value
                //
                //                //......

                



                if (window.XMLHttpRequest){
                    xmlhttp=new XMLHttpRequest();
                }
                else{
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function(){
                    if(xmlhttp.readyState==1){
                        //Sucede cuando se esta cargando la pagina
                        //
                        //mete la imagen de cargando
                        //            document.getElementById("enviando").innerHTML = "<p><center>Enviando<center><img src='../images/enviando.gif' alt='Enviando' width='150px'/></p>";//<-- Aca puede ir una precarga
                    }else if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    {
                        //alert(xmlhttp.responseText);
                        document.getElementById("listaRegargable").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET","informesPersIntervalo.php?dni=" + document.getElementById("trabajador").value
                    + "&fechaI=" + fechaI
                    + "&fechaF=" + fechaF,true);
                xmlhttp.send();
            }
        </script>

        <link rel="stylesheet" type="text/css" href="../stylesheet.css" media="screen, projection, tv " />

    </head>

    <body>
        <!--        <form name="formulario" action="" enctype="text/plain">-->
        <div id="blogtitle">
            <div id="small">Desarrollador (<u><?php echo $_SESSION['login'] ?></u>) - Informes de actividad</div>
            <div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
        </div>
        <div id="page">
            <!--            <div id="topmenu">


                            <ul class="BLUE">
                                <li><a href="#" onclick="" title="Informes relacionados con Desarrolladores"><span>Desarrolladores</span></a></li>
                                <li><a href="#" onclick="" title="Informes relacionados con las actividades del proyecto"><span>Actividades</span></a></li>
                            </ul>
                        </div>-->

            <!-- end top menu and blog title-->

            <div id="leftcontent">
                <img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />

                <h3 align="left">Men&uacute;</h3>


                <div align="left">
                    <ul class="BLUE">
                        <!--                        <li><a href="planIteracion.php">Planificar iteraci&oacute;n</a></li>
                                                <li><a href="../Comun/selecVacaciones.php">Escoger vacaciones</a></li>-->
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
                        <div class="tituloFormulario">
                            <h2>Informes de actividad</h2>
                        </div>
                        <div class="infoFormulario">
		En esta pantalla podr&aacute; cosultar datos de actividad del proyecto actual
                        </div>
                        <br/>
                        <div id="listaTrabajadoresIntervalo" style="display: inline">

                            <table>
                                <tr>
                                    <td>
                                        <label>Desde el d&iacute;a:</label>
                                    </td>
                                    <td>
                                        <div>
                                            <?php
                                            echo '<select id="diasi" name="diasi" size="1">';
                                            echo '<option value="0">D&iacute;a</option>';
                                            for ($i = 1; $i <= 31; $i++) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                            echo '</select>';
                                            ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <select name="mesi" size="1">
                                                <option value="0">Mes</option>
                                                <option value="1">Enero</option>
                                                <option value="2">Febrero</option>
                                                <option value="3">Marzo</option>
                                                <option value="4">Abril</option>
                                                <option value="5">Mayo</option>
                                                <option value="6">Junio</option>
                                                <option value="7">Julio</option>
                                                <option value="8">Agosto</option>
                                                <option value="9">Septiembre</option>
                                                <option value="10">Octubre</option>
                                                <option value="11">Noviembre</option>
                                                <option value="12">Diciembre</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td
                                        <div>
                                                <?php
                                                echo '<select name="anioi" size="1">';
                                                echo '<option value="0">A&ntilde;o</option>';
                                                $fecha = getdate();
                                                $anio = $fecha[year];
                                                for ($i = 2000; $i <= $anio; $i++) {
                                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                                }
                                                ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Hasta el d&iacute;a:</label>
                                    </td>
                                    <td>
                                        <div>
                                            <?php
                                                echo '<select name="diasf" size="1">';
                                                echo '<option value="0">D&iacute;a</option>';
                                                for ($i = 1; $i <= 31; $i++) {
                                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                                }
                                                echo '</select>';
                                            ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <select name="mesf" size="1">
                                                    <option value="0">Mes</option>
                                                    <option value="1">Enero</option>
                                                    <option value="2">Febrero</option>
                                                    <option value="3">Marzo</option>
                                                    <option value="4">Abril</option>
                                                    <option value="5">Mayo</option>
                                                    <option value="6">Junio</option>
                                                    <option value="7">Julio</option>
                                                    <option value="8">Agosto</option>
                                                    <option value="9">Septiembre</option>
                                                    <option value="10">Octubre</option>
                                                    <option value="11">Noviembre</option>
                                                    <option value="12">Diciembre</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td
                                            <div>
                                                <?php
                                                echo '<select name="aniof" size="1">';
                                                echo '<option value="0">A&ntilde;o</option>';
                                                $fecha = getdate();
                                                $anio = $fecha[year];
                                                for ($i = 2000; $i <= $anio; $i++) {
                                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                                }
                                                ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input name="ver_informe" value="Ver" type="button" class="submit" onclick="recarga()" />
                                    </td>
                                </tr>
                            </table>
                            <div id="listaRegargable">

                                <div>
                                    <?php
                                                echo $informe;
                                    ?>
                                </div>
                            </div>
                        </div>

                </div>
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