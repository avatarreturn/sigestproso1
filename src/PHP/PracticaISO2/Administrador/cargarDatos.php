<?php
session_start();
$login = $_SESSION['tipoUsuario'];
if ($login != "A") {
    header("location: ../index.php");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

    <head>

        <title>Configurar sistema</title>

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

        <link rel="stylesheet" type="text/css" href="../stylesheet.css" media="screen, projection, tv " />

        <script type="text/javascript" language="javascript">
            ////////////////////////////////////////
            //RELACION CATEGORIA ROL
            ////////////////////////////////////////
            //elimina la confirmacion de la relacion categoria-rol
            function limpia_confirmacion(){
                document.getElementById("mensajeRelacionCreada").innerHTML="";
            }//fin limpia_configuracion()

            //confirma los datos de la nueva relacion antes de almacenarlos
            function valida_envia(){
                //comprobamos que no esta vacio el campo rol
                if ((document.carga_datos.rol.value.length==0)||(document.carga_datos.rol.value=='Escriba un rol:')){
                    alert("Tiene que escribir un rol para la relaci\xF3n.")
                    document.carga_datos.rol.focus()
                    return 0;
                }
                //comprobamos que la categoria es un numero
                if(isNaN(document.carga_datos.selectCategorias.value))
                {
                    alert("Seleccione un n\xFAmero para la categor\xEDa.");
                    document.carga_datos.selectCategorias.focus()
                    return 0;
                }
                if (confirm("Se añadir\xE1 la siguiente relaci\xF3n:\n ROL:  "+document.getElementById("rol").value+"\n CATEGOR\xCDA:  "+document.getElementById("selectCategorias").value)){
                    actualiza_datos();
                }
            }//fin valida_envia()

            //actualiza la relacion rol-categoira mediante AJAX
            function actualiza_datos(){
                // Obtener la instancia del objeto XMLHttpRequest
                if(window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                }
                else if(window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = function(){
                    if (peticion_http.readyState==4 && peticion_http.status==200)
                    {
                        window.location.href = "cargarDatos.php?relacionCreada=true";
                    }
                }
                // Realizar peticion HTTP
                peticion_http.open('GET', 'datosCargados.php?rol='+document.getElementById("rol").value+'&selectCategorias='+document.getElementById("selectCategorias").value, true);
                peticion_http.send(null);
            }

            ////////////////////////////////////////
            //CATEGORIA MAXIMA
            ////////////////////////////////////////

            //elimina la confirmacion de la modificacion de la categoria maxima
            function limpia_confirmacion2(){
                document.getElementById("mensajeMaximaCategoria").innerHTML="";
            }//fin limpia_confirmacion2()

            //confirma los datos de la categoria maxima antes de almacenarnos
            function valida_envia2(){
                miInteger = parseInt(document.carga_datos2.numMaxCategoria.value);
                if(!isNaN(miInteger)){
                    actualiza_datos2();
                }else{
                    alert("Introduzca un n\xFAmero");
                }
            }//fin valida_envia2()

            //actualiza la categoria mediante AJAX
            function actualiza_datos2(){
                // Obtener la instancia del objeto XMLHttpRequest
                if(window.XMLHttpRequest) {
                    peticion_http = new XMLHttpRequest();
                }
                else if(window.ActiveXObject) {
                    peticion_http = new ActiveXObject("Microsoft.XMLHTTP");
                }
                // Preparar la funcion de respuesta
                peticion_http.onreadystatechange = function(){
                    if (peticion_http.readyState==4 && peticion_http.status==200)
                    {
                        window.location.href = "cargarDatos.php?modificadaMaxCategoria=true";
                    }
                }
                // Realizar peticion HTTP
                peticion_http.open('GET', 'datosCargados2.php?categoria='+document.getElementById("numMaxCategoria").value, true);
                peticion_http.send(null);
            }

        </script>
    </head>
    <body>

        <!-- start top menu and blog title-->

        <div id="blogtitle">
            <div id="small">Administrador</div>
            <div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
        </div>

        <div id="page">
            <div id="topmenu">

            </div>

            <!-- end top menu and blog title-->

            <!-- start left box-->

            <div id="leftcontent" style="display:inline">
                <img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />
                <h3 align="left">Main Menu</h3>

                <div align="left">
                    <ul class="BLUE">
                        <li><a href="crearProyecto.php">Crear proyecto</a></li>
                        <li><a href="cargarDatos.php">Configurar sistema</a></li>
                    </ul>
                </div>

                <p><img src= "../images/Logo2.jpg" alt="#" border="0" style="width: 180px; height: auto;"/></p>
                <img style="padding-top:2px; margin-left:-12px; margin-bottom:-4px;" src="../images/specs_bottom.jpg" alt="" />

            </div>
            <!-- end left box-->

            <!-- start content -->

            <div id="centercontent">
                <h1>SIGESTPROSO</h1>
                <p><br /></p>
                <p>
                <div id="formulario">
                    <form id="carga_datos2" action="datosCargados2.php" method="post" name="carga_datos2">
                        <div class="tituloFormulario">
                            <h2>Configurar sistema</h2>
                        </div>
                        <div class="infoFormulario">
		A trav&eacute;s de esta pantalla el administrador podr&aacute; cargar los datos iniciales del proyecto.
                        </div>
                        <div class="filaFormulario">
                            <div class="etiquetaCampo">
                                <br>
                                <label for="numMaxCategoria">N&uacute;mero m&aacute;ximo de categor&iacute;as:</label>
                            </div>
                            <div class="campo">
                                <table>
                                    <tr>
                                        <?php
                                        include_once('../Persistencia/conexion.php');
                                        $conexion = new conexion();
                                        $result = mysql_query('SELECT categoriaMaxima FROM Configuracion');
                                        $row3 = mysql_fetch_array($result);
                                        $numMaxCategoria = $row3[0];
                                        echo '<td>
                                            <input id="numMaxCategoria" name="numMaxCategoria" type="text" class="validate" value="' . $numMaxCategoria . '">
                                                </td>';
                                        ?>
                                        <td><input name="crear2" type = "button" value = "Modificar" onclick="valida_envia2()"></td>
                                        <td>
                                            <div id="mensajeMaximaCategoria">
                                                <?php
                                                if ($_GET["modificadaMaxCategoria"])
                                                    echo "<label style=\"color: green\";><font size=\"2\">M&aacute;xima categor&iacute;a modificada</font></label>";
                                                echo '<script type="text/javascript">
                                                   window.setTimeout("limpia_confirmacion2()", 4000);
                                                    </script>';
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </form>
                    <form id="carga_datos"  action="datosCargados.php" method="post" name="carga_datos">
                        <div id="targetDiv" class="filaFormulario" >
                            <div class="etiquetaCampo">
                                <br>
                                <label>Introduzca la relaci&oacute;n de categor&iacute;as y roles:</label>
                            </div>
                            <div id="tabla" class="campo">
                                <table>
                                    <tr>
                                        <td><input id="rol" name="rol" type="text" class="validate" value="Escriba un rol:"/></td>
                                        <td>
                                            <?php
                                                $contador = 1;
                                                echo '<SELECT id="selectCategorias" NAME="selectCategorias" size="1">';
                                                echo '<option>Escoja categoria:</option>';
                                                while ($contador <= $numMaxCategoria) {
                                                    echo '<option value="' . $contador . '">' . $contador . ' </option>';
                                                    $contador++;
                                                }
                                                echo '</SELECT>';
                                            ?>
                                            </td>
                                            <td><input name="crear" type = "button" value = "A&ntilde;adir" onclick="valida_envia()"></td>
                                            <td>
                                                <div id="mensajeRelacionCreada">
                                                <?php
                                                if ($_GET["relacionCreada"])
                                                    echo "<label style=\"color: green\";><font size=\"2\">La relaci&oacute;n ha sido a&ntilde;adida con &eacute;xito</font></label>";
                                                    echo '<script type="text/javascript">
                                                        window.setTimeout("limpia_confirmacion()", 4000);
                                                        </script>';
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>        <!-- end content -->
        </div>        <!-- end page -->



        <!-- start right box --><!-- end right box -->
        <!-- start footer -->

        <div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>

        </div>

        <!-- end footer -->

    </body>
</html>