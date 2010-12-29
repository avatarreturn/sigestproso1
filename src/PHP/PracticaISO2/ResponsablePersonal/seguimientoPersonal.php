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

        <?php
////        //BORRAR
////        //$dniLogueado = $_SESSION['dni'];
        include_once ('../Persistencia/conexion.php');
        $conexion = new conexion();
        $result = mysql_query('SELECT t.dni, t.nombre, t.apellidos, tp.Trabajador_dni, tp.Proyecto_idProyecto, tp.porcentaje FROM trabajador t, trabajadorProyecto tp where (t.dni=tp.Trabajador_dni);');
        $totTraProy = mysql_num_rows($result);
        if ($totTraProy > 0) {
            $trabajador = "";
            $dniAnterior = "";
            $cont = 0;
            $cont2 = 0;
            while ($rowEmp = mysql_fetch_assoc($result)) {
                $cont = $cont + 1;
                if ($rowEmp['Trabajador_dni'] == $dniAnterior) {
                    $trabajador = $trabajador . "<a href='#'>&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/iActividad4.gif' alt='Actividad' border='0' style='width: auto; height: 12px;'>  Proyecto: "
                            . $rowEmp['Proyecto_idProyecto'] . " Dedicacion: " . $rowEmp['porcentaje'] . "</img></a><br/> ";
                    //$trabajador = $trabajador . "<label>Proyecto: " . $rowEmp['Proyecto_idProyecto']. " Dedicacion: ". $rowEmp['porcentaje']. "</label><br/>";// . "</div><br/>";
                } else {
                    if ($cont != 0) {
                        $trabajador = $trabajador . "</div><br/>";
                    }
                    $trabajador = $trabajador . "<a href='#' onclick=\"ocultarR('oculto" . $cont . "')\"><img src= '../images/iJefeProyecto.gif' alt='#' border='0' "
                            . "style='width: auto; height: auto;'/>&nbsp;&nbsp;" . $rowEmp['nombre'] . " " . $rowEmp['apellidos'] . " " . $rowEmp['dni'] . "</a> - "
                            . "<div id=\"oculto" . $cont . "\" style=\"display:none\"><br/><a href='#'>&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/iActividad4.gif' alt='Actividad' border='0' style='width: auto; height: 12px;'>"
                            . "  Proyecto: " . $rowEmp['Proyecto_idProyecto'] . " Dedicacion: " . $rowEmp['porcentaje'] . "</img></a><br/> ";
                }

                $dniAnterior = $rowEmp['dni'];
            }
            if ($trabajador != "") {
                $trabajador = $trabajador . "</div><br/>";
            }
        }
//        $conexion->cerrarConexion();
        ?>
        <!--pasar dos parametros a la funcion, uno el primer elemento a ocultar y otro el numero de elementos consecutivos a ocultar-->
        <script>
            function ocultarR(x){
                
                if(document.getElementById(x).style.display=="none"){
                    document.getElementById(x).style.display="inline";
                }else{
                    document.getElementById(x).style.display="none"
                }
                
            }
        </script>

    </head>

    <body>

        <!-- start top menu and blog title-->

        <div id="blogtitle">
            <div id="small">Responsable de Personal</div>
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

        <!-- start content -->

        <div id="centercontent">


            <h1>SIGESTPROSO </h1>
            <p><br /></p>
            <div id="formulario">
                <!--                <form  action="crearUsuario.php" method="post">-->
                <form method="POST" name="nuevo_usuario">
                    <div class="tituloFormulario">
                        <h2>Seguimiento del personal</h2>
                    </div>
                    <div class="infoFormulario">
		A trav&eacute;s de esta pantalla el Responsable de Personal podr&aacute; ver la situaci&oacute;n de cada trabajador dentro de la empresa.
                    </div>
                    <br>
                    <div>
                        <?php
                        echo $trabajador;
                        ?>
                    </div>
                </form>
            </div>

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