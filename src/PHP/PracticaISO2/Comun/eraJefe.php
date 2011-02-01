<?php
session_start();
include_once ('../Persistencia/conexion.php');
$conexion = new conexion();

$proyecto=$_GET['idPF'];
$_SESSION['proyectoFinalizado']=$proyecto;
$dni=$_SESSION['dni'];
$sql="select jefeProyecto from Proyecto where idProyecto=".$proyecto.";";
$result=mysql_query($sql);
$rowJef=mysql_fetch_assoc($result);
if($rowJef['jefeProyecto']==$dni){
    echo'<script type="text/javascript">
            document.location.href="../JefeProyecto/InformesProyectoF.php";
            </script>';
}else{
    echo'<script type="text/javascript">
            document.location.href="../Desarrollador/InformeProyectoFinalizadoD.php";
            </script>';
}

$conexion->cerrarConexion();
?>
