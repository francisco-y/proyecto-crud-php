<?php
    session_start();
    require_once 'controlador/logincontrolador.php';
    $controller = new logincontroller();
    $controller->manejarSolicitud();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Acceso</title>
    <link rel="stylesheet" href="css/loginstyle.css">
</head>
<body>
    <div class="bg">
        <ul class="glass">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <div class="container">
            <div class="form">
                <h1>Control de Acceso</h1>
                <form method="post">
                    <input type="text" name="txtusuario" id="user" placeholder="Usuario" required><br><br>
                    <input type="password" name="txtclave" id="pass" placeholder="Contraseña" required><br><br>
                    <input type="hidden" name="accion" value="autenticar">
                    <button type="submit">INGRESAR</button>
                    <div id="mensaje" class="<?php echo isset($_SESSION['mensaje']) ? 'mensaje-visible' : ''; ?>">
                        <?php
                            if(isset($_SESSION['mensaje'])){
                                echo $_SESSION['mensaje'];
                                unset($_SESSION['mensaje']);
                            }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>