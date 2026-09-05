<?php
session_start();

//Verifica si el usuario ha cerrado la sesion o no está autenticado
if(!isset($_SESSION['usuario_iniciado']) || $_SESSION['usuario_iniciado'] !== "activo"){
    //Redirige al usuario a la pagina de inicio
    header('Location: ../index.php');
    exit;
}else{
    //aqui se coloca el codigo si la sesion esta activa
    require_once '../controlador/clientecontrolador.php';

    $controller = new ClienteController();
    $controller->manejarSolicitud(); //Manejar las solicitudes POST
    $clientes = $controller->obtenerClientes();

    require_once '../controlador/ciudadcontrolador.php';
    $controllerciu = new CiudadController();
    $controllerciu->manejarSolicitud(); //Manejar las solicitudes POST
    $ciudades = $controllerciu->obtenerCiudades();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Clientes</title>
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
        <h1>Lista de clientes</h1>
        <!-- Se agrega un boton para agregar un cliente-->
        <button id="modalBtn1" onclick="abrirModal('mimodal1')"><i class="fa-solid fa-circle-plus"></i>Agregar clientes</button>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>RUC</th>
                <th>Telefono</th>
                <th>Ciudad</th>
                <th>Acciones</th>
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
                        <!-- Agregar una funcion onclick en los botones "Editar" para abrir la modal de edicion -->
                        <button class="bedit" type="button" onclick="openEditModal(
                            <?php echo $cliente['idclientes']; ?>,
                            '<?php echo $cliente['cli_nombre']; ?>',
                            '<?php echo $cliente['cli_apellido']; ?>',
                            '<?php echo $cliente['cli_ruc']; ?>',
                            '<?php echo $cliente['cli_telefono']; ?>',
                            '<?php echo $cliente['idciudades']; ?>'
                        )"><i class="fa-solid fa-pen-to-square"></i></button>

                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $cliente['idclientes']; ?>">
                            <input type="hidden" name="accion" value="eliminarcli">
                            <button class="belim" type="submit"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- primera ventana modal que es para el boton agregar-->
        <div id="mimodal1" class="modal">
            <div class="modal-content">
                <div id="tit_modal">
                    <h2>Agregar Cliente</h2>
                    <span id="closeBtn" onclick="cerrarModal('mimodal1')">&times;</span>
                </div>
                <form method="POST">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                    <br>
                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" placeholder="Apellido" required>
                    <br>
                    <label for="ruc">RUC:</label>
                    <input type="text" id="ruc" name="ruc" placeholder="RUC" required>
                    <br>
                    <label for="telefono">Telefono:</label>
                    <input type="text" id="telefono" name="telefono" placeholder="Telefono" required>
                    <br>
                    <label for="ciudad">Ciudad:</label>
                    <span id="mensajeCiudad" class="mensaje-error">Seleccione una ciudad</span>
                    <div id="ciu-busc">
                        <input type="text" id="ciudad" name="ciudad" placeholder="Ciudad" readonly>
                        <button type="button" id="modalBtn2" onclick="abrirModal('mimodal2')"><i id="i-busc" class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    <input type="hidden" name="accion" value="agregarcli">
                    <button id="agregarCliente" type="submit" class="bagr">Agregar</button>
                </form>
                
            </div>
        </div>

        <!-- Modal para editar cliente -->
        <div id="mimodal1-edit" class="modal">
            <div class="modal-content">
                <div id="tit_modal">
                    <h2>Editar Cliente</h2>
                    <span id="closeBtn" onclick="cerrarModal('mimodal1-edit')">&times;</span>
                </div>
                <form method="POST">
                    <label for="edit-nombre">Nombre:</label>
                    <input type="text" id="edit-nombre" name="nombre" placeholder="Nombre" required>
                    <br>
                    <label for="edit-apellido">Apellido:</label>
                    <input type="text" id="edit-apellido" name="apellido" placeholder="Apellido" required>
                    <br>
                    <label for="edit-ruc">RUC:</label>
                    <input type="text" id="edit-ruc" name="ruc" placeholder="RUC" required>
                    <br>
                    <label for="edit-telefono">Telefono:</label>
                    <input type="text" id="edit-telefono" name="telefono" placeholder="Telefono" required>
                    <br>
                    <label for="edit-ciudad">Ciudad:</label>
                    <div id="ciu-busc">
                        <input type="text" id="edit-ciudad" name="ciudad" placeholder="Ciudad" readonly>
                        <button type="button" id="modalBtn3" onclick="abrirModal('mimodal2')"><i id="i-busc" class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    <input type="hidden" name="accion" value="editarcli">
                    <input type="hidden" id="edit-id" name="id" >
                    <button type="submit" class="bgua">Guardar Cambios</button>
                </form>
                
            </div>
        </div>

        <!-- segunda ventana modal-->
        <div id="mimodal2" class="modal">
            <div class="modal-content" id="modal-ciusel">
                <div id="tit_modal">
                    <h2>Lista de ciudades</h2>
                    <span id="closeBtn" onclick="cerrarModal('mimodal2')">&times;</span>
                </div>
                <!-- aqui se coloca la tabla de buscador segun el fk-->
                <table border="1" id="ta-ciusel">
                    <tr>
                        <th>ID</th>
                        <th>Ciudad</th>
                        <th>Accion</th>
                    </tr>
                    <?php foreach ($ciudades as $ciudad): ?>
                        <tr>
                            <td><?php echo $ciudad['idciudades']; ?></td>
                            <td><?php echo $ciudad['ciu_nombre']; ?></td>
                            <td>
                                <button class="bsel" type="button" onclick="seleccionarCiudad(
                                    <?php echo $ciudad['idciudades']; ?>
                                )">Seleccionar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
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