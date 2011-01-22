<?php session_start();

    $_SESSION['proyectoEscogido'] = $_GET['idP'];

    include_once('../Persistencia/conexion.php');
    $conexion = new conexion();

         // Lista de actividades activas del proyecto actual
	 $result = mysql_query("SELECT nombre, idActividad, duracionEstimada FROM Actividad WHERE\n"
                    . "fechaFin is NULL\n"
                    . "AND\n"
                    . "fechaInicio is NOT NULL\n"
                    . "AND\n"
  		    . "(Iteracion_IdIteracion in\n"
                    . "(SELECT idIteracion FROM Iteracion WHERE\n"
                    . "Fase_idFase in \n"
                    . "(SELECT idFase FROM Fase WHERE\n"
                    . "Proyecto_idProyecto = "
                    . $_SESSION['proyectoEscogido']
                    .")))");
         $totEmp = mysql_num_rows($result);
         
         if ($totEmp >0) {
             $cont=0;
             $listado="";

             $numhoras = 0;         // número de horas en informes aceptados
             $artefacto = False;    // existe artefacto para la actividad
             $mensajeterminar = '';

             while ($rowEmp = mysql_fetch_assoc($result)) {
                 $cont = $cont + 1;

                 // Meter cada actividad en el listado
                 $listado = $listado
                    ."&nbsp;&nbsp;<a href=\"#\" onclick=\"ocultarA('oculto".$cont."')\"><img src= '../images/iActividad4.gif' alt='Actividad' border='0'"
                    . "style='width: auto; height: 12px;'/>&nbsp;&nbsp;Actividad:&nbsp;&nbsp;".$rowEmp['nombre']."</a>"."<br/>"
                    . "<div id=\"oculto". $cont. "\" style=\"display:none\">";

                 // Artefacto de cada actividad anterior
                 $result2 = mysql_query("SELECT nombre FROM Artefacto WHERE \n"
                         . "Actividad_idActividad = "
                         . $rowEmp['idActividad']);
                 $totEmp2 = mysql_num_rows($result2);

                 // Si ya hay artefacto se añade al listado y se pone artefacto a true
                 if ($totEmp2 >0) {
                     $artefacto = True;
                     while ($rowEmp2 = mysql_fetch_assoc($result2)) {
                         $listado = $listado
                        . "&nbsp;&nbsp;&nbsp;&nbsp;<a href='verArtefacto.php?idAct=".$rowEmp['idActividad']."&idP=".$_SESSION['proyectoEscogido']."'>&nbsp;&nbsp;&nbsp;<img src= '../images/iActividad4.gif' alt='Artefacto' border='0'"
                        . "style='width: auto; height: 12px;'/>"
                        . "&nbsp;&nbsp;&nbsp;&nbsp;Artefacto:&nbsp;&nbsp;".$rowEmp2['nombre']
                        . "</a><br/>";
                     }
                }

                // Lista de trabajadores asignados a cada actividad anterior
                $result3 = mysql_query("SELECT nombre, dni FROM Trabajador WHERE \n"
                     . "dni in \n"
                     . "(SELECT Trabajador_dni FROM TrabajadorActividad WHERE \n"
                     . "Actividad_idActividad = "
                     . $rowEmp['idActividad']
                     . ")");
                $totEmp3 = mysql_num_rows($result3);

                $cont2 = 0;

                if ($totEmp3 > 0) {
                    while ($rowEmp3 = mysql_fetch_assoc($result3)) {
                        $cont2 = $cont2 + 1;

                        // Se añade cada trabajador al listado
                        $listado = $listado
                        ."&nbsp;&nbsp;<a href=\"#\" onclick=\"ocultarT('oculto2".$cont2."')\">&nbsp;&nbsp;&nbsp;&nbsp;<img src= '../images/iJefeProyecto.gif' alt='Desarrollador' border='0'"
                        . "style='width: auto; height: 12px;'/>&nbsp;&nbsp;".$rowEmp3['nombre']."&nbsp;&nbsp;".$rowEmp3['dni']."</a>"."<br/>"
                        . "<div id=\"oculto2". $cont2. "\" style=\"display:none\">";

                        // Lista de informes pendientes o cancelados de cada trabajador anterior
                        $result4 = mysql_query("SELECT semana, estado, idInformeTareas FROM InformeTareas WHERE \n"
                             . "(estado in ('Pendiente', 'Cancelado') and "
                             . "(Trabajador_dni = '".$rowEmp3['dni']."'))");

                        $totEmp4 = mysql_num_rows($result4);

                        if ($totEmp4 > 0) {
                            while ($rowEmp4 = mysql_fetch_assoc($result4)) {

                                // Se añade cada informe al listado
                                $listado = $listado
                                . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='verInformeTareas.php?idP=".$_SESSION['proyectoEscogido']."&idInf".$rowEmp4['idInformeTareas']."'>&nbsp;&nbsp;&nbsp;&nbsp;<img src= '../images/iTarea.png' alt='Informe de actividad' border='0'"
                                . "style='width: auto; height: 12px;'/>"
                                . "&nbsp;&nbsp;&nbsp;".$rowEmp4['semana']."&nbsp;&nbsp;&nbsp;&nbsp;[".$rowEmp4['estado']
                                . "]</a><br/>";
                            }
                        }                        
                        
                    }
                    $listado = $listado . "</div>";
                }

                // Cálculo de si es posible cerrar una actividad o no
                $result5 = mysql_query("SELECT horas FROM TareaPersonal WHERE \n"
                        . "InformeTareas_idInformeTareas in ("
                        . "SELECT idInformeTareas FROM InformeTareas WHERE \n"
                        . "estado = 'Aceptado' and Actividad_idActividad = "
                        . $rowEmp['idActividad'].")");
                $totEmp5 = mysql_num_rows($result5);

                if ($totEmp5 >0) {
                     while ($rowEmp5 = mysql_fetch_assoc($result5)) {
                         $aux = (int) $rowEmp5['horas'];
                         $numhoras = $numhoras + $aux;
                     }
                }

                $mensajeterminar = "<br/><div class=\"centercontentleft\" style=\"width:auto;\">";

                if ($numhoras >= $rowEmp['duracionEstimada']){
                    $mensajeterminar = $mensajeterminar."El n&uacute;mero de horas trabajadas es mayor "
                                       ."o igual a la estimaci&oacute;n de esfuerzo inicial <br/>";
                    if ($artefacto == True) {
                        // horas y artefacto ok
                        $mensajeterminar = $mensajeterminar."El artefacto correspondiente ha sido depositado <br/>"
                        . "<center><input type='button' id='bTerminar' value='Terminar' name='Terminar' alt='Terminar la actividad' onclick='terminar("
                        . $rowEmp['idActividad'].")'/></center>";
                    } else {
                        $mensajeterminar = $mensajeterminar."El artefacto correspondiente no ha sido depositado a&uacute;n";
                    }
                } else {
                    $mensajeterminar = $mensajeterminar."El n&uacute;mero de horas trabajadas es menor "
                                       ."a la estimaci&oacute;n de esfuerzo inicial <br/>";
                    if ($artefacto == True) {
                        $mensajeterminar = $mensajeterminar."El artefacto correspondiente ha sido depositado";
                    } else {
                        $mensajeterminar = $mensajeterminar."El artefacto correspondiente no ha sido depositado a&uacute;n";
                    }
                }
                $mensajeterminar = $mensajeterminar . "</div>";
                $listado = $listado.$mensajeterminar;

             }
             $listado = $listado."</div>";
         }

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

<!--CODIGO JAVASCRIPT-->

            <script type="text/javascript">
                // Oculta la información de cada actividad
                function ocultarA(x){
                       if(document.getElementById(x).style.display=="none"){
                           document.getElementById(x).style.display="inline";
                       }else{
                           document.getElementById(x).style.display="none"
                       }
                }

                // Oculta la información de cada trabajador
                function ocultarT(x){
                   if(document.getElementById(x).style.display=="none"){
                       document.getElementById(x).style.display="inline";
                   }else{
                       document.getElementById(x).style.display="none"
                   }
                }

                function terminar(x){

                    if (window.XMLHttpRequest) {
                        xmlhttp=new XMLHttpRequest();
                    } else {
                        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange=function() {
                        if(xmlhttp.readyState==1){
                            //2- Sucede cuando se esta cargando la pagina
                            document.getElementById("bTerminar").innerHTML = "<p><center>Terminando actividad...<center><img src='../images/enviando.gif' alt='Terminando' width='150px'/></p>";
                        } else if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                            //3- AQUI VA LA RESPUESTA, DESPUES DE Q EL SERVIDOR HAGA LO Q SEA
                            //alert(xmlhttp.responseText);  ES LA VARIABLE A LA Q VAN LOS ECHOS DE LA SERVIDOR ASOCIADA
                            location.href = "revisarInformesAct.php?idP=" + "<?php echo $_SESSION['proyectoEscogido']?>";
                        }
                    }

                    //1- LO Q LE MANDAS AL SERVIDOR
                    xmlhttp.open("GET","terminarActividad.php?idAct=" + x,true);
                    xmlhttp.send();

                }
            </script>

    </head>
    <body>

        <!-- start top menu and blog title-->

<div id="blogtitle">
    <div id="small">Revisi&oacute;n de informes de actividades</div>
		<div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
</div>
<!--
		<div id="topmenu">


		<ul class="BLUE">
		<li><a href="#" title="Downloads"><span>ISO II</span></a></li>
		<li><a href="#" title="Vacaciones"><span>Vacaciones</span></a></li>
		<li><a href="#" title="Links"><span>Santillana</span></a></li>
		</ul>
</div>-->

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
        <h2 style="text-align: center">Seleccione el proyecto sobre el que desea trabajar</h2>
        <div class="centercontentleft" style="width:auto;">

            <?php
//                echo utf8_decode("<span>" .$listado . "</span>");
                echo $listado;
            ?>
            <br/><br/>


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