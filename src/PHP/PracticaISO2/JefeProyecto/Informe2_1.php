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
        include_once ('../Persistencia/conexion.php');
        $conexion = new conexion();
//        $proyecto=$_SESSION['proyectoEscogido'];
        $proyecto = $_GET['idP'];
        $sql = "select fechaInicio, fechaFin from Proyecto where idProyecto=" . $proyecto . ";";
        $result = mysql_query($sql);
        $row = mysql_fetch_assoc($result);
        $fechaInicioP = $row['fechaInicio'];
        $fechaFinP = $row['fechaFin'];
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
            function recarga(){

                if (document.obtenerInformes.diasi.value==0){
                    alert("Elija una fecha inicial correcta")
                    document.obtenerInformes.diasi.focus()
                    document.obtenerInformes.listarecargable.style.display=="none"
                    return 0;
                }
                if (document.obtenerInformes.mesi.value==0){
                    alert("Elija una fecha inicial correcta")
                    document.obtenerInformes.mesi.focus()
                    document.obtenerInformes.listarecargable.style.display=="none"
                    return 0;
                }
                if (document.obtenerInformes.anioi.value==0){
                    alert("Elija una fecha inicial correcta")
                    document.obtenerInformes.anioi.focus()
                    document.obtenerInformes.listarecargable.style.display=="none"
                    return 0;
                }
                if (document.obtenerInformes.diasf.value==0){
                    alert("Elija una fecha final correcta")
                    document.obtenerInformes.diasf.focus()
                    document.obtenerInformes.listarecargable.style.display=="none"
                    return 0;
                }
                if (document.obtenerInformes.mesf.value==0){
                    alert("Elija una fecha final correcta")
                    document.obtenerInformes.mesf.focus()
                    document.obtenerInformes.listarecargable.style.display=="none"
                    return 0;
                }
                if (document.obtenerInformes.aniof.value==0){
                    alert("Elija una fecha final correcta")
                    document.obtenerInformes.aniof.focus()
                    document.obtenerInformes.listarecargable.style.display=="none"
                    return 0;
                }

                document.getElementById("listarecargable").style.display="inline";
                //alert(document.getElementById("trabajador").value);
                // formar fecha
                var fechaI; //coger los datos del formulario y hacer el string para cada fecha
                fechaI=document.obtenerInformes.anioi.value+"-"+document.obtenerInformes.mesi.value+"-"+document.obtenerInformes.diasi.value
                var fechaF;
                fechaF=document.obtenerInformes.aniof.value+"-"+document.obtenerInformes.mesf.value+"-"+document.obtenerInformes.diasf.value

                //..........
                var FechaValI = new Date();
                FechaValI.setTime(Date.parse(fechaI));
                var FechaValF = new Date();
                FechaValF.setTime(Date.parse(fechaF));
                var FechaValP = new Date();
                FechaValP.setTime(Date.parse("<?php echo $fechaInicioP; ?>"))
                var FechaValH = new Date();
                FechaValH.setTime(Date.parse("<?php echo $fechaFinP; ?>"))
                //
                var FvalI = FechaValI.getTime();
                var FvalF = FechaValF.getTime();
                var IniP = FechaValP.getTime();
                var HOY = FechaValH.getTime();
                //
                //                alert(FechaValI+" "+FechaValF);
                //
                if (IniP > FvalI){
                    alert("La fecha inicial no puede ser anterior a la fecha de inicio del proyecto");
                    document.obtenerInformes.diasf.focus()
                    document.obtenerInformes.listarecargable.style.display=="none"
                    return 0
                }
                if (FvalF < FvalI){
                    alert("La fecha final no puede ser anterior a la fecha inicial");
                    document.obtenerInformes.diasf.focus()
                    document.obtenerInformes.listarecargable.style.display=="none"
                    return 0
                }
                if (FvalF > HOY){
                    alert("La fecha final no puede ser posterior a la de final del proyecto");
                    document.obtenerInformes.diasf.focus()
                    document.obtenerInformes.listarecargable.style.display=="none"
                    return 0
                }

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
                        document.getElementById("listarecargable").innerHTML = xmlhttp.responseText;
                    }
                }
                proyecto="<?php echo $proyecto; ?>";
                xmlhttp.open("GET","Informe2R.php?proyecto="+proyecto
                    + "&fechaI=" + fechaI
                    + "&fechaF=" + fechaF, true);
                xmlhttp.send();
            }
        </script>

    </head>

    <body>
        <!--        <form name="formulario" action="" enctype="text/plain">-->
        <div id="blogtitle">
            <div id="small">Jefe de Proyecto -(<?php echo $_SESSION['login'];?>)- Informes - Trabajadores y sus actividades</div>
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
		Relaci&oacute;n de trabajadores y sus actividades asignadas durante un periodo determinado.
                                    </div>
                                    <div>
                                        <br/>
                                        <table>
                                            <tr>
                                                <td>
                                                    <label>Desede el d&iacute;a:</label>
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
                                    </div>
                                    <table><tr><td>
                                                <div id="listarecargable" class="centercontentleft" style="display: none">

                                                </div>
                                            </td></tr>
                                        <tr><td>
                                                <div><h3>Condiciones:</h3>

                                                    <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;La fecha inicial debe ser posterior a la fecha de inicio del proyecto <label style="color: red">(<?php echo $fechaInicioP; ?>)</label>
                                                        y no posterior a la de fin del proyecto</p>

                                                    <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;La fecha final no debe ser posterior a la fecha de fin del proyecto <label style="color: red">(<?php echo $fechaFinP; ?>)</label></p>
                                                    <br/>
                                                </div>
                                            </td></tr></table>
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