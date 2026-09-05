<?php
    require_once 'modelo/conexion.php';
    require_once 'modelo/loginmodelo.php';

    class logincontroller{
        private $modelo;

        public function __construct(){
            $conexion = new Conexion();//instancia desde el controlador a la conexion
            $this->modelo = new loginmodel($conexion);
        }

        public function manejarSolicitud(){
            if(isset($_POST['accion'])){
                if($_POST['accion'] == "autenticar"){
                    $usuario = $_POST['txtusuario'];
                    $clave = $_POST['txtclave'];
                    if($this->validarUser($usuario, $clave)){
                        //crear otra variable de sesion para que la pagina sepa que esta activa la sesion
                        $_SESSION['usuario_iniciado'] = "activo";
                        //redirigir al usuario a la pagina nueva en caso de exito
                        header('Location: vista/menu.php');
                        exit; //Terminar el script para evitar que se siga ejecutando
                    }else{
                        //establecer una variable de sesion
                        $_SESSION['mensaje'] = "USUARIO O CONTRASEÑA INCORRECTA";
                        header('Location: index.php');
                        exit;
                    }
                }
            }
        }
        public function validarUser($usuario, $clave){
            return $this->modelo->validarUsuario($usuario, $clave);
        }
    }
?>