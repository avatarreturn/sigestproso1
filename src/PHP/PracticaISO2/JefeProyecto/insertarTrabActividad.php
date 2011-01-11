<?php session_start();
$id = $_GET['id'];

$_SESSION['trabActividad'][] = $id;


include_once('../Persistencia/conexion.php');
        $conexion = new conexion();

        $result = mysql_query(
                "SELECT t.nombre as name, t.apellidos as app, p.Trabajador_dni as dni, r.nombre as rol \n"
    . "FROM TrabajadorProyecto p, Trabajador t, Rol r WHERE\n"
    . "p.Proyecto_idProyecto = '".$_SESSION['proyectoEscogido']."'\n"
    . "AND \n"
    . "t.dni = p.Trabajador_dni\n"
    . "AND\n"
    . "r.idRol= p.Rol_idRol\n"
    . "AND\n"
    . "(SELECT l.categoria FROM Rol l WHERE l.idRol='".$_SESSION['rolAct']."') >= r.categoria");


        $salida = "<p>Asigne uno o varios trabajadores a la actividad<br/>";
        $totEmp = mysql_num_rows($result);

        if ($totEmp >0) {
        $salida = $salida . "<select id='TrabajadorActividad' onchange='selTrab()'><option value='-1'>- Escoja un Trabajador -</option>";
            while ($rowEmp = mysql_fetch_assoc($result)) {
                if(in_array($rowEmp['dni'], $_SESSION['trabActividad'])){
                  $salida = $salida . "<option disabled='disabled' value='".$rowEmp['dni']."'>". $rowEmp['name']." ". $rowEmp['app']." (".$rowEmp['rol'] .")</option>";}
                else{//
                   $salida = $salida . "<option value='".$rowEmp['dni']."'>". $rowEmp['name']." ". $rowEmp['app']." (".$rowEmp['rol'] .")</option>";}
                }
                $salida = $salida ."</select><br/><br/>";

        }else{
            $salida = $salida . "<span style='color:red'>No existen trabajadores asociados a este proyecto con el rol escogido</span><br/><br/>";
        }
       $salida = $salida . "Indique una duraci&oacute;n estimada a la actividad <input type='text' id='durEstimada' size='5' maxlength='5'/><small> Horas Hombre</small></p>";

                $conexion->cerrarConexion();
        echo utf8_encode($salida);


?>
