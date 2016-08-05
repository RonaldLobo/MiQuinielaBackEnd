<?php
//Marlon Castro
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Prediccion.php';

class DbPrediccion {

    function agregarPrediccion($prediccion){
        $sql = "INSERT INTO prediccion (fkIdPrediccionPartido, fkIdPrediccionUsuario, fkIdPrediccionEquipo1, fkIdPrediccionEquipo2, marcadorEquipo1, marcadorEquipo2, puntaje) VALUES ('"
                .$prediccion->idPartido."', '"
                .$prediccion->idUsuario. "', '"
                .$prediccion->idEquipo1. "','"
                .$prediccion->idEquipo2. "','"
                .$prediccion->marcador1. "','"
                .$prediccion->marcador2. "','"
                .$prediccion->puntaje. "')";
        $db = new DB();
        $id = $db->agregar($sql);
        $prediccion->id = $id;
        return $prediccion;
    }
    
    function actualizarPrediccion($prediccion){
        $sql = "UPDATE prediccion SET "
                . "fkIdPrediccionPartido=".$prediccion->idPartido.", "
                . "fkIdPrediccionUsuario=".$prediccion->idUsuario.", "
                . "fkIdPrediccionEquipo1=".$prediccion->idEquipo1.", "
                . "fkIdPrediccionEquipo2=".$prediccion->idEquipo2.", "
                . "marcadorEquipo1=".$prediccion->marcador1.", "
                . "marcadorEquipo2=".$prediccion->marcador2.", "
                . "puntaje=".$prediccion->puntaje." "
                . "WHERE pkIdPrediccion=".$prediccion->id;
        $db = new DB();
        $db->actualizar($sql);
        return $prediccion;
    }
    
    function actualizarPuntaje($puntaje,$id){
        $sql = "UPDATE prediccion SET "
                . "puntaje=".$puntaje." "
                . "WHERE pkIdPrediccion=".$id;
        $db = new DB();
        $db->actualizar($sql);
        return $prediccion;
    }
    
    function deletePrediccion($id){
        $sql = "DELETE FROM prediccion WHERE pkIdPrediccion=".$id;
        $db = new DB();
        $db->actualizar($sql);
    }

    function deletePrediccionPartido($idPartido){
        $sql = "DELETE FROM prediccion WHERE fkIdPrediccionPartido=".$idPartido;
        $db = new DB();
        $db->actualizar($sql);
    }
    
    function obtenerPrediccion($id){
        $sql = "SELECT * FROM prediccion WHERE pkIdPrediccion=".$id;
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $prediccion = $this->parseRowAPrediccion($row);
        return $prediccion;
    }
    
    function listarPartidosPrediccion($idUsuario,$idTorneo){
        $sql = "SELECT prediccion.pkIdPrediccion,prediccion.fkIdPrediccionEquipo1,prediccion.fkIdPrediccionEquipo2"
                . ",prediccion.marcadorEquipo1 as m1,prediccion.marcadorEquipo2 as m2, partido.marcadorEquipo1 as p1,"
                . "partido.marcadorEquipo2 as p2,prediccion.puntaje ,partido.fecha FROM prediccion INNER JOIN usuario INNER JOIN partido"
                . " ON  usuario.pkIdUsuario=prediccion.fkIdPrediccionUsuario AND prediccion.fkIdPrediccionPartido=partido.pkIdPartido "
                . "WHERE prediccion.fkIdPrediccionUsuario=".$idUsuario." AND prediccion.puntaje!=0 AND partido.fkIdPartidoTorneo=".$idTorneo; 
        $db = new DB();
        $rowList = $db->listar($sql);
        $partidoList = $this->parseRowAPrediccionUserList($rowList);
        return $partidoList;
    }
    
    function parseRowPartidoPrediccion($row){
        $prediccion     = new Prediccion();
        $equipo1        = new Equipo();
        $equipo2        = new Equipo();
        $dbPrediccion   = new DbPrediccion();
        $dbEquipo       = new DbEquipo();
        $dbTorneo       = new DbTorneo();
        $prediccionPartido = array();
        
        if(isset($row['pkIdPrediccion'])){
            $prediccion->id = $row['pkIdPrediccion'];
        }
       
        
        if(isset($row['fkIdPrediccionEquipo1'])){
            $prediccion->idEquipo1 = $row['fkIdPrediccionEquipo1'];
        }
        
        if(isset($row['fkIdPrediccionEquipo2'])){
            $prediccion->idEquipo2 = $row['fkIdPrediccionEquipo2'];
        }
        
        if(isset($row['m1'])){
            $prediccion->marcador1 = $row['m1']."(".$row['p1'].")";
        }
        
        if(isset($row['m2'])){
            $prediccion->marcador2 = "(".$row['p2'].")".$row['m2'];
        }
        
        if(isset($row['puntaje'])){
            $prediccion->puntaje = $row['puntaje'];
        }
        
        
        $equipo1    = $dbEquipo->obtenerEquipo($prediccion->idEquipo1);
        $equipo2    = $dbEquipo->obtenerEquipo($prediccion->idEquipo2);
        
        
        $prediccion->idEquipo1 = $equipo1->equipo."&".$equipo1->acronimo;
        $prediccion->idEquipo2 = $equipo2->equipo."&".$equipo2->acronimo;
        if(strtotime($row['fecha']) < time()){
            return $prediccion;}  else {
            return null;
        }
    }
    
    function obtenerPrediccionPorPartido($id){ #camh20170707
        $sql = "SELECT * FROM prediccion WHERE fkIdPrediccionPartido=".$id;
        $db = new DB();
        $rowList = $db->listar($sql);
        $prediccionList = $this->parseRowAPrediccionList($rowList);
        return $prediccionList;
    }
    
    function obtenerPrediccionPorPartidoUsuario($id, $usuario){ #camh20170707
        $sql = "SELECT * FROM prediccion WHERE fkIdPrediccionPartido=".$id." AND fkIdPrediccionUsuario=".$usuario;
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $prediccion = $this->parseRowAPrediccion($row);
        return $prediccion;
    }
    
    /*function obtenerPorPrediccion($predictionname){
        $sql = "SELECT * FROM prediccion WHERE prediccion='".$predictionname."'";
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $prediccion = $this->parseRowAPrediccion($row);
        return $prediccion;
    }*/
    
    function listarPredicciones(){
        $sql = "SELECT * FROM prediccion";
        $db = new DB();
        $rowList = $db->listar($sql);
        $prediccionList = $this->parseRowAPrediccionList($rowList);
        return $prediccionList;
    }
    
    
    
    function parseRowAPrediccion($row) {
        $prediction = new Prediccion();
        if(isset($row['pkIdPrediccion'])){
            $prediction->id = $row['pkIdPrediccion'];
        }
        if(isset($row['fkIdPrediccionPartido'])){
            $prediction->idPartido = $row['fkIdPrediccionPartido'];
        }
        if(isset($row['fkIdPrediccionUsuario'])){
            $prediction->idUsuario = $row['fkIdPrediccionUsuario'];
        }
        if(isset($row['fkIdPrediccionEquipo1'])){
            $prediction->idEquipo1 = $row['fkIdPrediccionEquipo1'];
        }
        if(isset($row['fkIdPrediccionEquipo2'])){
            $prediction->idEquipo2 = $row['fkIdPrediccionEquipo2'];
        }
        if(isset($row['marcadorEquipo1'])){
            $prediction->marcador1 = $row['marcadorEquipo1'];
        }
        if(isset($row['marcadorEquipo2'])){
            $prediction->marcador2 = $row['marcadorEquipo2'];
        }
        if(isset($row['puntaje'])){
            $prediction->puntaje = $row['puntaje'];
        }
        return $prediction;
    }
    
    function parseRowAPrediccionList($rowList) {
        $parsedPrediccions = array();
        foreach ($rowList as $row) {
            array_push($parsedPrediccions, $this->parseRowAPrediccion($row));
        }
        return $parsedPrediccions;
    }
    
    function parseRowAPrediccionUserList($rowList) {
        $parsedPrediccions = array();
        foreach ($rowList as $row) {
            array_push($parsedPrediccions, $this->parseRowPartidoPrediccion($row));
        }
        return $parsedPrediccions;
    }
    
} 
