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


        <link rel="stylesheet" type="text/css" href="stylesheet.css" media="screen, projection, tv " />

    </head>

    <body>

        <!-- start top menu and blog title-->

        <div id="blogtitle">
            <div id="small">Administrador</div>
            <div id="small2"><a href="logout.php">Cerrar sesi&oacute;n</a></div>
        </div>

        <div id="topmenu">


            <ul class="BLUE">
                <li><a href="iniAdministrador.php" title="Principal"><span>Crear proyecto</span></a></li>
                <li><a href="iniAdministrador2.php" title="Principal"><span>Cargar datos</span></a></li>
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
                <form  action="" method="post" id="AltaProyecto">
                    <div class="tituloFormulario">
                        <h2>Alta Proyecto</h2>
                    </div>
                    <div class="infoFormulario">
		A trav&eacute;s de esta pantalla el administrador podr&aacute; crear un nuevo proyecto y asignar el correspondiente responsable, marcar los objetivos del mismo,  modificar el n&uacute;mero de proyectos en los que una persona puede estar implicado y cargar los datos iniciales del proyecto.
                    </div>
                    <div class="filaFormulario">
                        <div class="etiquetaCampo">
                            <br>
                            <label for="responsable">Responsable:</label>
                        </div>
                        <div class="campo">
                            <?php
                            include_once('Persistencia/conexion.php');
                            $conexion = new conexion();
                            $result = mysql_query('SELECT usuario FROM usuarios WHERE descripcion="jefeProyecto"');
                            echo '<SELECT NAME="Colores" size="1">';
                            echo '<option>Seleccione un Jefe de Proyecto</option>';
                            while ($rowEmp = mysql_fetch_assoc($result)) {
                                echo '<option value="valor">' . $rowEmp['usuario'] . '</option>';
                            }
                            echo '</SELECT>';
                            $conexion->cerrarConexion();
                            ?>
                        </div>
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
                            <label for="objetivos">Objetivos del Proyecto:</label>
                        </div>
                        <div class="campo">
                            <textarea id="textarea_objetivos" name="comunicacion" rows="5" cols="50"></textarea>
                        </div>
                    </div>
                    <div class="tituloFormulario">
                        <h2>Configurar proyecto</h2>
                    </div>
                    <div class="filaFormulario">
                        <div class="etiquetaCampo">
                            <label for="numProyectos">N&uacute;mero m&aacute;ximo de proyectos:</label>
                        </div>
                        <div class="campo">
                            <input name="numProyectos" type="text" class="validate" value="3" />
                        </div>
                    </div>
                    <div class="tituloFormulario">
                        <h2>Tablas iniciales</h2>
                    </div>

                    <div class="boton">
                        <input name="guardar" value="Crear" type="submit" class="submit"/>
                    </div>
                </form>
            </div>
        </div>


        <!-- end content -->

        <!-- start right box --><!-- end right box -->
        <!-- start footer -->

        <div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>


            <!-- start left boxes -->

            <div class="centercontentleftb">
                <div class="centercontentleftimg">Sample Box for Products</div>
                <div class="centercontentrightimg">Sample Box for Products</div>
            </div>

            <!-- endleft boxes -->

            <!-- start right boxes -->

            <div class="centercontentrightb">
                <div class="centercontentleftimg">Sample Box for Products</div>
                <div class="centercontentrightimg">Sample Box for Products</div>
            </div>

            <!-- end right boxes -->

            <!-- end bottom boxes -->

        </div>

        <!-- end footer -->




    </body>
</html>
