<?php

class Prediccion {
    public $id = 0;
    public $idPartido = '';
    public $idUsuario = '';
    public $idEquipo1 = '';
    public $idEquipo2 = '';
    public $marcador1 = '';
    public $marcador2 = '';
    public $puntaje = '';
 
   
    function toJson() {
        $data = array(
        'prediccion' => array(
            'id'=>(int)$this->id,
            'idPartido'=> (int)$this->idPartido,
            'idUsuario'=> (int)$this->idUsuario,
            'equipo1'=> $this->idEquipo1,
            'equipo2'=> $this->idEquipo2,
            'marcador1'=> (int)$this->marcador1,
            'marcador2'=> (int)$this->marcador2,
            'puntaje'=> (int)$this->puntaje
            )
        );
        return json_encode($data);
    }
    
    function toJsonSeveral() {
        $data = array(
        'prediccion' => array(
            'id'=>$this->id,
            'idPartido'=> $this->idPartido,
            'idUsuario'=> $this->idUsuario,
            'equipo1'=> $this->idEquipo1,
            'equipo2'=> $this->idEquipo2,
            'marcador1'=> $this->marcador1,
            'marcador2'=> $this->marcador2,
            'puntaje'=> $this->puntaje
            ),
        'prediccion2' => array(
            'id'=>$this->id,
            'idPartido'=> $this->idPartido,
            'idUsuario'=> $this->idUsuario,
            'equipo1'=> $this->idEquipo1,
            'equipo2'=> $this->idEquipo2,
            'marcador1'=> $this->marcador1,
            'marcador2'=> $this->marcador2,
            'puntaje'=> $this->puntaje
            ),
        'prediccion3' => array(
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
    
    function parseDto($prediccion) {
        if(isset($prediccion->id)){
            $this->id = $prediccion->id;
        }
        if(isset($prediccion->idPartido)){
            $this->idPartido = $prediccion->idPartido;
        }
        if(isset($prediccion->idUsuario)){
            $this->idUsuario = $prediccion->idUsuario;
        }
        if(isset($prediccion->idEquipo1)){
            $this->idEquipo1 = $prediccion->idEquipo1;
        }
        if(isset($prediccion->idEquipo2)){
            $this->idEquipo2 = $prediccion->idEquipo2;
        }
        if(isset($prediccion->marcador1)){
            $this->marcador1 = $prediccion->marcador1;
        }
        if(isset($prediccion->marcador2)){
            $this->marcador2 = $prediccion->marcador2;
        }
        if(isset($prediccion->puntaje)){
            $this->puntaje = $prediccion->puntaje;
        }
    }
    
} 
