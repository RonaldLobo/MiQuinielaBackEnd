<?php

class UsuarioGrupo {
    public $id = 1;
    public $usuario = '';
    public $grupo = '';
    public $estado = '';
 
   
    function toJson() {
        $data = array(
        'usuarioGrupo' => array(
            'id'=> $this->id,
            'usuario'=> $this->usuario,
            'grupo'=> $this->grupo,
            'estado'=> $this->estado
            )
        );
        return json_encode($data);
    }
    
    function parseDto($userTournament) {
        if(isset($userTournament->id)){
            $this->id = $userTournament->id;
        }
        if(isset($userTournament->usuario)){
            $this->usuario = $userTournament->usuario;
        }
        if(isset($userTournament->grupo)){
            $this->grupo = $userTournament->grupo;
        }
        if(isset($userTournament->estado)){
            $this->estado = $userTournament->estado;
        }
    }
    
} 
