<?php session_start();
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

        //buscamos la Fase actual de este proyecto

        $result2 = mysql_query("SELECT * FROM Fase WHERE\n"
                . "Proyecto_idProyecto= '".$_SESSION['proyectoEscogido'] ."'\n"
                . "AND\n"
                . "fechaFinR is NULL\n"
                . "AND\n"
                . "fechaInicioR is not NULL"
                );

        $totEmp2 = mysql_num_rows($result2);

        if ($totEmp2 ==1) {
            while ($rowEmp2 = mysql_fetch_assoc($result2)) {
                $nombreFAct = $rowEmp2['nombre'];
                $festIFAct = $rowEmp2['fechaInicioE'];
                $festFFAct = $rowEmp2['fechaFinE'];
                $idFAct = $rowEmp2['idFase'];
            }
        }

        //buscamos la Iteracion actual de este proyecto

        $result3 = mysql_query("SELECT * FROM Iteracion WHERE\n"
            . "Fase_idFase = \"".$idFAct. "\"\n"
            . "AND\n"
            . "fechaFin is NULL\n"
            . "AND\n"
            . "fechaInicio is not NULL"
                );

        $totEmp3 = mysql_num_rows($result3);

        if ($totEmp3 ==1) {
            while ($rowEmp3 = mysql_fetch_assoc($result3)) {
                $numeroIAct = $rowEmp3['numero'];
                $idIAct = $rowEmp3['idIteracion'];
            }
        }else  if ($totEmp3 ==0) {
            $faseCero=1;
        }else{$faseCero=0;}

        // Calculamos si es la iteracion actual es la ultima de esta fase

        $result4 = mysql_query("SELECT MAX(numero) as 'maximo' FROM Iteracion WHERE\n"
            . "Fase_idFase = \"".$idFAct. "\"");


        $totEmp4 = mysql_num_rows($result4);

        if ($totEmp4 ==1) {
            while ($rowEmp4 = mysql_fetch_assoc($result4)) {
                $iteracionMax = $rowEmp4['maximo']; // ojo puede fallar
            }
        }

        // Comprobamos no estar en la ultima iteracion de la ultima fase
        if($numeroIAct == $iteracionMax && $nombreFAct=="Transicion" ){
            $casiFinP = 1;
        }else{
            $casiFinP = 0;




        //Comprobamos que no se haya planificado la siguiente iteracion si no ai cambio de fase
        if($numeroIAct < $iteracionMax){
        $numeroINext = $numeroIAct +1;
         $result5 = mysql_query("SELECT idIteracion FROM Iteracion WHERE\n"
            . "Fase_idFase = \"".$idFAct. "\" AND numero =".$numeroINext);

         $totEmp5 = mysql_num_rows($result5);
         if ($totEmp5 >0) {
             while ($rowEmp5 = mysql_fetch_assoc($result5)) {
                    $idINext =  $rowEmp5['idIteracion']; // id Iteracion siguiente sin cambio de fase
                }
         }
        $result5 = mysql_query("SELECT nombre FROM Actividad WHERE\n"
            . "Iteracion_idIteracion = \"".$idINext. "\"");


        $totEmp5 = mysql_num_rows($result5);

        if ($totEmp5 >0) {
                $planificado = 1;
                $LActividades = "<p><b>Listado de actividades planificadas:</b> <br/>";
                while ($rowEmp5 = mysql_fetch_assoc($result5)) {
                    $LActividades = $LActividades . $rowEmp5['nombre'] . "<br/>";
                }
                $LActividades = $LActividades ."</p>";
        }else{
            $planificado = 0;
        }
        }

        // comprobamos que no se haya planificado la siguiente iteracion de una fase NUEVA
        if($nombreFAct=="Transicion"){
        }elseif($numeroIAct == $iteracionMax){
            if($nombreFAct == "Inicio"){
                $faseNext = "Elaboracion";}
                else if($nombreFAct == "Elaboracion"){
                    $faseNext = "Construccion";}else{
                        $faseNext = "Transicion";
                    }
         $result6 = mysql_query("SELECT idFase FROM Fase WHERE\n"
            . "Proyecto_idProyecto = \"".$_SESSION['proyectoEscogido']. "\""
            . "AND nombre ='".$faseNext . "'");
         $totEmp6 = mysql_num_rows($result6);

        if ($totEmp6 == 1) {
                while ($rowEmp6 = mysql_fetch_assoc($result6)) {
                    $idFNext =  $rowEmp6['idFase'];
                }}

        // comprobamos si tienes iteraciones la fase siguiente
                $result6 = mysql_query("SELECT idIteracion FROM Iteracion WHERE\n"
            . "Fase_idFase = \"".$idFNext. "\" AND numero = 1");
         $totEmp6 = mysql_num_rows($result6);

        if ($totEmp6 >0) { // Si ai iteraciones definidias para la fase siguiente
                $FNextVacia = 0; // la fase siguiente SI tiene iteraciones
                while ($rowEmp6 = mysql_fetch_assoc($result6)) {
                    $idIFNext =  $rowEmp6['idIteracion']; // id iteracion nueva de fase NUEVA
                }}else{ // aun no ai iteraciones definidas en la fase siguiente
                    $FNextVacia = 1;
                }
         if(FNextVacia == 0){ // si ai iteracion en la fase siguiente, comprobamos  si esta planificada
             //comprobamos si tiene Actividades
            $result5 = mysql_query("SELECT nombre FROM Actividad WHERE\n"
            . "Iteracion_idIteracion = \"".$idIFNext. "\"");


        $totEmp5 = mysql_num_rows($result5);

        if ($totEmp5 >0) {
                $planificado = 1;
                $LActividades = "<p><b>Listado de actividades planificadas:</b> <br/>";
                while ($rowEmp5 = mysql_fetch_assoc($result5)) {
                    $LActividades = $LActividades . $rowEmp5['nombre'] . "<br/>";
                }
                $LActividades = $LActividades ."</p>";
        }else{
            $planificado = 0;
        }



         }

        }// Fin estamos en la Iteraccion maxima
        }// Fin de FinProyecto= 0




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
        document.getElementById("leftcontent").style.display="inline";

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
		<div id="small">Jefe de Proyecto - Planificaci&oacute;n de iteraciones</div>
		<div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
</div>

<!--		<div id="topmenu">


		<ul class="BLUE">
		<li><a href="#" title="Downloads"><span>Downloads</span></a></li>
		<li><a href="#" title="Gallery"><span>Photo Gallery</span></a></li>
		<li><a href="#" title="Links"><span>Subscribe</span></a></li>
		<li><a href="#" title="Links"><span>Tech Blog</span></a></li>
		<li><a href="#" title="Links"><span>Contact</span></a></li>
		<li><a href="#" title="Links"><span>RSS Feeds</span></a></li>
		</ul>
</div>-->

<!-- end top menu and blog title-->

<!-- start left box-->

<div id="leftcontent" style="display:none">
	<img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />
        <h4 style="padding-right: 10px; ">Una vez haya* terminado de asignar trabajadores, continue con la definici&oacute;n del proyecto.</h4>
        <h3 style="color:black;">Definir el plan de fases<br/></h3>
	<input type="button" value="Continuar" onclick="javascript:location.href = 'defFases.php'"/>

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
        <div id="personalDentro" class="centercontentleft" style="width:auto; height:auto; font-size: 15px; float: right">
            <b>Fase actual:</b>
            &nbsp; <i><?php echo $nombreFAct?></i>
            <br/>&nbsp;&nbsp;<small> Fechas estimadas(<?php echo $festIFAct ."&nbsp;&nbsp;al&nbsp;&nbsp;". $festFFAct?>)</small><br/>
            <span id="listadoPer" style="display:inline"><br/><b>Iteracion actual:</b> <?php 
            if($faseCero == 1){
                echo "<small>No hay iteraciones en esta fase</small>";
            }else{echo $numeroIAct;} ?></span>
            <br/>
        </div>
        <?php if($casiFinP == 1){
            //Estamos en la ultima Iteracion de TOODO el proyecot
            echo "<p>La iteracci&oacute;n actual es la <b>&uacute;ltima del proyecto</b>, no puede seguir planificando";
        }else{
                if($numeroIAct < $iteracionMax && faseCero == 0){
            if($planificado == 1){ echo "<p style=\"color:red;\"> Ya ha planificado la siguiente iteracci&oacute;n, no podr&aacute;
                planificar mas iteracciones hasta que haya finalizado la iteracci&oacute;n actual</p>" .$LActividades; }else {  ?>
            }

           PLANIFICACION NORMAL!!!

        <?php
                }}else{
                if($FNextVacia == 1){// si cambiamos de fase Y no ai iteraciones creadas
                    echo "<p>La siguiente iteracci&oacute;n pertenece a la fase siguiente<b>(".$faseNext.")</b></p>"
                        . "<p style='color:red'>A&uacute;n no ha escogido el n&uacute;mero de iteraciones del que constar&aacute; la fase siguiente</p>"
                        . "<p>Especifique el n&uacute;mero de iteraciones de la fase <b>".$faseNext."</b>"
                        . "  <input type='text' id='NIterFNext' size='2' maxlength='2'/>"
                        . "</p>";
                }else{

                if($planificado==1){
                    echo "<p style=\"color:red;\"> Ya ha planificado la siguiente iteracci&oacute;n, no podr&aacute;"
                    . " planificar mas iteracciones hasta que haya finalizado la iteracci&oacute;n actual</p>" .$LActividades;
                }else{

            echo "CAMBIO DE FASE Pero NO ESTAN PLANIFICADAS las siguientes, aunk si estan definidas-- FASECERO = --" . $faseCero ."--";
        }}}
        }//Fin casiFin

        ?>
        
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