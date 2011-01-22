<?php session_start();

// CODIGO PHP DE LAS COSAS Q SALEN DE LA BD PARA MOSTRAR POR PANTALLA

    //$_SESSION['ActividadEscogidaJ'] = $_GET['idActJ'];
    $_SESSION['proyectoEscogido'] = $_GET['idP'];

    include_once('../Persistencia/conexion.php');
    $conexion = new conexion();

    //CONSULTAS
            //$result2 = mysql_query("SELECT * FROM Artefacto WHERE\n"
            //. "Actividad_idActividad = \"".$_SESSION['ActividadEscogida']."\"");


         // Lista de actividades activas del proyecto actual
	 $result = mysql_query("SELECT nombre, idActividad FROM Actividad WHERE\n"
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

         // Artefacto de cada actividad anterior
         $result1 = mysql_query("SELECT nombre FROM Artefacto WHERE \n"
                 . "Actividad_idActividad = "
                 . $rowEmp['idActividad']);
         $totEmp1 = mysql_num_rows($result1);

         // Lista de trabajadores asignados a cada actividad anterior
         $result2 = mysql_query("SELECT nombre, dni FROM Trabajador WHERE \n"
                 . "dni in \n"
                 . "(SELECT Trabajador_dni FROM TrabajadorActividad WHERE \n"
                 . "Actividad_idActividad = "
                 . $rowEmp['idActividad']);
         $totEmp2 = mysql_num_rows($result2);

         // Lista de informes pendientes o cancelados de cada trabajador anterior
         $result3 = mysql_query("SELECT semana, estado FROM InformeTareas WHERE \n"
                 . "estado in ('Pendiente', 'Cancelado') and "
                 . "Trabajador_dni = "
                 . $rowEmp2['dni']);
         $totEmp3 = mysql_num_rows($result3);




 /*
    if ($totEmp2 ==1) { // existen ya un artefacto
                while ($rowEmp2 = mysql_fetch_assoc($result2)) {
                $nomArtefacto = $rowEmp2['nombre'];
                $desArtefacto = $rowEmp2['url'];
                $commArtefacto = $rowEmp2['comentarios'];
                }
            }else{ // aun no existe
                $nomArtefacto = "";
                $desArtefacto = "";
                $commArtefacto = "";
                $result= mysql_query("INSERT INTO Artefacto VALUES('"
                    . $_SESSION['ActividadEscogida']."','','','')");
            }
*/
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
    <div id="small">Selecci&oacute;n de proyecto</div>
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
        <h2 style="text-align: center">Revisi&oacute;n de informes de actividad</h2>
        <div class="centercontentleft" style="width:auto;">
            <?php
            if ($noProyectos==""){
            if($jefeProy == ""){}else{
            echo utf8_decode("<span>Como Jefe de Proyecto:<br/>" .$jefeProy . "</span><br/>");
            }
            if($desarrProy == ""){}else{
            echo utf8_decode("<span>Como Desarrollador:<br/>" .$desarrProy . "</span>");
            }
            }else{
                echo $noProyectos;
            }
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
