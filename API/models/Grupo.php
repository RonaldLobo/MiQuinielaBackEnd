<?php

class Grupo {
    public $id = 1;
    public $idTorneo = '';
    public $idUsuario = '';
    public $estado = '';
 
   
    function toJson() {
        $data = array(
        'grupo' => array(
            'id'=>$this->id,
            'idTorneo'=> $this->idTorneo,
            'idUsuario'=> $this->idUsuario,
            'estado'=> $this->estado
            )
        );
        return json_encode($data);
    }
    
    function toJsonSeveral() {
        $data = array(
        'grupo' => array(
            'id'=>$this->id,
            'idTorneo'=> $this->idTorneo,
            'idUsuario'=> $this->idUsuario,
            'estado'=> $this->estado
            ),
        'grupo2' => array(
            'id'=>$this->id,
            'idPartido'=> $this->idPartido,
            'idUsuario'=> $this->idUsuario,
            'equipo1'=> $this->idEquipo1,
            'equipo2'=> $this->idEquipo2,
            'marcador1'=> $this->marcador1,
            'marcador2'=> $this->marcador2,
            'puntaje'=> $this->puntaje
            ),
        'grupo3' => array(
            'id'=>$this->id,
            'idPartido'=> $this->idPartido,
            'idUsuario'=> $this->idUsuario,
            'equipo1'=> $this->idEquipo1,
            'equipo2'=> $this->idEquipo2,
            'marcador1'=> $this->marcador1,
            'marcador2'=> $this->marcador2,
            'puntaje'=> $this->puntaje
            )
            
        );
        return json_encode($data);
    }
    
    function fromJson(){
        return null;
    }
    
    function parseDto($grupo) {
        if(isset($grupo->id)){
            $this->id = $grupo->id;
        }
        if(isset($grupo->idTorneo)){
            $this->idTorneo = $grupo->idTorneo;
        }
        if(isset($grupo->idUsuario)){
            $this->idUsuario = $grupo->idUsuario;
        }
        if(isset($grupo->estado)){
            $this->estado = $grupo->estado;
        }
    }
    
} 
