<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of conexion
 *
 * @author marsant
 */
class conexion {


    private $recurso;
    private $debug = false;
    private $server = "localhost";
    private $user = "grupo01";
    private $password = "0F9RLuM8";
    private $database = "grupo01";

    function __construct() {
        $this->recurso = mysql_connect($this->server, $this->user, $this->password) or die('ERROR EN LA CONEXION: ' . mysql_error());
        mysql_select_db($this->database,$this->recurso) or die('ERROR AL ESCOJER LA BD: ' . mysql_error());
    }

    function cerrarConexion() {
        mysql_close($this->recurso);
    }
    
}
?>
