<?php
//Marlon Castro
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Grupo.php';

class DbGrupo {

    function agregarGrupo($grupo){
        $sql = "INSERT INTO grupo (fkIdGrupoTorneo, fkIdGrupoUsuario, estado, nombre) VALUES ('"
                .$grupo->idTorneo."', '"
                .$grupo->idUsuario. "', '"
                .$grupo->estado. "', '"
                .$grupo->nombre. "')";
        $db = new DB();
        $id = $db->agregar($sql);
        $grupo->id = $id;
        return $grupo;
    }
    
    function actualizarGrupo($grupo){
        $sql = "UPDATE grupo SET "
                . "fkIdGrupoTorneo=".$grupo->idTorneo.", "
                . "fkIdGrupoUsuario=".$grupo->idUsuario.", "
                . "estado=".$grupo->estado.", "
                . "nombre=".$grupo->nombre." "
                . "WHERE pkIdGrupo=".$grupo->id;
        $db = new DB();
        $db->actualizar($sql);
        return $grupo;
    }
    
    function deleteGrupo($id){
        $sql = "DELETE FROM grupo WHERE pkIdGrupo=".$id;
        $db = new DB();
        $db->actualizar($sql);
    }
    
    function obtenerGrupo($id){
        $sql = "SELECT * FROM grupo WHERE pkIdGrupo=".$id;
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $grupo = $this->parseRowAGrupo($row);
        return $grupo;
    }
    
    function obtenerGrupoGeneral($idTorneo){
        $sql = "SELECT * FROM grupo WHERE fkIdGrupoTorneo=".$idTorneo." AND nombre = 'General'";
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $grupo = $this->parseRowAGrupo($row);
        return $grupo;
    }
    
    /*function obtenerPorGrupo($groupname){
        $sql = "SELECT * FROM grupo WHERE grupo='".$groupname."'";
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $grupo = $this->parseRowAGrupo($row);
        return $grupo;
    }*/
    
    function listarGrupos(){
        $sql = "SELECT * FROM grupo";
        $db = new DB();
        $rowList = $db->listar($sql);
        $grupoList = $this->parseRowAGrupoList($rowList);
        return $grupoList;
    }
    function listarGruposUsuario($grupoVal){
        $sql = "SELECT* FROM grupo INNER JOIN usuarioGrupo ON grupo.pkIdGrupo=usuarioGrupo.fkIdGrupo "
                . "WHERE usuarioGrupo.estado='miembro' AND usuarioGrupo.fkIdUsuarioGrupo=".$grupoVal;
        $db = new DB();
        $rowList = $db->listar($sql);
        $grupoList = $this->parseRowAGrupoList($rowList);
        return $grupoList;
    }
    
    function listarGruposSinUsuario($grupoVal){
        $sql = 'SELECT pkIdGrupo,fkIdGrupoTorneo,fkIdGrupoUsuario,grupo.estado,nombre FROM grupo LEFT JOIN usuarioGrupo ON grupo.pkIdGrupo = usuarioGrupo.fkIdGrupo AND usuarioGrupo.fkIdUsuarioGrupo = '
                . $grupoVal
                . ' INNER JOIN usuarioTorneo ON usuarioTorneo.fkIdTorneo = grupo.fkIdGrupoTorneo WHERE usuarioGrupo.pkIdUsuarioGrupo IS NULL GROUP BY grupo.pkIdGrupo';
        $db = new DB();
        $rowList = $db->listar($sql);
        $grupoList = $this->parseRowAGrupoList($rowList);
        return $grupoList;
    }
    
    
    function parseRowAGrupo($row) {
        $group = new Grupo();
        if(isset($row['pkIdGrupo'])){
            $group->id = $row['pkIdGrupo'];
        }
        if(isset($row['fkIdGrupoTorneo'])){
            $group->idTorneo = $row['fkIdGrupoTorneo'];
        }
        if(isset($row['fkIdGrupoUsuario'])){
            $group->idUsuario = $row['fkIdGrupoUsuario'];
        }
        if(isset($row['estado'])){
            $group->estado = $row['estado'];
        }
        if(isset($row['nombre'])){
            $group->nombre = $row['nombre'];
        }
        return $group;
    }
    
    function parseRowAGrupoList($rowList) {
        $parsedGrupos = array();
        foreach ($rowList as $row) {
            array_push($parsedGrupos, $this->parseRowAGrupo($row));
        }
        return $parsedGrupos;
    }
    
    
    
} 
