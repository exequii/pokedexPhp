<?php

class PokedexController{
    private $printer;
    private $model;

    public function __construct($printer,$model)
    {
        $this->printer = $printer;
        $this->model = $model;
    }

    public function show(){
        $data["pokemones"] = $this->model->getPokemonList();
        $data['usuario'] = $_SESSION['usuario'];
        if(empty($_SESSION['admin'])){
            echo $this->printer->render("view/pokedexView.html",$data);
        }else{
            $data['admin'] = $_SESSION['admin'];
            echo $this->printer->render("view/pokedexView.html",$data);
        }
    }

    public function buscar(){
        $filtro = $_GET["busqueda"];
        $data["pokemones"] = $this->model->getPokemonFilterListBy($filtro);
        $data["error"]=false;
        if(empty($data["pokemones"])){
            $data["pokemones"] = $this->model->getPokemonList();
            $data["error"]=true;
        }
        echo $this->printer->render("view/pokedexView.html",$data);
    }

    public function descripcion(){
        $id = $_GET["idPokemon"];
        $_SESSION['idPokemon'] = $id;
        if(empty($id)){
            $data["pokemones"] = $this->model->getPokemonList();
            $data["error"]=true;
            echo $this->printer->render("view/pokedexView.html",$data);
        }else{
            $data["pokemones"] = $this->model->getPokemonFilterListById($id);
            if(!empty($_SESSION['admin']) && !empty($_SESSION['usuario'])){
                $data['admin']=$_SESSION['admin'];
                $data['usuario'] = $_SESSION['usuario'];
            }
            echo $this->printer->render("view/descripcionView.html",$data);
        }
    }

    public function nuevo(){
        echo $this->printer->render("view/nuevoPokemonView.html");
    }

    public function baja(){
        $id= $_SESSION['idPokemon'];
        $this->model->borrarPokemon($id);
        header("location: /pokemon");
    }

    public function modificar(){
        echo $this->printer->render("view/modificarView.html");
    }

    public function cambiarDatos(){
        $numero= $_POST["numero"];
        $nombre= $_POST["nombre"];
        $descripcion= $_POST["descripcion"];
        $tipo= $_POST["tipo"];
        $idPokemon = $_SESSION['idPokemon'];
        $imagen= $_FILES["imagen"];
        $this->subirImagen();

        $this->model->actualizar($numero,$nombre,$descripcion,$tipo,$nombre . ".png",$idPokemon);
        header("location: /pokemon");
    }

    public function agregar(){
        $numero= $_POST["numero"];
        $nombre= $_POST["nombre"];
        $descripcion= $_POST["descripcion"];
        $tipo= $_POST["tipo"];
        $imagen= $_FILES["imagen"];

        $this->subirImagen();
        //move_uploaded_file($_FILES["imagen"]["tmp_name"] ,"/public/" .$nombre. ".png");

        $this->model->nuevo($numero,$nombre,$descripcion,$tipo,$nombre . ".png");
        header("location: /pokemon");
    }

    public function subirImagen(){

            $arch = $_FILES['imagen']['name'];
            if (isset($arch) && $arch != "") {
                $tipo = $_FILES['imagen']['type'];
                $tamano = $_FILES['imagen']['size'];
                $temp = $_FILES['imagen']['tmp_name'];
                if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 20000000)) {
                    echo "<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
                - Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.</b></div>";
                }
                else {
                    if (move_uploaded_file($temp, './public/'.$arch)) {
        
                        echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
        
                        echo "<p><img src='./public/$arch'></p>";
                    }
                    else {
                        //Si no se ha podido subir la imagen, mostramos un mensaje de error
                        echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
                    }
                }
            }
        }
    
}
