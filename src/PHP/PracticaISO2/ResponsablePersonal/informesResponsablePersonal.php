<?php
session_start();
$login = $_SESSION['tipoUsuario'];
if ($login != "R") {
    header("location: ../index.php");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
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
        <link rel="stylesheet" type="text/css" href="estiloTablas.css"/>

        <?php
        include_once("../Utiles/funciones.php");

        include_once ('../Persistencia/conexion.php');
        $conexion = new conexion();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////// INICIO INFORMES DE LA ULTIMA SEMANA ///////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //Calculamos el lunes de la semana actual
        $semana = semanaActual();


        /////////////////Esta es la consulta que tengo que poner////////////////////////////
        //
        //
        //SELECT t.dni, t.nombre, t.apellidos, i.idInformeTareas, ta.idTareaPersonal, ta.horas, c.descripcion, p.nombre proyecto
        //FROM trabajador t, informetareas i, tareapersonal ta, catalogotareas c, actividad a, iteracion it, fase f, proyecto p
        //WHERE (i.semana='2011-01-10') AND (t.dni=i.Trabajador_dni)
        //      AND (ta.CatalogoTareas_idTareaCatalogo=c.idTareaCatalogo)
        //      AND (i.idInformeTareas=ta.InformeTareas_idInformeTareas)
        //      AND (i.Actividad_idActividad=a.idActividad)
        //      AND (a.Iteracion_idIteracion=it.idIteracion)
        //      AND (it.Fase_idFase=f.idFase)
        //      AND (f.Proyecto_idProyecto=p.idProyecto)
        //ORDER BY t.nombre
        /////////////////////////////////////////////////////////////////////////////////////

        $result = mysql_query('SELECT t.dni, t.nombre, t.apellidos, i.idInformeTareas, ta.idTareaPersonal, ta.horas, c.descripcion, p.idProyecto, p.nombre proyecto FROM trabajador t, informetareas i, tareapersonal ta, catalogotareas c, actividad a, iteracion it, fase f, proyecto p where (i.semana=\'' . $semana . '\') AND (t.dni=i.Trabajador_dni) AND (ta.CatalogoTareas_idTareaCatalogo=c.idTareaCatalogo) AND (i.idInformeTareas=ta.InformeTareas_idInformeTareas) AND (i.Actividad_idActividad=a.idActividad) AND (a.Iteracion_idIteracion=it.idIteracion) AND (it.Fase_idFase=f.idFase) AND (f.Proyecto_idProyecto=p.idProyecto) ORDER BY t.nombre;');

        $totTraProy = mysql_num_rows($result);
        if ($totTraProy > 0) {
            $trabajador = "";
            $dniAnterior = "";
            $proyAnterior = "";
            $arrayDnis[] = "";
            $arrayProy;
            $cont = 1;
            $cont2 = 1;
            $sumaHoras = 0;
            $contD[] = 0;   //Array que almacena el numero de veces que aparece cada DNI
            while ($rowEmp = mysql_fetch_assoc($result)) { //recorro la matriz resultado
                $tabla[$cont2] = $rowEmp;
                if ($rowEmp['dni'] != $dniAnterior) {       //
                    //
                    array_push($contD, 1);                  // añado un elemento más al array de contadores por cada dni distinto que aparezca
                    array_push($arrayDnis, $rowEmp['dni']); // añado un elemento más al array de dni's por cada dni distinto que aparezca
                    $dniAnterior = $rowEmp['dni'];          //
                } else {
                    $contD[count($contD) - 1]++;            // sumo uno en el elemento correspondiente del array de contadores
                }

                if ($rowEmp['proyecto'] != $proyAnterior) {
                    $arrayProy[$rowEmp['proyecto']] = 0;
                    $proyAnterior = $rowEmp['proyecto'];
                }

                $cont2++;
            }
            for ($i = 1; $i < count($contD); $i++) {    //aqui empiezo a imprimir los resultados
                $sumaHoras = 0;
                $dni = $tabla[$cont]['dni'];
                $trabajador = $trabajador . "<a href='#' onclick=\"ocultarR('oculto" . $i . "')\">"
                        . "<img src= '../images/iJefeProyecto.gif' alt='#' border='0' style='width: auto; height: 12px;'/>"
                        . "&nbsp;&nbsp;" . $tabla[$cont]['nombre'] . " " . $tabla[$cont]['apellidos'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $tabla[$cont]['dni'] . "</a>"
                        . "<br/><div id=\"oculto" . $i . "\" style=\"display:none\">";
                if (vacacionesSiNo($tabla[$cont]['dni'], $semana)) { // si el trabajador esta de vacaciones le pongo un solito al lado
                    $trabajador = $trabajador . "<table class=\"tablaVariable\"><tr><td><label>Esta de vacaciones</label></td></a></tr></table>";
                }

                $arrayProyCopia = $arrayProy; //Utilizo una copia del original por que el foreach se lia con los punteros internos del array

                for ($j = $contD[$i]; $j >= 1; $j--) {
//                    $trabajador = $trabajador . "<a href='#'><table class=\"tablaVariable\"><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/iTarea.png' alt='Actividad' border='0' style='width: auto; height: 12px;'>"
//                            . "</img>&nbsp;&nbsp;&nbsp;&nbsp;<label>" . utf8_encode($tabla[$cont]['descripcion']) . " </label></td><td><label>" . $tabla[$cont]['horas'] . " horas</label></td></a></tr></table>";

                    $cont++;
                    $sumaHoras = $sumaHoras + $tabla[$cont - 1]['horas'];
                    $arrayProyCopia[$tabla[$cont - 1]['proyecto']] = $arrayProyCopia[$tabla[$cont - 1]['proyecto']] + $tabla[$cont - 1]['horas'];
                }
                $trabajador = $trabajador . "<table>";
                foreach ($arrayProyCopia as $proy => $horas) {
                    if ($horas != 0) {
                        //consulta para la participacion en el proyecto
                        $resPar = mysql_query('SELECT porcentaje  FROM trabajadorproyecto WHERE Trabajador_dni = \'' . $dni . '\' AND Proyecto_idProyecto=(select idProyecto from proyecto where nombre=\'' . $proy . '\')');
                        $rowPar = mysql_fetch_assoc($resPar);
                        //fin consulta participacion
                        $trabajador = $trabajador . "<tr><td><a><label>Proyecto: " . $proy . "</label></a></td><td><a><label>&nbsp;&nbsp;&nbsp;&nbsp;Participaci&oacute;n: " . $rowPar[porcentaje] . "%<label></a></td><td><a><label>&nbsp;&nbsp;&nbsp;&nbsp;Horas: " . $horas . "</label></a></td></tr>";
                    }
                }
                $trabajador = $trabajador . "<tr><td><a><label>Horas totales: " . $sumaHoras . "</label></a></td></tr></table><br/></div>";
            }

            //aqui calculo los trabajadores sin informacion de horas trabajadas
            $sql = "select dni, nombre, apellidos from trabajador where";
            if (count($arrayDnis) > 1) { //si el array de dni encontrados tiene contenido
                $sql = $sql . " (dni != '" . $arrayDnis[1] . "')"; //excluyo de la consulta el primer dni
                for ($i = 1; $i < count($arrayDnis); $i++) {    //repito para cada dni
                    $sql = $sql . " and (dni != '" . $arrayDnis[$i] . "')"; //para excluir de la consulta los dni ya encontrados
                }
                $sql = $sql . ";"; //cierro la consulta sql
            }
            $result = mysql_query($sql);
            $restoTrabaj = "";
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $restoTrabaj = $restoTrabaj . "<a href='#' onclick=\"ocultarR('oculto" . $rowEmp['dni'] . "')\">"
                        . "<img src= '../images/iJefeProyecto.gif' alt='#' border='0' style='width: auto; height: 12px;'/>"
                        . "&nbsp;&nbsp;" . $rowEmp['nombre'] . " " . $rowEmp['apellidos'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $rowEmp['dni'] . "</a>";


                if (vacacionesSiNo($rowEmp['dni'], $semana)) {
                    $intervVaca = vacacionesPeriodo($rowEmp['dni'], $semana);
                    $restoTrabaj = $restoTrabaj . "<a href='#'>&nbsp;&nbsp;<img src= '../images/vacaciones.jpg' alt='#' border='0' style='width: auto; height: 12px;'/></a>"
                            . "<div id=\"oculto" . $rowEmp['dni'] . "\" style=\"display:none\"><br/><a><label>Est&aacute; de vacaciones desde el dia " . $intervVaca['fechaInicio'] . " hasta el dia " . $intervVaca['fechaFin'] . "</label></a></div>";
                }
                $restoTrabaj = $restoTrabaj . "<br/>";
            }
        } else {        ///si no hay ningun trabajador con datos de tareas realizadas para esta semana
            $sql = "select dni, nombre, apellidos from trabajador;";
            $result = mysql_query($sql);
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $restoTrabaj = $restoTrabaj . "<a href='#' onclick=\"ocultarR('oculto" . $rowEmp['dni'] . "')\">"
                        . "<img src= '../images/iJefeProyecto.gif' alt='#' border='0' style='width: auto; height: 12px;'/>"
                        . "&nbsp;&nbsp;" . $rowEmp['nombre'] . " " . $rowEmp['apellidos'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $rowEmp['dni'] . "</a>";


                if (vacacionesSiNo($rowEmp['dni'], $semana)) {
                    $intervVaca = vacacionesPeriodo($rowEmp['dni'], $semana);
                    $restoTrabaj = $restoTrabaj . "<a href='#'>&nbsp;&nbsp;<img src= '../images/vacaciones.jpg' alt='#' border='0' style='width: auto; height: 12px;'/></a>"
                            . "<div id=\"oculto" . $rowEmp['dni'] . "\" style=\"display:none\"><br/><a><label>Est&aacute; de vacaciones desde el dia " . $intervVaca['fechaInicio'] . " hasta el dia " . $intervVaca['fechaFin'] . "</label></a></div>";
                }
                $restoTrabaj = $restoTrabaj . "<br/>";
            }
        }
//        require('../Utiles/fpdf.php');
//        $pdf = new FPDF();
//        $pdf->AddPage();
//        $pdf->SetFont('Arial', 'B', 16);
//        for ($i = 1; $i <= count($tabla); $i++) {
//            $pdf->Cell(40, 10, $tabla[$i]['nombre']." ".$tabla[$i]['apellidos']." ".$tabla[$i]['proyecto']);
//        }
//        $pdf->Output();
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////// FIN INFORMES DE LA ULTIMA SEMANA ///////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
            function conmutar(x){

                if (x=="listaTrabajadores"){
                    document.getElementById(x).style.display="inline";
                    document.getElementById("listaTrabajadoresIntervalo").style.display="none";
                }
                if (x=="listaTrabajadoresIntervalo"){
                    document.getElementById(x).style.display="inline";
                    document.getElementById("listaTrabajadores").style.display="none";
                }
            }

            function recarga(){

                if (document.obtenerInformes.trabajador.value==0){
                    alert("Tiene que elegir un tabajador")
                    document.obtenerInformes.trabajador.focus()
                    return 0;
                }

                //alert(document.getElementById("trabajador").value);
                // formar fecha
                var fechaI;var fechaF; //coger los datos del formulario y hacer el string para cada fecha
                fechaI=document.obtenerInformes.anioi.value+"-"+document.obtenerInformes.mesi.value+"-"+document.obtenerInformes.diasi.value

                fechaF=document.obtenerInformes.aniof.value+"-"+document.obtenerInformes.mesf.value+"-"+document.obtenerInformes.diasf.value

                //..........
                var FechaVal = new Date();
                FechaVal.setTime(Date.parse(fechaF));
                //alert(disabledDaysVal[i]);
                var FechaVal2 = new Date();
                FechaVal2.setTime(Date.parse("<?php echo date("Y-m-d")?>"))

                var FvalF = FechaVal.getTime();
                var Hoy = FechaVal2.getTime();

//                alert(FechaVal+" "+FechaVal2);

                if (FvalF > Hoy){
                   alert("La fecha final no puede ser superior a la fecha actual");
                   document.obtenerInformes.diasf.focus()
                   return 0
                }

                if (window.XMLHttpRequest){
                    xmlhttp=new XMLHttpRequest();
                }
                else{
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function(){
                    if(xmlhttp.readyState==1){
                        //Sucede cuando se esta cargando la pagina
                        //
                        //mete la imagen de cargando
                        //            document.getElementById("enviando").innerHTML = "<p><center>Enviando<center><img src='../images/enviando.gif' alt='Enviando' width='150px'/></p>";//<-- Aca puede ir una precarga
                    }else if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    {
                        //alert(xmlhttp.responseText);
                        document.getElementById("listaRegargable").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET","informesPersIntervalo.php?dni=" + document.getElementById("trabajador").value
                    + "&fechaI=" + fechaI
                    + "&fechaF=" + fechaF,true);
                xmlhttp.send();
            }
        </script>

    </head>

    <body>

        <div id="blogtitle">
            <div id="small">Responsable de Personal (<u><?php echo $_SESSION['login'] ?></u>) - Informes</div>
            <div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
        </div>
        <div id="page">
            <div id="topmenu">


                <ul class="BLUE">
                    <li><a href="#" onclick="conmutar('listaTrabajadores')" title="Informes ultima semana"><span>Ultima semana</span></a></li>
                    <li><a href="#" onclick="conmutar('listaTrabajadoresIntervalo')" title="Informes intervalo de tiempo"><span>Elegir intervalo</span></a></li>
                </ul>
            </div>

            <!-- end top menu and blog title-->

            <div id="leftcontent">
                <img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />

                <h3 align="left">Men&uacute;</h3>


                <div align="left">
                    <ul class="BLUE">
                        <li><a href="iniResponsablePersonal.php">Crear trabajadores</a></li>
                        <li><a href="seguimientoPersonal.php">Seguimiento Personal</a></li>
                        <li><a href="informesResponsablePersonal.php">Informes</a></li>
                    </ul>
                </div>


                <p><img src= "../images/Logo2.jpg" alt="#" border="0" style="width: 180px; height: auto;"/></p>


                <!-- You have to modify the "padding-top: when you change the content of this div to keep the footer image looking aligned -->

                <img style="padding-top:2px; margin-left:-12px; margin-bottom:-4px;" src="../images/specs_bottom.jpg" alt="" />



            </div>

            <!-- start content -->

            <div id="centercontent">


                <h1>SIGESTPROSO </h1>
                <p><br /></p>
                <p>
                <table>
                    <tr>
                        <td>
                            <div id="formulario">
                                <form action="" method="POST" name="obtenerInformes">
                                    <div class="tituloFormulario">
                                        <h2>Informes</h2>
                                    </div>
                                    <div class="infoFormulario">
		A trav&eacute;s de esta pantalla el Responsable de Personal podr&aacute; obtener informacion acerca de la participaci&oacute;n en proyectos y las vacaciones de cada trabajador.
                                    </div>
                                    <div id="listaTrabajadores" class="centercontentleft">
                                        <?php
                                        echo $trabajador;
                                        ?>
                                        <br/>

                                        <a href="#"><label>Trabajadores sin informacion esta semana: </label></a>
                                        <br/><br/>
                                        <?php
                                        echo utf8_decode($restoTrabaj);
                                        ?>
                                    </div>
                                    <div id="listaTrabajadoresIntervalo" style="display: none">
                                        <table>
                                            <tr>
                                                <td>
                                                    <div>
                                                        <select id="trabajador" name="trabajador" size="1">
                                                            <option value="0">Seleccione un trabajador</option>
                                                            <?php
                                                            $conexion = new conexion();
                                                            $result = mysql_query('select nombre, apellidos, dni from Trabajador order by nombre;');
                                                            while ($rowEmp = mysql_fetch_assoc($result)) {
                                                                echo "<option value=\"" . $rowEmp['dni'] . "\">" . utf8_decode($rowEmp['nombre']) . " " . utf8_decode($rowEmp['apellidos']) . " " . $rowEmp['dni'] . "</option>";
                                                            }
                                                            $conexion->cerrarConexion();
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table>
                                            <tr>
                                                <td>
                                                    <label>Desede el d&iacute;a:</label>
                                                </td>
                                                <td>
                                                    <div>
                                                        <?php
                                                            echo '<select id="diasi" name="diasi" size="1">';
                                                            echo '<option value="0">D&iacute;a</option>';
                                                            for ($i = 1; $i <= 31; $i++) {
                                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                                            }
                                                            echo '</select>';
                                                        ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <select name="mesi" size="1">
                                                                <option value="0">Mes</option>
                                                                <option value="1">Enero</option>
                                                                <option value="2">Febrero</option>
                                                                <option value="3">Marzo</option>
                                                                <option value="4">Abril</option>
                                                                <option value="5">Mayo</option>
                                                                <option value="6">Junio</option>
                                                                <option value="7">Julio</option>
                                                                <option value="8">Agosto</option>
                                                                <option value="9">Septiembre</option>
                                                                <option value="10">Octubre</option>
                                                                <option value="11">Noviembre</option>
                                                                <option value="12">Diciembre</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td
                                                        <div>
                                                            <?php
                                                            echo '<select name="anioi" size="1">';
                                                            echo '<option value="0">A&ntilde;o</option>';
                                                            $fecha = getdate();
                                                            $anio = $fecha[year];
                                                            for ($i = 2000; $i <= $anio; $i++) {
                                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                                            }
                                                            ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Hasta el d&iacute;a:</label>
                                                </td>
                                                <td>
                                                    <div>
                                                        <?php
                                                            echo '<select name="diasf" size="1">';
                                                            echo '<option value="0">D&iacute;a</option>';
                                                            for ($i = 1; $i <= 31; $i++) {
                                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                                            }
                                                            echo '</select>';
                                                        ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <select name="mesf" size="1">
                                                                <option value="0">Mes</option>
                                                                <option value="1">Enero</option>
                                                                <option value="2">Febrero</option>
                                                                <option value="3">Marzo</option>
                                                                <option value="4">Abril</option>
                                                                <option value="5">Mayo</option>
                                                                <option value="6">Junio</option>
                                                                <option value="7">Julio</option>
                                                                <option value="8">Agosto</option>
                                                                <option value="9">Septiembre</option>
                                                                <option value="10">Octubre</option>
                                                                <option value="11">Noviembre</option>
                                                                <option value="12">Diciembre</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td
                                                        <div>
                                                            <?php
                                                            echo '<select name="aniof" size="1">';
                                                            echo '<option value="0">A&ntilde;o</option>';
                                                            $fecha = getdate();
                                                            $anio = $fecha[year];
                                                            for ($i = 2000; $i <= $anio; $i++) {
                                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                                            }
                                                            ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input name="ver_informe" value="Ver" type="button" class="submit" onclick="recarga()" />
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="centercontentleft" id="listaRegargable">


                                        </div>
                                    </div>


                                    </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <a href='#'>&nbsp;&nbsp;<img src= '../images/vacaciones.jpg' alt='#' border='0' style='width: auto; height: 12px;'/></a>
                                            <label>Este trabajador est&aacute; de vacaciones en este momento</label>
                                        </td>
                                    </tr>
                                    </table>

                            </div>
                            <br>

                            </form>
                            </div>
                            </div>
                            </div>


                            <!-- end content -->
                            <!-- start footer -->

                            <div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>




                            </div>

                            <!-- end footer -->




                            </body>
                            </html>

