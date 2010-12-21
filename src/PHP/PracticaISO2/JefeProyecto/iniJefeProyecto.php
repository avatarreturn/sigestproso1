<?php session_start();

        $_SESSION['proyectoEscogido'] = $_GET['idP'];
        include_once('../Persistencia/conexion.php');
        $conexion = new conexion();
        $result = mysql_query("SELECT nombre, descripcion, jefeProyecto FROM Proyecto WHERE\n"
         . "idProyecto = \"" .$_SESSION['proyectoEscogido']. "\"");

        $totEmp = mysql_num_rows($result);

        if ($totEmp ==1) {
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $nombreP = $rowEmp['nombre'];
                $descripcionP = $rowEmp['descripcion'];
            }
        }
        



?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>

<title><?php echo $nombreP ?></title>

<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />



<link rel="stylesheet" type="text/css" href="../stylesheet.css" media="screen, projection, tv " />

</head>

<body>

<!-- start top menu and blog title-->

<div id="blogtitle">
		<div id="small">Jefe de Proyecto</div>
		<div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
</div>

		<div id="topmenu">


		<ul class="BLUE">
		<li><a href="#" title="Downloads"><span>Downloads</span></a></li>
		<li><a href="#" title="Gallery"><span>Photo Gallery</span></a></li>
		<li><a href="#" title="Links"><span>Subscribe</span></a></li>
		<li><a href="#" title="Links"><span>Tech Blog</span></a></li>
		<li><a href="#" title="Links"><span>Contact</span></a></li>
		<li><a href="#" title="Links"><span>RSS Feeds</span></a></li>
		</ul>
</div>

<!-- end top menu and blog title-->

<!-- start left box-->

<div id="leftcontent">
	<img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />

	<h3 align="left">Main Menu</h3>


	<div align="left">
		<ul class="BLUE">
			<li><a href="#">Sample Link</a></li>
			<li><a href="#">Sample Link</a></li>
			<li><a href="#">Sample Link</a></li>
			<li><a href="#">Sample Link</a></li>
			<li><a href="#">Sample Link</a></li>
		</ul>
	</div>

	<p>Nullam non metus. Duis in metus vitae elit luctus convallis. Ut sagittis. Nam tempor. Nam vehicula adipiscing augue. Vestibulum pretium lacinia erat. Duis ut enim. In hendrerit vulputate lectus. Donec ipsum magna, tempor ornare, fringilla sit amet, placerat</p>

	</div>

	<!-- You have to modify the "padding-top: when you change the content of this div to keep the footer image looking aligned -->

	<img style="padding-top:2px; margin-left:-12px; margin-bottom:-4px;" src="../images/specs_bottom.jpg" alt="" />




<!-- end left box-->

<!-- start content -->

<div id="centercontent">


	<h1>SIGESTPROSO</h1>
<p><br /></p>

	<p><a href="#"><?php echo $nombreP ?></a> - <?php echo $descripcionP ?></p>
        <?php
        $result2 = mysql_query(
                "SELECT nombre, dni, apellidos FROM Trabajador WHERE\n"
                . "dni in\n"
                . "(SELECT Trabajador_dni FROM TrabajadorProyecto\n"
                . "GROUP BY Trabajador_dni\n"
                . "HAVING COUNT(*) <3\n"
                . "UNION\n"
                . "SELECT dni FROM Trabajador WHERE\n"
                . "dni not in\n"
                . "(SELECT Trabajador_dni FROM TrabajadorProyecto\n"
                . "GROUP BY Trabajador_dni))"
                . "and \n"
                . "dni not in \n"
                . "(SELECT Trabajador_dni FROM TrabajadorProyecto WHERE\n"
                . "Proyecto_idProyecto = \"".$_SESSION['proyectoEscogido']."\")\n"
                . "and dni <> \"".$_SESSION['dni']."\""
                );

        $totEmp2 = mysql_num_rows($result2);

        if ($totEmp2 >0) {
            $personal = "<select>";
            while ($rowEmp2 = mysql_fetch_assoc($result2)) {
                $personal = $personal . "<option value='".$rowEmp2['dni']."'>". $rowEmp2['nombre']." ".$rowEmp2['apellidos']."</option>";
            }
        }
        $personal = $personal ."</select>";

        echo $personal;
        ?>

</div>


<!-- end content -->

<!-- start right box -->

<div id="rightcontent">
	<img style="margin-top:-9px; margin-left: -5px;" src="../images/top2.jpg" alt="" />

	<img style="width: 153px; height: 59px; float: left; padding:9px;" src="../images/n8g.jpg" alt="Nautica08" />

	<p><a href="#">Pick a location:</a><br />
	sit amet, consectetuer adipiscing elit, sed diam nonummy nibh   euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad   minim veniam, quis nostrud exercitation ulliam corper</p>
	<p> Pick a location:<br />
	sit amet, consectetuer adipiscing elit, sed diam nonummy nibh   euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad   minim veniam, quis nostrud exercitation ulliam corper</p>
	<p> Pick a location:<br />
	sit amet, consectetuer adipiscing elit, sed diam nonummy nibh   euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad   minim veniam, quis nostrud exercitation ulliam corper</p>

	<img style="padding-top:5px; margin-left:-5px; margin-bottom:-4px;" src="../images/specs_bottom.jpg" alt="" />
</div>

<!-- end right box -->
<!-- start footer -->

<div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>


<!-- start left boxes -->

	<div class="centercontentleftb">
		<div class="centercontentleftimg">Sample Box for Products</div>
			<div class="centercontentrightimg">Sample Box for Products</div>
	</div>

	<!-- endleft boxes -->

	<!-- start right boxes -->

	<div class="centercontentrightb">
			<div class="centercontentleftimg">Sample Box for Products</div>
		<div class="centercontentrightimg">Sample Box for Products</div>
	</div>

		<!-- end right boxes -->

<!-- end bottom boxes -->

</div>

<!-- end footer -->
<?php $conexion->cerrarConexion(); ?>



</body>
</html>
