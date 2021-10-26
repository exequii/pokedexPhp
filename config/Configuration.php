<?php
class Configuration{

    private $config;

    public  function createPokedexController(){
        require_once("controller/PokedexController.php");
        return new PokedexController($this->createPrinter(), $this->createPokedexModel());
    }

    
    public function createLoginController(){
        require_once("controller/LoginController.php");
        return new LoginController( $this->createLoginModel(), $this->createPrinter());
    }

    public function createRegistroController(){
        require_once("controller/RegistroController.php");
        return new RegistroController( $this->createRegistroModel(), $this->createPrinter());
    }

    /***************************************************************** */

    private  function createPokedexModel(){
        require_once("model/PokedexModel.php");
        $database = $this->getDatabase();
        return new PokedexModel($database);
    }

    public function createLoginModel(){
        require_once("model/LoginModel.php");
        $database = $this->getDatabase();
        return new LoginModel($database);
    }

    public function createRegistroModel(){
        require_once("model/RegistroModel.php");
        $database = $this->getDatabase();
        return new RegistroModel($database);
    }

    /***************************************************************** */

    
    private  function getDatabase(){
        require_once("helpers/MyDatabase.php");
        $config = $this->getConfig();
        return new MyDatabase($config["servername"], $config["username"], $config["password"], $config["dbname"]);
    }

    private  function getConfig(){
        if( is_null( $this->config ))
            $this->config = parse_ini_file("config/config.ini");

        return  $this->config;
    }

    private function getLogger(){
        require_once("helpers/Logger.php");
        return new Logger();
    }

    public function createRouter($defaultController, $defaultAction){
        include_once("helpers/Router.php");
        return new Router($this,$defaultController,$defaultAction);
    }

    private function createPrinter(){
        require_once ('third-party/mustache/src/Mustache/Autoloader.php');
        require_once("helpers/MustachePrinter.php");
        return new MustachePrinter("view/partials");
    }

}