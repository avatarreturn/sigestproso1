<?php
session_start();
$login = $_SESSION['tipoUsuario'];
if ($login != "T") {
    header("location: ../index.php");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "Http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>

<title>Vacaciones</title>

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
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="../Utiles/jquery.min.js"></script>
<script src="../Utiles/jquery-ui.min.js"></script>
<script src="../Utiles/jquery.ui.datepicker-es.js"></script>


<?php
// calcular fecha fin por Inicio + duracion/8 hora diarias por hombre y porcentaje¿¿
        include_once('../Persistencia/conexion.php');
        $conexion = new conexion();


        // numero de semanas ya cogidas para le trabajador
        $result = mysql_query("SELECT fechaInicio, fechaFin, (TO_DAYS(fechaFin) - TO_DAYS(fechaInicio)) as dias FROM Vacaciones WHERE Trabajador_dni='".$_SESSION['dni']."'");

        $totEmp = mysql_num_rows($result);

        if ($totEmp >0) {
            $varSemansaLibres = 4;
            $varListadoVac  = "<p>Actualmente tiene cogidas las siguientes semanas:<br>";
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $varSemansaLibres = $varSemansaLibres - (($rowEmp['dias']+1)/7);
                 $varListadoVac =  $varListadoVac ."<tt>Desde ".$rowEmp['fechaInicio'] ." hasta ".$rowEmp['fechaFin'] ."</tt><br/>";
            }
            $varListadoVac =  $varListadoVac . "</p>";
        }else{
            $varSemansaLibres = 4;
            $varListadoVac ="";
        }

        //---------------------------

        $result = mysql_query("SELECT fechaInicio, duracionEstimada, idActividad FROM Actividad WHERE\n"
                            . "fechaFin is NULL \n"
                            . "AND \n"
                            . "idActividad in \n"
                            . "(SELECT Actividad_idActividad FROM TrabajadorActividad\n"
                            . "WHERE Trabajador_dni = \"". $_SESSION['dni']."\")");
        $totEmp = mysql_num_rows($result);

        if ($totEmp >0) {
            $fechasF1= array();
            $fechasFFin = array();
            $fechasFFinVal = array();
            while ($rowEmp = mysql_fetch_assoc($result)) {

                // si tiene fecha de inicio
                if($rowEmp['fechaInicio']!= ""){
                    // Extraer las dos fechas
                // Generar las fechas de por medio e ir metiendolas en un array
                if (in_array($rowEmp['fechaInicio'], $fechasF1)) {
                }else{  $fechasF1[] = $rowEmp['fechaInicio'];}
                $fechaInicio = $rowEmp['fechaInicio'];
                $fechaInicio= date("Y-m-d", strtotime("$fechaInicio - 1 days"));
                $diasHH = ceil($rowEmp['duracionEstimada'] / 40) * 7;
//                echo "duracion estimada en dias =" . $diasHH;
                $fechaFin= date("Y-m-d", strtotime("$fechaInicio + $diasHH days"));
                    while ( $fechaInicio != $fechaFin) {
                    $can_dias = 1;
                    $fec_vencimi= date("Y-m-d", strtotime("$fechaInicio + $can_dias days"));
                    $fechaInicio = $fec_vencimi;
                    if(in_array($fec_vencimi, $fechasF1)){}
                    else{  $fechasF1[] = $fec_vencimi; }
                    }
                }else{// no tiene fecha de inicio
                    //comprobamos si tiene predecesora
                    $result2 = mysql_query("SELECT * FROM ActividadPredecesora WHERE Actividad_idActividad='".$rowEmp['idActividad']."'");
                    $totEmp2 = mysql_num_rows($result2);

        if ($totEmp2 ==1) { // solo tiene una predecesora
            // 3 casos, que tenga fecha de inicio, que no la tenga por tener mas de 2 niveles de precedencia, o que sea de otra iteracion
            while ($rowEmp2 = mysql_fetch_assoc($result2)) {
                $fechaInicioPredecesora ="";
                while ( $fechaInicioPredecesora == "") {
                    
                
                $result3 = mysql_query("SELECT fechaInicio, duracionEstimada FROM Actividad WHERE\n"
                            . "idActividad='".$rowEmp2['Actividad_idActividadP']. "'");
                $totEmp3 = mysql_num_rows($result3);
                if ($totEmp3 ==1) { 
                    while ($rowEmp3 = mysql_fetch_assoc($result3)) { 
                        if($rowEmp3['fechaInicio'] == ""){// No tiene fecha de inciio
                            // tela..................
                        }else{ // tiene fecha de inicio
                            // sacar una fecha de inicio estimada y sumarle duracion de la actividad en cuestion
                           
                            $fechaInicioPredecesora = $rowEmp3['fechaInicio'];
                            $fechaInicioPredecesora= date("Y-m-d", strtotime("$fechaInicioPredecesora - 1 days"));
                            $diasHHPred = ceil($rowEmp3['duracionEstimada'] / 40) * 7;
                            $diasHH = ceil($rowEmp['duracionEstimada'] / 40) * 7;
                            $fechaInicio= date("Y-m-d", strtotime("$fechaInicioPredecesora + $diasHHPred days"));
                            $fechaFin = date("Y-m-d", strtotime("$fechaInicio + $diasHH days"));;
                            while ( $fechaInicio != $fechaFin) {
                                $can_dias = 1;
                                $fec_vencimi= date("Y-m-d", strtotime("$fechaInicio + $can_dias days"));
                                $fechaInicio = $fec_vencimi;
                                if(in_array($fec_vencimi, $fechasF1)){}
                                else{  $fechasF1[] = $fec_vencimi; }
                                }
                        }
                    }
                }
                }

            }

        }else if ($totEmp2 >1){ // tiene mas de una predecesora

        }else if ($totEmp2 <1){ // no tiene predecesora, ni fechaI, es de otra iteracion
            //Tela.....

        }




            }
            // cambio de formato
               for($i=0;$i<count($fechasF1);$i++){
                $fechasFFin[]=date("n-j-Y",strtotime($fechasF1[$i]));
                $fechasFFinVal[]=date("Y-m-d",strtotime($fechasF1[$i]));
               }
     
        }
        }
        $conexion->cerrarConexion();
       // echo "FECHAS =" . $fechas."++";
        $fechas = "";
        $fechasVal = "";
        for($i=0;$i<count($fechasFFin);$i++){
                $fechas = $fechas . "\"" . $fechasFFin[$i] ."\",";
                $fechasVal = $fechasVal . "\"" . $fechasFFinVal[$i] ."\",";
               }


        // Prueba de suma de fechas Funciona!
//        $can_dias = 1;
//        $fec_emision= "2010-12-01";
//        $fec_vencimi= date("Y-m-d", strtotime("$fec_emision + $can_dias days"));
//        echo "FECHA +1 = ". $fec_vencimi;
        ?>


<script>
var disabledDays = [<?php echo $fechas;?>];
var disabledDaysVal = [<?php echo $fechasVal;?>];

//***********************************

/* create an array of days which need to be disabled */
//var disabledDays = ["2-21-2010","1-4-2011"];

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
	jQuery('#datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
		constrainInput: true,
                numberOfMonths: 2,
		beforeShowDay: noWeekendsOrHolidays
//                onSelect: function(dateText, inst) {
//                alert(dateText)
//            }
	});
});

function validar(){
    var FechaIni = new Date();
    FechaIni.setTime(Date.parse(($('#datepicker').val())));
    var FechaFin = new Date();
    FechaFin.setTime(Date.parse(($('#datepicker').val())));
    var week = parseInt(($('#Weeks').val())) * 7;
    if(FechaIni.getDay()== 1){


    FechaFin.setDate(FechaFin.getDate() + (week-1));
    var curr_date = FechaFin.getDate();
    var curr_month = FechaFin.getMonth();
    curr_month = curr_month + 1;
    var curr_year = FechaFin.getFullYear();
    //alert(curr_date + '/'+ curr_month + '/'+ curr_year);
    //*** Validamos
    var Bandera = 0;
    var Fini = FechaIni.getTime();
    var Ffin = FechaFin.getTime();
    //alert(Fini +"--"+Ffin);
    for (i=0;i<disabledDays.length;i++){
        var FechaVal = new Date();
        FechaVal.setTime(Date.parse(disabledDaysVal[i]));
        //alert(disabledDaysVal[i]);
        var Fval = FechaVal.getTime();
        if (Fval > Fini &&  Fval<Ffin){
            Bandera = 1;
            alert("Las fechas no respetan los horarios de las actividades ya marcadas");
            break;
        }
    }
    if(Bandera == 0){
        alert("Fechas Correctas");
    }
    }else{
        alert("Debe escojer un Lunes como comienzo de vacaciones")
    }
    //alert("Fecha de fin: "+FechaFin.getDate()+"-"+FechaFin.getMonth()+"-"+FechaFin.getFullYear());
}
</script>
</head>

<body>

<!-- start top menu and blog title-->

<div id="blogtitle">
		<div id="small">Vacaciones</div>
		<div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
</div>
<!--		<div id="topmenu">


		<ul class="BLUE">
		<li><a href="#" title="Downloads"><span>ISO II</span></a></li>
		<li><a href="#" title="Vacaciones"><span>Vacaciones</span></a></li>
		<li><a href="#" title="Links"><span>Santillana</span></a></li>
		</ul>
</div>-->

<!-- end top menu and blog title-->

<!-- start left box-->
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
	<p><a href="http://www.studio7designs.com"><img src= "../images/logo3.png" alt="#" border="2" style="width: 500px; height: 65px;"/></a><br/></p>
        <div id="vacaciones">
        <h2 style="text-align: center">Escoja su periodo vacacional</h2>
        <div class="centercontentleft">
            <div type="text" id="datepicker"></div>
            <br/>
            N&uacute;mero de semanas:
            <?php
            
            if($varSemansaLibres == 0){
                echo "No dispone de mas semanas de vacaciones actualmente";
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
            
            <?php
            if($varSemansaLibres >0){
                echo "<center><input type='button' value='Confirmar' name='Confirmar' onclick='validar()'/></center>";
            }

            if($varListadoVac == ""){

            }else{
                echo "<br>" .$varListadoVac;
            }?>
            <br/><br/>
        </div>
        <div><h3>Condiciones:</h3>

            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;El periodo m&aacute;ximo de vacaciones ser&aacute; de 4 semanas naturales - (De Lunes a Domingo)</p>
            <p><img src= "../images/LICondiciones.jpg" alt="#" border="0" style="width: auto; height: 12px;"/>&nbsp;&nbsp;El periodo seleccionado no interferir&aacute; en ningun momento con la realizaci&oacute;n de ninguna
            actividad previamente fijada.</p>
            <br/>
            <p style="padding-left:5px;"><small><img src= "../images/LeyendaDLibre.jpg" alt="#" border="0" style="width: auto; height: auto;"/>&nbsp;&nbsp;D&iacute;as libres</small><br/>
            <small><img src= "../images/LeyendaDOcupado.jpg" alt="#" border="0" style="width: auto; height: auto;"/>&nbsp;&nbsp;Fines de semana, fiestas nacionales y dias con actividades programadas</small></p>
        </div>
        
        </div>

</div>
</div>

<div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>


</div>

</body>
</html>