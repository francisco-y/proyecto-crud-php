<?php
    session_start();

    //Verifica si el usuario ha cerrado la sesion o no está autenticado
    if(!isset($_SESSION['usuario_iniciado']) || $_SESSION['usuario_iniciado'] !== "activo"){
        //Redirige al uusario a la pagina de inicio
        header('Location: ../index.php');
        exit;
    }else{
        //aqui se coloca el codigo si la sesion esta activa
        require_once '../controlador/clientecontrolador.php';
        $controller = new ClienteController();
        $controller->manejarSolicitud(); //Manejar las solicitudes POST
        $clientes = $controller->obtenerClientes();
    
        require_once '../controlador/productocontrolador.php';
        $controllerpro = new ProductoController();
        $controllerpro->manejarSolicitud(); //Manejar las solicitudes POST
        $productos = $controllerpro->obtenerProductos();

        require_once '../controlador/facturacontrolador.php';
        $controllerfactura = new FacturaController();
        $controllerfactura->manejarSolicitud(); //Manejar las solicitudes POST
        $ultimoid = $controllerfactura->obtenerUltimoId();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
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
                            <td><label for="">CONDICION VENTA</label></td>
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
                            <td><input type="text" id="codigocli" name="codigocli" readonly></td>
                            <td><button id="buscar" onclick="abrirModal('mimodalcli')">Buscar</button></td>
                        </tr>
                        <tr>
                            <td><label for="nombre">Nombre:</label></td>
                            <td><input type="text" id="nombre" name="nombre" readonly></td>
                            <td><label for="apellido">Apellido:</label></td>
                            <td><input type="text" id="apellido" name="apellido" readonly></td>
                            <td></td> <!-- Celda vacía en la tercera columna -->
                        </tr>
                        <tr>
                            <td><label for="ruc">RUC:</label></td>
                            <td><input type="text" id="ruc" name="ruc" readonly></td>
                            <td><label for="ciudad">Ciudad:</label></td>
                            <td><input type="text" id="ciudad" name="ciudad" readonly></td>
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
            <input type="hidden" name="accion" value="guardar">
            <button id="bgua" class="icon-button" type="submit">GUARDAR</button>
        </form>


        <!-- primera ventana modal que es para el cliente-->
        <div id="mimodalcli" class="modal">
            <div class="modal-content">
                <div id="tit_modal">
                    <h2>Clientes</h2>
                    <span id="closeBtn" onclick="cerrarModal('mimodalcli')">&times;</span>
                </div>
                <table border="1" id="ta_sel_fac">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>RUC</th>
                        <th>Telefono</th>
                        <th>Ciudad</th>
                        <th>Accion</th>
                    </tr>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo $cliente['idclientes']; ?></td>
                            <td><?php echo $cliente['cli_nombre']; ?></td>
                            <td><?php echo $cliente['cli_apellido']; ?></td>
                            <td><?php echo $cliente['cli_ruc']; ?></td>
                            <td><?php echo $cliente['cli_telefono']; ?></td>
                            <td><?php echo $cliente['idciudades']; ?></td>
                            <td>
                                <!-- Agregar una funcion onclick en los botones "Seleccionar" para abrir la modal-->
                                <button class="bsel" type="button" onclick="transferirCliente(
                                    '<?php echo $cliente['idclientes']; ?>',
                                    '<?php echo $cliente['cli_nombre']; ?>',
                                    '<?php echo $cliente['cli_apellido']; ?>',
                                    '<?php echo $cliente['cli_ruc']; ?>',
                                    '<?php echo $cliente['idciudades']; ?>'
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

    <script src="../js/facturascript.js"></script>
</body>
</html>