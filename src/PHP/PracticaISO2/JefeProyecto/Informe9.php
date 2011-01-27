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
        include_once ('../Persistencia/conexion.php');
        $conexion = new conexion();
//        $proyecto = 5; //esta variable tiene que se de sesion
        $proyecto=$_SESSION['proyectoEscogido'];
        $sql = "SELECT MAX(a.fechaInicioE) fechaMayor
                FROM Actividad a, TrabajadorActividad ta, Trabajador t, TrabajadorProyecto tp
                WHERE (ta.Actividad_idActividad=a.idActividad)
                    AND (t.dni=ta.Trabajador_dni)
                    AND (tp.Trabajador_dni=t.dni)
                    AND (tp.Proyecto_idProyecto=".$proyecto.");";
        $result = mysql_query($sql);
        $row = mysql_fetch_assoc($result);
        $fechaMayor = $row['fechaMayor'];
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
                
                if (document.obtenerInformes.diasf.value==0){
                    alert("Elija una fecha final correcta")
                    document.obtenerInformes.diasf.focus()
                    return 0;
                }
                if (document.obtenerInformes.mesf.value==0){
                    alert("Elija una fecha final correcta")
                    document.obtenerInformes.mesf.focus()
                    return 0;
                }
                if (document.obtenerInformes.aniof.value==0){
                    alert("Elija una fecha final correcta")
                    document.obtenerInformes.aniof.focus()
                    return 0;
                }

                document.getElementById("listarecargable").style.display="inline";
                //alert(document.getElementById("trabajador").value);
                // formar fecha
                
                var fechaF;
                fechaF=document.obtenerInformes.aniof.value+"-"+document.obtenerInformes.mesf.value+"-"+document.obtenerInformes.diasf.value

                //..........
                var FechaValF = new Date();
                FechaValF.setTime(Date.parse(fechaF));
                var FechaValH = new Date();
                FechaValH.setTime(Date.parse("<?php echo date("Y-m-d");?>"));
                //
                var FvalF = FechaValF.getTime();
                var HOY = FechaValH.getTime();

//                if (IniP > FvalI){
//                    alert("La fecha inicial no puede ser anterior a la fecha de inicio del proyecto");
//                    document.obtenerInformes.diasf.focus()
//                    return 0
//                }
                if (FvalF < HOY){
                    alert("La fecha escogida no puede ser anterior a la fecha actual");
                    document.obtenerInformes.diasf.focus()
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
                xmlhttp.open("GET","Informe9R.php?proyecto="+proyecto
                    + "&fechaF=" + fechaF, true);
                xmlhttp.send();
            }
        </script>

    </head>

    <body>
        <!--        <form name="formulario" action="" enctype="text/plain">-->
        <div id="blogtitle">
            <div id="small">Jefe de Proyecto - Informes - Reparto de actividades pendientes</div>
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
                        <table class="tablaVariable2">
                            <tr>
                                <td>
                                    <div class="tituloFormulario">
                                        <h2>Informes del proyecto</h2>
                                    </div>
                                    <div class="infoFormulario">
		Relación de personas, con las actividades asignadas y los tiempos de trabajo para cada una de ellas para un periodo de tiempo posterior a la fecha actual
                                    </div>
                                    <div>
                                        <br/>
                                        <table>                                            
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
                                                            for ($i = $anio; $i < $anio+10; $i++) {
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

                                                    <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;La fecha debe ser posterior a la fecha actual</p>
                                                    <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;Solo podra ver el reparto de trabajo hasta la fecha de inicio estimada
                                                        de la ultima actividad planificada <label style="color: red">(<?php echo $fechaMayor; ?>)</label></p>
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