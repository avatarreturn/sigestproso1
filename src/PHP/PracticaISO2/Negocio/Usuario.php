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

    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////METODOS ESTATICOS////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Funcion que crea un usuario a partir de los datos de la base de datos
    static public function getUsuario($parametroLogin) {
        $datos = mysql_query('SELECT * FROM Usuario WHERE (login=\'' . $parametroLogin . '\')') or die(mysql_error());
        $totalrows=mysql_num_rows($datos);
        if($totalrows>0){
            while($rowEmp=  mysql_fetch_assoc($datos)){
                return new Usuario($rowEmp['login'], $rowEmp['password'], $rowEmp['tipoUsuario']);
            }  
        } else {
            return false;
        }
    }
}

?>
