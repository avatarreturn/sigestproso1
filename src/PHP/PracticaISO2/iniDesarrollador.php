<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>

<title>Desarrollador</title>

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


<link rel="stylesheet" type="text/css" href="stylesheet.css" media="screen, projection, tv " />
<link href="Utiles/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="Utiles/jquery.min.js"></script>
<script src="Utiles/jquery-ui.min.js"></script>
<script src="Utiles/jquery.ui.datepicker-es.js"></script>


<script>
jQuery(document).ready(function() {
	jQuery('#datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
                numberOfMonths: 2
		//beforeShowDay: noWeekendsOrHolidays
//                onSelect: function(dateText, inst) {
//                alert(dateText)
//            }
	});
});

</script>
</head>

<body>

<!-- start top menu and blog title-->

<div id="blogtitle">
		<div id="small">Desarrollador</div>
		<div id="small2"><a href="logout.php">Cerrar sesi&oacute;n</a></div>
</div>

		<div id="topmenu">


		<ul class="BLUE">
		<li><a href="#" title="Downloads"><span>ISO II</span></a></li>
		<li><a href="#" title="Vacaciones"><span>Vacaciones</span></a></li>
		<li><a href="#" title="Links"><span>Santillana</span></a></li>
		</ul>
</div>

<!-- end top menu and blog title-->

<!-- start left box-->

<div id="leftcontent">
	<img style="margin-top:-9px; margin-left:-12px;" src="images/top2.jpg" alt="" />

	<h3 align="left">Main Menu</h3>


	<div align="left">
		<ul class="BLUE">
			<li><a href="#">Sample Link</a></li>
			<li><a href="#">Sample Link</a></li>
		</ul>
	</div>

<!--	<h3 align="left">Sub menu</h3>
	<div align="left">
		<ul class="BLUE">
			<li><a href="#">Sample Link</a></li>
			<li><a href="#">Sample Link</a></li>
		</ul>
        </div>-->
        <p><img src= "images/Logo2.jpg" alt="#" border="0" style="width: 180px; height: auto;"/></p>


	<!-- You have to modify the "padding-top: when you change the content of this div to keep the footer image looking aligned -->

	<img style="padding-top:2px; margin-left:-12px; margin-bottom:-4px;" src="images/specs_bottom.jpg" alt="" />



</div>

<!-- end left box-->

<!-- start content -->

<div id="centercontent">


	<h1>SIGESTPROSO</h1>
	<p><a href="http://www.studio7designs.com"><img src= "images/logo.jpg" alt="#" border="0" style="width: auto; height: 65px;"/></a><br/></p>
        <div id="vacaciones">
        <h2 style="text-align: center">Escoja su periodo vacacional</h2>
        <div class="centercontentleft">
            <div type="text" id="datepicker"></div>
            <br/>
            N&uacute;mero de semanas:
            <?php
            $varSemansaLibres = 4;
            if($varSemansaLibres == 0){
                echo "No dispone de vacaciones actualmente";
            }else if($varSemansaLibres == 1){
                echo "<SELECT ID='Weeks' NAME='SemanasVacaciones' SIZE=1 onChange='javascript:alert();'>
                    <OPTION VALUE='1'>1</OPTION></SELECT>";
            }else if($varSemansaLibres == 2){
                echo "<SELECT ID='Weeks' NAME='SemanasVacaciones' SIZE=1 onChange='javascript:alert();'>
                    <OPTION VALUE='1'>1</OPTION><OPTION VALUE='2'>2</OPTION></SELECT>";
            }else if($varSemansaLibres == 3){
                echo "<SELECT ID='Weeks' NAME='SemanasVacaciones' SIZE=1 onChange='javascript:alert();'>
                    <OPTION VALUE='1'>1</OPTION><OPTION VALUE='2'>2</OPTION><OPTION VALUE='3'>3</OPTION></SELECT>";
            }else if($varSemansaLibres == 4){
                echo "<SELECT ID='Weeks' NAME='SemanasVacaciones' SIZE=1 onChange='javascript:alert();'>
                    <OPTION VALUE='1'>1</OPTION><OPTION VALUE='2'>2</OPTION><OPTION VALUE='3'>3</OPTION><OPTION VALUE='4'>4</OPTION></SELECT>";
            }

            ?>
            <center><input type="button" value="Confirmar" name="Confirmar" onclick="validar()"/></center>
            <br/><br/>
        </div>
        <div><h3>Condiciones:</h3>

            <p><img src= "images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;El periodo m&aacute;ximo de vacaciones ser&aacute; de 4 semanas.</p>
            <p><img src= "images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;El periodo seleccionado ser&aacute; de 1, 2, 3 &oacute; 4 semanas completas.</p>
            <p><img src= "images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;El periodo seleccionado no interferir&aacute; en ningun momento con la realizaci&oacute;n de ninguna
            actividad previamente fijada.</p>

        </div>
        <p><br/><br/><br/> Se come el footer al menu! </p>
        </div>

</div>


<div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>


</div>

</body>
</html>