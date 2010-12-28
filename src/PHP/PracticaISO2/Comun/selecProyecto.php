<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

    <title>Selecci&oacute;n de proyecto</title>

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


<?php 
        //BORRAR
        $dniLogueado = $_SESSION['dni'];
        include_once('../Persistencia/conexion.php');
        $conexion = new conexion();
        $result = mysql_query("SELECT nombre, descripcion, jefeProyecto, idProyecto FROM Proyecto WHERE\n"
    . "jefeProyecto = \"".$dniLogueado."\" or idProyecto in \n"
    . "(SELECT Proyecto_idProyecto FROM TrabajadorProyecto WHERE \n"
    . "Trabajador_dni = \"".$dniLogueado."\")");
        $totEmp = mysql_num_rows($result);

        if ($totEmp >0) {
            $desarrProy = "";
            $jefeProy = "";
            $cont = 0;
            while ($rowEmp = mysql_fetch_assoc($result)) {
                if($rowEmp['jefeProyecto'] == $dniLogueado){
                    $jefeProy = "<a href='../JefeProyecto/iniJefeProyecto.php?idP=".$rowEmp['idProyecto']
                    ."'><img src= '../images/iJefeProyecto.gif' alt='#' border='0' "
                    . "style='width: auto; height: auto;'/>&nbsp;&nbsp;".$rowEmp['nombre']."</a> - "
                    . $rowEmp['descripcion']."<br/>";
                }else{
                    $cont = $cont+1;
                    $desarrProy = $desarrProy ."&nbsp;&nbsp;<a href=\"#\" onclick=\"ocultarR('oculto".$cont."')\"><img src= '../images/iProyecto.png' alt='#' border='0'"
                    . "style='width: auto; height: 12px;'/>&nbsp;&nbsp;".$rowEmp['nombre']."</a> - ".$rowEmp['descripcion']."<br/>"
                    . "<div id=\"oculto". $cont. "\" style=\"display:none\">";

                    $sql = "SELECT nombre, idActividad FROM actividad WHERE\n"
                    . "fechaFin is NULL\n"
                    . "AND\n"
                    . "idActividad in \n"
                    . "(SELECT Actividad_idActividad FROM TrabajadorActividad WHERE\n"
                    . "Trabajador_dni = \""
                    . $dniLogueado
                    . "\")\n"
                    . "AND\n"
                    . "(Iteracion_IdIteracion in\n"
                    . "(SELECT idIteracion FROM Iteracion WHERE\n"
                    . "Fase_idFase in \n"
                    . "(SELECT idFase FROM Fase WHERE\n"
                    . "Proyecto_idProyecto = "
                    . $rowEmp['idProyecto']
                    .")))";
                    $result2 = mysql_query($sql);
                    $totEmp2 = mysql_num_rows($result2);
                     if ($totEmp2 >0) {
                    while ($rowEmp2 = mysql_fetch_assoc($result2)) {
                       $desarrProy = $desarrProy
                        . "&nbsp;&nbsp;<a href='#'>&nbsp;&nbsp;&nbsp;&nbsp;<img src= '../images/iActividad4.gif' alt='Actividad' border='0'"
                        . "style='width: auto; height: 12px;'/>"
                        . "&nbsp;".$rowEmp2['nombre']
                        . "</a><br/>";

                    }
                     }
                     $desarrProy = $desarrProy . "</div>";
                }
            }
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

<!-- start top menu and blog title-->

<div id="blogtitle">
		<div id="small">Proyecto</div>
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

<!-- start left box-->

<div id="leftcontent">
	<img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />

	<h3 align="left">Men&uacute;</h3>


	<div align="left">
		<ul class="BLUE">
			<li><a href="selecProyecto.php">Selecionar proyecto</a></li>
			<li><a href="selecVacaciones.php">Escoger vacaciones</a></li>
		</ul>
	</div>

<!--	<h3 align="left">Sub menu</h3>
	<div align="left">
		<ul class="BLUE">
			<li><a href="#">Sample Link</a></li>
			<li><a href="#">Sample Link</a></li>
		</ul>
        </div>-->
        <p><img src= "../images/Logo2.jpg" alt="#" border="0" style="width: 180px; height: auto;"/></p>


	<!-- You have to modify the "padding-top: when you change the content of this div to keep the footer image looking aligned -->

	<img style="padding-top:2px; margin-left:-12px; margin-bottom:-4px;" src="../images/specs_bottom.jpg" alt="" />



</div>

<!-- end left box-->

<!-- start content -->

<div id="centercontent">


	<h1>SIGESTPROSO</h1>
	<p><a href="#"><img src= "../images/logo.jpg" alt="#" border="0" style="width: auto; height: 65px;"/></a><br/></p>
        <div id="selProyecto">
        <h2 style="text-align: center">Seleccione el proyecto sobre el que desea trabajar</h2>
        <div class="centercontentleft" style="width:500px;">
            <?php
            if($jefeProy == ""){}else{
            echo "<span>Como Jefe de Proyecto:<br/>" .$jefeProy . "</span><br/>";
            }
            if($desarrProy == ""){}else{
            echo "<span>Como Desarrollador:<br/>" .$desarrProy . "</span>";
            }
            ?>
         
            
        </div>
       

        </div>

</div>


<div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>


</div>

</body>
</html>
