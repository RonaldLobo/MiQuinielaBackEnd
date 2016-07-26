<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Torneo.php';

class DbTorneo {
   
      
    function agregarTorneo($torneo){
        $sql = "INSERT INTO torneo (torneo, estado) VALUES ('"
                .$torneo->torneo ."', '"
                .$torneo->estado. "')";
        $db = new DB();
        $torneoId = $db->agregar($sql);
        $torneo->id = $torneoId;
        return $torneo;
   }
    
    function actualizarTorneo($torneo){
        $sql = "UPDATE torneo SET "
                . "torneo='".$torneo->torneo."', "
                . "estado='".$torneo->estado."'"
                . "WHERE pkIdTorneo=".$torneo->id;
        $db = new DB();
        $db->actualizar($sql);
        return $torneo;
    }
    
       
    function eliminarTorneo($id){
        $sql = "DELETE FROM torneo WHERE pkIdTorneo=".$id;
        $db = new DB();
        $db->actualizar($sql);
    }
           
    
    function obtenerTorneo($id){
        $sql = "SELECT torneo, estado, pkIdTorneo FROM torneo WHERE pkIdTorneo=".$id;
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $usuario = $this->parseRowTorneo($row);
        return $usuario;
    }
    
    function obtenerPorTorneo($torneo){
        $sql = "SELECT torneo, estado, pkIdTorneo FROM torneo WHERE torneo='".$torneo."'";
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $usuario = $this->parseRowTorneo($row);
        return $usuario;
    }
    
    function listarTorneo(){
        $sql = " SELECT torneo, estado, pkIdTorneo FROM torneo";
        $db = new DB();
        $rowList = $db->listar($sql);
        $usuarioList = $this->parseRowTorneoList($rowList);
        return $usuarioList;
    }
      
    function listarTorneoPorUsuario($usuario){
        $sql = "SELECT torneo.pkIdTorneo , torneo.torneo , torneo.estado FROM usuarioTorneo INNER JOIN torneo ON usuarioTorneo.fkIdTorneo=torneo.pkIdTorneo WHERE usuarioTorneo.fkIdUsuario=".$usuario;
        $db = new DB();
        $rowList = $db->listar($sql);
        $usuarioList = $this->parseRowTorneoList($rowList);
        return $usuarioList;
    }
      
        
    function parseRowTorneo($row) {
        $torn = new Torneo();
        if(isset($row['torneo'])){
            $torn->torneo = $row['torneo'];
        }
        if(isset($row['pkIdTorneo'])){
            $torn->id = $row['pkIdTorneo'];
        }
        if(isset($row['estado'])){
            $torn->estado = $row['estado'];
        }
         return $torn;
    }
    
    function parseRowTorneoList($rowList) {
        $parsedTorneo = array();
        foreach ($rowList as $row) {
            array_push($parsedTorneo, $this->parseRowTorneo($row));
        }
        return $parsedTorneo;
    }
    
}
