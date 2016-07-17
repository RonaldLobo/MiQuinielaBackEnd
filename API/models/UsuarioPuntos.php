<?php

class UsuarioPuntos {
    public $id = 1;
    public $nombre = '';
    public $puntaje = 0;
   
    function toJson() {
        $data = array(
        'usuarioPuntos' => array(
            'nombre' => $this->nombre,
            'id'=>$this->id,
            'puntaje'=> $this->puntaje
            )
        );
        return json_encode($data);
    }
    
    function toJsonSeveral() {
        $data = array(
        'usuario' => array(
            'nombre' => $this->nombre,
            'id'=>$this->id,
            'apellido'=> $this->apellido1
            ),
        'usuario2' => array(
            'nombre' => $this->nombre,
            'id'=>$this->id,
            'apellido'=> $this->apellido1
            ),
        'usuario3' => array(
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
    
    function parseDto($user) {
        if(isset($user->nombre)){
            $this->nombre = $user->nombre;
        }
        if(isset($user->id)){
            $this->id = $user->id;
        }
        if(isset($user->puntaje)){
            $this->puntaje = $user->puntaje;
        }
    }
    
} 
