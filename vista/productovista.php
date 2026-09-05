<?php
    session_start();

    //Verifica si el usuario ha cerrado la sesion o no está autenticado
    if(!isset($_SESSION['usuario_iniciado']) || $_SESSION['usuario_iniciado'] !== "activo"){
        //Redirige al uusario a la pagina de inicio
        header('Location: ../index.php');
        exit;
    }else{
        //aqui se coloca el codigo si la sesion esta activa
    
        require_once '../controlador/productocontrolador.php';
        $controller = new ProductoController();
        $controller->manejarSolicitud(); //Manejar las solicitudes POST
        $productos = $controller->obtenerProductos();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="../css/style.css">
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
        <h1>Lista de productos</h1>
        <!-- Se agrega un boton para agregar un producto-->
        <button id="modalBtn1" onclick="abrirModal('mimodal1')"><i class="fa-solid fa-circle-plus"></i>Agregar productos</button>
        
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>IVA</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo $producto['idproductos']; ?></td>
                    <td><?php echo $producto['pro_nombre']; ?></td>
                    <td><?php echo $producto['pro_precio']; ?></td>
                    <td><?php echo $producto['pro_stock']; ?></td>
                    <td><?php echo $producto['pro_iva']; ?></td>
                    <td>
                        <!-- Agregar una funcion onclick en los botones "Editar" para abrir la modal de edicion -->
                        <button class="bedit" type="button" onclick="openEditModalpro(
                            <?php echo $producto['idproductos']; ?>,
                            '<?php echo $producto['pro_nombre']; ?>',
                            '<?php echo $producto['pro_precio']; ?>',
                            '<?php echo $producto['pro_stock']; ?>',
                            '<?php echo $producto['pro_iva']; ?>'
                        )"><i class="fa-solid fa-pen-to-square"></i></button>

                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $producto['idproductos']; ?>">
                            <input type="hidden" name="accion" value="eliminarpro">
                            <button class="belim" type="submit"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>


        <!-- Modal para agregar producto -->
        <div id="mimodal1" class="modal">
            <div class="modal-content">
                <div id="tit_modal">
                    <h2>Agregar Producto</h2>
                    <span id="closeBtn" onclick="cerrarModal('mimodal1')">&times;</span>
                </div>
                <form method="POST">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                    <br>
                    <label for="precio">Precio:</label>
                    <input type="text" id="precio" name="precio" placeholder="Precio" required>
                    <br>
                    <label for="stock">Stock:</label>
                    <input type="text" id="stock" name="stock" placeholder="Stock" required>
                    <br>
                    <label for="iva">IVA:</label>
                    <input type="text" id="iva" name="iva" placeholder="IVA" required>
                    <br>
                    <input type="hidden" name="accion" value="agregarpro">
                    <button type="submit" class="bagr">Agregar</button>
                </form>
                
            </div>
        </div>
        <!-- Modal para editar producto -->
        <div id="mimodal1-edit" class="modal">
            <div class="modal-content">
                <div id="tit_modal">
                    <h2>Editar Producto</h2>
                    <span id="closeBtn" onclick="cerrarModal('mimodal1-edit')">&times;</span>
                </div>
                <form method="POST">
                    <label for="edit-nombre">Nombre:</label>
                    <input type="text" id="edit-nombre" name="nombre" placeholder="Nombre" required>
                    <br>
                    <label for="edit-precio">Precio:</label>
                    <input type="text" id="edit-precio" name="precio" placeholder="Precio" required>
                    <br>
                    <label for="edit-stock">Stock:</label>
                    <input type="text" id="edit-stock" name="stock" placeholder="Stock" required>
                    <br>
                    <label for="edit-iva">IVA:</label>
                    <input type="text" id="edit-iva" name="iva" placeholder="IVA" required>
                    <br>
                    <input type="hidden" name="accion" value="editarpro">
                    <input type="hidden" id="edit-id" name="id" >
                    <button type="submit" class="bgua">Guardar Cambios</button>
                </form>
                
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

    <script src="../js/script.js"></script>
</body>
</html>