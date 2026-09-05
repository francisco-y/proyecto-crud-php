<?php
require_once '../modelo/conexion.php';
require_once '../modelo/facturaventamodelo.php';

class FacturaVentaController{
    private $modelo;

    public function __construct(){
        $conexion = new Conexion(); //Crear una instancia de la clase de conexion
        $this->modelo = new FacturaVentaModel($conexion); //Pasar la conexion al modelo
    }

    public function obtenerVentas(){
        return $this->modelo->obtenerVentas();
    }

}
?>