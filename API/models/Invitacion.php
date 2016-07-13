<?php

class Invitacion {
    public $id = 1;
    public $grupo = '';
 
   
    function toJson() {
        $data = array(
        'usuarioGrupo' => array(
            'id'=>$this->id,
            'grupo'=> $this->grupo
            )
        );
        return json_encode($data);
    }
    
    function parseDto($userTournament) {
        if(isset($userTournament->id)){
            $this->id = $userTournament->id;
        }
        if(isset($userTournament->grupo)){
            $this->grupo = $userTournament->grupo;
        }
    }
    
} 
