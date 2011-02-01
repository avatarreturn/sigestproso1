<?php
session_start();

if ($_GET['idP'] == "") {

} else {
    $_SESSION['proyectoEscogido'] = $_GET['idP'];
}
include_once('../Persistencia/conexion.php');
$conexion = new conexion();
$result = mysql_query("SELECT nombre, descripcion, jefeProyecto FROM Proyecto WHERE\n"
                . "idProyecto = \"" . $_SESSION['proyectoEscogido'] . "\"");

$totEmp = mysql_num_rows($result);

if ($totEmp == 1) {
    while ($rowEmp = mysql_fetch_assoc($result)) {
        $nombreP = $rowEmp['nombre'];
        $descripcionP = $rowEmp['descripcion'];
    }
}

// variable de sesion reiniciada para meter trabajadores asignadas
$_SESSION['trabActividad'] = array();
//sacamos la lista de roles disponibles
$result3 = mysql_query(
                "SELECT nombre, idRol FROM Rol WHERE categoria > 1");

$totEmp3 = mysql_num_rows($result3);

if ($totEmp3 > 0) {
    $rolesDisponibles = "<select id='RolActividad' onchange='trabajRol()'><option value='-1'>- Escoja un rol -</option>";
    while ($rowEmp3 = mysql_fetch_assoc($result3)) {
        $rolesDisponibles = $rolesDisponibles . "<option value='" . $rowEmp3['idRol'] . "'>" . $rowEmp3['nombre'] . "</option>";
    }
}
$rolesDisponibles = $rolesDisponibles . "</select>";




//buscamos la Fase actual de este proyecto

$result2 = mysql_query("SELECT * FROM Fase WHERE\n"
                . "Proyecto_idProyecto= '" . $_SESSION['proyectoEscogido'] . "'\n"
                . "AND\n"
                . "fechaFinR is NULL\n"
                . "AND\n"
                . "fechaInicioR is not NULL"
);

$totEmp2 = mysql_num_rows($result2);

if ($totEmp2 == 1) {
    while ($rowEmp2 = mysql_fetch_assoc($result2)) {
        $nombreFAct = $rowEmp2['nombre'];
        $festIFAct = $rowEmp2['fechaInicioE'];
        $festFFAct = $rowEmp2['fechaFinE'];
        $idFAct = $rowEmp2['idFase'];
    }
}

//buscamos la Iteracion actual de este proyecto

$result3 = mysql_query("SELECT * FROM Iteracion WHERE\n"
                . "Fase_idFase = \"" . $idFAct . "\"\n"
                . "AND\n"
                . "fechaFin is NULL\n"
                . "AND\n"
                . "fechaInicio is not NULL"
);

$totEmp3 = mysql_num_rows($result3);

if ($totEmp3 == 1) {
    while ($rowEmp3 = mysql_fetch_assoc($result3)) {
        $numeroIAct = $rowEmp3['numero'];
        $idIAct = $rowEmp3['idIteracion'];
        $_SESSION['IdIterActual'] = $idIAct;
    }
} else if ($totEmp3 == 0) {
    $faseCero = 1;
} else {
    $faseCero = 0;
}




// miramos si es la primera iteracion del proyecto
if ($numeroIAct == 1 && $nombreFAct == "Inicio") {
    $result5 = mysql_query("SELECT nombre FROM Actividad WHERE\n"
                    . "Iteracion_idIteracion = \"" . $idIAct . "\"");


    $totEmp5 = mysql_num_rows($result5);

    if ($totEmp5 > 0) {
        $PrimIter = 0;
    } else {
        $PrimIter = 1;
    }
} else {
    $PrimIter = 0;
}


// Calculamos si es la iteracion actual es la ultima de esta fase

$result4 = mysql_query("SELECT MAX(numero) as 'maximo' FROM Iteracion WHERE\n"
                . "Fase_idFase = \"" . $idFAct . "\"");


$totEmp4 = mysql_num_rows($result4);

if ($totEmp4 == 1) {
    while ($rowEmp4 = mysql_fetch_assoc($result4)) {
        $iteracionMax = $rowEmp4['maximo']; // ojo puede fallar
    }
}

// Comprobamos no estar en la ultima iteracion de la ultima fase
if ($numeroIAct == $iteracionMax && $nombreFAct == "Transicion") {
    $casiFinP = 1;
} else {
    $casiFinP = 0;




    //Comprobamos que no se haya planificado la siguiente iteracion si no ai cambio de fase
    if ($numeroIAct < $iteracionMax) {
        $numeroINext = $numeroIAct + 1;
        $result5 = mysql_query("SELECT idIteracion FROM Iteracion WHERE\n"
                        . "Fase_idFase = \"" . $idFAct . "\" AND numero =" . $numeroINext);

        $totEmp5 = mysql_num_rows($result5);
        if ($totEmp5 > 0) {
            while ($rowEmp5 = mysql_fetch_assoc($result5)) {
                $idINext = $rowEmp5['idIteracion']; // id Iteracion siguiente sin cambio de fase
            }
        }
        $result5 = mysql_query("SELECT nombre FROM Actividad WHERE\n"
                        . "Iteracion_idIteracion = \"" . $idINext . "\"");


        $totEmp5 = mysql_num_rows($result5);

        if ($totEmp5 > 0) {
            $planificado = 1;
            $LActividades = "<p><b>Listado de actividades planificadas:</b> <br/>";
            while ($rowEmp5 = mysql_fetch_assoc($result5)) {
                $LActividades = $LActividades . "&nbsp;&nbsp;<img src= '../images/iActividad4.gif' alt='Actividad' border='0'"
                        . "style='width: auto; height: 12px;'/>&nbsp;" . $rowEmp5['nombre'] . "<br/>";
            }
            $LActividades = $LActividades . "</p>";
        } else {
            $planificado = 0;
        }
    }

    // comprobamos que no se haya planificado la siguiente iteracion de una fase NUEVA
    if ($nombreFAct == "Transicion") {
        
    } elseif ($numeroIAct == $iteracionMax) {
        if ($nombreFAct == "Inicio") {
            $faseNext = "Elaboracion";
        } else if ($nombreFAct == "Elaboracion") {
            $faseNext = "Construccion";
        } else {
            $faseNext = "Transicion";
        }
        $result6 = mysql_query("SELECT idFase FROM Fase WHERE\n"
                        . "Proyecto_idProyecto = \"" . $_SESSION['proyectoEscogido'] . "\""
                        . "AND nombre ='" . $faseNext . "'");
        $totEmp6 = mysql_num_rows($result6);

        if ($totEmp6 == 1) {
            while ($rowEmp6 = mysql_fetch_assoc($result6)) {
                $idFNext = $rowEmp6['idFase'];
            }
        }

        // comprobamos si tienes iteraciones la fase siguiente
        $result6 = mysql_query("SELECT idIteracion FROM Iteracion WHERE\n"
                        . "Fase_idFase = \"" . $idFNext . "\" AND numero = 1");
        $totEmp6 = mysql_num_rows($result6);

        if ($totEmp6 > 0) { // Si ai iteraciones definidias para la fase siguiente
            $FNextVacia = 0; // la fase siguiente SI tiene iteraciones
            while ($rowEmp6 = mysql_fetch_assoc($result6)) {
                $idIFNext = $rowEmp6['idIteracion']; // id iteracion nueva de fase NUEVA
            }
        } else { // aun no ai iteraciones definidas en la fase siguiente
            $FNextVacia = 1;
        }
        if (FNextVacia == 0) { // si ai iteracion en la fase siguiente, comprobamos  si esta planificada
            //comprobamos si tiene Actividades
            $result5 = mysql_query("SELECT nombre FROM Actividad WHERE\n"
                            . "Iteracion_idIteracion = \"" . $idIFNext . "\"");


            $totEmp5 = mysql_num_rows($result5);

            if ($totEmp5 > 0) {
                $planificado = 1;
                $LActividades = "<p><b>Listado de actividades planificadas:</b> <br/>";
                while ($rowEmp5 = mysql_fetch_assoc($result5)) {
                    $LActividades = $LActividades . "&nbsp;&nbsp;<img src= '../images/iActividad4.gif' alt='Actividad' border='0'"
                            . "style='width: auto; height: 12px;'/>&nbsp;" . $rowEmp5['nombre'] . "<br/>";
                }
                $LActividades = $LActividades . "</p>";
            } else {
                $planificado = 0;
            }
        }
    }// Fin estamos en la iteracion maxima
}// Fin de FinProyecto= 0
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "Http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
        <title>[SIGESTPROSO]-Seguimiento Integrado de la GEStion Temporal de PROyectos de SOftware</title>

        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script src="../Utiles/jquery.min.js"></script>
        <script src="../Utiles/jquery-ui.min.js"></script>
        <script src="../Utiles/jquery.ui.datepicker-es.js"></script>

        <link rel="stylesheet" type="text/css" href="../stylesheet.css" media="screen, projection, tv " />
        <script type="TEXT/JAVASCRIPT">
            var contador = -1;
            var trabAsignado = 0;
            function anadir(x){
                var predec = "";
                for (i=0;i<=contador;i++) {
                    if(eval("document.formulario.OP"+i+".checked") == true){
                        predec = predec + (eval("document.formulario.OP"+i+".value")) + "[BRK]";
                    }
                }
                if(document.getElementById("actividad").value==""
                    || document.getElementById("RolActividad").value== "-1"){
                    alert("Escoja un rol y/o escoja correctamente el nombre de la actividad")
                }else if(document.getElementById("durEstimada").value <= 0){
                    alert("Escoja correctamente la duracion estimada de la actividad")
                }else if( trabAsignado == 0){
                    alert("Escoja al menos 1 trabajador para la actividad")
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
                            if(xmlhttp.responseText== 1){
                                var frase = "ERROR: ";
                                alert(frase +"las fechas estimadas de la actividad coinciden con las vacaciones de alguno de los trabajadores asociados a la misma.\n\n--Vuelva a definir esta ultima actividad.");
                                document.getElementById("durEstimada").value="";
                                document.getElementById("TrabAct").style.display="none";
                                document.getElementById("predecesoras").style.display="none";
                                document.getElementById('RolActividad').disabled=false;
                                document.getElementById("RolActividad").value="-1";
                                document.getElementById("terminar").style.display="inline";
                            }else{
//                                alert(xmlhttp.responseText);
                            var data = xmlhttp.responseText.split ( "[BRK]" );
                            //        document.getElementById("SelecPers").innerHTML=data[0];
                            document.getElementById("actividad").value="";
                            document.getElementById("durEstimada").value="";
                            document.getElementById("actividadesAsig").innerHTML=data[0];
                            document.getElementById("actividadesAsig").style.display="inline";
                            document.getElementById("TrabAct").style.display="none";
                            document.getElementById("predecesoras").style.display="none";
                            document.getElementById('RolActividad').disabled=false;
                            document.getElementById("RolActividad").value="-1";
                            document.getElementById("terminar").style.display="inline";
                            document.getElementById("predecesoras").innerHTML= data[1];
                            trabAsignado = eval(data[2]);
                            contador = contador +1 ;
                            }
                        }
                    }
                    xmlhttp.open("GET","insertarActividad.php?INext="+
                        "<?php echo $idINext; ?>"
                        + "&nombreA=" + document.getElementById("actividad").value
                        + "&duracion=" + document.getElementById("durEstimada").value
                        + "&predec=" + predec
                        + "&primeraI=" + x
                        + "&esPrimera=" + "<?php echo $PrimIter; ?>"
                        + "&rolA=" +document.getElementById("RolActividad").value,true);
                    xmlhttp.send();
                }}


            // segun el ROl sacamos unos trabajadores u otros
            function trabajRol(){
                if(document.getElementById("RolActividad").value == -1){
                    Alert("Seleccione un rol valido")
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
                            document.getElementById("botonAnadir").innerHTML = "<p><center>Cargando datos...<center><img src='../images/enviando.gif' alt='Cargando' width='150px'/></p>";//<-- Aca puede ir una precarga
                        }else if (xmlhttp.readyState==4 && xmlhttp.status==200)
                        {
                            //            alert(xmlhttp.responseText);
                            document.getElementById("TrabAct").innerHTML = xmlhttp.responseText;
                            document.getElementById("TrabAct").style.display="inline";
                            document.getElementById("predecesoras").style.display="table";
                            document.getElementById("botonAnadir").innerHTML =
                                "<br/>Si desea a&ntilde;adir la actividad a la iteraci&oacute;n &nbsp;&nbsp;<input style='margin-left:20px;' type='button' value='A&ntilde;adir' onclick=\"anadir('" +
                                "<?php
if ($PrimIter == 1) {
    echo $idIAct;
} else {
    if ($numeroIAct < $iteracionMax && faseCero == 0) {
        if ($planificado == 1) {
            
        } else {
            echo "-1";
        }
    } else {
        if ($FNextVacia == 1) {
            
        } else {

            if ($planificado == 1) {
                
            } else {
                echo $idIFNext;
            }
        }
    }
}
?>"
                                        + "')\"/>" +
                                        "<br/>Si desea terminar de planificar la iteraci&oacute;n &nbsp;&nbsp;<input style='margin-left:20px; ' id='terminar' type='button' value='Terminar' onclick=\"javascript:location.href = 'planIteracion.php'\"/></p>";


                                }
                            }
                            xmlhttp.open("GET","cargarTrabRol.php?id=" + document.getElementById("RolActividad").value,true);
                            xmlhttp.send();
                        }
                    }
                    // Añadimos iteraciones en la fase siguiente si no tiene
                    function insIterFNext(){
                        if(document.getElementById("NIterFNext").value==""
                            || document.getElementById("NIterFNext").value < 0){
                            alert("El numero introducido no es valido")
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
                                    location.href = "planIteracion.php"
                                }
                            }
                            xmlhttp.open("GET","insertarIteraciones.php?FaseNext="
                                + "<?php echo $idFNext ?>"
                                + "&numIt=" +document.getElementById("NIterFNext").value,true);
                            xmlhttp.send();
                        }}
                    //DIalogo JQuery
                    $(document).ready(function() {
                        $("#dialog").dialog({
                            autoOpen: false,
                            buttons: { "Cancelar": function() {cerrarD()},
                                "Asignar": function() {asignarTrab()}},
                            draggable: false,
                            resizable: false,
                            zIndex: 500,
                            beforeClose: function() {
                                $("#the_lights").fadeTo("slow",0);
                                document.getElementById("the_lights").style.display="none";
                            },
                            width: 455
                        });
                    });

                    function asignarTrab(){
                        if (window.XMLHttpRequest){
                            xmlhttp=new XMLHttpRequest();
                        }
                        else{
                            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange=function(){
                            if(xmlhttp.readyState==1){
                                //Sucede cuando se esta cargando la pagina
                                //document.getElementById("TrabAct").innerHTML = "<p><center>Cargando datos...<center><img src='../images/enviando.gif' alt='Cargando' width='150px'/></p>";//<-- Aca puede ir una precarga
                            }else if (xmlhttp.readyState==4 && xmlhttp.status==200)
                            {
                                //            alert(xmlhttp.responseText);
                                var data = xmlhttp.responseText.split ( "[BRK]" );
                                document.getElementById("TrabAct").innerHTML = data[0];
                                document.getElementById('RolActividad').disabled=true;
                                document.getElementById("the_lights").style.display="none";
                                trabAsignado = eval(data[1]);
                                $("#the_lights").fadeTo("slow",0);
                                document.getElementById("the_lights").style.display="none";
                                $("#dialog").dialog("close");

                            }
                        }
                        xmlhttp.open("GET","insertarTrabActividad.php?id=" + document.getElementById("TrabajadorActividad").value,true);
                        xmlhttp.send();
                    }

                    var disabledDays = [];
                    
                    function selTrab(){
                        if (window.XMLHttpRequest){
                            xmlhttp=new XMLHttpRequest();
                        }
                        else{
                            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange=function(){
                            if(xmlhttp.readyState==1){
                                //Sucede cuando se esta cargando la pagina
                                document.getElementById("botonAnadir").innerHTML = "<p><center>Cargando datos...<center><img src='../images/enviando.gif' alt='Cargando' width='150px'/></p>";//<-- Aca puede ir una precarga
                            }else if (xmlhttp.readyState==4 && xmlhttp.status==200)
                            {
                                //            alert(xmlhttp.responseText);
                                document.getElementById("botonAnadir").innerHTML =
                                    "<br/>Si desea a&ntilde;adir la actividad a la iteraci&oacute;n &nbsp;&nbsp;<input style='margin-left:20px;' type='button' value='A&ntilde;adir' onclick=\"anadir('" +
                                    "<?php
if ($PrimIter == 1) {
    echo $idIAct;
} else {
    if ($numeroIAct < $iteracionMax && faseCero == 0) {
        if ($planificado == 1) {
            
        } else {
            echo "-1";
        }
    } else {
        if ($FNextVacia == 1) {
            
        } else {

            if ($planificado == 1) {
                
            } else {
                echo $idIFNext;
            }
        }
    }
}
?>"
                                    + "')\"/>" +
                                    "<br/>Si desea terminar de planificar la iteraci&oacute;n &nbsp;&nbsp;<input style='margin-left:20px; ' id='terminar' type='button' value='Terminar' onclick=\"javascript:location.href = 'planIteracion.php'\"/></p>";
                                var data = xmlhttp.responseText.split ( "[BRK]" );
                                disabledDays = eval(data[0]);
                                document.getElementById("nomVacas").innerHTML = data[1];
                                document.getElementById("the_lights").style.display="block";
                                $("#the_lights").fadeTo("slow",0.2);
                                jQuery('#datepicker').datepicker( "refresh" );
                                $("#dialog").dialog("open");

                            }
                        }
                        xmlhttp.open("GET","cargarVacaciones.php?id=" + document.getElementById("TrabajadorActividad").value,true);
                        xmlhttp.send();
 
                    }

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

                    jQuery("#dialog").ready(function() {
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
                    function cerrarD(){
                        document.getElementById("the_lights").style.display="none";
                        $("#the_lights").fadeTo("slow",0);
                        document.getElementById("the_lights").style.display="none";
                        $("#dialog").dialog("close");

                    }
                    //$("#dialog").ready(function(){
                    //  $("#the_lights").fadeTo(1,0);
                    ////  $("#turnon").click(function () {
                    ////  });
                    //});

        </script>
        <style>
            #the_lights{
                background-color: #000;
                display: none;
                height: 100%;
                left: 0;
                position: absolute;
                top: 0;
                width: 100%;
            }
            #standout{
                z-index: 1000;
            }
        </style>
    </head>

    <body>
        <form name="formulario" action="" enctype="text/plain">
            <!-- start top menu and blog title-->

            <div id="blogtitle">
    <div id="small">Jefe de proyecto (<u><?php echo $_SESSION['login'] ?></u>) - Planificar iteraci&oacute;n</div>
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
            <div id="page">
                <div id="leftcontent" style="display:inline">
                    <img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />
                    <h3 align="left">Men&uacute;</h3>


                    <div align="left">
                        <ul class="BLUE">
                            <li><a href="../Comun/selecProyecto.php">Seleccionar proyecto</a></li>
                            <li><a href="../JefeProyecto/revisarInformesAct.php">Revisar actividades activas</a></li>
                            <li><a href="#">Planificar iteraci&oacute;n</a></li>
<!--                            Quitad el enlace de la pagina en la que se esta(como aqui planificar iteracion)
                            y añadid el enlace de esta:
                            href="../JefeProyecto/planIteracion.php" -->
                            <li><a href="../JefeProyecto/InformesProyecto.php">Informes</a></li>
                            <li><a href="../Comun/InformesProyectoFinalizado.php">Informes proyectos finalizados</a></li>
                            <li><a href="../Comun/selecVacaciones.php">Escoger vacaciones</a></li>
                        </ul>
                    </div>
                    <!-- You have to modify the "padding-top: when you change the content of this div to keep the footer image looking aligned -->
                    <p><img src= "../images/Logo2.jpg" alt="#" border="0" style="width: 180px; height: auto;"/></p>
                    <img style="padding-top:2px; margin-left:-12px; margin-bottom:-4px;" src="../images/specs_bottom.jpg" alt="" />

                </div>
                <!-- end left box-->

                <!-- start content -->

                <div id="centercontent">


                    <h1>SIGESTPROSO</h1>
                    <p><br /></p>

                    <p><a href="#"><?php echo utf8_decode($nombreP) ?></a> - <?php echo utf8_decode($descripcionP) ?></p><br/>
                    <div id="personalDentro" class="centercontentleft" style="width:auto; height:auto; font-size: 15px; float: right">
                        <b>Fase actual:</b>
                        &nbsp; <i><?php echo utf8_decode($nombreFAct) ?></i>
                        <br/>&nbsp;&nbsp;<small> Duraci&oacute;n estimada (<?php echo $festIFAct . "&nbsp;&nbsp;al&nbsp;&nbsp;" . $festFFAct ?>)</small><br/>
                        <span id="listadoPer" style="display:inline"><br/><b>Iteracion actual:</b> <?php
                    if ($faseCero == 1) {
                        echo "<small>No hay iteraciones en esta fase</small>";
                    } else {
                        echo $numeroIAct . " de " . $iteracionMax;
                    } ?></span>
                        <br/>
                        <p id="actividadesAsig" style="color: black; display:none"></p>
                    </div>
                    <?php
                    if ($casiFinP == 1) {
                        //Estamos en la ultima Iteracion de TOODO el proyecot
                        echo "<p>La iteraci&oacute;n actual es la <b>&uacute;ltima del proyecto</b>, no puede seguir planificando";
                    } else {
                        if ($PrimIter == 1) { // esla primera iteracion del proyecto
                            echo "<p style='color:black'>Se dispone a planificar la primera iteraci&oacute;n <b>(" . $numeroIAct . ")</b> del proyecto</p>";
                            echo "<p>Nombre de la actividad <input type='text' id='actividad'/><br/><br/>";
                            echo "Indique una duraci&oacute;n estimada a la actividad <input type='text' id='durEstimada' size='5' maxlength='5'/><small> Horas Hombre</small><br/><br/>";
                            echo "Asocie un rol a la actividad<br/> " . utf8_decode($rolesDisponibles) . "<br/>";
                            echo "</p>";
                            echo "<br/><div id='TrabAct' style='display:none'></div>";
                            echo "<br><span id='predecesoras' sytle='display:none; border: solid black;'></span>";
                            echo "<div id='botonAnadir'>";
                            echo "<br/>Si desea a&ntilde;adir la actividad a la iteraci&oacute;n &nbsp;&nbsp;<input style='margin-left:20px;' type='button' value='A&ntilde;adir' onclick=\"anadir('" . $idIAct . "')\"/>";
                            echo "<br/>Si desea terminar de planificar la iteraci&oacute;n &nbsp;&nbsp;<input style='margin-left:20px;' id='terminar' type='button' value='Terminar' onclick=\"javascript:location.href = 'planIteracion.php'\"/></p>";
                            echo "</div>";
                        } else {
                            if ($numeroIAct < $iteracionMax && faseCero == 0) {
                                if ($planificado == 1) {
                                    echo "<p style=\"color:red;\"> Ya ha planificado la siguiente iteraci&oacute;n, no podr&aacute;
                planificar mas iteraciones hasta que haya finalizado la iteraci&oacute;n actual</p>" . utf8_decode($LActividades);
                                } else {
 ?>

                    <?php
                                    echo "<p style='color:black'>Se dispone a planificar la iteraci&oacute;n <b>(" . $numeroINext . ")</b> de esta misma fase</p>";
                                    echo "<p>Nombre de la actividad <input type='text' id='actividad'/><br/><br/>";
                                    echo "Indique una duraci&oacute;n estimada a la actividad <input type='text' id='durEstimada' size='5' maxlength='5'/><small> Horas Hombre</small><br/><br/>";
                                    echo "Asocie un rol a la actividad<br/> " . utf8_decode($rolesDisponibles) . "<br/>";
                                    echo "</p>";
                                    echo "<br/><div id='TrabAct' style='display:none'></div>";
                                    echo "<br><span id='predecesoras' sytle='display:none; border: solid black;'></span>";
                                    echo "<div id='botonAnadir'>";
                                    echo "<br/>Si desea a&ntilde;adir la actividad a la iteraci&oacute;n &nbsp;&nbsp;<input style='margin-left:20px;' type='button' value='A&ntilde;adir' onclick=\"anadir('-1')\"/>";
                                    echo "<br/>Si desea terminar de planificar la iteraci&oacute;n &nbsp;&nbsp;<input style='margin-left:20px;'  id='terminar' type='button' value='Terminar' onclick=\"javascript:location.href = 'planIteracion.php'\"/></p>";
                                    echo "</div>";
                    ?>

                    <?php
                                }
                            } else {
                                if ($FNextVacia == 1) {// si cambiamos de fase Y no ai iteraciones creadas
                                    echo "<p>La siguiente iteraci&oacute;n pertenece a la fase siguiente <b>(" . utf8_decode($faseNext) . ")</b></p>"
                                    . "<p style='color:red'>A&uacute;n no ha escogido el n&uacute;mero de iteraciones del que constar&aacute; la fase siguiente</p>"
                                    . "<p>Especifique el n&uacute;mero de iteraciones de la fase <b>" . utf8_decode($faseNext) . "</b>"
                                    . "  <input type='text' id='NIterFNext' size='2' maxlength='2'/>"
                                    . "<br/><br/><input type='button' value='Confirmar' onclick='insIterFNext()'/>"
                                    . "</p>";
                                } else {

                                    if ($planificado == 1) {
                                        echo "<p style=\"color:red;\"> Ya ha planificado la siguiente iteraci&oacute;n, no podr&aacute;"
                                        . " planificar mas iteraciones hasta que haya finalizado la iteraci&oacute;n actual</p>" . $LActividades;
                                    } else {

                                        echo "<p style='color:black'>Se dispone a planificar la primera iteraci&oacute;n <b>(1)</b> de la fase siguiente (" . utf8_decode($faseNext) . ")</p>";
                                        echo "<p>Nombre de la actividad <input type='text' id='actividad'/><br/><br/>";
                                        echo "Indique una duraci&oacute;n estimada a la actividad <input type='text' id='durEstimada' size='5' maxlength='5'/><small> Horas Hombre</small><br/><br/>";
                                        echo "Asocie un rol a la actividad<br/> " . utf8_decode($rolesDisponibles) . "<br/>";
                                        echo "</p>";
                                        echo "<br/><div id='TrabAct' style='display:none'></div>";
                                        echo "<br><span id='predecesoras' sytle='display:none; border: solid black;'></span>";
                                        echo "<div id='botonAnadir'>";
                                        echo "<br/>Si desea a&ntilde;adir la actividad a la iteraci&oacute;n &nbsp;&nbsp;<input style='margin-left:20px;' type='button' value='A&ntilde;adir' onclick=\"anadir('" . $idIFNext . "')\"/>";
                                        echo "<br/>Si desea terminar de planificar la iteraci&oacute;n &nbsp;&nbsp;<input style='margin-left:20px; '  id='terminar' type='button' value='Terminar' onclick=\"javascript:location.href = 'planIteracion.php'\"/></p>";
                                        echo "</div>";
                                    }
                                }
                            }
                        }
                    }//Fin casiFin
                    ?>
                            <div id = "standout">
                                <div id="dialog" title="Calendario de vacaciones">
                                    <span id="nomVacas" style="padding-bottom:10px; padding-top:5px; display:block;"></span>
                                    <div type="text" id="datepicker"></div>
                                    <br/><br/><center>&#191;Desea asignar este trabajador a esta actividad&#63;</center>
                                </div>
                            </div>

                        </div>
                    </div>



                    <div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>


                    </div>

                    <!-- end footer -->
<?php $conexion->cerrarConexion(); ?>

        </form>
        <div id='the_lights'></div>
    </body>
</html>