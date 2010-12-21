<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>

    <title>Formulario de tareas</title>

<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="description" content="studio7designs" />
<meta name="keywords" content="#" />
<meta name="googlebot" content="index, follow" />
<meta name="language" content="en-us, english" />
<meta name="classification" content="#" />
<meta name="author" content="www.studio7designs.com" />
<meta name="copyright" content="#" />
<meta name="location" content="#" />
<meta name="zipcode" content="#" />


<link rel="stylesheet" type="text/css" href="stylesheet.css" media="screen, projection, tv " />




<script>

// FUNCION EN AJAX -- ai k copiarla entera, solo modificar lo marcado mas abajo!
    function prueba(){

       if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {

    // AKI SE METE EL CONTENIDO K CAMBIARA AL EJECUTAR LA FUNCION.
    // estamos cambiando el contenido del DIV cuyo ID = aqui, por el resultado de la clase pruebaAJax2.php
    document.getElementById("aqui").innerHTML=xmlhttp.responseText;
    }
  }
  // aki se modifica el nombre de la clase, nada mas
xmlhttp.open("GET","pruebaAjax2.php",true);
xmlhttp.send();




    }
</script>
</head>

<body>

<!-- start top menu and blog title-->

<div id="blogtitle">
		<div id="small">Tareas</div>
		<div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
</div>
<!--
		<div id="topmenu">


		<ul class="BLUE">
		<li><a href="#" title="Downloads"><span>ISO II</span></a></li>
		<li><a href="#" title="Vacaciones"><span>Vacaciones</span></a></li>
		<li><a href="#" title="Links"><span>Santillana</span></a></li>
		</ul>
</div>-->

<!-- end top menu and blog title-->

<!-- start left box-->


<!-- end left box-->

<!-- start content -->

<div id="centercontent">


	<h1>SIGESTPROSO</h1>
        <div id="selProyecto">
            <h2 style="text-align: center">PRUEBA DE (<i style="color:blue">AJAX</i>)</h2>
        <div class="centercontentleft" style="width:auto;">
           <br/><br/><br/><br/><br/>
<!--           EL BOTON EJECUTA LA FUNCION PRUEBA k se ejecuta con ajax, debido a como esta implementanda arriba -->
            <center><input type="button" value="Enviar" name="Enviar" onclick="prueba()"/></center>

<!--            Este es el contenido del DIV k vamos a cambiar, ace falta ponerle un ID-->
            <div id="aqui">No e pulsado el boton</div>
<br/><br/><br/><br/><br/>
        </div>


        </div>

</div>


</body>
</html>
