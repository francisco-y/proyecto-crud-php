<?php
require_once '../modelo/conexion.php';
require_once '../modelo/facturacompramodelo.php';

class FacturaCompraController{
    private $modelo;

    public function __construct(){
        $conexion = new Conexion(); //Crear una instancia de la clase de conexion
        $this->modelo = new FacturaCompraModel($conexion); //Pasar la conexion al modelo
    }

    public function obtenerCompras(){
        return $this->modelo->obtenerCompras();
    }

}
?>