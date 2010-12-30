<?php session_start();

$FaseNext = $_GET['FaseNext'];
$numIt = $_GET['numIt'];

include_once('../Persistencia/conexion.php');
        $conexion = new conexion();
//Insertamos iteraciones en la fase seleccionada
         for ($i = 1; $i <= $numIt; $i++) {
         $result= mysql_query("INSERT INTO Iteracion VALUES(NULL,'"
                    . $FaseNext."','"
                    . $i."',NULL,NULL)");
         }
echo $FaseNext ."--". $numIt;
$conexion->cerrarConexion();
?>
