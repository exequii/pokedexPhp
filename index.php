<?php
session_start();
include_once("config/Configuration.php");

$module = isset($_GET["module"]) ? $_GET["module"] : "pokedex" ;
$action = isset($_GET["action"]) ? $_GET["action"] : "show" ;

$configuration = new Configuration();
$router = $configuration->createRouter( "createPokedexController", "show");

$router->executeActionFromModule($module,$action);

?>