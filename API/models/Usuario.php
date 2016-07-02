<?php

class Usuario {
    public $id = 1;
    public $nombre = 'Ronald';
    public $apellido1 = 'Lobo';
    public $correo = 'email@email.com';
    public $usuario = 'ronald169090';
    public $tipo = 'normal';
    public $contrasenna = 'ronald';
 
   
    function toJson() {
        $data = array(
        'usuario' => array(
            'nombre' => $this->nombre,
            'id'=>$this->id,
            'apellido'=> $this->apellido1,
            'correo'=> $this->correo,
            'usuario'=> $this->usuario,
            'tipo'=> $this->tipo,
            'contrasenna'=> $this->contrasenna
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
    
    function parse($user) {
        if(isset($user->nombre)){
            $this->nombre = $user->nombre;
        }
        if(isset($user->id)){
            $this->id = $user->id;
        }
        if(isset($user->apellido1)){
            $this->apellido1 = $user->apellido1;
        }
        if(isset($user->correo)){
            $this->correo = $user->correo;
        }
        if(isset($user->usuario)){
            $this->usuario = $user->usuario;
        }
        if(isset($user->tipo)){
            $this->tipo = $user->tipo;
        }
        if(isset($user->contrasenna)){
            $this->contrasenna = $user->contrasenna;
        }
    }
    
    function parseRowAUsuario($row) {
        if(isset($row['nombre'])){
            $this->nombre = $row['nombre'];
        }
        if(isset($row['pkIdUsuario'])){
            $this->id = $row['pkIdUsuario'];
        }
        if(isset($row['apellido1'])){
            $this->apellido1 = $row['apellido1'];
        }
        if(isset($row['correo'])){
            $this->correo = $row['correo'];
        }
        if(isset($row['usuario'])){
            $this->usuario = $row['usuario'];
        }
        if(isset($row['tipo'])){
            $this->tipo = $row['tipo'];
        }
        if(isset($row['contrasenna'])){
            $this->contrasenna = $row['contrasenna'];
        }
    }
    
    function validaUsuario(){
        
    }
} 
