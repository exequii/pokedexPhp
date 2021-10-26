<?php

class RegistroController{

    private $printer;
    private $registroModel;

    public function __construct($registroModel,$printer)
    {
        $this->printer = $printer;
        $this->registroModel = $registroModel;
    }

    public function show()
    {
        if (isset($_SESSION['usuario'])){
            $data['usuario'] = $_SESSION['usuario'];
            echo $this->printer->render( "view/registroView.html",$data);
        }else {
            echo $this->printer->render( "view/registroView.html");
        }    
    }

    function procesarRegistro(){
        $data["usuario"] = $_POST["usuario"];
        $data["clave"] = $_POST["clave"];
        $data["repiteClave"] = $_POST["repiteClave"];
        $data["rol"] = "usuario";

        if($data["clave"] == $data["repiteClave"]){
            $data['msg'] = $this->registroModel->setUsuario($data["usuario"], $data["clave"], $data["repiteClave"], $data["rol"]);
            echo $this->printer->render( "view/registroView.html", $data);
        }
        else{
            $data['errores'] = "Las contraseñas no coinciden";
            echo $this->printer->render( "view/registroView.html", $data);
        }
    }

    function logout(){
        if(isset($_SESSION['usuario'])){
            session_destroy();
        }

        header('Location: index.php');
    }

}

?>