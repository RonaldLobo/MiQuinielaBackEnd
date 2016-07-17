<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbPrediccion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbTorneo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Partido.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Prediccion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbEquipo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Equipo.php';

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
        $partido->fecha = strtotime($partido->fecha);
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
    
    function obtenerPartido($idPartido, $idUsuario){
        $sql     = "SELECT * FROM partido WHERE pkIdPartido=".$idPartido;
        $db      = new DB();
        $row     = $db->obtenerUno($sql);
        $partido = $this->parseRowPartido($row, $idUsuario);
        return $partido;
    }
    
    function listarPartidos($idUsuario){
        $sql = "SELECT * FROM partido";
        $db = new DB();
        $rowList = $db->listar($sql);
        $partidoList = $this->parseRowaPartidoList($rowList, $idUsuario);
        return $partidoList;
    }
    
    function listarPartidosEntre($idUsuario, $fechaInicio, $fechaFin){
        $sql = "SELECT "
                . " partido.pkIdPartido, "
                . " partido.fkIdPartidoTorneo, "
                . " partido.fkIdPartidoEquipo1, "
                . " partido.fkIdPartidoEquipo2, "
                . " partido.marcadorEquipo1, "
                . " partido.marcadorEquipo2, "
                . " partido.fecha "
                . " FROM "
                . " partido INNER JOIN torneo ON partido.fkIdPartidoTorneo=torneo.pkIdTorneo "
                . " INNER JOIN grupo ON grupo.fkIdGrupoTorneo=torneo.pkIdTorneo "
                . " INNER JOIN usuarioGrupo ON usuarioGrupo.fkIdGrupo=grupo.pkIdGrupo "
                . " WHERE usuarioGrupo.fkIdUsuarioGrupo=".$idUsuario
                . " AND partido.fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."'"
                . " GROUP BY partido.pkIdPartido"; 
        $db = new DB();
        $rowList = $db->listar($sql);
        $partidoList = $this->parseRowaPartidoList($rowList, $idUsuario);
        return $partidoList;
    }
    
    function parseRowPartido($row, $idUsuario){
        $partido        = new Partido();
        $prediccion     = new Prediccion();
        $equipo1        = new Equipo();
        $equipo2        = new Equipo();
        $dbPrediccion   = new DbPrediccion();
        $dbEquipo       = new DbEquipo();
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
            $partido->fecha = strtotime($row['fecha']);
        }
        
        $prediccion = $dbPrediccion->obtenerPrediccionPorPartido($partido->idPartido);
        $torneo     = $dbTorneo->obtenerTorneo($partido->idPartidoTorneo);
        $equipo1    = $dbEquipo->obtenerEquipo($partido->idPartidoEquipo1);
        $equipo2    = $dbEquipo->obtenerEquipo($partido->idPartidoEquipo2);
        

        
        if($prediccion->id == "0"){
            $prediccion->idPartido = $partido->idPartido;
            $prediccion->idEquipo1 = $partido->idPartidoEquipo1;
            $prediccion->idEquipo2 = $partido->idPartidoEquipo2;
            $prediccion->idUsuario = $idUsuario;
            $prediccion->marcador1 = 0;
            $prediccion->marcador2 = 0;
            $prediccion->puntaje   = 0;
            
            $prediccionReult = $dbPrediccion->agregarPrediccion($prediccion);
            
           $prediccionPartido = array('marcador1'=>0, 'marcador2'=>0, 'puntaje'=>0);
        }
        else{
           $prediccionPartido = array('marcador1'=>$prediccion->marcador1, 
               'marcador2'=>$prediccion->marcador2, 
               'puntaje'=>$prediccion->puntaje); 
        }
        
        $partido->idPartidoEquipo1 = $equipo1->equipo;
        $partido->idPartidoEquipo2 = $equipo2->equipo;
        
        $torneoPartido = array('id'=>$torneo->id, 'nombre'=>$torneo->torneo);
        
        $partido->prediccion    = $prediccionPartido;
        $partido->torneo        = $torneoPartido;
        
        return $partido;
    }
    
    function parseRowaPartidoList($rowList, $idUsuario){
        $pasedPartidos = array();
        foreach ($rowList as $row){
            array_push($pasedPartidos, $this->parseRowPartido($row, $idUsuario));
        }
        return $pasedPartidos;
    }
}
