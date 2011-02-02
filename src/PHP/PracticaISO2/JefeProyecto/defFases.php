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




?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "Http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>

<title>[SIGESTPROSO]-Seguimiento Integrado de la GEStion Temporal de PROyectos de SOftware</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="../Utiles/jquery.min.js"></script>
<script src="../Utiles/jquery-ui.min.js"></script>
<script src="../Utiles/jquery.ui.datepicker-es.js"></script>
<style type="text/css">
/*#datepicker1I .ui-datepicker  {
    background: #B0DFA4;
    border: 1px solid #555;
    color: #EEE;
}*/
</style>
<link rel="stylesheet" type="text/css" href="../stylesheet.css" media="screen, projection, tv " />
<script type="TEXT/JAVASCRIPT">
    var disabledDays = ["2-21-2010","1-4-2010"];

    /* utility functions */
function nationalDays(date) {
	var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
	//console.log('Chforecking (raw): ' + m + '-' + d + '-' + y);
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
                numberOfMonths: 1
//		beforeShowDay: noWeekendsOrHolidays
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
    var FechaIni = new Date();
    FechaIni.setTime($.datepicker.parseDate('yy-mm-dd',$('#datepicker1I').val()));
    
    var FechaIni2 = new Date();
    FechaIni2.setTime($.datepicker.parseDate('yy-mm-dd',$('#datepicker2I').val()));
    var FechaIni3 = new Date();
    FechaIni3.setTime($.datepicker.parseDate('yy-mm-dd',$('#datepicker3I').val()));
    var FechaIni4 = new Date();
    FechaIni4.setTime($.datepicker.parseDate('yy-mm-dd',$('#datepicker4I').val()));
    var FechaFin = new Date();
    FechaFin.setTime($.datepicker.parseDate('yy-mm-dd',$('#datepicker4F').val()));
        if(FechaIni.getDay()!= 1){
            alert("La fase de inicio no comienza en Lunes");
        }else if(FechaIni2.getDay()!= 1){
            alert("La fase de elaboracion no comienza en Lunes");
        }else if(FechaIni3.getDay()!= 1){
            alert("La fase de construccion no comienza en Lunes");
        }else if(FechaIni4.getDay()!= 1){
            alert("La fase de transicion no comienza en Lunes");
        }else if(FechaFin.getDay()!= 0){
            alert("La fase de transicion no acaba en Domingo" );
        } else{
        if($('#datepicker1I').val()>= $('#datepicker2I').val()
            || $('#datepicker2I').val()>= $('#datepicker3I').val()
            || $('#datepicker3I').val()>= $('#datepicker4I').val()
            || $('#datepicker4I').val()>= $('#datepicker4F').val()
        ){
            alert("Revise el orden cronologico de las fechas escogidas")
        }else if(document.getElementById("nIteraciones").value == ""
            ||document.getElementById("nIteraciones").value < 1){
            alert("Introduzca un numero correcto de iteraciones para la fase de inicio, minimo 1")
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
    + "&2I=" + $('#datepicker2I').val()
    + "&3I=" + $('#datepicker3I').val()
    + "&4I=" + $('#datepicker4I').val()
    + "&nI=" + document.getElementById("nIteraciones").value
    + "&4F=" + $('#datepicker4F').val(),true);
    xmlhttp.send();
    }}}
</script>
</head>

<body>

<!-- start top menu and blog title-->

<div id="blogtitle">
    <div id="small">Jefe de proyecto (<u><?php echo $_SESSION['login'] ?></u>) - Definici&oacute;n de fases</div>
		<div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
</div>
<div id="page">
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
        <p><img src= "../images/info_icon.jpg" alt="#" border="0" style="width: 100px;  height: auto; display: block; margin: auto;"/></p>
        <h4 style="padding-right: 10px; ">Una vez haya terminado de asignar las fechas correspondientes a cada fase, contin&uacute;e con el plan de iteraciones.</h4>
        <h3 style="color:black;">Definir el plan de iteraciones<br/></h3>
	<input type="button" value="Continuar" onclick="Anadir2()"/>

	
</div>
<!-- end left box-->

<!-- start content -->

<div id="centercontent">


	<h1>SIGESTPROSO</h1>
<p><br /></p>

	<p><a href="#"><?php echo utf8_decode($nombreP) ?></a> - <?php echo utf8_decode($descripcionP) ?></p><br/>
        
        <div id="Fechas" class="centercontentleft" style="width:auto; height:auto;">
            <div id="Finicio">
                <p style="text-align: center; font-size: 22px;">Fase de <b> inicio </b></p>
            <div type="text" id="datepicker1I"  style="float:left"><p style=" font-size: 16px;">Escoja fecha de inicio</p></div>
            <div style="margin-left:290px;"><h3>Condiciones:</h3>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;Todas las fases deben empezar en <b>Lunes</b></p>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;Las fases deben seguir un orden cronol&oacute;gico<br/>&nbsp;&nbsp;&nbsp;&nbsp; (Inicio->Elaboraci&oacute;n->Construcci&oacute;n->Transici&oacute;n)</p>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;La fecha de inicio de la fase de Inicio, se considerar&aacute; la fecha de inicio del proyecto</p>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;La fecha de fin de una fase ser&aacute; el d&iacute;a anterior a la fecha de inicio de la fase siguiente</p>
           </div>
            </div>
            <div id="Felaboracion" style="display:none">
                <p style="text-align: center; font-size: 22px;">Fase de <b> elaboraci&oacute;n </b></p>
            <div type="text" id="datepicker2I" style="float:left;"><p style=" font-size: 16px;">Escoja fecha de inicio</p></div>
            <div style="margin-left:290px;"><h3>Condiciones:</h3>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;Todas las fases deben empezar en <b>Lunes</b></p>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;Las fases deben seguir un orden cronol&oacute;gico<br/>&nbsp;&nbsp;&nbsp;&nbsp; (Inicio->Elaboraci&oacute;n->Construcci&oacute;n->Transici&oacute;n)</p>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;La fecha de fin de una fase ser&aacute; el d&iacute;a anterior a la fecha de inicio de la fase siguiente</p>
           </div>            </div>
            <div id="Fconstruccion" style="display:none">
                <p style="text-align: center; font-size: 22px;">Fase de <b> construci&oacute;n </b></p>
            <div type="text" id="datepicker3I" style="float:left"><p style=" font-size: 16px;">Escoja fecha de inicio</p></div>
            <div style="margin-left:290px;"><h3>Condiciones:</h3>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;Todas las fases deben empezar en <b>Lunes</b></p>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;Las fases deben seguir un orden cronol&oacute;gico<br/>&nbsp;&nbsp;&nbsp;&nbsp; (Inicio->Elaboraci&oacute;n->Construcci&oacute;n->Transici&oacute;n)</p>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;La fecha de fin de una fase ser&aacute; el d&iacute;a anterior a la fecha de inicio de la fase siguiente</p>
           </div>            </div>
            <div id="Ftransicion" style="display:none">
                <p style="text-align: center; font-size: 22px;">Fase de <b> transici&oacute;n </b></p>
            <div type="text" id="datepicker4I" style="float:left"><p style=" font-size: 16px;">Escoja fecha de inicio</p></div>
            <div type="text" id="datepicker4F" style="float:right; margin-left:100px;"><p style=" font-size: 16px;">Escoja fecha de fin</p></div>
            <br/><br/><br/>
            <div style="clear:both;"><h3><br/>Condiciones:</h3>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;Todas las fases deben empezar en <b>Lunes</b> y acabar en <b>Domingo</b></p>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;Las fases deben seguir un orden cronol&oacute;gico<br/>&nbsp;&nbsp;&nbsp;&nbsp; (Inicio->Elaboraci&oacute;n->Construcci&oacute;n->Transici&oacute;n)</p>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;La fecha de fin de la fase de Transici&oacute;n, se considerar&aacute; la <b>fecha estimada de fin del proyecto</b></p>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;La fecha de fin de una fase ser&aacute; el d&iacute;a anterior a la fecha de inicio de la fase siguiente</p>
           </div>
            </div>
            
        </div><p style="float:left">Indique el n&uacute;mero de <b>iteraciones</b> que habr&aacute; en la primera fase <b>(inicio)</b>&nbsp;
                        <input type="text" id="nIteraciones" size="2" maxlength="2" /> </p>
        </div>

</div>

<div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>


</div>

<!-- end footer -->
<?php $conexion->cerrarConexion(); ?>



</body>
</html>

