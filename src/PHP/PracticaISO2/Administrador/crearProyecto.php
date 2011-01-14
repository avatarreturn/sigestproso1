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

        <title>Crear Proyecto</title>

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

        <script language="javascript" type="text/javascript">
            //elimina las confirmaciones
            function limpia_confirmacion(id){
                document.getElementById(id).innerHTML="";
            }//fin limpia_confirmacion()

            //valida los datos introducidos por el usuario
            function valida_envia(){
                //comprobamos que no esta vacio el campo nombre
                if (document.nuevo_proyecto.nombre.value.length==0){
                    alert("Tiene que escribir un nombre para el proyecto.")
                    document.nuevo_proyecto.nombre.focus()
                    return 0;
                }
                //comprobamos que no esta vacio el campo de jefe de proyecto
                if (document.nuevo_proyecto.jefeProyecto.value=="Seleccione un Jefe de Proyecto"){
                    alert("Tiene que seleccionar un Jefe de Proyecto.")
                    document.nuevo_proyecto.jefeProyecto.focus()
                    return 0;
                }
                if (confirm("Se crear\xE1 el nuevo proyecto.")){
                    document.nuevo_proyecto.submit();
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
                    <form  action="proyectoCreado.php" method="POST" name="nuevo_proyecto">
                        <div class="tituloFormulario">
                            <h2>Crear Proyecto</h2>
                        </div>
                        <div class="infoFormulario">
		A trav&eacute;s de esta pantalla el administrador podr&aacute; crear un nuevo proyecto, asignar el correspondiente responsable y marcar los objetivos del mismo.
                        </div>
                        <div class="filaFormulario">
                            <div class="etiquetaCampo">
                                <br>
                                <label for="nombre">Nombre del Proyecto:</label>
                            </div>
                            <div class="campo">
                                <table>
                                    <tr>
                                        <td>
                                            <input name="nombre" type="text" class="validate" />
                                        </td>
                                        <td>
                                            <div id="mensajeProyectoNoCreado">
                                                <?php
                                                if ($_GET["proyectoNoCreado"]) {
                                                    echo "<label style=\"color: red\";><font size=\"2\">El nombre utilizado para el proyecto ya existe, introduzca uno diferente</font></label>";
                                                    echo '<script type="text/javascript">
                                                        window.setTimeout("limpia_confirmacion(\"mensajeProyectoNoCreado\")", 4000);
                                                        </script>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="filaFormulario">
                            <div class="etiquetaCampo">
                                <br>
                                <label for="responsable">Responsable:</label>
                            </div>
                            <div class="campo">
                                <?php
                                                include_once('../Persistencia/conexion.php');
                                                $conexion = new conexion();
                                                $result = mysql_query('SELECT nombre, apellidos, dni FROM Trabajador WHERE (categoria like "1") and dni not in (SELECT jefeProyecto FROM Proyecto WHERE fechaFin is NULL)');
                                                $totalResultados = mysql_num_rows($result);
                                                if ($totalResultados > 0) {
                                                    //hay algún resultado
                                                    echo '<SELECT NAME="jefeProyecto" size="1">';
                                                    echo '<option>Seleccione un Jefe de Proyecto</option>';
                                                    while ($rowEmp = mysql_fetch_assoc($result)) {
                                                        echo '<option value="' . $rowEmp['dni'] . '">' . $rowEmp['nombre'] . ' ' . $rowEmp['apellidos'] . '</option>';
                                                    }
                                                    echo '</SELECT>';
                                                } else {
                                                    //no hay jefes de proyecto libres
                                                    echo "<label style=\"color: red\";><font size=\"2\">No existen Jefes de Proyecto libres en este momento</font></label>";
                                                }

                                                $conexion->cerrarConexion();
                                ?>
                            </div>
                                        </div>
                                        <div class="filaFormulario">
                                            <div class="etiquetaCampo">
                                                <br>
                                                <label for="objetivos">Descripci&oacute;n del Proyecto:</label>
                                            </div>
                                            <div class="campo">
                                                <textarea id="textarea_objetivos" name="descripcion" rows="5" cols="50"></textarea>
                                            </div>
                                        </div>
                                        <div class="boton">
                                            <input name="crear" value="Crear" type="button" class="submit" onclick="valida_envia()"/>
                                            <input name="Limpiar" value="Limpiar" type="reset" class="submit"/>
                                            <div id="mensajeProyectoCreado">
                                <?php
                                                if ($_GET["proyectoCreado"]) {
                                                    echo "<label style=\"color: green\";><font size=\"2\">El proyecto se ha creado con &eacute;xito</font></label>";
                                                    echo '<script type="text/javascript">
                                    window.setTimeout("limpia_confirmacion(\"mensajeProyectoCreado\")", 4000);
                                    </script>';
                                                }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end content -->

        <!-- start right box --><!-- end right box -->
        <!-- start footer -->

        <div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>

        </div>

        <!-- end footer -->




    </body>
</html>
