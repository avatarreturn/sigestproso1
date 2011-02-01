<?php
session_start();
$login = $_SESSION['tipoUsuario'];
if ($login != "R") {
    header("location: ../index.php");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

    <head>

        <title>[SIGESTPROSO]-Seguimiento Integrado de la GEStion Temporal de PROyectos de SOftware</title>

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

    </head>

    <body>

        <!--   script para validar los campos     -->
        <script language="javascript" type="text/javascript">
            function valida_envia(){

                //           comprobamos que no esta vacio el campo de nombre
                if (document.nuevo_usuario.nombre.value.length==0){
                    alert("Tiene que escribir un nombre")
                    document.nuevo_usuario.nombre.focus()
                    return 0;
                }

                //           comprobamos que no esta vacio el campo de apellidos
                if (document.nuevo_usuario.apellidos.value.length==0){
                    alert("Tiene que escribir sus apellidos")
                    document.nuevo_usuario.apellidos.focus()
                    return 0;
                }

                //           comprobamos que no esta vacio el campo de fecha de nacimiento
                if (document.nuevo_usuario.dias.value=="0" || document.nuevo_usuario.mes.value=="0" || document.nuevo_usuario.anio.value=="0"){
                    alert("Tiene que elegir una fecha de nacimiento")
                    document.nuevo_usuario.dias.focus()
                    return 0;
                }

                //           comprobamos que no esta vacio el campo de nombre de usuario

                if (document.nuevo_usuario.nick.value.length==0){
                    alert("Tiene que escribir un nombre de usuario")
                    document.nuevo_usuario.nick.focus()
                    return 0;
                }

                //           comprobamos que no esta vacio el campo contraseña
                if (document.nuevo_usuario.password.value.length==0){
                    alert("Tiene que escribir una contraseña")
                    document.nuevo_usuario.password.focus()
                    return 0;
                }

                //           comprobamos que no esta vacio el campo repetir contraseña
                if (document.nuevo_usuario.repassword.value.length==0){
                    alert("Introduzca la misma contraseña en ambos campos")
                    document.nuevo_usuario.repassword.focus()
                    return 0;
                }

                //           comprobamos que las dos contraseñas introducidas son iguales
                if (document.nuevo_usuario.repassword.value!=document.nuevo_usuario.password.value){
                    alert("Introduzca la misma contrase\xF1a en ambos campos")
                    document.nuevo_usuario.password.value=""
                    document.nuevo_usuario.repassword.value=""
                    document.nuevo_usuario.password.focus()
                    return 0;
                }

                //           comprobamos que se ha escogido una categoria
                if (document.nuevo_usuario.categoria.value==""){
                    alert("Debe escoger una categoria para este usuario")
                    document.nuevo_usuario.categoria.focus()
                    return 0;
                }

                if (confirm("Se crear\xE1 el nuevo usuario")){
                    document.nuevo_usuario.submit();
                }
                
            }
        </script>

        <!-- start top menu and blog title-->

        <div id="blogtitle">
            <div id="small">Responsable de Personal (<u><?php echo $_SESSION['login'] ?></u>) - Crear trabajador</div>
            <div id="small2"><a href="../logout.php">Cerrar sesi&oacute;n</a></div>
        </div>

        <div id="topmenu">


            <ul class="BLUE">
                <li><a href="iniResponsablePersonal.php" title="Crear trabajadores"><span>Crear trabajadores</span></a></li>
                <li><a href="informesResponsablePersonal.php" title="Obtener informes"><span>Obtener informes</span></a></li>
                <li><a href="seguimientoPersonal.php" title="Seguimiento Personal"><span>Seguimiento Personal</span></a></li>
            </ul>
        </div>

        <!-- end top menu and blog title-->
        <div id="page">
            <div id="leftcontent">
                <img style="margin-top:-9px; margin-left:-12px;" src="../images/top2.jpg" alt="" />

                <h3 align="left">Men&uacute;</h3>


                <div align="left">
                    <ul class="BLUE">
                        <li><a href="iniResponsablePersonal.php">Crear trabajador</a></li>
                        <li><a href="seguimientoPersonal.php">Seguimiento Personal</a></li>
                        <li><a href="informesResponsablePersonal.php">Informes</a></li>
                    </ul>
                </div>


                <p><img src= "../images/Logo2.jpg" alt="#" border="0" style="width: 180px; height: auto;"/></p>


                <!-- You have to modify the "padding-top: when you change the content of this div to keep the footer image looking aligned -->

                <img style="padding-top:2px; margin-left:-12px; margin-bottom:-4px;" src="../images/specs_bottom.jpg" alt="" />



            </div>

            <!-- start content -->

            <div id="centercontent">


                <h1>SIGESTPROSO </h1>
                <p><br /></p>
                <div id="formulario">
                    <!--                <form  action="crearUsuario.php" method="post">-->
                    <form action="crearUsuario.php" method="POST" name="nuevo_usuario">
                        <div class="tituloFormulario">
                            <h2>Crear trabajador</h2>
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
                                        echo '<option value="0">D&iacute;a</option>';
                                        for ($i = 1; $i <= 31; $i++) {
                                            echo '<option value="1">' . $i . '</option>';
                                        }
                                        echo '</select>';
                                        ?>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <select name="mes" size="1">
                                            <option value="0">Mes</option>
                                            <option value="1">Enero</option>
                                            <option value="2">Febrero</option>
                                            <option value="3">Marzo</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Mayo</option>
                                            <option value="6">Junio</option>
                                            <option value="7">Julio</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                    </div>
                                </td>
                                <td
                                    <div>
                                            <?php
                                            echo '<select name="anio" size="1">';
                                            echo '<option value="0">A&ntilde;o</option>';
                                            $fecha = getdate();
                                            $anio = $fecha[year] - 18;
                                            for ($i = 1950; $i <= $anio; $i++) {
                                                echo '<option value="'.$i.'">' . $i . '</option>';
                                            }
                                            ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <br>
                                    <label for="dni">DNI</label>
                                </td>
                                <td>
                                    <br>
                                    <input name="dni" type="text" class="campo">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <br>
                                    <label for="Categoría">Categor&iacute;a:</label>
                                </td>
                                <td>
                                    <br>
                                    <select size="1" name="categoria">
                                        <option value="">Escoja categor&iacute;a</option>
                                        <?php
                                            include_once ('../Persistencia/conexion.php');
                                            $conexion = new conexion();
                                            $result = mysql_query('SELECT `categoriaMaxima`  FROM `Configuracion`');
                                            $row = mysql_fetch_array($result);
                                            $catMax=(int)$row["categoriaMaxima"];
                                            for ($i=1; $i<=$catMax;$i++){
                                                echo "<option value=\"".$i."\">".$i."</option>";
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                        </table>

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
                                            <label for="repassword">Contrase&ntilde;a:</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="etiquetaCampo">
                                            <label for="repassword">Repita contrase&ntilde;a:</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="campo">
                                            <input name="password" type="password" class="validate" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="campo">
                                            <input name="repassword" type="password" class="validate" />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <br>
                        <div class="boton">
                            <input name="Guardar" value="Crear" type="button" class="submit" onclick="valida_envia()" />
                            <input name="Limpiar" value="Limpiar" type="reset" class="submit"/>

                            <?php
                                            if ($_GET["creadoUsuario"]) {
                                                echo "<label style=\"color: red\";>El usuario se ha creado con exito</label>";
                                            }
                            ?>
                        </div>
                    </form>
                </div>

            </div>
        </div>


        <!-- end content -->
        <!-- start footer -->

        <div id="footer">&copy; 2006 Design by <a href="http://www.studio7designs.com">Studio7designs.com</a> | <a href="http://www.arbutusphotography.com">ArbutusPhotography.com</a> | <a href="http://www.opensourcetemplates.org">Opensourcetemplates.org</a>


        </div>

        <!-- end footer -->




    </body>
</html>
