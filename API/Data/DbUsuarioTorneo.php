<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/UsuarioTorneo.php';

class DbUsuarioTorneo {

    function agregarUsuarioTorneo($usuarioTorneo){
        $sql = "INSERT INTO usuarioTorneo (fkIdUsuario, fkIdTorneo) VALUES ('"
                .$usuarioTorneo->usuario."', '"
                .$usuarioTorneo->torneo. "')";
        $db = new DB();
        $id = $db->agregar($sql);
        $usuarioTorneo->id = $id;
        return $usuarioTorneo;
    }
    function agregarUsuarioTorneoAuth($usuarioTorneo){
        $sql = "INSERT INTO usuarioTorneo (fkIdUsuario, fkIdTorneo) VALUES ('"
                .$usuarioTorneo->id."', '1')";
        $db = new DB();
        $id = $db->agregar($sql);
        $usuarioTorneo->id = $id;
        return $usuarioTorneo;
    }
    
    function actualizarUsuarioTorneo($usuarioTorneo){
        $sql = "UPDATE usuarioTorneo SET "
                . "fkIdUsuario='".$usuarioTorneo->usuario."', "
                . "fkIdTorneo='".$usuarioTorneo->torneo."' "
                . "WHERE pkIdUsuarioTorneo=".$usuarioTorneo->id;
        $db = new DB();
        $db->actualizar($sql);
        return $usuarioTorneo;
    }
    
    function deleteUsuarioTorneo($id){
        $sql = "DELETE FROM usuarioTorneo WHERE pkIdUsuarioTorneo=".$id;
        $db = new DB();
        $db->actualizar($sql);
    }
    
    function deleteUsuarioTorneoPorTorneoYUsuario($torneo,$usuario){
        $sql = "DELETE FROM usuarioTorneo WHERE fkIdUsuario=".$usuario." AND fkIdTorneo=".$torneo;
        $db = new DB();
        $db->actualizar($sql);
    }
            
    function obtenerUsuarioTorneo($id){
        $sql = "SELECT * FROM usuarioTorneo WHERE pkIdUsuarioTorneo=".$id;
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $usuarioTorneo = $this->parseRowAUsuarioTorneo($row);
        return $usuarioTorneo;
    }
    
    function obtenerUsuarioTorneoPorUsuarioTorneo($idUsuario,$idTorneo){
        $sql = "SELECT * FROM usuarioTorneo WHERE fkIdUsuario=".$idUsuario." AND fkIdTorneo=".$idTorneo;
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $usuarioTorneo = $this->parseRowAUsuarioTorneo($row);
        return $usuarioTorneo;
    }
    
    /*function obtenerPorUsuarioTorneo($userTournametname){
        $sql = "SELECT * FROM usuarioTorneo WHERE usuarioTorneo='".$userTournametname."'";
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $usuarioTorneo = $this->parseRowAUsuarioTorneo($row);
        return $usuarioTorneo;
    }*/
    
    function listarUsuarioTorneos(){
        $sql = "SELECT * FROM usuarioTorneo";
        $db = new DB();
        $rowList = $db->listar($sql);
        $usuarioTorneoList = $this->parseRowAUsuarioTorneoList($rowList);
        return $usuarioTorneoList;
    }
    
    
    
    function parseRowAUsuarioTorneo($row) {
        $userTournamet = new UsuarioTorneo();
        if(isset($row['pkIdUsuarioTorneo'])){
            $userTournamet->id = $row['pkIdUsuarioTorneo'];
        }
        if(isset($row['fkIdUsuario'])){
            $userTournamet->usuario = $row['fkIdUsuario'];
        }
        if(isset($row['fkIdTorneo'])){
            $userTournamet->torneo = $row['fkIdTorneo'];
        }
        return $userTournamet;
    }
    
    function parseRowAUsuarioTorneoList($rowList) {
        $parsedUsuarioTorneos = array();
        foreach ($rowList as $row) {
            array_push($parsedUsuarioTorneos, $this->parseRowAUsuarioTorneo($row));
        }
        return $parsedUsuarioTorneos;
    }
    
    
    
} 
