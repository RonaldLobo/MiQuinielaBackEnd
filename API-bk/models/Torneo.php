<?php


class Torneo {
     
    public $id = 1;
    public $torneo = '';
    public $estado= '';

   
    function toJson() {
        $data = array(
        'torneo' => array(
            'torneo' => $this->torneo,
            'id'=>$this->id,
            'estado'=> $this->estado
            )
        );
        return json_encode($data);
    }
    
      
    function fromJson(){
        return null;
    }
    
    function parseDto($team) {
        if(isset($team->torneo)){
            $this->torneo = $team->torneo;
        }
        if(isset($team->id)){
            $this->id = $team->id;
        }
        if(isset($team->estado)){
            $this->estado = $team->estado;
        }
    }
    
    
}
