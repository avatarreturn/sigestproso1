<?php session_start();

    include_once('../Persistencia/conexion.php');
    $conexion = new conexion();

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
        
    </script>

    </head>
    <body>
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
        <h2 style="text-align: center">Ver artefacto</h2>
        <div class="centercontentleft" style="width:auto;">
        
            <div id="DTareas">

            <?php
            echo "<p style='color:black'>Informe de tareas correspondiente a la semana <b>".$semana."</b></p>";
            if($estadoInf!= ""){
                    echo $estadoInf;
                    }
                    if($estadoInf== "" || $cancelado==1 || $pendiente==1){
                      echo "<p>Su m&aacute;ximo de horas esta semana para esta actividad es de <b>". $maxHoras." Horas</b> </p>" ;
                    }
                echo utf8_decode($Tareas);
                ?>
                <?php if($estadoInf== "" || $cancelado==1 || $pendiente==1){?>
            <span id="enviando" >
            <center><input type="button" value="Enviar" name="Enviar" onclick="enviar()"/></center>
            </span>
            <?php } ?>
                </div>


</div>
</div>
<!--FIN del bloque central-->


<div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>


</div>


    </body>
    <?php $conexion->cerrarConexion(); ?>
</html>
