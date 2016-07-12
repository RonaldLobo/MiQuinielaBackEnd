<?php

/**
 * Description of Partido
 *
 * @author camh
 */
class Partido {
    	public $idPartido         = 0;
	public $idPartidoTorneo   = 0; 
	public $idPartidoEquipo1  = 0;
	public $idPartidoEquipo2  = 0;
	public $marcadorEquipo1   = 0;
        public $marcadorEquipo2   = 0;
        public $fecha             = "";
        public $prediccion        = "";
        public $torneo            = "";
                
        function toJson(){
            $data = array(
                'partido' => array(
                    'idPartido'         => $this->idPartido,
                    'idPartidoTorneo'   => $this->idPartidoTorneo,
                    'idPartidoEquipo1'  => $this->idPartidoEquipo1,
                    'idPartidoEquipo2'  => $this->idPartidoEquipo2,
                    'marcadorEquipo1'   => $this->marcadorEquipo1,
                    'marcadorEquipo2'   => $this->marcadorEquipo2,
                    'fecha'             => $this->fecha,
                    'prediccion'        => $this->prediccion,
                    'torneo'            => $this->torneo
                    
                )
            );
            return json_encode($data);
        }
        
        
        function parseDto($partido){
            if(isset($partido->idPartido)){
                $this->idPartido = $partido->idPartido;
            }
            
            if(isset($partido->idPartidoTorneo)){
                $this->idPartidoTorneo = $partido->idPartidoTorneo;
            }
            
            if(isset($partido->idPartidoEquipo1)){
                $this->idPartidoEquipo1 = $partido->idPartidoEquipo1;
            }
            
            if(isset($partido->idPartidoEquipo2)){
                $this->idPartidoEquipo2 = $partido->idPartidoEquipo2;
            }
            
            if(isset($partido->marcadorEquipo1)){
                $this->marcadorEquipo1 = $partido->marcadorEquipo1;
            }
            
            if(isset($partido->marcadorEquipo2)){
                $this->marcadorEquipo2 = $partido->marcadorEquipo2;
            }
            
            if(isset($partido->fecha)){
                $this->fecha = $partido->fecha;
            }
        }

}
