<?php
    class Conexion{

        private $servername = "mysql-proyectos-franciscoadrianyegros-18bb.l.aivencloud.com";//direccion del servidor
        private $username = "avnadmin";//es el super usuario de mysql
        private $password = "AVNS_hmw88cRMxdzuPvlB-Fs";//contraseña del super usuario
        private $database = "proyecto_php1";
        private $port = "17260";
        private $conn;
        public function __construct(){
            try{
                //se crea una instancia de conexion PDO para conectarse a una bd
                $this->conn = new PDO("mysql:host=$this->servername; port=$this->port; dbname=$this->database; charset=utf8", $this->username, $this->password);
                //configurar el modo de error para lanzar excepciones en caso que haya
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo "ERROR DE CONEXION: " . $e->getMessage();
            }
        }
        public function getConnection(){
            return $this->conn;//devuelve la conexion establecida
        }
    }
?>