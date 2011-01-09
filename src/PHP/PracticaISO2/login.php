<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>


        <title>[SIGESTPROSO] Seguimiento Integrado de la GESTi&oacute;n Temporal de PROyectos de Software</title>

        <link rel="stylesheet" type="text/css" href="login.css" />
<script language="javascript" type="text/javascript">
            function valida_envia(){
                document.login_form.submit();
            }
</script>

    </head>

    <body id="login" <%--onload="document.login_form.user_login.focus();"--%>>

          <div id="sitewrapper">
              <div id="header">SIGESTPROSO</div>

            <div id="content">
                <div id="main">
                    
                    <h1>Entrar en la aplicaci&oacute;n</h1>
                    <form action="validarUsuario.php" method="POST" name="login_form">
                        <div id="email">
                            <fieldset id="user-email">
                                <p>
                                    <strong><a href="#" <%-- onclick="forgot_password(); return false;"--%>>&iquest;Olvid&oacute; la contrase&ntilde;a?</a></strong>

                                    <label><b>Usuario</b><span><input name="login" tabindex="1" id="login" type="text" /></span></label>
                                </p>
                            </fieldset>
                        </div>
                        <div id="password">
                            <fieldset id="user-password">
                                <p>
                                    <label><b>Contrase&ntilde;a</b><span><input name="password" tabindex="2" id="password"type="password" /></span></label>
                                </p>
                            </fieldset>
                            <fieldset id="entrar">
                                <img id="sign-in" name="boton_login" src="images/entrar.gif" alt="Entrar" tabindex="3" onclick="valida_envia()" />
                                <strong id="resp"></strong>
                            </fieldset>
                        </div>
                        
                        <div id="forgot-password" style="display: none;">
                            <input name="commit" value="Email me my password" type="submit" />
                            <label>Just kidding <a href="#" onclick="remember(); return false;">I remember now</a></label>
                        </div>
                        
                    </form>
                </div><!-- /main -->
            </div><!-- /content -->

        </div>
        <div id="footer">
            <br/><br/>
            <div class="copyright">P&aacute;gina web optimizada para ver en pantalla completa (pulse &#60;F11&#62;) con el navegador Mozilla Firefox.</div>
<!--            <div class="copyright">Copyright © PATRAC</div>-->
        </div><!-- /sitewrapper -->
    </body>
</html>
