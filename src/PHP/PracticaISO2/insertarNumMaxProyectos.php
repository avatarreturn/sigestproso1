<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <link rel="stylesheet" type="text/css" href="login.css" />
        <script language="javascript" type="text/javascript">
            function valida_envia(){
                if(isNaN(document.formulario.numMaxProyect.value))
                {
                    alert("Introduzca un n\xFAmero.");
                    document.formulario.numMaxProyect.focus()
                    return 0;
                }else{
                    document.formulario.submit();
                }
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
                    <h1>N&uacute;mero m&aacute;ximo proyectos</h1>
                    <form action="NumMaxProyectoModificado.php" method="post" name="formulario">
                        <div id="email">
                            <fieldset id="user-email">
                                <table align="center" valign="middle">
                                    <tr>
                                        <td align="center">Inserte el n&uacute;mero m&aacute;ximo de proyectos:</td>
                                        <td><input type="text" name="numMaxProyect" size="10" maxlength="20" /></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <br></br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center"><input type="button" value="Enviar" onclick="valida_envia()" /></td>
                                        <td align="center"><input type="reset" value="Limpiar" /></td>
                                    </tr>
                                </table>
                            </fieldset>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </body>
</html>
