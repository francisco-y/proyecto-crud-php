<?php
    class loginmodel{
        private $conn;

        public function __construct($conexion){
            //obtener la conexion con el modelo getConnection
            $this->conn = $conexion->getConnection();
        }

        public function validarUsuario($usuario, $clave){
            $sql = "select * from usuarios where usu_nombre = :nombre and usu_clave = :clave and usu_estado = 'ACTIVO'";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nombre', $usuario);
            $stmt->bindParam(':clave', $clave);
            $stmt->execute();
            //verificar si se encontraron registros
            $numRegistros = $stmt->rowCount();
            return $numRegistros > 0;
        }
    }
?>