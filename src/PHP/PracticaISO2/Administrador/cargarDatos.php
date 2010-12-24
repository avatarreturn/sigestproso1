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

        <script type="text/javascript" language="javascript">
            //variables utilizadas en la funcion que llama al servidor
            //corresponden al estado de la respuesta del servidor
            var READY_STATE_UNINITIALIZED=0; //No inicializado (objeto creado, pero no se ha invocado el método open)
            var READY_STATE_LOADING=1; //Cargando (objeto creado, pero no se ha invocado el método send)
            var READY_STATE_LOADED=2; //Cargado (se ha invocado el método send, pero el servidor aún no ha respondido)
            var READY_STATE_INTERACTIVE=3; //Interactivo (se han recibido algunos datos, aunque no se puede emplear la propiedad responseText)
            var READY_STATE_COMPLETE=4; //Completo (se han recibido todos los datos de la respuesta del servidor)

            //variable global para todas las funciones que almacena el objeto XMLHttRequest
            var peticion_http;
            var limiteCategoria;

            /*
             * @param url: la url del contenido que se va a cargar
             * @param metodo: el metodo utilizado para la peticion HTTP
             * @param funcion: referencia a la funcion que procesa la respuesta del servidor
             */
            function cargaContenido(url) {
                //se inicializa el objeto XMLHttpRequest
                peticion_http = inicializa_xhr();
                if(peticion_http) {
                    //realiza la peticion al servidor
                    peticion_http.open("GET", url, true);
                    //se establece la funcion que procesa la respuesa del servidor, sin parentesis
                    //en este caso sera: muestraContenido
                    peticion_http.onreadystatechange = muestraContenido;
                    //la peticion se envia al servidor, sin datos
                    peticion_http.send(null);
                }
            }

            //funcion que inicializa el objeto XMLHttpRequest
            function inicializa_xhr() {
                if(window.XMLHttpRequest) {
                    return new XMLHttpRequest();
                }
                else if(window.ActiveXObject) {
                    return new ActiveXObject("Microsoft.XMLHTTP");
                }
            }

            //comprobar que la peticion ha sido correcta
            function muestraContenido() {
                var obj = document.getElementById('targetDiv');
                if(peticion_http.readyState == READY_STATE_COMPLETE) {
                    //status==200: respuesta correcta
                    //status==404: no encontrado
                    //status==500: error del servidor
                    if(peticion_http.status == 200) {
                        //responseText contiene el valor respuesta del servidor en forma de string
                        obj.innerHTML = peticion_http.responseText;
                    }
                }
            }

            //crea el select de categorias
            function pintaOptions(maximo){
                //limite del select
                limiteCategoria=maximo;
		var select = document.createElement('select');
                select.setAttribute("id", "selectCategorias");
		select.size = 1;
		var option = document.createElement('option');
		for (var t, i = 1; i <= limiteCategoria; ++i) {
			t = document.createTextNode(i);
			o2 = option.cloneNode(true);
			o2.setAttribute("value", i);
			o2.appendChild(t);
			select.appendChild(o2);
		}
		document.getElementById("prueba").appendChild(select);
            }
            
            //repinta el select de categorias al ser pulsado el boton "Actualizar"
            function modificaMaxCategoria(maximo){
                document.getElementById("prueba").innerHTML="";
                pintaOptions(maximo);
            }

            //anhade una categoria al textArea
            function anhadirCategoria(){
                var fila=document.getElementById("rol").value+"("+document.getElementById("selectCategorias").value+")";
                document.getElementById("textarea_roles").value=fila;
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
		A trav&eacute;s de esta pantalla el administrador podr&aacute; cargar los datos iniciales del proyecto.
                    </div>
                    <div class="filaFormulario">
                        <div class="etiquetaCampo">
                            <br>
                            <label for="numMaxCategoria">N&uacute;mero m&aacute;ximo de categor&iacute;as:</label>
                        </div>
                        <div class="campo">
                            <table>
                                <tr>
                                    <td><input id="numMaxCategoria" name="numMaxCategoria" type="text" class="validate" value="5"/></td>
                                    <td><input type = "button" value = "Actualizar" onclick = "modificaMaxCategoria(document.carga_datos.numMaxCategoria.value)"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="targetDiv" class="filaFormulario" >
                        <!--ESTE CONTENIDO SE CARGA CON AJAX-->
                        <div class="etiquetaCampo">
                            <br>
                            <label>Introduzca la relaci&oacute;n de categor&iacute;as y roles:</label>
                        </div>
                        <div id="tabla" class="campo">
                            <table>
                                <tr>
                                    <td><input id="rol" name="rol" type="text" class="validate" value="Escriba un rol:"/></td>
                                    <td>
                                        <div id="prueba"><script>pintaOptions(document.carga_datos.numMaxCategoria.value);</script></div>
                                    </td>
                                    <td><input type = "button" value = "A&ntilde;adir categor&iacute;a" onclick = "anhadirCategoria()"></td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td>
                                        <div class="etiquetaCampo">
                                            <br>
                                            <label>Relaciones de categor&iacute;as y roles ya introducidas:</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><textarea id="textarea_roles" name="rolescreados" rows="5" cols="30"></textarea></td>
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

        </div>

        <!-- end footer -->

    </body>
</html>
