<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/UsuarioGrupo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Invitacion.php';

class DbUsuarioGrupo {

    function agregarUsuarioGrupo($usuarioGrupo){
        $sql = "INSERT INTO usuarioGrupo (fkIdUsuarioGrupo, fkIdGrupo, estado) VALUES ('"
                .$usuarioGrupo->usuario."', '"
                .$usuarioGrupo->grupo."', '"
                .$usuarioGrupo->estado."')";
        $db = new DB();
        $id = $db->agregar($sql);
        $usuarioGrupo->id = $id;
        return $usuarioGrupo;
    }
    
    function actualizarUsuarioGrupo($usuarioGrupo){
        $sql = "UPDATE usuarioGrupo SET "
                . "fkIdUsuarioGrupo='".$usuarioGrupo->usuario."', "
                . "estado='".$usuarioGrupo->estado."', "
                . "fkIdGrupo='".$usuarioGrupo->grupo."' "
                . "WHERE pkIdUsuarioGrupo=".$usuarioGrupo->id;
        $db = new DB();
        $db->actualizar($sql);
        return $usuarioGrupo;
    }
    
    function deleteUsuarioGrupo($id,$gru){
        $sql = "DELETE FROM usuarioGrupo WHERE fkIdUsuarioGrupo=".$id." AND fkIdGrupo=".$gru;
        $db = new DB();
        $db->actualizar($sql);
    }
    
    
    
    function obtenerUsuarioGrupo($id){
        $sql = "SELECT * FROM usuarioGrupo WHERE pkIdUsuarioGrupo=".$id;
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $usuarioGrupo = $this->parseRowAUsuarioGrupo($row);
        return $usuarioGrupo;
    }
    
    /*function obtenerPorUsuarioGrupo($userTournametname){
        $sql = "SELECT * FROM usuarioGrupo WHERE usuarioGrupo='".$userTournametname."'";
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $usuarioGrupo = $this->parseRowAUsuarioGrupo($row);
        return $usuarioGrupo;
    }*/
    
    function listarUsuarioGrupos(){
        $sql = "SELECT * FROM usuarioGrupo";
        $db = new DB();
        $rowList = $db->listar($sql);
        $usuarioGrupoList = $this->parseRowAUsuarioGrupoList($rowList);
        return $usuarioGrupoList;
    }
    
    function listarUsuarioGruposPorUsuarioYEstado($id,$estado){
        $sql = "SELECT usuarioGrupo.pkIdUsuarioGrupo, grupo.nombre FROM usuarioGrupo INNER JOIN grupo ON usuarioGrupo.fkIdGrupo=grupo.pkIdGrupo WHERE usuarioGrupo.estado='"
                . $estado
                . "' AND usuarioGrupo.fkIdUsuarioGrupo = "
                . $id;
        //"SELECT usuarioGrupo.pkIdUsuarioGrupo, grupo.nombre FROM usuarioGrupo INNER JOIN grupo ON usuarioGrupo.fkIdGrupo=grupo.pkIdGrupo WHERE usuarioGrupo.estado='pendiente'"
        //$sql = "SELECT * FROM usuarioGrupo WHERE fkIdUsuarioGrupo=".$id." AND estado='".$estado."'";
        $db = new DB();
        $rowList = $db->listar($sql);
        $usuarioGrupoList = $this->parseRowAUsuarioGrupoListInvitacion($rowList);
        return $usuarioGrupoList;
    }
    
    
    
    function parseRowAUsuarioGrupo($row) {
        $userTournamet = new UsuarioGrupo();
        if(isset($row['pkIdUsuarioGrupo'])){
            $userTournamet->id = $row['pkIdUsuarioGrupo'];
        }
        if(isset($row['fkIdUsuarioGrupo'])){
            $userTournamet->usuario = $row['fkIdUsuarioGrupo'];
        }
        if(isset($row['fkIdGrupo'])){
            $userTournamet->grupo = $row['fkIdGrupo'];
        }
        if(isset($row['estado'])){
            $userTournamet->estado = $row['estado'];
        }
        return $userTournamet;
    }
    
    function parseRowAUsuarioGrupoList($rowList) {
        $parsedUsuarioGrupos = array();
        foreach ($rowList as $row) {
            array_push($parsedUsuarioGrupos, $this->parseRowAUsuarioGrupo($row));
        }
        return $parsedUsuarioGrupos;
    }
    
    function parseRowAUsuarioGrupoInvitacion($row) {
        $userTournamet = new Invitacion();
        if(isset($row['pkIdUsuarioGrupo'])){
            $userTournamet->id = $row['pkIdUsuarioGrupo'];
        }
        if(isset($row['nombre'])){
            $userTournamet->grupo = $row['nombre'];
        }
        return $userTournamet;
    }
    
    function parseRowAUsuarioGrupoListInvitacion($rowList) {
        $parsedUsuarioGrupos = array();
        foreach ($rowList as $row) {
            array_push($parsedUsuarioGrupos, $this->parseRowAUsuarioGrupoInvitacion($row));
        }
        return $parsedUsuarioGrupos;
    }
    
} 
