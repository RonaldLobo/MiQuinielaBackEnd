<?php

class Validador {
    function validaPresencia($value) {
        return isset($value);
    }
    
    function validaCorreo($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
    
    function validaSoloLetras($value) {
        return preg_match("/^[a-zA-Z ]*$/",$value);
    }
    
    function validaSoloNumero($value) {
        return is_numeric($valor);
    }
    
} 
