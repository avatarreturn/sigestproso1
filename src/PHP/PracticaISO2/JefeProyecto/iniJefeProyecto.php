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

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />  


<link rel="stylesheet" type="text/css" href="../stylesheet.css" media="screen, projection, tv " />
<script type="TEXT/JAVASCRIPT">
    function Anadir(x){
        if(document.getElementById("RolPersonal").value=="-1"
            || document.getElementById("porcentaje").value== ""
            || document.getElementById("porcentaje").value > x
            || document.getElementById("porcentaje").value < 1){
            alert("Escoja un rol y/o escoja  correctamente su participacion")
        }else{
         if (window.XMLHttpRequest){
      xmlhttp=new XMLHttpRequest();
      }
    else{
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function(){
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        var data = xmlhttp.responseText.split ( "[BRK]" );
        document.getElementById("SelecPers").innerHTML=data[0];
        document.getElementById("datosP").innerHTML="";
        document.getElementById("listadoPer").innerHTML=document.getElementById("listadoPer").innerHTML + "<br/>&nbsp;&nbsp; <i>" +data[1] +"</i>";
        document.getElementById("listadoPer").style.display="inline";

        }
      }
    xmlhttp.open("GET","insertarTrab_Proy.php?dni="+
        document.getElementById("SelPersonal").value
    + "&porcentaje=" + document.getElementById("porcentaje").value
        + "&rol=" +document.getElementById("RolPersonal").value,true);
    xmlhttp.send();
    }}


// DATOS POR CADA TRABAJADOR
        function datosPersonal(){
        if(document.getElementById("SelPersonal").value=="-1"){
            alert("Escoja un empleado")
        }else{
         if (window.XMLHttpRequest){
      xmlhttp=new XMLHttpRequest();
      }
    else{
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function(){
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        document.getElementById("datosP").innerHTML=xmlhttp.responseText;
        }
      }
    xmlhttp.open("GET","DatosTrabajador.php?dni="+
        document.getElementById("SelPersonal").value,true);
    xmlhttp.send();
    }}


</script>
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

	<p><a href="#"><?php echo $nombreP ?></a> - <?php echo $descripcionP ?></p><br/>
        <div id="personalDentro" class="centercontentleft" style="width:300px; height:auto; float:right">
            <b>Jefe de proyecto:</b><br/>
            &nbsp;&nbsp; <i>JEFE SESSION ID</i><br/>            
            <span id="listadoPer" style="display:none"><b>Trabajadores asignados:</b></span>
            <br/>
        </div>
        <p>Seleccione el personal deseado para el proyecto</p>
        <div id="SelecPers">
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
        $personal = "<select id='SelPersonal' onchange='datosPersonal()'><option value='-1'>- Empleado -</option>";
        if ($totEmp2 >0) {
            while ($rowEmp2 = mysql_fetch_assoc($result2)) {
                $personal = $personal . "<option value='".$rowEmp2['dni']."'>". $rowEmp2['nombre']." ".$rowEmp2['apellidos']."</option>";
            }
        }
        $personal = $personal ."</select>";

        echo $personal;
        ?>
            </div>
        <div id="datosP"></div>

        

</div>


<!-- end content -->

<!-- start right box -->



<!-- end right box -->
<!-- start footer -->

<div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>


</div>

<!-- end footer -->
<?php $conexion->cerrarConexion(); ?>



</body>
</html>
