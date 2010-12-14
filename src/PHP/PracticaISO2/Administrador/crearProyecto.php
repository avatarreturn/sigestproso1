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

    </head>

    <body>
        <script language="javascript" type="text/javascript">
            function valida_envia(){

//                //comprobamos que no esta vacio el campo de nombre de usuario
//                if (document.nuevo_proyecto.nick.value.length==0){
//                    alert("Tiene que escribir un nombre de usuario")
//                    document.nuevo_proyecto.nick.focus()
//                    return 0;
//                }
//
//                //comprobamos que no esta vacio el campo contraseña
//                if (document.nuevo_proyecto.password.value.length==0){
//                    alert("Tiene que escribir una contraseña")
//                    document.nuevo_proyecto.password.focus()
//                    return 0;
//                }
//
//                //comprobamos que no esta vacio el campo repetir contraseña
//                if (document.nuevo_proyecto.repassword.value.length==0){
//                    alert("Introduzca la misma contraseña en ambos campos")
//                    document.nuevo_proyecto.repassword.focus()
//                    return 0;
//                }
//
//                //comprobamos que las dos contraseñas introducidas son iguales
//                if (document.nuevo_usuario.repassword.value!=document.nuevo_usuario.password.value){
//                    alert("Introduzca la misma contraseña en ambos campos")
//                    document.nuevo_proyecto.password.value=""
//                    document.nuevo_proyecto.repassword.value=""
//                    document.nuevo_proyecto.password.focus()
//                    return 0;
//                }
                document.nuevo_proyecto.submit();
            }
        </script>
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
                            <label for="responsable">Responsable:</label>
                        </div>
                        <div class="campo">
                            <?php
                            include_once('../Persistencia/conexion.php');
                            $conexion = new conexion();
                            $result = mysql_query('SELECT usuario FROM usuarios WHERE descripcion="jefeProyecto"');
                            echo '<SELECT NAME="jefesProyecto" size="1">';
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
                            <label for="fecha">Fecha de inicio:</label>
                        </div>
                        <div class="campo">
                            <?php
                            echo '<input NAME="fecha" type="text" value="' . date('d-m-Y') . '" class="validate" DISABLED/>';
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
