<?php
require_once '../modelo/conexion.php';
require_once '../modelo/usuariomodelo.php';

class UsuarioController{
    private $modelo;

    public function __construct(){
        $conexion = new Conexion(); //Crear una instancia de la clase de conexion
        $this->modelo = new UsuarioModel($conexion); //Pasar la conexion al modelo
    }
    public function manejarSolicitud(){
        if(isset($_POST['accion'])){
            if($_POST['accion'] == 'agregarusu'){
                $nombre = $_POST['nombre'];
                $clave = $_POST['clave'];
                $tipo = $_POST['tipo'];
                $estado = $_POST['estado'];
                $personal = $_POST['personal'];
                $this->agregarUsuario($nombre, $clave, $tipo, $estado, $personal);
            }elseif($_POST['accion'] == 'editarusu'){
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $clave = $_POST['clave'];
                $tipo = $_POST['tipo'];
                $estado = $_POST['estado'];
                $personal = $_POST['personal'];
                $this->actualizarUsuario($id, $nombre, $clave, $tipo, $estado, $personal);
            }elseif($_POST['accion'] == 'eliminarusu'){
                $id = $_POST['id'];
                $this->eliminarUsuario($id);
            }
        }
    }

    public function agregarUsuario($nombre, $clave, $tipo, $estado, $personal){
        return $this->modelo->agregarUsuario($nombre, $clave, $tipo, $estado, $personal);
    }

    public function obtenerUsuarios(){
        return $this->modelo->obtenerUsuarios();
    }


    public function actualizarUsuario($id, $nombre, $clave, $tipo, $estado, $personal){
        $resultado = $this->modelo->actualizarUsuario($id, $nombre, $clave, $tipo, $estado, $personal);

        //Verifica si la actualizacion se realizo con exito y redirige
        if($resultado){
            header('Location: ../vista/usuariovista.php');
            exit(); 
            //Asegúrate de que la ejecucion del script se detenga despues de la redireccion
        }else{
            //Maneja el caso en que la actualizacion falló
            //Puedes mostrar un mensaje de error o realizar otras acciones necesarias
            echo "La actualizacion del usuario falló. Por favor, intentelo nuevamente.";
        }
    }


    public function eliminarUsuario($id){
        return $this->modelo->eliminarUsuario($id);
    }
}
?>