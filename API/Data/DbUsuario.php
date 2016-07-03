<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Usuario.php';

class DbUsuario {

    function agregarUsuario($usuario){
        $sql = "INSERT INTO usuario (nombre, apellido1, correo,usuario,tipo,contrasenna) VALUES ('"
                .$usuario->nombre."', '"
                .$usuario->apellido1. "', '"
                .$usuario->correo. "','"
                .$usuario->usuario. "','"
                .$usuario->tipo. "','"
                .$usuario->contrasenna. "')";
        $db = new DB();
        $id = $db->agregar($sql);
        $usuario->id = $id;
        return $usuario;
    }
    
    function actualizarUsuario($usuario){
        $sql = "UPDATE usuario SET "
                . "nombre='".$usuario->nombre."', "
                . "apellido1='".$usuario->apellido1."', "
                . "correo='".$usuario->correo."', "
                . "usuario='".$usuario->usuario."', "
                . "tipo='".$usuario->tipo."', "
                . "contrasenna='".$usuario->contrasenna."' "
                . "WHERE pkIdUsuario=".$usuario->id;
        $db = new DB();
        $db->actualizar($sql);
        return $usuario;
    }
    
    function deleteUsuario($id){
        $sql = "DELETE FROM usuario WHERE id=".$id;
        $db = new DB();
        $db->actualizar($sql);
    }
    
    function obtenerUsuario($id){
        $sql = "SELECT * FROM usuario WHERE pkIdUsuario=".$id;
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $usuario = $this->parseRowAUsuario($row);
        return $usuario;
    }
    
    function obtenerPorUsuario($username){
        $sql = "SELECT * FROM usuario WHERE usuario='".$username."'";
        $db = new DB();
        $row = $db->obtenerUno($sql);
        $usuario = $this->parseRowAUsuario($row);
        return $usuario;
    }
    
    function listarUsuarios(){
        $sql = "SELECT * FROM usuario";
        $db = new DB();
        $rowList = $db->listar($sql);
        $usuarioList = $this->parseRowAUsuarioList($rowList);
        return $usuarioList;
    }
    
    
    
    function parseRowAUsuario($row) {
        $user = new Usuario();
        if(isset($row['nombre'])){
            $user->nombre = $row['nombre'];
        }
        if(isset($row['pkIdUsuario'])){
            $user->id = $row['pkIdUsuario'];
        }
        if(isset($row['apellido1'])){
            $user->apellido1 = $row['apellido1'];
        }
        if(isset($row['correo'])){
            $user->correo = $row['correo'];
        }
        if(isset($row['usuario'])){
            $user->usuario = $row['usuario'];
        }
        if(isset($row['tipo'])){
            $user->tipo = $row['tipo'];
        }
        if(isset($row['contrasenna'])){
            $user->contrasenna = $row['contrasenna'];
        }
        return $user;
    }
    
    function parseRowAUsuarioList($rowList) {
        $parsedUsuarios = array();
        foreach ($rowList as $row) {
            array_push($parsedUsuarios, $this->parseRowAUsuario($row));
        }
        return $parsedUsuarios;
    }
    
    
    
} 