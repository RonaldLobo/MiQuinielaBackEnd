<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbPrediccion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbTorneo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Partido.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Prediccion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DbEquipo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Equipo.php';

class DbPartido {
    public $fechaLocal=""; 
    function agregarPartido($partido){
        $sql = "INSERT INTO partido(fkIdPartidoTorneo, fkIdPartidoEquipo1, "
                . "fkIdPartidoEquipo2, marcadorEquipo1,jornada, marcadorEquipo2, fecha) VALUES ("
                . $partido->idPartidoTorneo.", "
                . $partido->idPartidoEquipo1.", "
                . $partido->idPartidoEquipo2.", "
                . $partido->marcadorEquipo1.", '"
                . $partido->jornada."', "
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
                . "jornada='".$partido->jornada."', "
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
    
    function obtenerPartidoUnico($idPartido){
        $sql     = "SELECT * FROM partido WHERE pkIdPartido=".$idPartido;
        $db      = new DB();
        $row     = $db->obtenerUno($sql);
        $partido = $this->parseRowPartido($row);
        return $partido;
    }
    
    
    function obtenerPartido($idPartido, $idUsuario){
        $sql     = "SELECT * FROM partido WHERE pkIdPartido=".$idPartido;
        $db      = new DB();
        $row     = $db->obtenerUno($sql);
        $partido = $this->parseRowPartido($row, $idUsuario);
        return $partido;
    }
    
    function obtenerPartidoSolo($idPartido){
        $sql     = "SELECT * FROM partido WHERE pkIdPartido=".$idPartido;
        $db      = new DB();
        $row     = $db->obtenerUno($sql);
        $partido = $this->parseRowPartidoSolo($row, 1);
        return $partido;
    }
    
    function listarPartidos($idUsuario){
        $sql = "SELECT * FROM partido";
        $db = new DB();
        $rowList = $db->listar($sql);
        $partidoList = $this->parseRowaPartidoList($rowList, $idUsuario);
        return $partidoList;
    }
    function listarPartidosJ($idUsuario,$torneo){
        $sql = "SELECT * FROM partido INNER JOIN grupo ON grupo.fkIdGrupoTorneo=partido.fkIdPartidoTorneo WHERE grupo.fkIdGrupoTorneo=".$torneo." GROUP BY partido.jornada ORDER BY pkIdPartido Desc";
        $db = new DB();
        $rowList = $db->listar($sql);
        $partidoList = $this->parseRowaPartidoList($rowList, $idUsuario);
        return $partidoList;
    }
    
    function listarPartidosEntre($idUsuario, $fechaInicio, $fechaFin,$local){
        $this->fechaLocal=$local;
        $sql = "SELECT pa.pkIdPartido, pa.fkIdPartidoTorneo, pa.fkIdPartidoEquipo1, pa.fkIdPartidoEquipo2, "
                . "pa.marcadorEquipo1, pa.jornada, pa.marcadorEquipo2, pa.fecha "
                . "FROM partido pa, torneo tor, usuarioTorneo usTo "
                . "WHERE pa.fkIdPartidoTorneo = tor.pkIdTorneo "
                . "AND tor.pkIdTorneo = usTo.fkIdTorneo "
                . "AND usTo.fkIdUsuario = ".$idUsuario." "
                . "AND pa.fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."' ORDER BY pa.fecha "; 
        $db = new DB();
        $rowList = $db->listar($sql);
        $partidoList = $this->parseRowaPartidoList($rowList, $idUsuario);
        
        return $partidoList;
    }
    
    function obtenerPorcentajes($id){
        $sql = "select * FROM `prediccion` WHERE `fkIdPrediccionPartido`=".$id." and `fkIdPrediccionUsuario`!=1"; 
        $db = new DB();
        $rowList = $db->listar($sql);
        $resultados="";
        $ganados1=0;
        $ganados2=0;
        $empatados=0;
        foreach ($rowList as $row){
            if($row['marcadorEquipo1']==$row['marcadorEquipo2']){
                $empatados=$empatados+1;
            }else if($row['marcadorEquipo1']>$row['marcadorEquipo2']){
                $ganados1 =$ganados1+1;
            }else if($$row['marcadorEquipo1']<$row['marcadorEquipo2']){
                $ganados2 =$ganados2+1;
            }
        }
        $total=$ganados1+$ganados2+$empatados;
        if($total!=0){
            $victoria1=round($ganados1/$total*100);
            $victoria2=round($ganados2/$total*100);
            $empate =100-$victoria1-$victoria2;
        }else{
            $victoria1=0;
            $victoria2=0;
            $empate =0;
            
        }
        
        //$partidoList = $this->parseRowaPartidoList($rowList, $idUsuario);
        
        return $victoria1."&".$victoria2."&".$empate;
    }
    function obtenerAnteriores($jornada,$equipo,$torneo){
        $sql = "SELECT   * FROM `partido` where jornada!='".$jornada."' and fkIdPartidoTorneo=".$torneo." and (`fkIdPartidoEquipo1`=".$equipo." or `fkIdPartidoEquipo2`=".$equipo.") ORDER BY fecha desc LIMIT 5;"; 
        $db = new DB();
        $rowList = $db->listar($sql);
        $resultados="";
        foreach ($rowList as $row){
            if($row['marcadorEquipo1']==$row['marcadorEquipo2']){
                $resultados .="E&";
            }else if($row['fkIdPartidoEquipo1']==$equipo && $row['marcadorEquipo1']>$row['marcadorEquipo2']){
                $resultados .="G&";
            }else if($row['fkIdPartidoEquipo1']==$equipo && $row['marcadorEquipo1']<$row['marcadorEquipo2']){
                $resultados .="P&";
            }  else if($row['fkIdPartidoEquipo2']==$equipo && $row['marcadorEquipo1']>$row['marcadorEquipo2']){
                $resultados .="P&";
            }else if($row['fkIdPartidoEquipo2']==$equipo && $row['marcadorEquipo1']<$row['marcadorEquipo2']){
                $resultados .="G&";
            }
            //array_push($pasedPartidos, $this->parseRowPartido($row, $idUsuario));
        }
        //$partidoList = $this->parseRowaPartidoList($rowList, $idUsuario);
        
        return $resultados;
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
        
        if(isset($row['jornada'])){
            if (is_numeric($row['jornada'])) {
                $partido->jornada = (int)$row['jornada'];
            }else{
                $partido->jornada = $row['jornada'];
            }
        }
        
        if(isset($row['marcadorEquipo2'])){
            $partido->marcadorEquipo2 = $row['marcadorEquipo2'];
        }
        
        if(isset($row['fecha'])){
            $fechaLocal = strtotime($this->fechaLocal);  
            
            $fechaBack=strtotime(date('H:i', time()));
            $ejem=strtotime($row['fecha']);
            $diff=($fechaBack-$fechaLocal);
            $horaNueva=$ejem-$diff;
            //echo $fechaLocal.' -- '.$fechaBack.' -- '.$diff.' -- '.date("Y-m-d H:i:s",$horaNueva);
            $partido->fecha = date("Y-m-d H:i",$horaNueva);
        }
        
        $prediccion = $dbPrediccion->obtenerPrediccionPorPartidoUsuario($partido->idPartido,$idUsuario);
        $torneo     = $dbTorneo->obtenerTorneo($partido->idPartidoTorneo);
        $equipo1    = $dbEquipo->obtenerEquipo($partido->idPartidoEquipo1);
        $equipo2    = $dbEquipo->obtenerEquipo($partido->idPartidoEquipo2);
        $partido->previos1=  $this->obtenerAnteriores($partido->jornada,$partido->idPartidoEquipo1,$partido->idPartidoTorneo);
        $partido->previos2=  $this->obtenerAnteriores($partido->jornada,$partido->idPartidoEquipo2,$partido->idPartidoTorneo);
        $partido->porcentajes=  $this->obtenerPorcentajes($partido->idPartido);
        $fechaLocal = strtotime($this->fechaLocal);  
        $ejem=strtotime($row['fecha']);
        


        if($prediccion->id == "0"){
            $prediccion->idPartido = $partido->idPartido;
            $prediccion->idEquipo1 = $partido->idPartidoEquipo1;
            $prediccion->idEquipo2 = $partido->idPartidoEquipo2;
            $prediccion->idUsuario = $idUsuario;
            $prediccion->marcador1 = 0;
            $prediccion->marcador2 = 0;
            $prediccion->puntaje   = 0;
            
            if ($fechaLocal < $ejem) {
                $prediccionReult = $dbPrediccion->agregarPrediccion($prediccion);
                $prediccionPartido = array('id'=>$prediccionReult->id,'marcador1'=>0, 'marcador2'=>0, 'puntaje'=>0);
            
            }  else {
                $prediccionPartido = array('id'=>0,'marcador1'=>" ", 'marcador2'=>" ", 'puntaje'=>0);
            }

        }
        else{
           $prediccionPartido = array('id'=>$prediccion->id,'marcador1'=>$prediccion->marcador1, 
               'marcador2'=>$prediccion->marcador2, 
               'puntaje'=>$prediccion->puntaje); 
        }
        $partido->idPartidoEquipo1 = $equipo1->equipo."&".$equipo1->acronimo;
        $partido->idPartidoEquipo2 = $equipo2->equipo."&".$equipo2->acronimo;
        
        $torneoPartido = array('id'=>$torneo->id, 'nombre'=>$torneo->torneo);
        
        $partido->prediccion    = $prediccionPartido;
        $partido->torneo        = $torneoPartido;
        
        return $partido;
    }
    
    function parseRowPartidoSolo($row, $idUsuario){
        $partido        = new Partido();
        
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
        
        if(isset($row['jornada'])){
            if (is_numeric($row['jornada'])) {
                $partido->jornada = (int)$row['jornada'];
            }else{
                $partido->jornada = $row['jornada'];
            }
        }
        
        if(isset($row['marcadorEquipo2'])){
            $partido->marcadorEquipo2 = $row['marcadorEquipo2'];
        }
        
        if(isset($row['fecha'])){
            $partido->fecha = $row['fecha'];
        }

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
