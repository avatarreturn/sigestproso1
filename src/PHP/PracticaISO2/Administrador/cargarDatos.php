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

        <title>Nautica08</title>

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

            //            //crea el select de categorias
            //            function pintaOptions(maximo){
            //                //limite del select
            //                limiteCategoria=maximo;
            //                var select = document.getElementById("selectCategorias");
            //                var option = document.createElement('option');
            //                for (var t, i = 1; i <= limiteCategoria; ++i) {
            //                    t = document.createTextNode(i);
            //                    o2 = option.cloneNode(true);
            //                    o2.setAttribute("value", i);
            //                    o2.appendChild(t);
            //                    select.appendChild(o2);
            //                }
            //                //document.getElementById("divParaSelect").appendChild(select);
            //            }
            //
            //            //repinta el select de categorias al ser pulsado el boton "Actualizar"
            //            function modificaMaxCategoria(maximo){
            //                document.getElementById("selectCategorias").innerHTML="";
            //                pintaOptions(maximo);
            //            }


            //confirma los datos de la nueva relacion antes de almacenarlos
            function valida_envia(){
                //comprobamos que no esta vacio el campo rol
                if (document.carga_datos.rol.value.length==0){
                    alert("Tiene que escribir un rol para la relación.")
                    document.carga_datos.rol.focus()
                    return 0;
                }
                if (confirm("Se añadirá la siguiente relación:\n ROL:  "+document.getElementById("rol").value+"\n CATEGORÍA:  "+document.getElementById("selectCategorias").value)){
                    document.carga_datos.submit();
                }
            }

            //confirma los datos de la categoria maxima antes de almacenarnos
            function valida_envia2(){
                miInteger = parseInt(document.carga_datos2.numMaxCategoria.value);
                if(!isNaN(miInteger)){
                    document.carga_datos2.submit();
                }
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
                        <li><a href="cargarDatos.php">Cargar datos</a></li>
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
                            <h2>Configurar proyecto</h2>
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
                                        echo '<td><input id="numMaxCategoria" name="numMaxCategoria" type="text" class="validate" value="' . $numMaxCategoria . '" onchange="modificaMaxCategoria(document.carga_datos.numMaxCategoria.value)"/></td>';
                                        ?>
                                        <td><input name="crear2" type = "button" value = "Modificar" onclick="valida_envia2()"></td>
                                        <td>
                                            <?php
                                            if ($_GET["modificadaMaxCategoria"])
                                                echo "<label style=\"color: red\";><font size=\"2\">La máxima categoría ha sido modificada con éxito</font></label>";
                                            ?>
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
                                            <!-- <div id="divParaSelect"><select id="selectCategorias" name="selectCategorias" size="1"><script type="text/javascript">pintaOptions(document.carga_datos2.numMaxCategoria.value);</script></select></div>-->
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
                                            <?php
                                            if ($_GET["creadoProyecto"])
                                                echo "<label style=\"color: red\";><font size=\"2\">La relación ha sido añadida con éxito</font></label>";
                                            ?>
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