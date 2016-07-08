<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Torneo
 *
 * @author camh
 */
class Torneo {
        public $idTorneo         = 0;
        public $torneo           = '';
        public $estado           = 0;
    
        function toJson(){
            $data = array(
                'torneo' => array(
                    'idTorneo' => $this->idTorneo,
                    'torneo'   => $this->torneo,
                    'estado'   => $this->estado
                )
            );
            return json_encode($data);
        }
    
        function parseDto($torneo){
            if(isset($torneo->idTorneo)){
                $this->idTorneo = $torneo->idTorneo;
            }
            
            if(isset($torneo->torneo)){
                $this->torneo = $torneo->torneo;
            }
            
            if(isset($torneo->estado)){
                $this->estado = $torneo->estado;
            }
            
        }    
    
    
}
