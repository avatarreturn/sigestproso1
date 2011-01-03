<?php

// Nombre: Trabajador
// Descripcion: Clase que representa la entidad trabajador del dominio del problema y ofrece las operaciones correspondientes para su manejo
//Clases del negocio
//include_once('Vacaciones.php');
//include_once('Actividad.php');
//include_once('Usuario.php');
//Inclusi�n de operaciones de la clase de persistencia
//include_once('Persistencia/PTrabajador.php');

class Trabajador {

    private $dni;
    private $nombre;
    private $apellidos;
    private $fechaNac;
    private $categoria;

    public function __construct($dni, $nombre, $apellidos, $fechaNac, $categoria) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->fechaNac = $fechaNac;
        $this->categoria = $categoria;
    }

    ////////////////////////////////////////
    //Getters y Setters
    ////////////////////////////////////////

    public function getDni() {
        return $this->dni;
    }

    public function setDni($dni) {
        return $this->dni = $dni;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        return $this->nombre = $nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function setApellidos($apellidos) {
        return $this->apellidos = $apellidos;
    }

    public function getFechaNac() {
        return $this->fechaNac;
    }

    public function setFechaNac($fechaNac) {
        return $this->fechaNac = $fechaNac;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function setCategoria($in_categoria) {
        return $this->categoria = $in_categoria;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////METODOS/////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    //
    //
    //
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////METODOS ESTATICOS////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Funcion que crea un trabajador a partir de los datos de la base de datos
    static public function getTrabajador($parametroDni) {
        $datos = mysql_query('SELECT * FROM trabajador WHERE (dni=\'' . $parametroDni . '\')') or die(mysql_error());
        $totalrows=mysql_num_rows($datos);
        if($totalrows>0){
            while($rowEmp=  mysql_fetch_assoc($datos)){
                return new Trabajador($rowEmp['dni'], $rowEmp['nombre'], $rowEmp['apellidos'], $rowEmp['fechaNac'], $rowEmp['categoria']);
            }
        } else {
            return false;
        }
    }

    //////////////////////////////
    //Metodos de persistencia
    //////////////////////////////
//    //Funcion que se encarga de hacer persistente el objeto, devuelve true si lo guardo y false si no
//    public function Guardar() {
//
//        //Si el id es 0 inserto y si no actualizo el registro
//        if ($this->idTrabajador == 0) {
//
//            //Guardo las vacaciones
//            foreach ($this->vacaciones as $periodo) {
//                $periodo->Guardar();
//            }
//            //Invoco al metodo guardar estatico de PTrabajador, que me devuelve true si inserta y false si no
//            $retorno = PTrabajador::Guardar($this->dni, $this->categoria, $this->usuario->getIdUsuario());
//
//            if ($retorno == 0)
//                return false;
//            else {
//                $this->idTrabajador = $retorno;
//                return true;
//            }
//        } else {
//
//            //Actualizar las vacaciones
//            foreach ($this->vacaciones as $periodo) {
//                $periodo->Guardar();
//            }
//
//            $retorno = PTrabajador::Actualizar($this->idTrabajador, $this->dni, $this->categoria, $this->usuario->getIdUsuario());
//            if ($retorno == 0)
//                return false;
//            else
//                return true;
//        }
//    }
//
//    //Funci�n que elimina el objeto de persistencia, devuelve true si lo borr� y false si no
//    public function Borrar() {
//
//        //Si el id es distinto de 0 intento borrar si no ni lo intento
//        if ($this->idTrabajador == 0) {
//
//            return false;
//        } else {
//
//            //Borro las vacaciones
//            foreach ($this->vacaciones as $periodo) {
//                $periodo->Borrar();
//            }
//
//            //Borrado del trabajador
//            return PTrabajador::Borrar($this->idTrabajador);
//        }
//    }
//
//    ///////////////////////////////////////////
//    //M�todos est�ticos
//    ///////////////////////////////////////////
//    //Funci�n que devuelve todos los trabajadores implicados en una actividad
//    //Hay que reacerlo dependiendo de los valores devueltos
//    static public function getTrabajadoresByActividad(&$Actividad) {
//
//        try {
//            //Extraigo todos los trabajadores que participan en una actividad
//            $datos = PTrabajador::getTrabajadoresByActividad($Actividad->getIdActividad());
//            //Creaci�n de array de resultados
//            $retorno = array();
//            //Para cada trabajador tengo instancio un objeto
//            foreach ($datos as $dato) {
//                $aux = new Trabajador($dato[1], $dato[2], Usuario::GetUsuarioById($dato[3]));
//                //Asigno el id
//                $aux->idTrabajador = $dato[0];
//                //Cargo las vacaciones del trabajador
//                //$aux->vacaciones=Vacaciones::getVacacionesByTrabajador($dato[0]);
//                //Cargo el vector de resultados con la instancia actual
//                array_push($retorno, $aux);
//            }
//            return $retorno;
//        } catch (Exception $e) {
//            return false;
//        }
//    }
//
//    //Funci�n que obtiene todos los trabajadores inscritos en el sistema
//    static public function getAllTrabajadores() {
//
//        try {
//
//            //Extraer de la BBDD todos los trabajadores
//            $datos = PTrabajador::getAllTrabajadores();
//            $retorno = array();
//            foreach ($datos as $dato) {
//                $aux = new Trabajador($dato[1], $dato[2], Usuario::GetUsuarioById($dato[3]));
//                //Asigno el id
//                $aux->idTrabajador = $dato[0];
//                //Cargo el vector de resultados con la instancia actual
//                array_push($retorno, $aux);
//            }
//            return $retorno;
//        } catch (Exception $e) {
//            return false;
//        }
//    }
//
////Funci�n que obtiene todos los jefes de proyectos inscritos en el sistema
//    static public function getTrabajadorById($id) {
//
//        try {
//
//            //Extraer de la BBDD todos los trabajadores
//            $dato = PTrabajador::getTrabajadorById($id);
//
//            if (count($dato) != 0) {
//                //El ultimo parametro hay que pedir categoria por id
//                $aux = new Trabajador($dato[1], $dato[2], Usuario::GetUsuarioById($dato[3]));
//                $aux->idTrabajador = $dato[0];
//                //Cargo las vacaciones del trabajador
//                //$aux->vacaciones=Vacaciones::getVacacionesByTrabajador($dato[0]);
//                //Cargo el vector de resultados con la instancia actual
//            }
//            else
//                $aux=NULL;
//            return $aux;
//        } catch (Exception $e) {
//            return false;
//        }
//    }
//
////Funci�n que obtiene todos los trabajadores libres(que no pasan el 100 y el numero maximo de proyectos)
//    static public function getAllTrabajadoresLibres(&$proyecto) {
//
//        try {
//
//            //Extraer de la BBDD todos los trabajadores
//            $datos = PTrabajador::getAllTrabajadoresLibres($proyecto->getId());
//            $retorno = array();
//            foreach ($datos as $dato) {
//                //El ultimo parametro hay que pedir categoria por id
//                $aux = new Trabajador($dato[1], $dato[2], Usuario::GetUsuarioById($dato[3]));
//                //Asigno el id
//                $aux->idTrabajador = $dato[0];
//                //Cargo las vacaciones del trabajador
//                //$aux->vacaciones=Vacaciones::getVacacionesByTrabajador($dato[0]);
//                //Cargo el vector de resultados con la instancia actual
//                array_push($retorno, $aux);
//            }
//            return $retorno;
//        } catch (Exception $e) {
//            return false;
//        }
//    }
//
////Funcion que obtiene todos los jefes de proyectos inscritos en el sistema
//    static public function getAllJefeProyectoLibre() {
//
//        try {
//            //Extraer de la BBDD todos los trabajadores
//            $datos = PTrabajador::getAllJefeProyectoLibre();
//            $retorno = array();
//            foreach ($datos as $dato) {
//                //El ultimo parametro hay que pedir categoria por id
//                $aux = new Trabajador($dato[1], $dato[2], Usuario::GetUsuarioById($dato[3]));
//
//                //Asigno el id
//                $aux->idTrabajador = $dato[0];
//                //Cargo las vacaciones del trabajador
//                //$aux->vacaciones=Vacaciones::getVacacionesByTrabajador($dato[0]);
//                //Cargo el vector de resultados con la instancia actual
//                array_push($retorno, $aux);
//            }
//            return $retorno;
//        } catch (Exception $e) {
//            return false;
//        }
//    }
//
//    //Funci�n que obtiene el trabajador asociado a un usuario de la aplicacion
//    static public function getTrabajadorByUsuario(&$usuario) {
//
//        try {
//            $datos = PTrabajador::getTrabajadorByUsuario($usuario->getIdUsuario());
//            $retorno = new Trabajador($datos[1], $datos[2], $usuario);
//            $retorno->idTrabajador = $datos[0];
//            $retorno->vacaciones = Vacaciones::getVacacionesByTrabajador($retorno);
//            count($retorno->vacaciones);
//            return $retorno;
//        } catch (Exception $e) {
//            return false;
//        }
//    }
//
//    //Funci�n que obtiene todos los trabajadores capacitados para la realización de cierta actividad
//    static public function getAllTrabajadoresCapacitados($idRol, $f_ini, $f_fin, $c_proyecto) {
//
//        try {
//            //Extraer de la BBDD todos los trabajadores
//            $datos = PTrabajador::getAllTrabajadoresCapacitados($idRol, $f_ini, $f_fin, $c_proyecto);
//            $retorno = array();
//            foreach ($datos as $dato) {
//                //El ultimo parametro hay que pedir categoria por id
//                $aux = new Trabajador($dato[1], $dato[2], Usuario::GetUsuarioById($dato[3]));
//                //Asigno el id
//                $aux->idTrabajador = $dato[0];
//                //Cargo las vacaciones del trabajador
//                $aux->vacaciones = Vacaciones::getVacacionesByTrabajador($aux);
//                //Cargo el vector de resultados con la instancia actual
//                array_push($retorno, $aux);
//            }
//            return $retorno;
//        } catch (Exception $e) {
//            return false;
//        }
//    }
//
//    //Funci�n que obtiene todos los trabajadores capacitados para la realización de cierta actividad
//    static public function getResponsableProyecto($c_proyecto) {
//
//        try {
//            //Extraer de la BBDD todos los trabajadores
//            $datos = PTrabajador::getResponsableProyecto($c_proyecto);
//            $retorno = array();
//            foreach ($datos as $dato) {
//                //El ultimo parametro hay que pedir categoria por id
//                $aux = new Trabajador($dato[1], $dato[2], Usuario::GetUsuarioById($dato[3]));
//                //Asigno el id
//                $aux->idTrabajador = $dato[0];
//                //Cargo las vacaciones del trabajador
//                $aux->vacaciones = Vacaciones::getVacacionesByTrabajador($aux);
//                //Cargo el vector de resultados con la instancia actual
//                array_push($retorno, $aux);
//            }
//            return $retorno;
//        } catch (Exception $e) {
//            return false;
//        }
//    }
//
}
//Fin clase
?>
