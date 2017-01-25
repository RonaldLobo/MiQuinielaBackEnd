<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/API/Data/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/API/models/UsuarioPuntos.php';

class DbUsuario {

    function agregarUsuario($usuario){
        $sql = "INSERT INTO usuario (nombre, apellido1, correo,usuario,tipo,contrasenna,rol) VALUES ('"
                .$usuario->nombre."', '"
                .$usuario->apellido1. "', '"
                .$usuario->correo. "','"
                .$usuario->usuario. "','"
                .$usuario->tipo. "','"
                .$usuario->contrasenna. "','"
                .$usuario->rol. "')";
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
                . "contrasenna='".$usuario->contrasenna."', "
                . "rol='".$usuario->rol."' "
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
    function obtenerDifUsuario($username){
        $sql = "SELECT `pkIdUsuario`,`nombre`,`apellido1`,`correo`,`usuario`,`tipo`,`rol` FROM usuario WHERE pkIdUsuario!='".$username."' AND pkIdUsuario!=1";
        $db = new DB();
        $row = $db->listar($sql);
        $usuario = $this->parseRowAUsuarioList($row);
        return $usuario;
    }
    
    function listarUsuarios(){
        $sql = "SELECT `pkIdUsuario`,`nombre`,`apellido1`,`correo`,`usuario`,`tipo`,`rol` FROM usuario";
        $db = new DB();
        $rowList = $db->listar($sql);
        $usuarioList = $this->parseRowAUsuarioList($rowList);
        return $usuarioList;
    }
    
    
    function listarUsuariosPuntos($grupoVal,$jornada){
        if($jornada==0){$sql = "SELECT usuario.pkIdUsuario ,torneo.torneo, SUM(prediccion.puntaje)"
                . " as puntaje, usuario.usuario FROM usuarioGrupo "
                . "INNER JOIN grupo INNER JOIN usuario INNER JOIN torneo "
                . "INNER JOIN partido INNER JOIN prediccion "
                . "ON usuarioGrupo.fkIdGrupo=grupo.pkIdGrupo AND usuario.pkIdUsuario=usuarioGrupo.fkIdUsuarioGrupo "
                . "AND torneo.pkIdTorneo=grupo.fkIdGrupoTorneo AND partido.fkIdPartidoTorneo=torneo.pkIdTorneo "
                . "AND partido.pkIdPartido = prediccion.fkIdPrediccionPartido "
                . "AND usuario.pkIdUsuario=prediccion.fkIdPrediccionUsuario "
                . "WHERE usuarioGrupo.estado='miembro' AND usuario.pkIdUsuario!=1 AND usuarioGrupo.fkIdGrupo=" . $grupoVal . " GROUP BY usuario.pkIdUsuario"
                ." ORDER BY puntaje DESC, usuario.usuario ASC";
        }  else {
            $sql = "SELECT usuario.pkIdUsuario ,torneo.torneo, SUM(prediccion.puntaje)"
                . " as puntaje, usuario.usuario FROM usuarioGrupo "
                . "INNER JOIN grupo INNER JOIN usuario INNER JOIN torneo "
                . "INNER JOIN partido INNER JOIN prediccion "
                . "ON usuarioGrupo.fkIdGrupo=grupo.pkIdGrupo AND usuario.pkIdUsuario=usuarioGrupo.fkIdUsuarioGrupo "
                . "AND torneo.pkIdTorneo=grupo.fkIdGrupoTorneo AND partido.fkIdPartidoTorneo=torneo.pkIdTorneo "
                . "AND partido.pkIdPartido = prediccion.fkIdPrediccionPartido "
                . "AND usuario.pkIdUsuario=prediccion.fkIdPrediccionUsuario "
                . "WHERE partido.jornada=" . $jornada . " AND usuarioGrupo.estado='miembro' AND usuario.pkIdUsuario!=1 AND usuarioGrupo.fkIdGrupo=" . $grupoVal . " GROUP BY usuario.pkIdUsuario"
                ." ORDER BY puntaje DESC, usuario.usuario ASC";
        }
        $db = new DB();
        $rowList = $db->listar($sql);
        $usuarioList = $this->parseRowAUsuarioPuntosList($rowList);
        return $usuarioList;
    }
      function parseRowAUsuarioPuntos($row,$position) {
        $user = new UsuarioPuntos();
        if(isset($row['usuario'])){
            $user->nombre = substr($row['usuario'], 0, 14);
        }
        if(isset($row['pkIdUsuario'])){
            $user->id = $row['pkIdUsuario'];
        }
        if(isset($row['puntaje'])){
            $user->puntaje = $row['puntaje'];
        }
        if(isset($row['torneo'])){
            $user->torneo = $row['torneo'];
        }
        $user->position=$position;
        return $user;
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
        if(isset($row['rol'])){
            $user->rol = $row['rol'];
        }
        return $user;
    }
    
    function parseRowAUsuarioPuntosList($rowList) {
        $parsedUsuarios = array();
        $miPos=0;
        foreach ($rowList as $row) {
            $miPos++;
            array_push($parsedUsuarios, $this->parseRowAUsuarioPuntos($row,$miPos));
        }
        return $parsedUsuarios;
    }
    function parseRowAUsuarioList($rowList) {
        $parsedUsuarios = array();
        foreach ($rowList as $row) {
            array_push($parsedUsuarios, $this->parseRowAUsuario($row));
        }
        return $parsedUsuarios;
    }
    
    
    
} 
