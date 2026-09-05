<?php
require_once '../modelo/conexion.php';
require_once '../modelo/ciudadmodelo.php';

class CiudadController{
    private $modelo;

    public function __construct(){
        $conexion = new Conexion(); //Crear una instancia de la clase de conexion
        $this->modelo = new CiudadModel($conexion); //Pasar la conexion al modelo
    }
    public function manejarSolicitud(){
        if(isset($_POST['accion'])){
            if($_POST['accion'] == 'agregar'){
                $nombre = $_POST['nombre'];
                $this->agregarCiudad($nombre);
            }elseif($_POST['accion'] == 'editar'){
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $this->actualizarCiudad($id, $nombre);
            }elseif($_POST['accion'] == 'eliminar'){
                $id = $_POST['id'];
                $this->eliminarCiudad($id);
            }
        }
    }

    public function agregarCiudad($nombre){
        return $this->modelo->agregarCiudad($nombre);
    }


    public function obtenerCiudades(){
        return $this->modelo->obtenerCiudades();
    }

    public function actualizarCiudad($id, $nombre){
        $resultado = $this->modelo->actualizarCiudad($id, $nombre);

        //Verifica si la actualizacion se realizo con exito y redirige
        if($resultado){
            header('Location: ../vista/ciudadvista.php');
            exit(); 
            //Asegúrate de que la ejecucion del script se detenga despues de la redireccion
        }else{
            //Maneja el caso en que la actualizacion falló
            //Puedes mostrar un mensaje de error o realizar otras acciones necesarias
            echo "La actualizacion de la ciudad falló. Por favor, intentelo nuevamente.";
        }
    }


    public function eliminarCiudad($id){
        return $this->modelo->eliminarCiudad($id);
    }
}
?>