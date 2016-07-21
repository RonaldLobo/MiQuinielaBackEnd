<?php

class DB {
    public $dbName = 'appquiniela_2';
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public $conn;

   
   
    function Conectar() {
        //verifica si es localhost o si es live
        $whitelist = array( '127.0.0.1', '::1' );
        if(!in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){
            $this->servername = "appquinielacom.ipagemysql.com";
            $this->username = "appquinielaadmin";
            $this->password = "appquinielapass";
        }
        // Create connection
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);

        // Check connection
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }
    
    function agregar($sql){
        $this->Conectar();
        $id = 0;
        if ($this->conn->query($sql) === TRUE) {
            $id = $this->conn->insert_id;
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
        $this->Cerrar();
        return $id;
    }
    
    function actualizar($sql){
        $this->Conectar();
        if ($this->conn->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
        $this->Cerrar();
    }
    
    function obtenerUno($sql){
        $this->Conectar();
        try {
            $result = $this->conn->query($sql);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        $resultRow = array();
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
                $resultRow = $row;
            }
        } else {
            #echo "0 results";
        }
        $this->Cerrar();
        return $resultRow;
    }
    
    function listar($sql){
        $this->Conectar();
        $result = $this->conn->query($sql);
        $resultRow = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($resultRow,$row);
            }
        } else {
            //echo "0 results";
        }
        $this->Cerrar();
        return $resultRow;
    }
    
    
    function cerrar(){
        mysqli_close($this->conn);
    }
    
} 