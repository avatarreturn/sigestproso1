<?php session_start();

        $_SESSION['ActividadEscogida'] = $_GET['idAct'];
        $otraSemana = $_GET['sem'];




        include_once('../Persistencia/conexion.php');
        $conexion = new conexion();

        if($otraSemana == ""){
            //Comprobamos el estado del informe de esta semana
            // sacamos el Lunes de esta semana actual
            $dSemana= date(N);
            $semana=date("Y-m-d");
            if($dSemana!= 1){
            while ( $dSemana != 1) {
            $semana = date("Y-m-d",strtotime(date("Y-m-d", strtotime($semana)) . " -1 day"));
            $dSemana =  date('N', strtotime($semana));
            }
            }// fin del lunes
        }else{
            $semana = $otraSemana;
        }
       


            //Comprobamos el artefacto de la actividad
            $result2 = mysql_query("SELECT * FROM Artefacto WHERE\n"
            . "Actividad_idActividad = \"".$_SESSION['ActividadEscogida']."\"");

            $totEmp2 = mysql_num_rows($result2);
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



            //----
            //
            //Comprobamos si ai informes pendientes de otras semanas
            $result2 = mysql_query("SELECT idInformeTareas, estado,semana FROM InformeTareas WHERE\n"
            . "Actividad_idActividad = \"".$_SESSION['ActividadEscogida']. "\" AND "
            . "Trabajador_dni=\"".$_SESSION['dni']. "\" AND "
            . "estado<> \"Aceptado\" AND "
            . "semana<>\"".$semana."\"");

            $totEmp2 = mysql_num_rows($result2);
            $iPendientes = 0;
            if ($totEmp2 >0) { // existen informes pendientes para anteriores SEMANAs
            $iPendientes = 1;
            $listIPendientes = "<ul>";
            while ($rowEmp2 = mysql_fetch_assoc($result2)) {
                $listIPendientes = $listIPendientes ."<li>Informe a fecha de ".$rowEmp2['semana'] ." (".$rowEmp2['estado']. ") - <a href='#' onclick=\"javascript:location.href = 'tareas.php?idAct=".$_SESSION['ActividadEscogida']."&sem=".$rowEmp2['semana']."'\">Reenviar</a></li>";
            }
            $listIPendientes = $listIPendientes ."</ul>";
            }

            //---
            $result2 = mysql_query("SELECT idInformeTareas, estado FROM InformeTareas WHERE\n"
            . "Actividad_idActividad = \"".$_SESSION['ActividadEscogida']. "\" AND "
             . "Trabajador_dni=\"".$_SESSION['dni']. "\" AND "
            . "semana=\"".$semana."\"");

        $totEmp2 = mysql_num_rows($result2);
        $estadoInf = "";
        $cancelado=0;
        $pendiente=0;
         $cambiar=0;
         $idInformeActual = -1;
        if ($totEmp2 ==1) { // existen informes para ESTA SEMANA
            
            while ($rowEmp2 = mysql_fetch_assoc($result2)) {

            $idInformeActual = $rowEmp2['idInformeTareas'];
            if($rowEmp2['estado']=="Pendiente"){
                $estadoInf= "<p style='color:red'> Ya ha enviado el informe de tareas correspondiente a esta semana.<br/>"
                            . "El estado actual del informe es: <b>Pendiente de revisi&oacute;n</b> (puede actualizarlo si lo desea)</p>";
                $pendiente=1;
                $cambiar=1;
            }else if($rowEmp2['estado']=="Aceptado"){
                $estadoInf= "<p style='color:red'> Ya ha completado el informe de tareas correspondiente a esta semana.<br/>"
                            . "El estado actual del informe es: <b>Aceptado</b></p>";
            }else{
                $estadoInf= "<p style='color:red'> Ya ha completado el informe de tareas correspondiente a esta semana.<br/>"
                            . "El estado actual del informe es: <b>Cancelado</b><br/>"
                            . "<tt style='color:red'>Revise el informe y vuelva a enviarlo</tt></p>";
                $cancelado= 1;
                $cambiar=1;
            }
            }


        }

        
        // sacamos nombre de la actividad y proyecto
        $result = mysql_query("SELECT p.nombre as nombreP, p.idProyecto as idP, p.descripcion as descP, a.nombre as nombreA FROM Proyecto p, Actividad a, Iteracion i, Fase f WHERE\n"
    . "a.idActividad = \"".$_SESSION['ActividadEscogida'] . "\" AND\n"
    . "a.Iteracion_idIteracion = i.idIteracion AND\n"
    . "i.Fase_idFase = f.idFase AND\n"
    . "f.Proyecto_idProyecto = p.idProyecto");

        $totEmp = mysql_num_rows($result);

        if ($totEmp >0) {
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $nombreP = $rowEmp['nombreP'];
                $descripcionP = $rowEmp['descP'];
                $nombreA = $rowEmp['nombreA'];
                $idP = $rowEmp['idP'];
            }
        }

                if($totEmp2==0 || $cancelado==1 || $pendiente==1){ // Aun no ai informes para este semana o fue cancelado o pendiente

                    // si ya ai datos
                    if($idInformeActual == -1){
                        $result = mysql_query("SELECT * FROM CatalogoTareas ORDER BY descripcion");

        $totEmp = mysql_num_rows($result);
        $nTareas = $totEmp;
        $_SESSION['nTareas'] =$nTareas;
        if ($totEmp >0) {
            $Tareas =  "<p>Indique el n&uacute;mero de horas dedicadas a cada tarea:</p><TABLE cellspacing='12' cellpadding='0'>";
            $i = 0;
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $Tareas = $Tareas ."<TR>"
                ."<TD><img src= '../images/iTarea2.png' alt='#' border='0' style='width: auto; height: 12px;'/>&nbsp;".$rowEmp['descripcion']."</TD>"
                ."<TD><input type='text' id='tarea".$i."' value='0' size='2' maxlength='2'> </TD>"
                ."<TD><small>Horas</small></TD>"
                ."</TR>";
                $i++;
            }
            $Tareas = $Tareas ."</TABLE>";
        }

                    }else  {
                    $result = mysql_query("SELECT t.horas as Horas, c.descripcion as descripcion FROM TareaPersonal t, CatalogoTareas c WHERE\n"
    . " t.InformeTareas_idInformeTareas = '".$idInformeActual."' \n"
    . "AND\n"
    . "t.CatalogoTareas_idTareaCatalogo = c.idTareaCatalogo\n"
    . "ORDER BY c.descripcion");

        $totEmp = mysql_num_rows($result);
        $nTareas = $totEmp;
        $_SESSION['nTareas'] =$nTareas;
        if ($totEmp >0) {
            $Tareas =  "<p>Indique el n&uacute;mero de horas dedicadas a cada tarea:</p><TABLE cellspacing='12' cellpadding='0'>";
            $i = 0;
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $Tareas = $Tareas ."<TR>"
                ."<TD><img src= '../images/iTarea2.png' alt='#' border='0' style='width: auto; height: 12px;'/>&nbsp;".$rowEmp['descripcion']."</TD>"
                ."<TD><input type='text' id='tarea".$i."' value='".$rowEmp['Horas']."' size='2' maxlength='2'> </TD>"
                ."<TD><small>Horas</small></TD>"
                ."</TR>";
                $i++;
            }
            $Tareas = $Tareas ."</TABLE>";
        }
                    }
        //sacamos el porcentaje de participacion del proyecto

        $result = mysql_query("SELECT porcentaje FROM TrabajadorProyecto WHERE "
                ."Proyecto_idProyecto=\"".$idP."\" AND "
                ."Trabajador_dni=\"".$_SESSION['dni']."\"");

        $totEmp = mysql_num_rows($result);

        if ($totEmp ==1) {
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $porcentajeP = $rowEmp['porcentaje'];
            }
        }
        //------------

        //Suma total de horas
        $maxHoras = round(40 * $porcentajeP / 100);

        //genero el script de ajax
        $script= "\"insertarTareas.php?semana=".$semana."&cambio=".$cambiar."\"";
        for ($i = 1; $i <= $nTareas; $i++) {
         $script = $script . "+ \"&T".$i."=\" + document.getElementById(\"tarea". ($i-1) ."\").value ";
     }
        }

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "Http://www.w3.org/TR/html4/strict.dtd">

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

<script>
    function editar(){
        if(document.getElementById("urlArt").value == ""
    || document.getElementById("nomArt").value == ""){
            alert("El campo nombre y el campo URL no deben estar vacios")
        }else{
        if (window.XMLHttpRequest){
      xmlhttp=new XMLHttpRequest();
      }
    else{
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==1){
            //Sucede cuando se esta cargando la pagina
            document.getElementById("editando").innerHTML = "<p><center>Editando<center><img src='../images/enviando.gif' alt='Editando' width='150px'/></p>";//<-- Aca puede ir una precarga
        }else if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            //alert(xmlhttp.responseText);
            location.href = "tareas.php?idAct=" +"<?php echo $_SESSION['ActividadEscogida']?>";
        }
      }
      xmlhttp.open("GET","editarArtefacto.php?nombre=" + document.getElementById("nomArt").value
    + "&url=" + document.getElementById("urlArt").value
    + "&comm=" + document.getElementById("commArt").value,true);
    xmlhttp.send();
    }}


<?php if($nTareas!= ""){?>
function enviar(){
    var bandera = 0;
    var contador = 0;
    for (i = 0; i < <?php echo $nTareas?>; i++) {
    if(eval("parseInt(document.getElementById(\"tarea"+i+"\").value)")<0
        ||eval("document.getElementById(\"tarea"+i+"\").value")==""
        ||eval("isNaN(parseInt(document.getElementById(\"tarea"+i+"\").value))"))
           {
               alert("Compruebe la cantidad de horas establecidas en la "+(i+1)+"º tarea");
               bandera = 1;
               break;
           }else{
               contador = eval("contador + parseInt(document.getElementById(\"tarea"+i+"\").value)");
           }
    }
    if(bandera == 0 && contador > <?php echo $maxHoras;?>){
        bandera=1;
        alert("La suma de las horas ("+ contador+"), excede el maximo permitido");
        }
    if(bandera==0){
        if (window.XMLHttpRequest){
      xmlhttp=new XMLHttpRequest();
      }
    else{
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==1){
            //Sucede cuando se esta cargando la pagina
            document.getElementById("enviando").innerHTML = "<p><center>Enviando<center><img src='../images/enviando.gif' alt='Enviando' width='150px'/></p>";//<-- Aca puede ir una precarga
        }else if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            //alert(xmlhttp.responseText);
            location.href = "tareas.php?idAct=" +"<?php echo $_SESSION['ActividadEscogida']."&sem=". $semana;?>";
        }
      }
    xmlhttp.open("GET",<?php echo $script;?>
    + "&prueba=OK",true);
    xmlhttp.send();
    }}
<?php }?>

function cambio(x){
    if(x==1){
        document.getElementById("DTareas").style.display= "inline";
        document.getElementById("DArtefacto").style.display= "none";
     <?php if($iPendientes==1){ ?>   document.getElementById("DPendientes").style.display= "none";<?php } ?>
    }else if(x==2){
        document.getElementById("DTareas").style.display= "none";
        document.getElementById("DArtefacto").style.display= "inline";
     <?php if($iPendientes==1){ ?>   document.getElementById("DPendientes").style.display= "none";<?php } ?>
    }else if(x==3){
        document.getElementById("DTareas").style.display= "none";
        document.getElementById("DArtefacto").style.display= "none";
    <?php if($iPendientes==1){ ?>    document.getElementById("DPendientes").style.display= "inline";<?php } ?>
    }
}

</script>
</head>

<body>

<!-- start top menu and blog title-->

<div id="blogtitle">
		<div id="small">Desarrollador - Tareas</div>
		<div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
</div>
<div id="page">
<div id="topmenu">
		<ul class="BLUE">
		<li><a href="#" onclick="cambio(1)" title="Tareas"><span>Tareas</span></a></li>
		<li><a href="#" onclick="cambio(2)" title="Artefacto"><span>Artefacto</span></a></li>
                <?php if($iPendientes==1){ ?>
                <li><a href="#" onclick="cambio(3)" title="Pendientes" ><span style="color:red"><b>Informes Pendientes</b></span></a></li>
                    <?php } ?>
		</ul>
</div>

<!-- end top menu and blog title-->

<!-- start left box-->

<div id="leftcontent">
	<img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />

	<h3 align="left">Men&uacute;</h3>


	<div align="left">
		<ul class="BLUE">
			<li><a href="../Comun/selecProyecto.php">Selecionar proyecto</a></li>
			<li><a href="../Comun/selecVacaciones.php">Escoger vacaciones</a></li>
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
<p><br /></p>

	<p><a href="#"><?php echo utf8_decode($nombreP) ?></a> - <?php echo utf8_decode($descripcionP) ?></p>
        <div id="selProyecto">
            <h2 style="text-align: center">Actividad <i style="color:blue"><?php echo utf8_decode($nombreA) ?></i></h2>
        <div id="divTareas" class="centercontentleft" style="width:auto;">
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
            <div id="DArtefacto" Style="display:none">
                <p><b>Artefacto correspondiente a la actividad actual</b></p>
                <table style="padding-left:10px;">
                    <tr>
                    <td>Nombre:</td>
                    <td><input type="text" id="nomArt" value="<?php echo utf8_decode($nomArtefacto) ?>" size="75" /></td>
                    </tr>
                    <tr>
                    <td>URL:</td>
                    <td><input type="text" id="urlArt" size="75" value="<?php echo utf8_decode($desArtefacto) ?>" /></td>
                    </tr>
                </table>

                <p>Comentarios: <br> <textarea cols="70" id="commArt" rows="8"><?php echo utf8_decode($commArtefacto) ?></textarea></p>
                <span id="editando" >
            <center><input type="button" value="Editar" name="Editar" onclick="editar()"/></center>
            </span>
            </div>
            <div id="DPendientes" Style="display:none">

                <p>Listado de informes semanales que a&uacute;n no han sido aprobados por el jefe de proyecto:</p>
                <?php echo $listIPendientes; ?>
            </div>
        </div>
       

        </div>

</div>
</div>


<div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>


</div>

</body>
<?php $conexion->cerrarConexion(); ?>
</html>
