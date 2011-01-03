<?php session_start();

$F1I = $_GET['1I'];
$F2I = $_GET['2I'];
$F3I = $_GET['3I'];
$F4I = $_GET['4I'];
$F4F = $_GET['4F'];
$nI = $_GET['nI']; // numero de iteraciones



$F1F = date("Y-m-d",strtotime(date("Y-m-d", strtotime($F2I)) . " -1 day"));
$F2F = date("Y-m-d",strtotime(date("Y-m-d", strtotime($F3I)) . " -1 day"));
$F3F = date("Y-m-d",strtotime(date("Y-m-d", strtotime($F4I)) . " -1 day"));


include_once('../Persistencia/conexion.php');
        $conexion = new conexion();

        //Insertamos fechas en fase de inicio
         $result1= mysql_query("INSERT INTO Fase VALUES(NULL,'"
                    . $_SESSION['proyectoEscogido']."','"
                    . "Inicio','"
                    . $F1I."','"
                    . $F1F."','".$F1I ."',NULL)");

         //Insertamos fechas en fase de inicio
         $result2= mysql_query("INSERT INTO Fase VALUES(NULL,'"
                    . $_SESSION['proyectoEscogido']."','"
                    . "Elaboracion','"
                    . $F2I."','"
                    . $F2F."',NULL,NULL)");

         //Insertamos fechas en fase de inicio
         $result3= mysql_query("INSERT INTO Fase VALUES(NULL,'"
                    . $_SESSION['proyectoEscogido']."','"
                    . "Construccion','"
                    . $F3I."','"
                    . $F3F."',NULL,NULL)");

         //Insertamos fechas en fase de inicio
         $result4= mysql_query("INSERT INTO Fase VALUES(NULL,'"
                    . $_SESSION['proyectoEscogido']."','"
                    . "Transicion','"
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

         if($i == 1){
             $result= mysql_query("INSERT INTO Iteracion VALUES(NULL,'"
                    . $faseID."','"
                    . $i."','".$F1I ."',NULL)");
         }else{
         $result= mysql_query("INSERT INTO Iteracion VALUES(NULL,'"
                    . $faseID."','"
                    . $i."',NULL,NULL)");
         }}
        

         $result6= mysql_query("UPDATE Proyecto SET fechaInicio = '"
             . $F1I. "' WHERE idProyecto ='"
                 . $_SESSION['proyectoEscogido'] ."'");

//            echo  ("hola-" .$F1F);
        $conexion->cerrarConexion();

?>
