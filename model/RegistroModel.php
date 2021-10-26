<?php

class RegistroModel
{
    private $database;
    
    public function __construct($database){
        $this->database = $database;
    }

    function verificarSiLaCuentaExiste($email, $password){
        $SQL = "SELECT * FROM usuario WHERE usuario = '".$email."' AND clave = '".$password."'";
        $usuario = $this->database->query($SQL);
        if($usuario != null){
            return false;
        }
        else{
            return true;
        }
    }

    function setUsuario($email,$password,$repitePassword,$rol){
        if($password == $repitePassword) {
            if($this->verificarSiLaCuentaExiste($email,$password)){
                $SQL = "INSERT INTO `usuario` (`usuario`, `clave`, `rol`) VALUES ('$email','$password','$rol')";
                $this->database->excecute($SQL);

            }else{
                echo "El mail ya se encuentra registrado.";
            }
        }
        else{
            echo "Las contraseñas no coinciden";
            //$_SESSION['errores'] = "Las contraseñas no coinciden";
        }
    }
}

?>