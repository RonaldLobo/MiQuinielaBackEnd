<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbPrediccion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbTorneo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Partido.php';

class DbPartido {
    
    function agregarPartido($partido){
        $sql = "INSERT INTO partido(fkIdPartidoTorneo, fkIdPartidoEquipo1, "
                . "fkIdPartidoEquipo2, marcadorEquipo1, marcadorEquipo2, fecha) VALUES ("
                . $partido->idPartidoTorneo.", "
                . $partido->idPartidoEquipo1.", "
                . $partido->idPartidoEquipo2.", "
                . $partido->marcadorEquipo1.", "
                . $partido->marcadorEquipo2.", '"
                . $partido->fecha."')";
        $db = new DB();
        $idPartido = $db->agregar($sql);
        $partido->idPartido = $idPartido;
        return $partido;
    }
    
    function actualzarPartido($partido){
        $sql = "UPDATE partido SET "
                . "fkIdPartidoTorneo=".$partido->idPartidoTorneo.", "
                . "fkIdPartidoEquipo1=".$partido->idPartidoEquipo1.", "
                . "fkIdPartidoEquipo2=".$partido->idPartidoEquipo2.", "
                . "marcadorEquipo1=".$partido->marcadorEquipo1.", "
                . "marcadorEquipo2=".$partido->marcadorEquipo2.", "
                . "fecha='".$partido->fecha."' "
                . "WHERE pkIdPartido=".$partido->idPartido;
        $db = new DB();
        $db->actualizar($sql);
        return $partido;
    }
    
    function deletePartido($idPartido){
        $sql    = "DELETE FROM partido WHERE pkIdPartido=".$idPartido;
        $db     = new DB();
        $db->actualizar($sql);
    }
    
    function obtenerPartido($idPartido){
        $sql     = "SELECT * FROM partido WHERE pkIdPartido=".$idPartido;
        $db      = new DB();
        $row     = $db->obtenerUno($sql);
        $partido = $this->parseRowPartido($row);
        return $partido;
    }
    
    function listarPartidos(){
        $sql = "SELECT * FROM partido";
        $db = new DB();
        $rowList = $db->listar($sql);
        $partidoList = $this->parseRowaPartidoList($rowList);
        return $partidoList;
    }
    
    function parseRowPartido($row){
        $partido        = new Partido();
        $dbPrediccion   = new DbPrediccion();
        $dbTorneo       = new DbTorneo();
        $prediccionPartido = array();
        
        if(isset($row['pkIdPartido'])){
            $partido->idPartido = $row['pkIdPartido'];
        }
        
        if(isset($row['fkIdPartidoTorneo'])){
            $partido->idPartidoTorneo = $row['fkIdPartidoTorneo'];
        }
        
        if(isset($row['fkIdPartidoEquipo1'])){
            $partido->idPartidoEquipo1 = $row['fkIdPartidoEquipo1'];
        }
        
        if(isset($row['fkIdPartidoEquipo2'])){
            $partido->idPartidoEquipo2 = $row['fkIdPartidoEquipo2'];
        }
        
        if(isset($row['marcadorEquipo1'])){
            $partido->marcadorEquipo1 = $row['marcadorEquipo1'];
        }
        
        if(isset($row['marcadorEquipo2'])){
            $partido->marcadorEquipo2 = $row['marcadorEquipo2'];
        }
        
        if(isset($row['fecha'])){
            $partido->fecha = $row['fecha'];
        }
        
        $prediccion = $dbPrediccion->obtenerPrediccionPorPartido($partido->idPartido);
        $torneo     = $dbTorneo->obtenerTorneo($partido->idPartidoTorneo); 
        
        if($prediccion->id == 0){
           $prediccionPartido = array('marcador1'=>0, 'marcador2'=>0, 'puntaje'=>0);
        }
        else{
           $prediccionPartido = array('marcador1'=>$prediccion->marcador1, 
               'marcador2'=>$prediccion->marcador2, 
               'puntaje'=>$prediccion->puntaje); 
        }
        
        $torneoPartido = array('id'=>$torneo->idTorneo, 'nombre'=>$torneo->torneo);
        
        $partido->prediccion    = $prediccionPartido;
        $partido->torneo        = $torneoPartido;
        
        return $partido;
    }
    
    function parseRowaPartidoList($rowList){
        $pasedPartidos = array();
        foreach ($rowList as $row){
            array_push($pasedPartidos, $this->parseRowPartido($row));
        }
        return $pasedPartidos;
    }
}
