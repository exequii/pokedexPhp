<?php

class PokedexModel{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function getPokemonList(){
        return $this->database->query("SELECT * FROM pokemones");
    }

    public function getPokemonFilterListBy($filter){
        return $this->database->query("SELECT * FROM pokemones WHERE nombre LIKE '%".$filter."%' OR tipo LIKE '%".$filter."%' OR numero LIKE '%".$filter."%'");
    }

    public function getPokemonFilterListById($id){
        return $this->database->query("SELECT * FROM pokemones WHERE idPokemon =".$id."");
    }

    public function nuevo($numero,$nombre,$descripcion,$tipo,$imagen){
        $query = "INSERT INTO `pokemones` (`numero`, `tipo`, `nombre`, `descripcion`, `imagen`) VALUES ('$numero','$tipo','$nombre','$descripcion','$imagen')";
        return $this->database->excecute($query);
    }

    public function borrarPokemon($id){
        $sql = "DELETE FROM `pokemones` WHERE idPokemon=".$id."";
        return $this->database->excecute($sql);
    }

    public function actualizar($numero,$nombre,$descripcion,$tipo,$imagen,$id){
        $query = "UPDATE `pokemones` SET `numero`='$numero',`tipo`='$tipo',`nombre`='$nombre',`descripcion`='$descripcion',`imagen`='$imagen' WHERE `idPokemon`='$id'";
        return $this->database->excecute($query);
    }
}