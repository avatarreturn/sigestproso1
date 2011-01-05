<?php


// Nombre:Usuario
// Descripcion: Clase que representa la entidad usuario del dominio del problema y ofrece las operaciones correspondientes para su manejo
//include_once('Persistencia/PUsuario.php');
include_once ('Persistencia/conexion.php');

class Usuario {

    public $login;
    public $password;
    public $tipoUsuario;

    //Constructor de la clase privado para cuando recupero de la base de datos
    public function __construct($login, $password, $tipoUsuario) {
        $this->login = $login;
        $this->password = $password;
        $this->tipoUsuario = $tipoUsuario;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Getters y Setters
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        return $this->login = $login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        return $this->password = $password;
    }

    public function getTipo() {
        return $this->tipoUsuario;
    }

    public function setTipo($t) {
        return $this->tipoUsuario = $t;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////METODOS/////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
//    //Funcion que se encarga de hacer persistente el objeto, devuelve true si lo guard� y false si no, faltaria meter el update
//    public function Guardar() {
//
//        //Si el id es 0 inserto y si no actualizo el registro
//        if ($this->idUsuario == 0) {
//            //Invoco al metodo guardar estatico de pusuario, que me devuelve true si inserta y false si no
//            $retorno = PUsuario::Guardar($this->login, $this->nombre, $this->apellidos, $this->password, $this->email, $this->direccion, $this->telefono, $this->tipo);
//            if ($retorno == 0)
//                return false;
//            else {
//                $this->idUsuario = $retorno[0];
//                return true;
//            }
//        } else {
//            $retorno = PUsuario::Actualizar($this->idUsuario, $this->login, $this->nombre, $this->apellidos, $this->password, $this->email, $this->direccion, $this->telefono, $this->tipo);
//            if ($retorno == 0)
//                return false;
//            else
//                return true;
//        }
//    }
//
//    //Funcion que elimina el objeto de persistencia, devuelve true si lo borr� y false si no
//    public function Borrar() {
//        //Si el id es distinto de 0 intento borrar si no ni lo intento
//        if ($this->idUsuario == 0)
//            return false;
//        else
//            return PUsuario::Borrar($this->idUsuario);
//    }
//
//    //Funcion que comprueba si la contrase�a coincide con la del usuario, devuelve true si conincide false si no
//    public function CompruebaContrasena($npassword) {
//        if ($this->password == $npassword)
//            return true;
//        else
//            return false;
//    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////METODOS ESTATICOS////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Funcion que crea un usuario a partir de los datos de la base de datos
    static public function getUsuario($parametroLogin) {
        $datos = mysql_query('SELECT * FROM usuario WHERE (login=\'' . $parametroLogin . '\')') or die(mysql_error());
        $totalrows=mysql_num_rows($datos);
        if($totalrows>0){
            while($rowEmp=  mysql_fetch_assoc($datos)){
                return new Usuario($rowEmp['login'], $rowEmp['password'], $rowEmp['tipoUsuario']);
            }  
        } else {
            return false;
        }
    }

//    //Funcion que devuelve el objeto usuario si este existe, si este no existe devulve null
//    static public function ExisteUsuario($login) {
//        $datos = PUsuario::GetUsuario($login);
//        if ($datos)
//            return new Usuario($datos["0"], $datos["1"], $datos["2"], $datos["3"], $datos["4"], $datos["5"], $datos["6"], $datos["7"], $datos["8"]);
//        else
//            return false;
//    }
//
//    //Funcion que devuelve el objeto usuario si este existe, si este no existe devulve null
//    static public function GetUsuarioById($id) {
//        $datos = PUsuario::GetUsuarioById($id);
//        if ($datos)
//            return new Usuario($datos["0"], $datos["1"], $datos["2"], $datos["3"], $datos["4"], $datos["5"], $datos["6"], $datos["7"], $datos["8"]);
//        else
//            return false;
//    }
}

?>
