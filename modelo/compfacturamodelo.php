<?php
class compfacturaModel{
    private $conn;

    public function __construct($conexion){
        //Obtener la conexion desde la clase de conexion
        $this->conn = $conexion->getConnection();
    }

    public function insertarFactura($id, $fecha, $condicion, $estado, $proveedorid){
        $sql = "INSERT INTO facturacompra (idfacturascomp, fac_fecha_comp, fac_condicion_comp, fac_estado_comp, idproveedores, idusuarios)
        VALUES (:id, :fecha, :condicion, :estado, :proveedorid, 1)";
        $stmt = $this->conn->prepare($sql); //Preparar la consulta SQL
        $stmt->bindParam(':id', $id); //Asociar parametros
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':condicion', $condicion);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':proveedorid', $proveedorid);
        return $stmt->execute(); //Ejecutar la consulta y devolver true o false
    }
    
    public function insertarDetalle($idfactura, $idproducto, $precio, $cantidad){
        $sql = "INSERT INTO detallefacturacompra (idfacturascomp, idproductos, det_precio_comp, det_cantidad_comp)
        VALUES (:id, :producto, :precio, :cantidad)";
        $stmt = $this->conn->prepare($sql); //Preparar la consulta SQL
        $stmt->bindParam(':id', $idfactura); //Asociar parametros
        $stmt->bindParam(':producto', $idproducto);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':cantidad', $cantidad);
        return $stmt->execute(); //Ejecutar la consulta y devolver true o false
    }
    
    public function obtenerUltimoId(){
        $sql = "SELECT MAX(idfacturascomp) AS ultimo_id FROM facturacompra";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['ultimo_id'];
    }
}
?>