<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>


        <title>[SIGESTPROSO]-Seguimiento Integrado de la GEStion Temporal de PROyectos de SOftware</title>

        <link rel="stylesheet" type="text/css" href="login.css" />
        <script language="javascript" type="text/javascript">
            function valida_envia(){
                document.login_form.submit();
            }
        </script>

    </head>

    <body id="login" >

        <div id="sitewrapper">
            <br/><br/><br/><br/>
            <img id="sign-in" name="boton_login" src="images/sigestproso.gif" alt="Sigestproso"/>
            <br/>
            <div id="content">
                <div id="main">
                    <h1>Iniciar sesi&oacute;n</h1>
                    <form action="validarUsuario.php" method="POST" name="login_form">
                        <div id="email">
                            <fieldset id="user-email">
                                <p>
                                    <label><b>Usuario</b><span><input name="login" tabindex="1" id="login" type="text" /></span></label>
                                    <?php
                                    if ($_GET["usuarioNoExistente"])
                                        echo "<b><label style=\"color: red\";><font size=\"2\">Usuario no existente</font></label></b>";

                                    if ($_GET["noLogin"])
                                        echo "<b><label style=\"color: red\";><font size=\"2\">Debe especificar un login</font></label></b>";

                                    if($_GET["noLoginNoPassword"])
                                        echo "<b><label style=\"color: red\";><font size=\"2\">Debe especificar un login</font></label></b>";
                                    ?>
                                </p>
                            </fieldset>
                        </div>
                        <div id="password">
                            <fieldset id="user-password">
                                <p>
                                    <label><b>Contrase&ntilde;a</b><span><input name="password" tabindex="2" id="password"type="password" /></span></label>
                                    <?php
                                    if ($_GET["passwordIncorrecto"])
                                        echo "<b><label style=\"color: red\";><font size=\"2\">Password incorrecto</font></label></b>";

                                    if ($_GET["noPassword"])
                                        echo "<b><label style=\"color: red\";><font size=\"2\">Debe especificar un password</font></label></b>";

                                    if($_GET["noLoginNoPassword"])
                                        echo "<b><label style=\"color: red\";><font size=\"2\">Debe especificar un password</font></label></b>";
                                    ?>
                                </p>
                            </fieldset>
                            <fieldset id="entrar">
                                <img id="sign-in" name="boton_login" src="images/entrar.gif" alt="Entrar" tabindex="3" onclick="valida_envia()" />
                            </fieldset>
                        </div>
                    </form>
                </div><!-- /main -->
            </div><!-- /content -->

        </div>
        <div id="footer">
            <br/><br/>
            <div class="copyright">P&aacute;gina web optimizada para ver con el navegador Google Chrome.</div>
        </div><!-- /sitewrapper -->
    </body>
</html>
