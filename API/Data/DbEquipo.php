<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Equipo.php';

class DbEquipo {
    
    
    
    function agregarEquipo($equipo){
        $sql = "INSERT INTO equipo (equipo, estado,acronimo) VALUES ('"
                .$equipo->equipo ."', '"
                .$equipo->estado. "', '"
                .$equipo->acronimo. "')";
        $db = new DB();
        $equipo->id =$db->agregar($sql);
        return $equipo;
   }
    
    function actualizarEquipo($equipo){
        $sql = "UPDATE equipo SET "
                . "equipo='".$equipo->equipo."', "
                . "estado='".$equipo->estado."', "
                . "acronimo='".$equipo->acronimo."'"
                . "WHERE pkIdEquipo=".$equipo->id;
        $db = new DB();
        $db->actualizar($sql);
        return $equipo;
    }
    
       
    function eliminarEquipo($id){
        $sql = "DELETE equipo SET "
                . "WHERE pkIdEquipo=".$id;
        $db = new DB();
        $db->actualizar($sql);
        return $equipo;
    }
      
      
    
     function obtenerEquipo($id){
        $sql = "SELECT equipo, estado, pkIdEquipo,acronimo FROM equipo WHERE pkIdEquipo=".$id;
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $usuario = $this->parseRowEquipo($row);
        return $usuario;
    }
    
    function obtenerPorEquipo($equipo){
        $sql = "SELECT equipo, estado, pkIdEquipo, acronimo  FROM equipo WHERE equipo='".$equipo."'";
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $usuario = $this->parseRowEquipo($row);
        return $usuario;
    }
    
    function listarEquipo(){
        $sql = " SELECT equipo, estado, acronimo, pkIdEquipo FROM equipo";
        $db = new DB();
        $rowList = $db->listar($sql);
        $usuarioList = $this->parseRowEquipoList($rowList);
        return $usuarioList;
    }
    
       
    
    function parseRowEquipo($row) {
        $team = new Equipo();
        if(isset($row['equipo'])){
            $team->equipo = $row['equipo'];
        }
        if(isset($row['pkIdEquipo'])){
            $team->id = $row['pkIdEquipo'];
        }
        if(isset($row['estado'])){
            $team->estado = $row['estado'];
        }
        if(isset($row['acronimo'])){
            $team->acronimo = $row['acronimo'];
        }
         return $team;
    }
    
    function parseRowEquipoList($rowList) {
        $parsedEquipo = array();
        foreach ($rowList as $row) {
            array_push($parsedEquipo, $this->parseRowEquipo($row));
        }
        return $parsedEquipo;
    }
}
