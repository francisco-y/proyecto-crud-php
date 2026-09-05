<?php
class facturaModel{
    private $conn;

    public function __construct($conexion){
        //Obtener la conexion desde la clase de conexion
        $this->conn = $conexion->getConnection();
    }

    public function insertarFactura($id, $fecha, $condicion, $estado, $clienteid){
        $sql = "INSERT INTO facturaventa (idfacturas, fac_fecha, fac_condicion, fac_estado, idclientes, idusuarios)
        VALUES (:id, :fecha, :condicion, :estado, :clienteid, 1)";
        $stmt = $this->conn->prepare($sql); //Preparar la consulta SQL
        $stmt->bindParam(':id', $id); //Asociar parametros
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':condicion', $condicion);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':clienteid', $clienteid);
        return $stmt->execute(); //Ejecutar la consulta y devolver true o false
    }
    
    public function insertarDetalle($idfactura, $idproducto, $precio, $cantidad){
        $sql = "INSERT INTO detallefactura (idfacturas, idproductos, det_precio, det_cantidad)
        VALUES (:id, :producto, :precio, :cantidad)";
        $stmt = $this->conn->prepare($sql); //Preparar la consulta SQL
        $stmt->bindParam(':id', $idfactura); //Asociar parametros
        $stmt->bindParam(':producto', $idproducto);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':cantidad', $cantidad);
        return $stmt->execute(); //Ejecutar la consulta y devolver true o false
    }
    
    public function obtenerUltimoId(){
        $sql = "SELECT MAX(idfacturas) AS ultimo_id FROM facturaventa";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['ultimo_id'];
    }
}
?>