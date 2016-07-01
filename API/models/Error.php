<?php

class Error {
    public $id = 1;
    public $error = 'invalid password';
   
   
    function toJson() {
        $data = array(
        'error' => array(
            'id'=>$this->id,
            'error'=> $this->error
            )
        );
        return json_encode($data);
    }
    
} 
