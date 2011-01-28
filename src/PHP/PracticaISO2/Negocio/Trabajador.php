<?php

// Nombre: Trabajador
// Descripcion: Clase que representa la entidad trabajador del dominio del problema y ofrece las operaciones correspondientes para su manejo
//Clases del negocio
//include_once('Vacaciones.php');
//include_once('Actividad.php');
//include_once('Usuario.php');
//Inclusi�n de operaciones de la clase de persistencia
//include_once('Persistencia/PTrabajador.php');

class Trabajador extends Usuario {

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
        $datos = mysql_query('SELECT * FROM Trabajador WHERE (dni=\'' . $parametroDni . '\')') or die(mysql_error());
        $totalrows=mysql_num_rows($datos);
        if($totalrows>0){
            while($rowEmp=  mysql_fetch_assoc($datos)){
                return new Trabajador($rowEmp['dni'], $rowEmp['nombre'], $rowEmp['apellidos'], $rowEmp['fechaNac'], $rowEmp['categoria']);
            }
        } else {
            return false;
        }
    }

}
//Fin clase
?>
