<?php
class ProveedorModel{
    private $conn;

    public function __construct($conexion){
        //Obtener la conexion desde la clase de conexion
        $this->conn = $conexion->getConnection();
    }

    public function agregarProveedor($nombre, $ruc, $telefono){
        $sql = "INSERT INTO proveedores (prov_nombre, prov_ruc, prov_telefono)
        VALUES (:nombre, :ruc, :telefono)";
        $stmt = $this->conn->prepare($sql); //Preparar la consulta SQL
        $stmt->bindParam(':nombre', $nombre); //Asociar parametros
        $stmt->bindParam(':ruc', $ruc);
        $stmt->bindParam(':telefono', $telefono);
        return $stmt->execute(); //Ejecutar la consulta y devolver true o false
    }
    
    public function obtenerProveedores(){
        $sql = "SELECT * FROM proveedores";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        //Obtener todos los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarProveedor($id, $nombre, $ruc, $telefono){
        $sql = "UPDATE proveedores SET prov_nombre = :nombre,
        prov_ruc = :ruc, prov_telefono = :telefono WHERE idproveedores = :id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->bindParam(':nombre', $nombre); 
        $stmt->bindParam(':ruc', $ruc);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function eliminarProveedor($id){
        $sql = "DELETE FROM proveedores WHERE idproveedores = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>