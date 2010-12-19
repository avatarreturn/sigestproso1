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

        <script type="text/javascript"  language = "javascript">

            //array de objetos javascript
            function Objeto(cod,tex){
                this.cod=cod;
                this.tex=tex;
            }


            function pintaOptions(){
                //select donde se incluiran las opciones
                var select = document.getElementById('categoria');
                
                //array con los elementos a guardar
                var numMax = document.getElementById('numMaxCategoria').value;
                var array_options = new Array();
                for (i=1;i<=numMax;i++)
                {
                    array_options[i]=new Objeto(i,i);
                }
                var grupo_anterior="";
                var grupo;
                var opcion;
                for (var i in array_options){
                    if(grupo_anterior!=array_options[i].grupo){
                        grupo= document.createElement('OPTGROUP');
                        grupo.label= array_options[i].grupo;
                        grupo_anterior = array_options[i].grupo;
                        select.appendChild(grupo);}
                    opcion = document.createElement("OPTION");
                    opcion.setAttribute("value",array_options[i].cod);
                    opcion.innerHTML = array_options[i].tex;
                    select.appendChild(opcion);  }
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
                <form  action="" method="post" name="carga_datos">
                    <div class="tituloFormulario">
                        <h2>Configurar proyecto</h2>
                    </div>
                    <div class="infoFormulario">
		A trav&eacute;s de esta pantalla el administrador podr&aacute; modificar el n&uacute;mero de proyectos en los que una persona puede estar implicado y cargar los datos iniciales del proyecto.
                    </div>
                    <div class="filaFormulario">
                        <div class="etiquetaCampo">
                            <br>
                            <label for="numProyectos">N&uacute;mero m&aacute;ximo de proyectos:</label>
                        </div>
                        <div class="campo">
                            <input name="numProyectos" type="text" class="validate" value="3" />
                        </div>
                    </div>
                    <div class="filaFormulario">
                        <div class="etiquetaCampo">
                            <br>
                            <label for="numMaxCategoria">N&uacute;mero m&aacute;ximo de categor&iacute;as:</label>
                        </div>
                        <div class="campo">
                            <table>
                                <tr>
                                    <td><input id="numMaxCategoria" name="numMaxCategoria" type="text" class="validate"/></td>
                                    <td><button>Actualizar</button></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="targetDiv" class="filaFormulario" >
                        <div class="etiquetaCampo">
                            <br>
                            <label for="relacionRoles">Relaci&oacute;n de categor&iacute;as y roles:</label>
                        </div>
                        <div id="tabla" class="campo">
                            <table>
                                <tr>
                                    <td><input name="rol" type="text" class="validate" value="Escriba un rol:"/></td>
                                    <td>
                                        <select id="categoria">    <script type="" >pintaOptions();</script></select></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><button>A&ntilde;adir categor&iacute;a</button></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
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
