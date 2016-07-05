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
                . "fkIdPrediccionPartido='".$prediccion->idPartido."', "
                . "fkIdPrediccionUsuario='".$prediccion->idUsuario."', "
                . "fkIdPrediccionEquipo1='".$prediccion->idEquipo1."', "
                . "fkIdPrediccionEquipo2='".$prediccion->idEquipo2."', "
                . "marcadorEquipo1='".$prediccion->marcador1."', "
                . "marcadorEquipo2='".$prediccion->marcador2."' "
                . "puntaje='".$prediccion->puntaje."' "
                . "WHERE pkIdPrediccion=".$prediccion->id;
        $db = new DB();
        $db->actualizar($sql);
        return $prediccion;
    }
    
    function deletePrediccion($id){
        $sql = "DELETE FROM prediccion WHERE pkIdPrediccion=".$id;
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
    
    /*function obtenerPorPrediccion($predictionname){
        $sql = "SELECT * FROM prediccion WHERE prediccion='".$predictionname."'";
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $prediccion = $this->parseRowAPrediccion($row);
        return $prediccion;
    }*/
    
    function listarPrediccions(){
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
    
    
    
} 
