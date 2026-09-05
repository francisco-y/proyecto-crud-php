<?php
class CiudadModel{
    private $conn;

    public function __construct($conexion){
        //Obtener la conexion desde la clase de conexion
        $this->conn = $conexion->getConnection();
    }

    public function agregarCiudad($nombre){
        $sql = "INSERT INTO ciudades (ciu_nombre) VALUES (:nombre)";
        $stmt = $this->conn->prepare($sql); //Preparar la consulta SQL
        $stmt->bindParam(':nombre', $nombre); //Asociar parametros
        return $stmt->execute(); //Ejecutar la consulta y devolver true o false
    }
    

    public function obtenerCiudades(){
        $sql = "SELECT * FROM ciudades";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        //Obtener todos los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function actualizarCiudad($id, $nombre){
        $sql = "UPDATE ciudades SET ciu_nombre = :nombre WHERE idciudades = :id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function eliminarCiudad($id){
        $sql = "DELETE FROM ciudades WHERE idciudades = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>