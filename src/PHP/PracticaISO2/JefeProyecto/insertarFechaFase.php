<?php session_start();

$F1I = $_GET['1I'];
$F1F = $_GET['1F'];
$F2I = $_GET['2I'];
$F2F = $_GET['2F'];
$F3I = $_GET['3I'];
$F3F = $_GET['3F'];
$F4I = $_GET['4I'];
$F4F = $_GET['4F'];
$Objetivo = "Futuro óbjetivo";
include_once('../Persistencia/conexion.php');
        $conexion = new conexion();

        //Insertamos fechas en fase de inicio
         $result1= mysql_query("INSERT INTO Fase VALUES(NULL,'"
                    . $_SESSION['proyectoEscogido']."','"
                    . "Inicio','"
                    . utf8_decode($Objetivo)."','"
                    . $F1I."','"
                    . $F1F."',NULL,NULL)");

         //Insertamos fechas en fase de inicio
         $result2= mysql_query("INSERT INTO Fase VALUES(NULL,'"
                    . $_SESSION['proyectoEscogido']."','"
                    . "Elaboracion','"
                    . $Objetivo."','"
                    . $F2I."','"
                    . $F2F."',NULL,NULL)");

         //Insertamos fechas en fase de inicio
         $result3= mysql_query("INSERT INTO Fase VALUES(NULL,'"
                    . $_SESSION['proyectoEscogido']."','"
                    . "Construccion','"
                    . $Objetivo."','"
                    . $F3I."','"
                    . $F3F."',NULL,NULL)");

         //Insertamos fechas en fase de inicio
         $result4= mysql_query("INSERT INTO Fase VALUES(NULL,'"
                    . $_SESSION['proyectoEscogido']."','"
                    . "Transicion','"
                    . $Objetivo."','"
                    . $F4I."','"
                    . $F4F."',NULL,NULL)");
        



            echo  utf8_encode("OK");
        $conexion->cerrarConexion();

?>
