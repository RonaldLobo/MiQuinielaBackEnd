<?php

class UsuarioTorneo {
    public $id = 1;
    public $usuario = '';
    public $torneo = '';
 
   
    function toJson() {
        $data = array(
        'usuarioTorneo' => array(
            'usuario'=> $this->usuario,
            'torneo'=> $this->torneo
            )
        );
        return json_encode($data);
    }
    
    function toJsonSeveral() {
        $data = array(
        'usuarioTorneo' => array(
            'nombre' => $this->nombre,
            'id'=>$this->id,
            'apellido'=> $this->apellido1
            ),
        'usuarioTorneo2' => array(
            'nombre' => $this->nombre,
            'id'=>$this->id,
            'apellido'=> $this->apellido1
            ),
        'usuarioTorneo3' => array(
            'nombre' => $this->nombre,
            'id'=>$this->id,
            'apellido'=> $this->apellido1
            ),
            
        );
        return json_encode($data);
    }
    
    function fromJson(){
        return null;
    }
    
    function parseDto($userTournament) {
        if(isset($userTournament->usuario)){
            $this->usuario = $userTournament->usuario;
        }
        if(isset($userTournament->torneo)){
            $this->torneo = $userTournament->torneo;
        }
    }
    
} 
