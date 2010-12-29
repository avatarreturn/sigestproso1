<?php session_start();

$F1I = $_GET['1I'];
$F1F = $_GET['1F'];
$F2I = $_GET['2I'];
$F2F = $_GET['2F'];
$F3I = $_GET['3I'];
$F3F = $_GET['3F'];
$F4I = $_GET['4I'];
$F4F = $_GET['4F'];
$nI = $_GET['nI']; // numero de iteraciones
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
         
         //buscamos ID de la fase
         
         $result5 = mysql_query("SELECT idFase FROM Fase WHERE\n"
    . "Proyecto_idProyecto = \"".$_SESSION['proyectoEscogido']."\"\n"
    . "AND nombre= \"Inicio\"");

        $totEmp5 = mysql_num_rows($result5);

        if ($totEmp5 ==1) {
            while ($rowEmp5 = mysql_fetch_assoc($result5)) {
                $faseID = $rowEmp5['idFase'];
                
            }
        }
         //Insertamos iteraciones en inicio
         for ($i = 1; $i <= $nI; $i++) {
         $result= mysql_query("INSERT INTO Iteracion VALUES(NULL,'"
                    . $faseID."','"
                    . $i."',NULL,NULL)");
         }
        



            echo  utf8_encode("OK");
        $conexion->cerrarConexion();

?>
