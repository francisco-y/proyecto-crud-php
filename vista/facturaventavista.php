<?php
session_start();

//Verifica si el usuario ha cerrado la sesion o no está autenticado
if(!isset($_SESSION['usuario_iniciado']) || $_SESSION['usuario_iniciado'] !== "activo"){
    //Redirige al usuario a la pagina de inicio
    header('Location: ../index.php');
    exit;
}else{
    //aqui se coloca el codigo si la sesion esta activa
    require_once '../controlador/facturaventacontrolador.php';
    $controllerfv = new FacturaVentaController();
    $vfacturas = $controllerfv->obtenerVentas();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Facturas venta</title>
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
        <h1>Facturas de venta</h1>
        <!-- Se agrega un boton para generar factura-->
        <div id="dgenfac">
            <a id="genfac" href="facturavista.php"><i class="fa-solid fa-circle-plus"></i>Generar factura</a>
        </div>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Condicion</th>
                <th>Estado</th>
                <th>Cliente</th>
                <th>Usuario</th>
            </tr>
            <?php foreach ($vfacturas as $vfactura): ?>
                <tr>
                    <td><?php echo $vfactura['idfacturas']; ?></td>
                    <td><?php echo $vfactura['fac_fecha']; ?></td>
                    <td><?php echo $vfactura['fac_condicion']; ?></td>
                    <td><?php echo $vfactura['fac_estado']; ?></td>
                    <td><?php echo $vfactura['idclientes']; ?></td>
                    <td><?php echo $vfactura['idusuarios']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

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