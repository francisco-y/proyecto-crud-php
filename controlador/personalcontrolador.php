<?php
require_once '../modelo/conexion.php';
require_once '../modelo/personalmodelo.php';

class PersonalController{
    private $modelo;

    public function __construct(){
        $conexion = new Conexion(); //Crear una instancia de la clase de conexion
        $this->modelo = new PersonalModel($conexion); //Pasar la conexion al modelo
    }
    public function manejarSolicitud(){
        if(isset($_POST['accion'])){
            if($_POST['accion'] == 'agregarper'){
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $ci = $_POST['ci'];
                $direccion = $_POST['direccion'];
                $this->agregarPersonal($nombre, $apellido, $ci, $direccion);
            }elseif($_POST['accion'] == 'editarper'){
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $ci = $_POST['ci'];
                $direccion = $_POST['direccion'];
                $this->actualizarPersonal($id, $nombre, $apellido, $ci, $direccion);
            }elseif($_POST['accion'] == 'eliminarper'){
                $id = $_POST['id'];
                $this->eliminarPersonal($id);
            }
        }
    }

    public function agregarPersonal($nombre, $apellido, $ci, $direccion){
        return $this->modelo->agregarPersonal($nombre, $apellido, $ci, $direccion);
    }

    public function obtenerPersonales(){
        return $this->modelo->obtenerPersonales();
    }


    public function actualizarPersonal($id, $nombre, $apellido, $ci, $direccion){
        $resultado = $this->modelo->actualizarPersonal($id, $nombre, $apellido, $ci, $direccion);

        //Verifica si la actualizacion se realizo con exito y redirige
        if($resultado){
            header('Location: ../vista/personalvista.php');
            exit(); 
            //Asegúrate de que la ejecucion del script se detenga despues de la redireccion
        }else{
            //Maneja el caso en que la actualizacion falló
            //Puedes mostrar un mensaje de error o realizar otras acciones necesarias
            echo "La actualizacion del personal falló. Por favor, intentelo nuevamente.";
        }
    }


    public function eliminarPersonal($id){
        return $this->modelo->eliminarPersonal($id);
    }
}
?>