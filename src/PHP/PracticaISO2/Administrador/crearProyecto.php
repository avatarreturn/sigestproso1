<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
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

        <script language="javascript" type="text/javascript">
            function valida_envia(){

                //comprobamos que no esta vacio el campo nombre
                if (document.nuevo_proyecto.nombre.value.length==0){
                    alert("Tiene que escribir un nombre para el proyecto.")
                    document.nuevo_proyecto.nombre.focus()
                    return 0;
                }

                //comprobamos que no esta vacio el campo de jefe de proyecto
                if (document.nuevo_proyecto.jefesProyecto.value=="Seleccione un Jefe de Proyecto"){
                    alert("Tiene que seleccionar un Jefe de Proyecto.")
                    document.nuevo_proyecto.jefesProyecto.focus()
                    return 0;
                }

                if (confirm("Se creará el nuevo proyecto.")){
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

        <div id="topmenu">


            <ul class="BLUE">
                <li><a href="crearProyecto.php" title="Principal"><span>Crear proyecto</span></a></li>
                <li><a href="cargarDatos.php" title="Principal"><span>Cargar datos</span></a></li>
            </ul>
        </div>

        <!-- end top menu and blog title-->

        <!-- start left box--><!-- end left box-->

        <!-- start content -->

        <div id="centercontent">
            <h1>SIGESTPROSO</h1>
            <p><br /></p>
            <p>
            <div id="formulario">
                <form  action="proyectoCreado.php" method="POST" name="nuevo_proyecto">
                    <div class="tituloFormulario">
                        <h2>Alta Proyecto</h2>
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
                            <input name="nombre" type="text" class="validate" />
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
                            //select nombre, apellidos from trabajador where dni not in (select jefeProyecto from proyecto where fechaFin is NULL);
                            $result = mysql_query('select nombre, apellidos from trabajador where (categoria like "1") and dni not in (select jefeProyecto from proyecto where fechaFin is NULL)');
                            echo '<SELECT NAME="jefesProyecto" size="1">';
                            echo '<option>Seleccione un Jefe de Proyecto</option>';
                            while ($rowEmp = mysql_fetch_assoc($result)) {
                                echo '<option value="'. $rowEmp['usuario'] .'">' . $rowEmp['usuario'] . '</option>';
                            }
                            echo '</SELECT>';
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
                        <?php
                            if ($_GET["creadoProyecto"])
                                echo "<label style=\"color: red\";><font size=\"2\">El proyecto se ha creado con exito</font></label>";
                        ?>
                    </div>
                </form>
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
