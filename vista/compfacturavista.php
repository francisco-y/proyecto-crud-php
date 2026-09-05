<?php
    session_start();

    //Verifica si el usuario ha cerrado la sesion o no está autenticado
    if(!isset($_SESSION['usuario_iniciado']) || $_SESSION['usuario_iniciado'] !== "activo"){
        //Redirige al uusario a la pagina de inicio
        header('Location: ../index.php');
        exit;
    }else{
        //aqui se coloca el codigo si la sesion esta activa
        require_once '../controlador/proveedorcontrolador.php';
        $controller = new ProveedorController();
        $controller->manejarSolicitud(); //Manejar las solicitudes POST
        $proveedores = $controller->obtenerProveedores();
    
        require_once '../controlador/productocontrolador.php';
        $controllerpro = new ProductoController();
        $controllerpro->manejarSolicitud(); //Manejar las solicitudes POST
        $productos = $controllerpro->obtenerProductos();

        require_once '../controlador/compfacturacontrolador.php';
        $controllercompfactura = new CompFacturaController();
        $controllercompfactura->manejarSolicitud(); //Manejar las solicitudes POST
        $ultimoid = $controllercompfactura->obtenerUltimoId();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras</title>
    <link rel="stylesheet" href="../css/facturastyle.css">
    <script src="https://kit.fontawesome.com/34b3701c99.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="encabezado">
            <div id="dlo">
                <a href="menu.php"><img src="../img/logo 2.png" alt="LOGO" class="logo"></a>
            </div>
            <div>
                <nav>
                    <ul>
                        <li>
                            <a href="#">ADMINISTRAR</a>
                            <ul>
                                <li><a href="clientevista.php">CLIENTES</a></li>
                                <li><a href="ciudadvista.php">CIUDADES</a></li>
                                <li><a href="productovista.php">PRODUCTOS</a></li>
                                <li><a href="proveedorvista.php">PROVEEDORES</a></li>
                                <li><a href="usuariovista.php">USUARIOS</a></li>
                                <li><a href="personalvista.php">PERSONALES</a></li>
                            </ul>
                        </li>
                        <li><a href="facturaventavista.php">VENTAS</a></li>
                        <li><a href="facturacompravista.php">COMPRAS</a></li>
                        <li><a href="inventariovista.php">INVENTARIO</a></li>
                        <li>
                            <form method="post" action="../modelo/cerrarsesion.php">
                                <button type="submit" name="cerrar_sesion" class="cerrar" title="CERRAR SESION">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="content">
        <form action="" method="POST">
            <div class="cabeza">
                <div class="top-div">
                    <!-- Contenido del primer div en la parte superior -->
                    <table>
                        <tr>
                            <td><label for="">N° FACTURA</label></td>
                            <td><input type="text" name="txtid" id="txtid" value="<?php echo $ultimoid; ?>"></td>
                        </tr>
                        <tr>
                            <td><label for="">CONDICION COMPRA</label></td>
                            <td>
                                <select name="formaDePago" id="formaDePago">
                                    <option value="CONTADO">CONTADO</option>
                                    <option value="CREDITO">CREDITO</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>FECHA</td>
                            <td><input type="text" name="txtfecha" id="txtfecha" readonly></td>
                            <td>ESTADO</td>
                            <td><input type="text" name="txtestado" id="txtestado" value="PENDIENTE" readonly></td>
                        </tr>
                    </table>
                </div>
                <div class="top-div">
                    <table>
                        <tr>
                            <td><label for="codigo">Código:</label></td>
                            <td><input type="text" id="codigoprov" name="codigoprov" readonly></td>
                            <td><button id="buscar" onclick="abrirModal('mimodalprov')">Buscar</button></td>
                        </tr>
                        <tr>
                            <td><label for="nombre">Nombre:</label></td>
                            <td><input type="text" id="nombre" name="nombre" readonly></td>
                            <td></td> <!-- Celda vacía en la tercera columna -->
                        </tr>
                        <tr>
                            <td><label for="ruc">RUC:</label></td>
                            <td><input type="text" id="ruc" name="ruc" readonly></td>
                            <td><label for="telefono">Telefono:</label></td>
                            <td><input type="text" id="telefono" name="telefono" readonly></td>
                            <td></td> <!-- Celda vacía en la tercera columna -->
                        </tr>
                    </table>
                </div>
            </div>

            <div class="bottom-div">
                <div class="search-form">
                    <table class="centered-table">
                        <tr>
                            <td><label for="codigo">Código:</label></td>
                            <td><input type="text" id="codigopro" name="codigopro" readonly>
                            <input type="hidden" id="preciopro" name="preciopro">
                            <input type="hidden" id="ivapro" name="ivapro"></td>
                            <td><button id="buscar" onclick="abrirModal('mimodalpro')">Buscar</button></td>
                            <td><input type="text" id="nombrepro" name="nombrepro" readonly></td> <!-- Cuarta columna con ancho predeterminado -->
                            <td><label for="cantidad">Cantidad:</label></td>
                            <td><input type="text" id="cantidadpro" name="cantidadpro"></td>
                            <td><button type="button" id="buscar" onclick="agregarFila()">AÑADIR</button></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="bottom-div2">
                <div class="search-form">
                    <table id="tabladetalle" class="bordered-table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>P.U.</th>
                                <th>Cantidad</th>
                                <th>Exenta</th>
                                <th>5%</th>
                                <th>10%</th>
                                <th>ACCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            

                        </tbody>
                    </table>
                </div>
            </div>
            <input type="hidden" name="accion" value="compguardar">
            <button id="bgua" class="icon-button" type="submit">GUARDAR</button>
        </form>


        <!-- primera ventana modal que es para el proveedor-->
        <div id="mimodalprov" class="modal">
            <div class="modal-content">
                <div id="tit_modal">
                    <h2>Proveedores</h2>
                    <span id="closeBtn" onclick="cerrarModal('mimodalprov')">&times;</span>
                </div>
                <table border="1" id="ta_sel_fac">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>RUC</th>
                        <th>Telefono</th>
                        <th>Accion</th>
                    </tr>
                    <?php foreach ($proveedores as $proveedor): ?>
                        <tr>
                            <td><?php echo $proveedor['idproveedores']; ?></td>
                            <td><?php echo $proveedor['prov_nombre']; ?></td>
                            <td><?php echo $proveedor['prov_ruc']; ?></td>
                            <td><?php echo $proveedor['prov_telefono']; ?></td>
                            <td>
                                <!-- Agregar una funcion onclick en los botones "Seleccionar" para abrir la modal-->
                                <button class="bsel" type="button" onclick="transferirProveedor(
                                    '<?php echo $proveedor['idproveedores']; ?>',
                                    '<?php echo $proveedor['prov_nombre']; ?>',
                                    '<?php echo $proveedor['prov_ruc']; ?>',
                                    '<?php echo $proveedor['prov_telefono']; ?>'
                                )">Seleccionar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    
        <!-- primera ventana modal que es para el producto-->
        <div id="mimodalpro" class="modal">
            <div class="modal-content">
                <div id="tit_modal">
                    <h2>Productos</h2>
                    <span id="closeBtn" onclick="cerrarModal('mimodalpro')">&times;</span>
                </div>
                <table border="1" id="ta_sel_fac">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>IVA</th>
                        <th>Accion</th>
                    </tr>
                    <?php foreach ($productos as $pro): ?>
                        <tr>
                            <td><?php echo $pro['idproductos']; ?></td>
                            <td><?php echo $pro['pro_nombre']; ?></td>
                            <td><?php echo $pro['pro_precio']; ?></td>
                            <td><?php echo $pro['pro_stock']; ?></td>
                            <td><?php echo $pro['pro_iva']; ?></td>
                            <td>
                                <!-- Agregar una funcion onclick en los botones "Seleccionar" para abrir la modal-->
                                <button class="bsel" type="button" onclick="transferirProductos(
                                    '<?php echo $pro['idproductos']; ?>',
                                    '<?php echo $pro['pro_nombre']; ?>',
                                    '<?php echo $pro['pro_precio']; ?>',
                                    '<?php echo $pro['pro_iva']; ?>'
                                )">Seleccionar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <!-- Ventana modal mensaje -->
        <div id="mimodalmens" class="modal">
            <div class="content-mens">
                <p>La factura se realizó con éxito</p>
                <button id="bmens" onclick="cerrarModalYRecargar()">Aceptar</button>
            </div>
        </div>

        <!-- Ventana modal mensaje error -->
        <div id="mimodalmens-err" class="modal">
            <div class="content-mens-err">
                <p>Hubo un problema al realizar la factura</p>
                <button id="bmens" onclick="cerrarModalYRedirigir()">Aceptar</button>
            </div>
        </div>

    </main>

    <footer>
        <div class="footer-column footer-left">
            <a href="menu.php"><img src="../img/logo 2.png" alt="LOGO" class="logo"></a>
        </div>
        <div class="footer-column footer-right">
            <a href="https://www.facebook.com/" target="_blank"><i id="fac" class="fa fa-facebook social-icons"></i></a>
            <a href="https://www.instagram.com/" target="_blank"><i id="ins" class="fa fa-instagram social-icons"></i></a>
            <a href="https://www.youtube.com/" target="_blank"><i id="yout" class="fa-brands fa-youtube social-icons"></i></a>
        </div>
        <div class="rights-reserved">
            Derechos Reservados &copy; 2023 STI
        </div>
    </footer>

    <script src="../js/compfacturascript.js"></script>
</body>
</html>