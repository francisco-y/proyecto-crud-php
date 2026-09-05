<?php
class ClienteModel{
    private $conn;

    public function __construct($conexion){
        //Obtener la conexion desde la clase de conexion
        $this->conn = $conexion->getConnection();
    }

    public function agregarCliente($nombre, $apellido, $ruc, $telefono, $ciudad){
        $sql = "INSERT INTO clientes (cli_nombre, cli_apellido, cli_ruc, cli_telefono, idciudades)
        VALUES (:nombre, :apellido, :ruc, :telefono, :ciudad)";
        $stmt = $this->conn->prepare($sql); //Preparar la consulta SQL
        $stmt->bindParam(':nombre', $nombre); //Asociar parametros
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':ruc', $ruc);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':ciudad', $ciudad);
        return $stmt->execute(); //Ejecutar la consulta y devolver true o false
    }
    

    public function obtenerClientes(){
        $sql = "SELECT * FROM clientes";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        //Obtener todos los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function actualizarCliente($id, $nombre, $apellido, $ruc, $telefono, $ciudad){
        $sql = "UPDATE clientes SET cli_nombre = :nombre,
        cli_apellido = :apellido, cli_ruc = :ruc,
        cli_telefono = :telefono, idciudades = :ciudad WHERE idclientes = :id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->bindParam(':nombre', $nombre); 
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':ruc', $ruc);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function eliminarCliente($id){
        $sql = "DELETE FROM clientes WHERE idclientes = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>