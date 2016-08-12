<?php

class UsuarioVersion {
    public $id = 1;
    public $usuario = '';
    public $version = '';
 
   
    function toJson() {
        $data = array(
        'usuarioVersion' => array(
            'usuario' => $this->usuario,
            'id'=>$this->id,
            'version'=> $this->version
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
        if(isset($user->usuario)){
            $this->usuario = $user->usuario;
        }
        if(isset($user->id)){
            $this->id = $user->id;
        }
        if(isset($user->version)){
            $this->version = $user->version;
        }
    }
    
} 
