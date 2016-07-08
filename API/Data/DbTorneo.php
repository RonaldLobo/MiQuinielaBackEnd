<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Torneo.php';

class DbTorneo {
    function obtenerTorneo($idTorneo){
        $sql     = "SELECT * FROM torneo WHERE pkIdTorneo=".$idTorneo;
        $db      = new DB();
        $row     = $db->obtenerUno($sql);
        $partido = $this->parseRowPartido($row);
        return $partido;
    }
    
    function parseRowPartido($row){
        $torneo = new Torneo();
        if(isset($row['pkIdTorneo'])){
            $torneo->idTorneo = $row['pkIdTorneo'];
        }
        
        if(isset($row['torno'])){
            $torneo->torneo = $row['torno'];
        }
        
        if(isset($row['estado'])){
            $torneo->estado = $row['estado'];
        }
        
        return $torneo;
    }
    
    
}
