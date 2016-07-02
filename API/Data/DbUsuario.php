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
        $sql = "SELECT * FROM usuario WHERE id=".$id;
        $db = new DB();
        $usuario = new Usuario();
        $row = $db->obtener($sql);
        $usuario->parseRowAUsuario($row);
        return $usuario;
    }
} 
