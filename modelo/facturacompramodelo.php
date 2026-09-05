<?php
class FacturaCompraModel{
    private $conn;

    public function __construct($conexion){
        //Obtener la conexion desde la clase de conexion
        $this->conn = $conexion->getConnection();
    }

    public function obtenerCompras(){
        $sql = "SELECT * FROM facturacompra";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        //Obtener todos los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>