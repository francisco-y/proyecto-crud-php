<?php
class ProductoModel{
    private $conn;

    public function __construct($conexion){
        //Obtener la conexion desde la clase de conexion
        $this->conn = $conexion->getConnection();
    }

    public function agregarProducto($nombre, $precio, $stock, $iva){
        $sql = "INSERT INTO productos (pro_nombre, pro_precio, pro_stock, pro_iva)
        VALUES (:nombre, :precio, :stock, :iva)";
        $stmt = $this->conn->prepare($sql); //Preparar la consulta SQL
        $stmt->bindParam(':nombre', $nombre); //Asociar parametros
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':iva', $iva);
        return $stmt->execute(); //Ejecutar la consulta y devolver true o false
    }
    
    public function obtenerProductos(){
        $sql = "SELECT * FROM productos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        //Obtener todos los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarProducto($id, $nombre, $precio, $stock, $iva){
        $sql = "UPDATE productos SET pro_nombre = :nombre,
        pro_precio = :precio, pro_stock = :stock, 
        pro_iva = :iva WHERE idproductos = :id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->bindParam(':nombre', $nombre); 
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':iva', $iva);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function eliminarProducto($id){
        $sql = "DELETE FROM productos WHERE idproductos = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>