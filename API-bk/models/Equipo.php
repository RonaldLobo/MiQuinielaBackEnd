<?php


class Equipo {
   
    
    public $id = 1;
    public $equipo = '';
    public $estado= '';
    public $acronimo= '';

   
    function toJson() {
        $data = array(
        'equipo' => array(
            'equipo' => $this->equipo,
            'id'=>$this->id,
            'estado'=> $this->estado,
            'acronimo'=> $this->acronimo
            )
        );
        return json_encode($data);
    }
    
      
    function fromJson(){
        return null;
    }
    
    function parseDto($team) {
        if(isset($team->equipo)){
            $this->equipo = $team->equipo;
        }
        if(isset($team->id)){
            $this->id = $team->id;
        }
        if(isset($team->estado)){
            $this->estado = $team->estado;
        }
        if(isset($team->acronimo)){
            $this->acronimo = $team->acronimo;
        }
    }
    
    
}
