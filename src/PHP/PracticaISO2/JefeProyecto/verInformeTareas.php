<?php session_start();

    $_SESSION['proyectoEscogido'] = $_GET['idP'];
    $_SESSION['informeActual'] = $_GET['idInf'];

    include_once('../Persistencia/conexion.php');
    $conexion = new conexion();

    // Obtenemos el InformeTareas
    $result = mysql_query("SELECT Actividad_idActividad, Trabajador_dni, semana, estado FROM InformeTareas WHERE\n"
            . "idInformeTareas = ".$_SESSION['informeActual']); 
    $totEmp = mysql_num_rows($result);

    $estadoInf = "";
    $cancelado=0;
    $pendiente=0;

    if ($totEmp ==1) {
        while ($rowEmp = mysql_fetch_assoc($result)) {

            $actActual = $rowEmp['Actividad_idActividad'];
            $trabActual = $rowEmp['Trabajador_dni'];
            $semana = $rowEmp['semana'];

            if($rowEmp['estado']=="Pendiente"){
                $estadoInf= "<p style='color:red'> El estado actual del informe es: <b>Pendiente de revisi&oacute;n</b></p>";
                $pendiente=1;
            }else if($rowEmp['estado']=="Aceptado"){
                $estadoInf= "<p style='color:red'> El estado actual del informe es: <b>Aceptado</b></p>";
            }else{
                $estadoInf= "<p style='color:red'> El estado actual del informe es: <b>Cancelado</b><br/>";
                $cancelado= 1;
            }
        }
    }
    
    // Sacamos nombre de la actividad y proyecto
    $result2 = mysql_query("SELECT p.nombre as nombreP, p.descripcion as descP, a.nombre as nombreA FROM Proyecto p, Actividad a, Iteracion i, Fase f WHERE\n"
    . "a.idActividad = ".$actActual. " AND\n"
    . "a.Iteracion_idIteracion = i.idIteracion AND\n"
    . "i.Fase_idFase = f.idFase AND\n"
    . "f.Proyecto_idProyecto = p.idProyecto");
    $totEmp2 = mysql_num_rows($result2);

    if ($totEmp2 > 0) {
        while ($rowEmp2 = mysql_fetch_assoc($result2)) {
            $nombreP = $rowEmp2['nombreP'];
            $descripcionP = $rowEmp2['descP'];
            $nombreA = $rowEmp2['nombreA'];
        }
    }

    // Sacamos los datos de cada tarea personal
    $result3 = mysql_query("SELECT t.horas as Horas, c.descripcion as descripcion FROM TareaPersonal t, CatalogoTareas c WHERE \n"
    . "t.InformeTareas_idInformeTareas=".$_SESSION['informeActual']." \n"
    . "AND t.CatalogoTareas_idTareaCatalogo = c.idTareaCatalogo \n"
    . "ORDER BY c.descripcion");

    $totEmp3 = mysql_num_rows($result3);
    $nTareas = $totEmp3;
    $_SESSION['nTareas'] = $nTareas;

    if ($totEmp3 >0) {
        $Tareas =  "<p>N&uacute;mero de horas dedicadas a cada tarea:</p><TABLE cellspacing='12' cellpadding='0'>";
        $i = 0;
        while ($rowEmp3 = mysql_fetch_assoc($result3)) {
            $Tareas = $Tareas ."<TR>"
            ."<TD><img src= '../images/iTarea2.png' alt='#' border='0' style='width: auto; height: 12px;'/>&nbsp;".$rowEmp3['descripcion']."</TD>"
            ."<TD><input type='text' disabled='disabled' id='tarea".$i."' value='".$rowEmp3['Horas']."' size='2' maxlength='2'> </TD>"
            ."<TD><small>horas</small></TD>"
            ."</TR>";
            $i++;
        }
        $Tareas = $Tareas ."</TABLE>";
    }

    // Sacamos el porcentaje de participacion del proyecto
    $result4 = mysql_query("SELECT porcentaje FROM TrabajadorProyecto WHERE "
            ."Proyecto_idProyecto=".$_SESSION['proyectoEscogido']." AND "
            ."Trabajador_dni='".$trabActual."'");
    $totEmp4 = mysql_num_rows($result4);

    if ($totEmp4 ==1) {
        while ($rowEmp4 = mysql_fetch_assoc($result4)) {
            $porcentajeP = $rowEmp4['porcentaje'];
        }
    }
    // Suma total de horas
    $maxHoras = round(40 * $porcentajeP / 100);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "Http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>

        <title>SIGESTPROSO</title>

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

        <script type="text/javascript">

            // Evalúa un informe como aceptado (x=0) o como denegado (x=1)
            function evaluarInforme(x){
                if (window.XMLHttpRequest) {
                        xmlhttp=new XMLHttpRequest();
                    } else {
                        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange=function() {
                        if(xmlhttp.readyState==1){
                            //2- Sucede cuando se esta cargando la pagina
                            document.getElementById("enviando").innerHTML = "<p><center>Evaluando informe...<center><img src='../images/enviando.gif' alt='Evaluando' width='150px'/></p>";
                        } else if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                            //3- AQUI VA LA RESPUESTA, DESPUES DE Q EL SERVIDOR HAGA LO Q SEA
                            //alert(xmlhttp.responseText);  ES LA VARIABLE A LA Q VAN LOS ECHOS DE LA SERVIDOR ASOCIADA
                            location.href = "verInformeTareas.php?idP=" + "<?php echo $_SESSION['proyectoEscogido']?>" + "&idInf=" + "<?php echo $_SESSION['informeActual']?>";
                        }
                    }

                    //1- LO Q LE MANDAS AL SERVIDOR
                    xmlhttp.open("GET","evaluarInforme.php?idInf=" + "<?php echo $_SESSION['informeActual']?>" + "&e=" + x,true);
                    xmlhttp.send();
            }

            function volver(){
                location.href = "revisarInformesAct.php?idP=" + "<?php echo $_SESSION['proyectoEscogido']?>";
            }
        
        </script>

    </head>

    <body>
        <div id="blogtitle">
            <div id="small">Revisi&oacute;n de informes de actividades</div>
            <div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
        </div>
        <!-- end top menu and blog title-->

        <!-- ABRIMOS BLOQUE CENTRAL-->
        <div id="page">
            <div id="leftcontent">
                <img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />

                <h3 align="left">Men&uacute;</h3>

                <div align="left">
                        <ul class="BLUE">
                                <li><a href="selecProyecto.php">Seleccionar proyecto</a></li>
                                <li><a href="selecVacaciones.php">Escoger vacaciones</a></li>
                        </ul>
                </div>

                <p><img src= "../images/Logo2.jpg" alt="#" border="0" style="width: 180px; height: auto;"/></p>

                <!-- You have to modify the "padding-top: when you change the content of this div to keep the footer image looking aligned -->

                <img style="padding-top:2px; margin-left:-12px; margin-bottom:-4px;" src="../images/specs_bottom.jpg" alt="" />

            </div>

            <!-- end left box-->

            <!-- start content -->
            <div id="centercontent">

                <h1>SIGESTPROSO</h1>
                <br/><br/><br/>
                <div id="selProyecto">
                    <h2 style="text-align: center">Revisar informe de actividad</h2>
                    <div class="centercontentleft" style="width:auto;">

                        <div id="DTareas">

                            <?php
                                echo "<p style='color:black'>Informe de tareas correspondiente a la semana <b>".$semana."&nbsp;"."</b></p>";
                                if($estadoInf!= ""){
                                    echo $estadoInf;
                                }
                                if($estadoInf== "" || $cancelado==1 || $pendiente==1){
                                    echo "<p>Su m&aacute;ximo de horas esta semana para esta actividad es de <b>". $maxHoras." horas</b> </p>" ;
                                }
                                echo utf8_decode($Tareas);
                            ?>
                            
                            <?php if($estadoInf== "" || $cancelado==1 || $pendiente==1){?>
                                <span id="enviando" >
                                    <center>
                                        <input type="button" value="Aceptar" name="Aceptar" onclick="evaluarInforme(0)"/>
                                        &nbsp;&nbsp;
                                        <input type="button" value="Denegar" name="Denegar" onclick="evaluarInforme(1)"/>
                                        &nbsp;&nbsp;
                                        <input type="button" value="Volver" name="Volver" onclick="volver()"/>
                                    </center>
                                </span>
                            <?php } else { ?>
                                <center>
                                    <input type="button" value="Volver" name="Volver" onclick="volver()"/>
                                </center>
                            <?php } ?>
                            <br/>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--FIN del bloque central-->


        <div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>
        </div>
    
    
    </body>
    
    <?php $conexion->cerrarConexion(); ?>

</html>