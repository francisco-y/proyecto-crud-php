<?php
class UsuarioModel{
    private $conn;

    public function __construct($conexion){
        //Obtener la conexion desde la clase de conexion
        $this->conn = $conexion->getConnection();
    }

    public function agregarUsuario($nombre, $clave, $tipo, $estado, $personal){
        $sql = "INSERT INTO usuarios (usu_nombre, usu_clave, usu_tipo, usu_estado, idpersonales)
        VALUES (:nombre, :clave, :tipo, :estado, :personal)";
        $stmt = $this->conn->prepare($sql); //Preparar la consulta SQL
        $stmt->bindParam(':nombre', $nombre); //Asociar parametros
        $stmt->bindParam(':clave', $clave);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':personal', $personal);
        return $stmt->execute(); //Ejecutar la consulta y devolver true o false
    }
    

    public function obtenerUsuarios(){
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        //Obtener todos los resultados como un arreglo asociativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function actualizarUsuario($id, $nombre, $clave, $tipo, $estado, $personal){
        $sql = "UPDATE usuarios SET usu_nombre = :nombre,
        usu_clave = :clave, usu_tipo = :tipo,
        usu_estado = :estado, idpersonales = :personal WHERE idusuarios = :id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->bindParam(':nombre', $nombre); 
        $stmt->bindParam(':clave', $clave);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':personal', $personal);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function eliminarUsuario($id){
        $sql = "DELETE FROM usuarios WHERE idusuarios = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>