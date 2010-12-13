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
            <div id="small">Responsable de Personal</div>
            <div id="small2"><a href="logout.php">Cerrar sesi&oacute;n</a></div>
        </div>

        <div id="topmenu">


            <ul class="BLUE">
                <li><a href="iniResponsablePersonal.php" title="Crear trabajadores"><span>Crear trabajadores</span></a></li>
                <li><a href="iniResponsablePersonal2.php" title="Obtener informes"><span>Obtener informes</span></a></li>
            </ul>
        </div>

        <!-- end top menu and blog title-->

        <!-- start content -->

        <div id="centercontent">


            <h1>SIGESTPROSO </h1>
            <p><br /></p>
            <p>
            <div id="formulario">
                <form  action="crearUsuario.php" method="post">
                    <div class="tituloFormulario">
                        <h2>Registro de nuevo usuario</h2>
                    </div>
                    <div class="infoFormulario">
		A trav&eacute;s de esta pantalla el Responsable de Personal podr&aacute; registrar un nuevo usuario y asignarle una categor&iacute;a dentro de la empresa.
                    </div>
                    <br>
                    <table>
                        <tr>
                            <td>
                                <label for="Nombre">Nombre:</label>
                            </td>
                            <td>
                                <label for="Apellidos">Apellidos:</label>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="filaFormulario">
                                    <div class="campo">
                                        <input name="nombre" type="text" class="validate" />
                                    </div>
                                </div></td>
                            <td>
                                <div class="filaFormulario">
                                    <div class="campo">
                                        <input name="apellidos" type="text" class="validate" />
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td>
                                <label for="objetivos">Fecha de nacimiento:</label>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <div>
                                    <?php
                                    echo '<select name="dias" size="1">';
                                    echo '<option>D&iacute;a</option>';
                                    for ($i = 1; $i <= 31; $i++) {
                                        echo '<option value="1">' . $i . '</option>';
                                    }
                                    echo '</select>';
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <select size="1">
                                        <option value="Mes">Mes</option>
                                        <option value="Enero">Enero</option>
                                        <option value="Febrero">Febrero</option>
                                        <option value="Marzo">Marzo</option>
                                        <option value="Abril">Abril</option>
                                        <option value="Mayo">Mayo</option>
                                        <option value="Junio">Junio</option>
                                        <option value="Julio">Julio</option>
                                        <option value="Agosto">Agosto</option>
                                        <option value="Septiembre">Septiembre</option>
                                        <option value="Octubre">Octubre</option>
                                        <option value="Nomviembre">Noviembre</option>
                                        <option value="Diciembre">Diciembre</option>
                                    </select>
                                </div>
                            </td>
                            <td
                                <div>
                                        <?php
                                        echo '<select name="dias" size="1">';
                                        echo '<option>A&ntilde;o</option>';
                                        $fecha = getdate();
                                        $anio = $fecha[year] - 18;
                                        for ($i = 1950; $i <= $anio; $i++) {
                                            echo '<option value="1">' . $i . '</option>';
                                        }
                                        ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <br>
                                <label for="Categoría">Categoría:</label>
                            </td>
                            <td>
                                <br>
                                <select size="1">
                                    <option value="Escoja">Escoja categoría</option>
                                    <option value="jefeProyecto">Jefe de proyecto</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </td>
                        </tr>

                    </table>
            </div>

            <div class="filaFormulario">
                <table>
                    <tr>
                        <td>
                            <div class="etiquetaCampo">
                                <label for="nick">Nombre de usuario:</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="campo">
                                <input name="nick" type="text" class="validate" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="etiquetaCampo">
                                <label for="Nick">Contraseña:</label>
                            </div>
                        </td>
                        <td>
                            <div class="etiquetaCampo">
                                <label for="Nick">Repita contraseña:</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="campo">
                                <input name="password" type="text" class="validate" />
                            </div>
                        </td>
                        <td>
                            <div class="campo">
                                <input name="repassword" type="text" class="validate" />
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            <div class="boton">
                <input name="Guardar" value="Crear" type="submit" class="submit"/>
                <input name="Limpiar" value="Limpiar" type="reset" class="submit"/>
            </div>
        </form>
    </div>
</p>

</div>


<!-- end content -->
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
