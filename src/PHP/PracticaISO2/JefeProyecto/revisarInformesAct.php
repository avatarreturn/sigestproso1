<?php session_start();

// CODIGO PHP DE LAS COSAS Q SALEN DE LA BD PARA MOSTRAR POR PANTALLA

    //$_SESSION['ActividadEscogidaJ'] = $_GET['idActJ'];
    $_SESSION['proyectoEscogido'] = $_GET['idP'];

    include_once('../Persistencia/conexion.php');
    $conexion = new conexion();

    //CONSULTAS
            //$result2 = mysql_query("SELECT * FROM Artefacto WHERE\n"
            //. "Actividad_idActividad = \"".$_SESSION['ActividadEscogida']."\"");

    // DEVUELVE NUM D TUPLAS DE LA CONSULTA
    // $totEmp2 = mysql_num_rows($result2);
 /*
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
*/
    ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "Http://www.w3.org/TR/html4/strict.dtd">

<html>
    <head>
        <title>SIGESTPROSO</title>

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

<!--CODIGO JAVASCRIPT-->

<!-- PARA CADA FUNCION, PONER ESTO PARA EL AJAX EN EL CASO "BUENO"

if (window.XMLHttpRequest){
      xmlhttp=new XMLHttpRequest();
      }
    else{
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==1){
            //2- Sucede cuando se esta cargando la pagina
            document.getElementById("PONER AKI MI DIV HTML PARA CARGANDO").innerHTML = "<p><center>MENSAJE (CARGANDO...)<center><img src='../images/enviando.gif' alt='Editando' width='150px'/></p>";//<-- Aca puede ir una precarga
        }else if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        3- AQUI VA LA RESPUESTA, DESPUES DE Q EL SERVIDOR HAGA LO Q SEA
            //alert(xmlhttp.responseText);  ES LA VARIABLE A LA Q VAN LOS ECHOS DE LA SERVIDOR ASOCIADA
            location.href = "tareas.php?idAct=" +"<?php echo $_SESSION['ActividadEscogida']?>";
        }
      }

      1- LO Q LE MANDAS AL SERVIDOR
      xmlhttp.open("GET","editarArtefacto.php?nombre=" + document.getElementById("nomArt").value
    + "&url=" + document.getElementById("urlArt").value
    + "&comm=" + document.getElementById("commArt").value,true);
    xmlhttp.send();-->

    </head>
    <body>

<!--        PARA MOSTRAR ALGO X PANTALLA Q VENGA DE LA BD
        <p>Comentarios: <br> <textarea cols="70" id="commArt" rows="8"><?php echo utf8_decode($commArtefacto) ?></textarea></p>
  -->

    </body>
    <?php $conexion->cerrarConexion(); ?>
</html>
