<?php
require_once '../modelo/conexion.php';
require_once '../modelo/clientemodelo.php';

class ClienteController{
    private $modelo;

    public function __construct(){
        $conexion = new Conexion(); //Crear una instancia de la clase de conexion
        $this->modelo = new ClienteModel($conexion); //Pasar la conexion al modelo
    }
    public function manejarSolicitud(){
        if(isset($_POST['accion'])){
            if($_POST['accion'] == 'agregarcli'){
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $ruc = $_POST['ruc'];
                $telefono = $_POST['telefono'];
                $ciudad = $_POST['ciudad'];
                $this->agregarCliente($nombre, $apellido, $ruc, $telefono, $ciudad);
            }elseif($_POST['accion'] == 'editarcli'){
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $ruc = $_POST['ruc'];
                $telefono = $_POST['telefono'];
                $ciudad = $_POST['ciudad'];
                $this->actualizarCliente($id, $nombre, $apellido, $ruc, $telefono, $ciudad);
            }elseif($_POST['accion'] == 'eliminarcli'){
                $id = $_POST['id'];
                $this->eliminarCliente($id);
            }
        }
    }

    public function agregarCliente($nombre, $apellido, $ruc, $telefono, $ciudad){
        return $this->modelo->agregarCliente($nombre, $apellido, $ruc, $telefono, $ciudad);
    }

    public function obtenerClientes(){
        return $this->modelo->obtenerClientes();
    }


    public function actualizarCliente($id, $nombre, $apellido, $ruc, $telefono, $ciudad){
        $resultado = $this->modelo->actualizarCliente($id, $nombre, $apellido, $ruc, $telefono, $ciudad);

        //Verifica si la actualizacion se realizo con exito y redirige
        if($resultado){
            header('Location: ../vista/clientevista.php');
            exit(); 
            //Asegúrate de que la ejecucion del script se detenga despues de la redireccion
        }else{
            //Maneja el caso en que la actualizacion falló
            //Puedes mostrar un mensaje de error o realizar otras acciones necesarias
            echo "La actualizacion del cliente falló. Por favor, intentelo nuevamente.";
        }
    }


    public function eliminarCliente($id){
        return $this->modelo->eliminarCliente($id);
    }
}
?>