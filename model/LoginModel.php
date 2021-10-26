<?php

use JetBrains\PhpStorm\Internal\ReturnTypeContract;

class LoginModel
{
    private $database;
    
    public function __construct($database){
        $this->database = $database;
    }

    public function getUsuario($email,$password){
        $SQL = "SELECT * FROM usuario WHERE usuario = '".$email."' AND clave = '".$password."'";
        $usuario = $this->database->query($SQL);
        return $usuario;
    }


    public function obtenerRolDeUsuario($nombre_usuario){
        $SQL = "SELECT rol FROM usuario WHERE usuario like '$nombre_usuario'";
        return $this->database->query($SQL);
    }
}

?>