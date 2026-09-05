<?php
require_once '../modelo/conexion.php';
require_once '../modelo/proveedormodelo.php';

class ProveedorController{
    private $modelo;

    public function __construct(){
        $conexion = new Conexion(); //Crear una instancia de la clase de conexion
        $this->modelo = new ProveedorModel($conexion); //Pasar la conexion al modelo
    }
    public function manejarSolicitud(){
        if(isset($_POST['accion'])){
            if($_POST['accion'] == 'agregarprov'){
                $nombre = $_POST['nombre'];
                $ruc = $_POST['ruc'];
                $telefono = $_POST['telefono'];
                $this->agregarProveedor($nombre, $ruc, $telefono);
            }elseif($_POST['accion'] == 'editarprov'){
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $ruc = $_POST['ruc'];
                $telefono = $_POST['telefono'];
                $this->actualizarProveedor($id, $nombre, $ruc, $telefono);
            }elseif($_POST['accion'] == 'eliminarprov'){
                $id = $_POST['id'];
                $this->eliminarProveedor($id);
            }
        }
    }

    public function agregarProveedor($nombre, $ruc, $telefono){
        return $this->modelo->agregarProveedor($nombre, $ruc, $telefono);
    }

    public function obtenerProveedores(){
        return $this->modelo->obtenerProveedores();
    }

    public function actualizarProveedor($id, $nombre, $ruc, $telefono){
        $resultado = $this->modelo->actualizarProveedor($id, $nombre, $ruc, $telefono);

        //Verifica si la actualizacion se realizo con exito y redirige
        if($resultado){
            header('Location: ../vista/proveedorvista.php');
            exit(); 
            //Asegúrate de que la ejecucion del script se detenga despues de la redireccion
        }else{
            //Maneja el caso en que la actualizacion falló
            //Puedes mostrar un mensaje de error o realizar otras acciones necesarias
            echo "La actualizacion del proveedor falló. Por favor, intentelo nuevamente.";
        }
    }


    public function eliminarProveedor($id){
        return $this->modelo->eliminarProveedor($id);
    }
}
?>