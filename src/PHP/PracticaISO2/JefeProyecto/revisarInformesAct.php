<?php session_start();
    if($_GET['idP']==""){        
    }else{
        $_SESSION['proyectoEscogido'] = $_GET['idP'];
    }

    include_once('../Persistencia/conexion.php');
    $conexion = new conexion();

    $result12 = mysql_query("SELECT i.idIteracion as idIteracion, i.numero as numero"
            ." FROM Iteracion i, Fase f, Proyecto p"
            ." WHERE i.fechaInicio IS NOT NULL"
            ." AND i.fechaFin IS NULL"
            ." AND i.Fase_idFase=f.idFase"
            ." AND f.Proyecto_idProyecto=".$_SESSION['proyectoEscogido']);
    $totEmp12 = mysql_num_rows($result12);

    if ($totEmp12 > 0){
        while ($rowEmp12 = mysql_fetch_assoc($result12)) {
            $idIt = $rowEmp12['idIteracion'];
            $numIt = $rowEmp12['numero'];
        }

    }

    $result11 = mysql_query("SELECT p.nombre as nombre, p.descripcion as descripcion, f.nombre as nombreF"
            ." FROM Proyecto p, Fase f, Iteracion i"
            ." WHERE i.idIteracion=".$idIt
            ." AND f.idFase=i.Fase_idFase"
            ." AND f.Proyecto_idProyecto=p.idProyecto");
    $totEmp11 = mysql_num_rows($result11);


    if ($totEmp11 == 1){
        while ($rowEmp11 = mysql_fetch_assoc($result11)) {
            $nombreP = $rowEmp11['nombre'];
            $descripcionP = $rowEmp11['descripcion'];
            $nombreF = $rowEmp11['nombreF'];
        }

    }

         // Lista de actividades activas del proyecto actual
	 $result = mysql_query("SELECT a.nombre as nombre, a.idActividad as idActividad, a.duracionEstimada as duracionEstimada, i.idIteracion as idIteracion, i.numero as numIteracion, f.idFase as idFase"
                ." FROM Actividad a, Iteracion i, Fase f WHERE\n"
                . "a.fechaFin is NULL"
                . " AND a.fechaInicio is NOT NULL"
                . " AND a.Iteracion_IdIteracion=i.idIteracion"
                . " AND i.Fase_idFase=f.idFase"
                . " AND f.Proyecto_idProyecto=".$_SESSION['proyectoEscogido']);

         $totEmp = mysql_num_rows($result);
         
         if ($totEmp >0) {
             $cont=0;
             $cont2 = 0;
             $listado="";

             $numhoras = 0;         // número de horas en informes aceptados
             $artefacto = 0;    // existe artefacto para la actividad
             $mensajeterminar = '';

             while ($rowEmp = mysql_fetch_assoc($result)) {
                 $cont = $cont + 1;

                 $esfuerzoE = $rowEmp['duracionEstimada'];

                 $_SESSION['itActual'] = $rowEmp['idIteracion'];
                 $_SESSION['faseActual'] = $rowEmp['idFase'];
                 $_SESSION['numItActual'] = $rowEmp['numIteracion'];

                 // Meter cada actividad en el listado
                 $listado = $listado
                    ."&nbsp;&nbsp;<a href=\"#\" onclick=\"ocultarA('oculto".$cont."')\"><img src= '../images/iActividad4.gif' alt='Actividad' border='0'"
                    . "style='width: auto; height: 12px;'/>&nbsp;&nbsp;Actividad:&nbsp;&nbsp;".$rowEmp['nombre']."</a>"."<br/>"
                    . "<div id=\"oculto". $cont. "\" style=\"display:inline\">";

                 // Artefacto de cada actividad anterior
                 $result2 = mysql_query("SELECT nombre, url FROM Artefacto WHERE \n"
                         . "Actividad_idActividad = "
                         . $rowEmp['idActividad']);
                 $totEmp2 = mysql_num_rows($result2);

                 // Si ya hay artefacto se añade al listado y se pone artefacto a 1
                 if ($totEmp2 == 1) {
                     // $artefacto = 1;
                     while ($rowEmp2 = mysql_fetch_assoc($result2)) {
                         $url = $rowEmp2['url'];
                         if ($url == ''){
                             $artefacto = 0;
                         } else {
                             $artefacto = 1;
                             $listado = $listado
                            . "&nbsp;&nbsp;&nbsp;&nbsp;<a href='verArtefacto.php?idAct=".$rowEmp['idActividad']."&idP=".$_SESSION['proyectoEscogido']."'>&nbsp;&nbsp;&nbsp;&nbsp;<img src= '../images/recurso.gif' alt='Artefacto' border='0'"
                            . "style='width: auto; height: 12px;'/>"
                            . "&nbsp;&nbsp;&nbsp;Artefacto:&nbsp;&nbsp;".$rowEmp2['nombre']
                            . "</a>&nbsp;&nbsp;&nbsp;&nbsp;[Esfuerzo estimado: ".$esfuerzoE." horas hombre]<br/>";
                         }
                     }
                } else {
                    $artefacto = 0;
                }

                // Lista de trabajadores asignados a cada actividad anterior
                $result3 = mysql_query("SELECT nombre, apellidos, dni FROM Trabajador WHERE \n"
                     . "dni in \n"
                     . "(SELECT Trabajador_dni FROM TrabajadorActividad WHERE \n"
                     . "Actividad_idActividad = "
                     . $rowEmp['idActividad']
                     . ")");
                $totEmp3 = mysql_num_rows($result3);

                if ($totEmp3 > 0) {
                    
                    while ($rowEmp3 = mysql_fetch_assoc($result3)) {
                        $cont2 = $cont2 + 1;

                        // Se añade cada trabajador al listado
                        $listado = $listado
                        ."&nbsp;&nbsp;<a href=\"#\" onclick=\"ocultarT('ocultoT".$cont2."')\">&nbsp;&nbsp;&nbsp;&nbsp;<img src= '../images/iJefeProyecto.gif' alt='Desarrollador' border='0'"
                        . "style='width: auto; height: 12px;'/>&nbsp;&nbsp;".$rowEmp3['nombre']."&nbsp;".$rowEmp3['apellidos']."</a>"."<br/>"
                        . "<div id=\"ocultoT". $cont2. "\" style=\"display:inline\">";

                        $numInformes = 0;

                        // Lista de informes pendientes o cancelados de cada trabajador anterior
                        $result4 = mysql_query("SELECT semana, estado, idInformeTareas FROM InformeTareas WHERE"
                                ." (estado IN ('Pendiente', 'Cancelado')"
                                ." AND (Trabajador_dni='".$rowEmp3['dni']."')"
                                ." AND (Actividad_idActividad=".$rowEmp['idActividad']."))");

                        $totEmp4 = mysql_num_rows($result4);

                        if ($totEmp4 > 0) {
                            while ($rowEmp4 = mysql_fetch_assoc($result4)) {

                                $numInformes = $numInformes+1;

                                // Se añade cada informe al listado
                                $listado = $listado
                                . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='verInformeTareas.php?idP=".$_SESSION['proyectoEscogido']."&idInf=".$rowEmp4['idInformeTareas']."'>&nbsp;&nbsp;&nbsp;&nbsp;<img src= '../images/iTarea.png' alt='Informe de actividad' border='0'"
                                . "style='width: auto; height: 12px;'/>"
                                . "&nbsp;&nbsp;&nbsp;Semana:&nbsp;".$rowEmp4['semana']."</a>&nbsp;&nbsp;&nbsp;&nbsp;[".$rowEmp4['estado']
                                . "]<br/>";
                            }
                        }

                        if ($numInformes == 0) {
                            $listado = $listado
                            . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                            . "No tiene informes pendientes o cancelados en este momento<br/>";
                        }

                        $listado = $listado . "</div>";
                     
                    }
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

                $mensajeterminar = "<div class=\"centercontentleft\" style=\"width:480px; margin-left:25px; \">";

                if ($numhoras >= $rowEmp['duracionEstimada']){
                    $mensajeterminar = $mensajeterminar."El n&uacute;mero de horas trabajadas en informes aceptados es mayor "
                                       ."o igual a la estimaci&oacute;n de esfuerzo inicial. <br/>";
                    if ($artefacto == 1) {
                        $mensajeterminar = $mensajeterminar."El artefacto correspondiente ha sido depositado. <br/>"
                        . "<br/><center><input type='button' id='bTerminar' value='Terminar' name='Terminar' alt='Terminar la actividad' onclick='terminar("
                        . $rowEmp['idActividad'].")'/></center>";
                    } else {
                        $mensajeterminar = $mensajeterminar."El artefacto correspondiente no ha sido depositado a&uacute;n.";
                    }
                } else {
                    $mensajeterminar = $mensajeterminar."El n&uacute;mero de horas trabajadas en informes aceptados es menor "
                                       ."a la estimaci&oacute;n de esfuerzo inicial. <br/>";
                    if ($artefacto == 1) {
                        $mensajeterminar = $mensajeterminar."El artefacto correspondiente ha sido depositado.";
                    } else {
                        $mensajeterminar = $mensajeterminar."El artefacto correspondiente no ha sido depositado a&uacute;n.";
                    }
                }
                $mensajeterminar = $mensajeterminar . "</div>";
                $listado = $listado.$mensajeterminar;

                $listado = $listado."<br/><br/><br/><br/><br/></div>";

             }

             if ($cont == 0){
                 $listado = $listado."<br/>No existen actividades activas en este momento<br/>";
             }
        }

        // Verificación de si la siguiente iteración está planificada

        $planificado = 0;

        // Calculamos si la iteración actual es la última de esta fase
        $result7 = mysql_query("SELECT i.idIteracion as idIteracion, f.nombre as nombre FROM Iteracion i, Fase f WHERE"
                ." i.numero = (SELECT MAX(numero) as maximo FROM Iteracion WHERE Fase_idFase=" .$_SESSION['faseActual'].")"
                ." AND i.Fase_idFase=".$_SESSION['faseActual']
                ." AND f.idFase=i.Fase_idFase");
        $totEmp7 = mysql_num_rows($result7);
        
        if ($totEmp7 == 1) {
            while ($rowEmp7 = mysql_fetch_assoc($result7)) {
                $iteracionMax = $rowEmp7['idIteracion']; // número de la máxima iteración de la fase actual
                $nomFase = $rowEmp7['nombre'];
            }
        }

        // Comprobamos no estar en la ultima iteracion de la ultima fase
        if ($_SESSION['itActual'] == $iteracionMax && $nomFase == "Transicion") {
            $planificado = 1;
        } else {

            // Estamos en la última iteración de la fase actual
            if ($_SESSION['itActual'] == $iteracionMax) {

                if ($nomFase == "Inicio") {$nomFaseS = "Elaboracion";}
                else if ($nomFase == "Elaboracion"){$nomFaseS = "Construccion";}
                else if ($nomFase == "Construccion"){$nomFaseS = "Transicion";}

                $result8 = mysql_query("SELECT idFase FROM Fase"
                        ." WHERE nombre='".$nomFaseS
                        ."' AND Proyecto_idProyecto=".$_SESSION['proyectoEscogido']);
                $totEmp8 = mysql_num_rows($result8);

                if ($totEmp8 == 1){
                    while ($rowEmp8 = mysql_fetch_assoc($result8)){
                        $idFaseS = $rowEmp8['idFase'];
                    }
                }

                $result9 = mysql_query("SELECT idIteracion FROM Iteracion"
                        ." WHERE Fase_idFase=".$idFaseS
                        ." AND numero=1");
                $totEmp9 = mysql_num_rows($result9);

                if ($totEmp9 == 1){ // La fase siguiente está planificada
                    while ($rowEmp9 = mysql_fetch_assoc($result9)){
                        $idItS = $rowEmp9['idIteracion'];
                    }

                    // Comprobamos si la siguiente iteración está planificada
                    $result6 = mysql_query("SELECT nombre FROM Actividad WHERE"
                                    ." Iteracion_idIteracion=".$idItS);
                    $totEmp6 = mysql_num_rows($result6);

                    if ($totEmp6 > 0) {
                        $planificado = 1;
                    } else {
                        $planificado = 0;
                    }

                } else { // No está planificada ni siquiera la siguiente fase (no existen iteraciones para idFaseS)
                    $planificado = 0;
                }

            // No estamos en la última iteración de la fase actual
            } else {
                $numItS = $_SESSION['numItActual']+1;
                
                $result10 = mysql_query("SELECT idIteracion FROM Iteracion"
                        ." WHERE numero=".$numItS
                        ." AND Fase_idFase=".$_SESSION['faseActual']);
                $totEmp10 = mysql_num_rows($result10);

                if ($totEmp10 == 1){
                    while ($rowEmp10 = mysql_fetch_assoc($result10)){
                        $idItS = $rowEmp10['idIteracion'];
                    }
                }

                // Comprobamos si la siguiente iteración está planificada
                $result6 = mysql_query("SELECT nombre FROM Actividad WHERE"
                                ." Iteracion_idIteracion=".$idItS);
                $totEmp6 = mysql_num_rows($result6);
                if ($totEmp6 > 0) {
                    $planificado = 1;
                } else {
                    $planificado = 0;
                }
            }

            

        }


    ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "Http://www.w3.org/TR/html4/strict.dtd">

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

                // Termina la actividad con idActividad=x
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
                            if (xmlhttp.responseText == 0){
                                location.href = "revisarInformesAct.php?idP=" + "<?php echo $_SESSION['proyectoEscogido']?>";
                            } else if (xmlhttp.responseText == 1){
                                alert("No puede terminar esta actividad, pues es la ultima de la iteracion actual, hasta que no planifique la siguiente iteracion.");
                            } else if (xmlhttp.responseText == 2){
                                alert("No puede terminar una actividad con informes pendientes o cancelados, debe aceptarlos primero.");
                            }
                        }
                    }

                    //1- LO Q LE MANDAS AL SERVIDOR
                    xmlhttp.open("GET","terminarActividad.php?idAct=" + x + "&pl=" + "<?php echo $planificado?>",true);
                    xmlhttp.send();

                }
            </script>

    </head>
    <body>

        <!-- start top menu and blog title-->

<div id="blogtitle">
    <div id="small">Jefe de proyecto (<u><?php echo $_SESSION['login'] ?></u>) - Revisi&oacute;n de actividades activas</div>
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
                            <li><a href="../Comun/selecProyecto.php">Seleccionar proyecto</a></li>
                            <li><a href="#">Revisar actividades activas</a></li>
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

<!-- end left box-->

<!-- start content -->

<div id="centercontent">


	<h1>SIGESTPROSO</h1>
	<p><br/></p>

        <p><a href="#"><?php echo utf8_decode($nombreP) ?></a> - <?php echo utf8_decode($descripcionP) ?></p>

        <div id="selProyecto">
            <h2 style="text-align: center">Fase&nbsp;<i style="color:blue"><?php echo utf8_decode($nombreF) ?></i>
                &nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;Iteraci&oacute;n&nbsp;<i style="color:blue"><?php echo utf8_decode($numIt) ?></i></h2>
        <div class="centercontentleft" style="width:550px;">

            <?php
                echo utf8_decode("<span>" .$listado . "</span>");
            ?>
            <br/>

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