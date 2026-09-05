<?php
class PersonalModel{
    private $conn;

    public function __construct($conexion){
        //Obtener la conexion desde la clase de conexion
        $this->conn = $conexion->getConnection();
    }

    public function agregarPersonal($nombre, $apellido, $ci, $direccion){
        $sql = "INSERT INTO personales (per_nombre, per_apellido, per_ci, per_direccion)
        VALUES (:nombre, :apellido, :ci, :direccion)";
        $stmt = $this->conn->prepare($sql); //Preparar la consulta SQL
        $stmt->bindParam(':nombre', $nombre); //Asociar parametros
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':ci', $ci);
        $stmt->bindParam(':direccion', $direccion);
        return $stmt->execute(); //Ejecutar la consulta y devolver true o false
    }
    

    public function obtenerPersonales(){
        $sql = "SELECT * FROM personales";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        //Obtener todos los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function actualizarPersonal($id, $nombre, $apellido, $ci, $direccion){
        $sql = "UPDATE personales SET per_nombre = :nombre,
        per_apellido = :apellido, per_ci = :ci,
        per_direccion = :direccion WHERE idpersonales = :id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->bindParam(':nombre', $nombre); 
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':ci', $ci);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function eliminarPersonal($id){
        $sql = "DELETE FROM personales WHERE idpersonales = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>