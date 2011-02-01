<?php session_start();

    $_SESSION['Actividad'] = $_GET['idAct'];
    $_SESSION['proyectoEscogido'] = $_GET['idP'];

    include_once('../Persistencia/conexion.php');
    $conexion = new conexion();

    $result = mysql_query("SELECT * FROM Artefacto WHERE\n"
            . "Actividad_idActividad = \"".$_SESSION['Actividad']."\"");
    $totEmp = mysql_num_rows($result);

    if ($totEmp == 1) { // existe ya un artefacto
                while ($rowEmp = mysql_fetch_assoc($result)) {
                $nomArtefacto = $rowEmp['nombre'];
                $desArtefacto = $rowEmp['url'];
                $commArtefacto = $rowEmp['comentarios'];
                }
            }

    $result2 = mysql_query("SELECT nombre, descripcion FROM Proyecto"
            ." WHERE idProyecto=".$_SESSION['proyectoEscogido']);
    $totEmp2 = mysql_num_rows($result2);

    if ($totEmp2 == 1){
        while ($rowEmp2 = mysql_fetch_assoc($result2)){
            $nombreP = $rowEmp2['nombre'];
            $descripcionP = $rowEmp2['descripcion'];
        }
    }

    $result3 = mysql_query("SELECT nombre FROM Actividad"
            ." WHERE idActividad=".$_SESSION['Actividad']);
    $totEmp3 = mysql_num_rows($result3);

    if ($totEmp3 == 1){
        while ($rowEmp3 = mysql_fetch_assoc($result3)){
            $nombreA = $rowEmp3['nombre'];
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

        <script type="text/javascript">
            
            function volver(){
                location.href = "revisarInformesAct.php?idP=" + "<?php echo $_SESSION['proyectoEscogido']?>";
            }
            
        </script>

    </head>
    <body>
        <div id="blogtitle">
            <div id="small">Jefe de proyecto (<u><?php echo $_SESSION['login'] ?></u>) - Revisi&oacute;n de artefactos</div>
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

<!-- end left box-->

<!-- start content -->

<div id="centercontent">


	<h1>SIGESTPROSO</h1>
	<br/><br/><br/>

        <p><a href="#"><?php echo utf8_decode($nombreP) ?></a> - <?php echo utf8_decode($descripcionP) ?></p>


        <div id="selProyecto">
        <h2 style="text-align: center; width: 620px">Actividad&nbsp;<i style="color:blue"><?php echo utf8_decode($nombreA) ?></i></h2>
        <div class="centercontentleft" style="width:auto;">

        <div id="DArtefacto">
                <p><b>Artefacto</b></p>
                <table style="padding-left:10px;">
                    <tr>
                    <td>Nombre:</td>
                    <td><input type="text" disabled="disabled" id="nomArt" value="<?php echo utf8_decode($nomArtefacto) ?>" size="75" /></td>
                    </tr>
                    <tr>
                    <td>URL:</td>
                    <td><input type="text" disabled="disabled" id="urlArt" size="75" value="<?php echo utf8_decode($desArtefacto) ?>" /></td>
                    </tr>
                </table>

                <p>Comentarios: <br> <textarea cols="70" disabled="disabled" id="commArt" rows="8"><?php echo utf8_decode($commArtefacto) ?></textarea></p>
                <span id="editando" >
            <center><input type="button" value="Volver" name="Volver" onclick="volver()"/></center>
            </span>
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