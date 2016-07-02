<?php

class DB {
    public $dbName = 'appQuiniela';
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public $conn;

   
   
    function Conectar() {
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
    
    function obtener($sql){
        $this->Conectar();
        $result = $this->conn->query($sql);
        $resultRow;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
                $resultRow = $row;
            }
        } else {
            echo "0 results";
        }
        $this->Cerrar();
        return $resultRow;
    }
    
    function cerrar(){
        mysqli_close($this->conn);
    }
    
} 