<?php session_start();

        $ProEscogido = $_SESSION['proyectoEscogido'];
        include_once('../Persistencia/conexion.php');
        $conexion = new conexion();
        $result = mysql_query("SELECT nombre, descripcion, jefeProyecto FROM Proyecto WHERE\n"
         . "idProyecto = \"" .$ProEscogido. "\"");

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
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="../Utiles/jquery.min.js"></script>
<script src="../Utiles/jquery-ui.min.js"></script>
<script src="../Utiles/jquery.ui.datepicker-es.js"></script>

<link rel="stylesheet" type="text/css" href="../stylesheet.css" media="screen, projection, tv " />
<script type="TEXT/JAVASCRIPT">
    var disabledDays = ["2-21-2010","1-4-2010"];

    /* utility functions */
function nationalDays(date) {
	var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
	//console.log('Checking (raw): ' + m + '-' + d + '-' + y);
	for (i = 0; i < disabledDays.length; i++) {
		if($.inArray((m+1) + '-' + d + '-' + y,disabledDays) != -1 || new Date() > date) {
			//console.log('bad:  ' + (m+1) + '-' + d + '-' + y + ' / ' + disabledDays[i]);
			return [false];
		}
	}
	//console.log('good:  ' + (m+1) + '-' + d + '-' + y);
	return [true];
}
function noWeekendsOrHolidays(date) {
	var noWeekend = jQuery.datepicker.noWeekends(date);
	return noWeekend[0] ? nationalDays(date) : noWeekend;
}
  /* create datepicker */
jQuery(document).ready(function() {
	jQuery('#datepicker1I').datepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
                numberOfMonths: 1,
		beforeShowDay: noWeekendsOrHolidays
//                onSelect: function(dateText, inst) {
//                alert(dateText)
//            }
	});
});

jQuery(document).ready(function() {
	jQuery('#datepicker1F').datepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
                numberOfMonths: 1,
		beforeShowDay: noWeekendsOrHolidays
//                onSelect: function(dateText, inst) {
//                alert(dateText)
//            }
	});
});

jQuery(document).ready(function() {
	jQuery('#datepicker2I').datepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
                numberOfMonths: 1,
		beforeShowDay: noWeekendsOrHolidays
//                onSelect: function(dateText, inst) {
//                alert(dateText)
//            }
	});
});

jQuery(document).ready(function() {
	jQuery('#datepicker2F').datepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
                numberOfMonths: 1,
		beforeShowDay: noWeekendsOrHolidays
//                onSelect: function(dateText, inst) {
//                alert(dateText)
//            }
	});
});

jQuery(document).ready(function() {
	jQuery('#datepicker3I').datepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
                numberOfMonths: 1,
		beforeShowDay: noWeekendsOrHolidays
//                onSelect: function(dateText, inst) {
//                alert(dateText)
//            }
	});
});

jQuery(document).ready(function() {
	jQuery('#datepicker3F').datepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
                numberOfMonths: 1,
		beforeShowDay: noWeekendsOrHolidays
//                onSelect: function(dateText, inst) {
//                alert(dateText)
//            }
	});
});
jQuery(document).ready(function() {
	jQuery('#datepicker4I').datepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
                numberOfMonths: 1,
		beforeShowDay: noWeekendsOrHolidays
//                onSelect: function(dateText, inst) {
//                alert(dateText)
//            }
	});
});

jQuery(document).ready(function() {
	jQuery('#datepicker4F').datepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
                numberOfMonths: 1,
		beforeShowDay: noWeekendsOrHolidays
//                onSelect: function(dateText, inst) {
//                alert(dateText)
//            }
	});
});


function cambio(x){
    if(x==1){
        document.getElementById("Finicio").style.display= "inline";
        document.getElementById("Felaboracion").style.display= "none";
        document.getElementById("Fconstruccion").style.display= "none";
        document.getElementById("Ftransicion").style.display= "none";
    }else if(x==2){
        document.getElementById("Finicio").style.display= "none";
        document.getElementById("Felaboracion").style.display= "inline";
        document.getElementById("Fconstruccion").style.display= "none";
        document.getElementById("Ftransicion").style.display= "none";
    }else if(x==3){
        document.getElementById("Finicio").style.display= "none";
        document.getElementById("Felaboracion").style.display= "none";
        document.getElementById("Fconstruccion").style.display= "inline";
        document.getElementById("Ftransicion").style.display= "none";
    }else if(x==4){
        document.getElementById("Finicio").style.display= "none";
        document.getElementById("Felaboracion").style.display= "none";
        document.getElementById("Fconstruccion").style.display= "none";
        document.getElementById("Ftransicion").style.display= "inline";
}
}

//insertar fechas
function Anadir2(){
        if($('#datepicker1I').val()>= $('#datepicker1F').val()
            || $('#datepicker1F').val()> $('#datepicker2I').val()
            || $('#datepicker2I').val()>= $('#datepicker2F').val()
            || $('#datepicker2F').val()> $('#datepicker3I').val()
            || $('#datepicker3I').val()>= $('#datepicker3F').val()
            || $('#datepicker3F').val()> $('#datepicker4I').val()
            || $('#datepicker4I').val()>= $('#datepicker4F').val()
        ){
            alert("Revise las fechas escogidas" + $('#datepicker4I').val())
        }else if(document.getElementById("nIteraciones").value == ""
            ||document.getElementById("nIteraciones").value < 0){
            alert("Introduzca un numero correcto de iteraciones para la fase de inicio")
        }
        else{
         if (window.XMLHttpRequest){
      xmlhttp=new XMLHttpRequest();
      }
    else{
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function(){
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        location.href = "planIteracion.php";

        }
      }
    xmlhttp.open("GET","insertarFechaFase.php?1I="+
        $('#datepicker1I').val()
    + "&1F=" + $('#datepicker1F').val()
    + "&2I=" + $('#datepicker2I').val()
    + "&2F=" + $('#datepicker2F').val()
    + "&3I=" + $('#datepicker3I').val()
    + "&3F=" + $('#datepicker3F').val()
    + "&4I=" + $('#datepicker4I').val()
    + "&nI=" + document.getElementById("nIteraciones").value
    + "&4F=" + $('#datepicker4F').val(),true);
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
		<li><a href="#" onclick="cambio(1)" title="Inicio"><span>Inicio</span></a></li>
                <li><a href="#" onclick="cambio(2)" title="Elaboraci&oacute;n"><span>Elaboraci&oacute;n</span></a></li>
                <li><a href="#" onclick="cambio(3)" title="Construcci&oacute;n"><span>Construcci&oacute;n</span></a></li>
                <li><a href="#" onclick="cambio(4)" title="Transici&oacute;n"><span>Transici&oacute;n</span></a></li>
		</ul>
</div>

<!-- end top menu and blog title-->

<!-- start left box-->

<div id="leftcontent" style="display:inline">
	<img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />
        <h4 style="padding-right: 10px; ">Una vez haya* terminado de asignar las fechas correspondientes a cada fase, continue con el pl&aacute;n de iteraciones.</h4>
        <h3 style="color:black;">Definir el plan de iteraciones<br/></h3>
	<input type="button" value="Continuar" onclick="Anadir2()"/>

	<!-- You have to modify the "padding-top: when you change the content of this div to keep the footer image looking aligned -->
        <p><img src= "../images/Logo2.jpg" alt="#" border="0" style="width: 180px; height: auto;"/></p>
	<img style="padding-top:2px; margin-left:-12px; margin-bottom:-4px;" src="../images/specs_bottom.jpg" alt="" />

</div>
<!-- end left box-->

<!-- start content -->

<div id="centercontent">


	<h1>SIGESTPROSO</h1>
<p><br /></p>

	<p><a href="#"><?php echo $nombreP ?></a> - <?php echo $descripcionP ?></p><br/>
        
        <div id="Fechas" class="centercontentleft" style="width:auto; height:auto;">
            <div id="Finicio">
                <p style="text-align: center; font-size: 22px;">Fase de <b> inicio </b></p>
            <div type="text" id="datepicker1I" style="float:left"><p style=" font-size: 16px;">Escoja fecha de inicio</p></div>
            <div type="text" id="datepicker1F" style="float:right; margin-left:100px;"><p style=" font-size: 16px;">Escoja fecha de fin</p></div>
            
            </div>
            <div id="Felaboracion" style="display:none">
                <p style="text-align: center; font-size: 22px;">Fase de <b> elaboraci&oacute;n </b></p>
            <div type="text" id="datepicker2I" style="float:left"><p style=" font-size: 16px;">Escoja fecha de inicio</p></div>
            <div type="text" id="datepicker2F" style="float:right; margin-left:100px;"><p style=" font-size: 16px;">Escoja fecha de fin</p></div>
            </div>
            <div id="Fconstruccion" style="display:none">
                <p style="text-align: center; font-size: 22px;">Fase de <b> construci&oacute;n </b></p>
            <div type="text" id="datepicker3I" style="float:left"><p style=" font-size: 16px;">Escoja fecha de inicio</p></div>
            <div type="text" id="datepicker3F" style="float:right; margin-left:100px;"><p style=" font-size: 16px;">Escoja fecha de fin</p></div>
            </div>
            <div id="Ftransicion" style="display:none">
                <p style="text-align: center; font-size: 22px;">Fase de <b> transici&oacute;n </b></p>
            <div type="text" id="datepicker4I" style="float:left"><p style=" font-size: 16px;">Escoja fecha de inicio</p></div>
            <div type="text" id="datepicker4F" style="float:right; margin-left:100px;"><p style=" font-size: 16px;">Escoja fecha de fin</p></div>
            </div>
            
        </div><p style="float:left">Indique el n&uacute;mero de <b>iteracciones</b> que habr&aacute; en la primera fase<b>(inicio)<b>&nbsp;
                        <input type="text" id="nIteraciones" size="2" maxlength="2" /> </p>
        </div>



<div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>


</div>

<!-- end footer -->
<?php $conexion->cerrarConexion(); ?>



</body>
</html>

