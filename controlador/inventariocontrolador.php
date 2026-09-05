<?php
require_once '../modelo/conexion.php';
require_once '../modelo/inventariomodelo.php';

class InventarioController{
    private $modelo;

    public function __construct(){
        $conexion = new Conexion(); //Crear una instancia de la clase de conexion
        $this->modelo = new InventarioModel($conexion); //Pasar la conexion al modelo
    }

    public function obtenerProductos(){
        return $this->modelo->obtenerProductos();
    }

}
?>