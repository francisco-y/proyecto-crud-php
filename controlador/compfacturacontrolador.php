<?php
require_once '../modelo/conexion.php';
require_once '../modelo/compfacturamodelo.php';

class CompFacturaController{
    private $modelo;

    public function __construct(){
        $conexion = new Conexion(); //Crear una instancia de la clase de conexion
        $this->modelo = new compfacturaModel($conexion); //Pasar la conexion al modelo
    }
    public function manejarSolicitud(){
        if(isset($_POST['accion'])){
            if($_POST['accion'] == 'compguardar'){
                
                // Obtener los datos de la factura desde $_POST
                $id = $_POST['txtid'];
                $fecha = $_POST['txtfecha'];
                $condicion = $_POST['formaDePago'];
                $estado = $_POST['txtestado'];
                $proveedorid = $_POST['codigoprov'];
                $user = '1';
                $this->modelo->insertarFactura($id, $fecha, $condicion, $estado, $proveedorid, $user);

                //Obtener los detalles de la factura desde el formulario
                $detallesFactura = [];

                $codigos = $_POST['codigo'];
                $nombres = $_POST['nombre'];
                $precios = $_POST['precio'];
                $cantidades = $_POST['cantidad'];

                for($i = 0; $i < count($codigos); $i++){
                    $detalle = [
                        'codigo' => $codigos[$i],
                        'nombre' => $nombres[$i],
                        'precio' => $precios[$i],
                        'cantidad' => $cantidades[$i]
                    ];
                    $detallesFactura[] = $detalle;
                }

                //Ahora puedes insertar los detalles en la base de datos
                foreach($detallesFactura as $detalle){
                    $idfactura = $_POST['txtid'];
                    $idproducto = $detalle['codigo'];
                    $precio = $detalle['precio'];
                    $cantidad = $detalle['cantidad'];

                    //Llama a la funcion del modelo para insertar cada detalle
                    $this->insertarDetalle($idfactura, $idproducto, $precio, $cantidad);
                }
            }
        }
    }
    public function insertarDetalle($idfactura, $idproducto, $precio, $cantidad){
        $resultado = $this->modelo->insertarDetalle($idfactura, $idproducto, $precio, $cantidad);
        if ($resultado) {
            echo '<script>window.resultadoProceso = "exito";</script>';
        } else {
            echo '<script>window.resultadoProceso = "error";</script>';
        }
    }
    public function obtenerUltimoId(){
        $ultimoId = $this->modelo->obtenerUltimoId() + 1;
        return $ultimoId;
    }
}
?>