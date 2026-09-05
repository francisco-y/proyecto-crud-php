<?php
require_once '../modelo/conexion.php';
require_once '../modelo/productomodelo.php';

class ProductoController{
    private $modelo;

    public function __construct(){
        $conexion = new Conexion(); //Crear una instancia de la clase de conexion
        $this->modelo = new ProductoModel($conexion); //Pasar la conexion al modelo
    }
    public function manejarSolicitud(){
        if(isset($_POST['accion'])){
            if($_POST['accion'] == 'agregarpro'){
                $nombre = $_POST['nombre'];
                $precio = $_POST['precio'];
                $stock = $_POST['stock'];
                $iva = $_POST['iva'];
                $this->agregarProducto($nombre, $precio, $stock, $iva);
            }elseif($_POST['accion'] == 'editarpro'){
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $precio = $_POST['precio'];
                $stock = $_POST['stock'];
                $iva = $_POST['iva'];
                $this->actualizarProducto($id, $nombre, $precio, $stock, $iva);
            }elseif($_POST['accion'] == 'eliminarpro'){
                $id = $_POST['id'];
                $this->eliminarProducto($id);
            }
        }
    }

    public function agregarProducto($nombre, $precio, $stock, $iva){
        return $this->modelo->agregarProducto($nombre, $precio, $stock, $iva);
    }

    public function obtenerProductos(){
        return $this->modelo->obtenerProductos();
    }

    public function actualizarProducto($id, $nombre, $precio, $stock, $iva){
        $resultado = $this->modelo->actualizarProducto($id, $nombre, $precio, $stock, $iva);

        //Verifica si la actualizacion se realizo con exito y redirige
        if($resultado){
            header('Location: ../vista/productovista.php');
            exit(); 
            //Asegúrate de que la ejecucion del script se detenga despues de la redireccion
        }else{
            //Maneja el caso en que la actualizacion falló
            //Puedes mostrar un mensaje de error o realizar otras acciones necesarias
            echo "La actualizacion del producto falló. Por favor, intentelo nuevamente.";
        }
    }


    public function eliminarProducto($id){
        return $this->modelo->eliminarProducto($id);
    }
}
?>