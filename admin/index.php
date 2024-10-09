<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="source/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="source/img/favicon.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Inicio de Sesión - Gestor de Contenidos</title>
</head>
<body>
    <section class="side">
        <img src="source/img/universidad.svg" alt="">
    </section>
    <section class="main">
        <div class="login-container">
            <p class="title">Bienvenido al Gestor de Contenidos</p>
            <div class="separator"></div>
            <p class="welcome-message">Porfavor, ingresa tus datos para validar tu información.</p>

            <form class="login-form" action="Controller/loginController.php" method="POST">
                <div class="form-control">
                    <input type="number" name="dniusuario" id="dniusuario" placeholder="DNI">
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-control">
                    <input type="password" id="contrasenia" name="contrasenia" placeholder="Contraseña">
                    <i class="fas fa-lock"></i>
                </div>

                <button type="submit" class="btn btn-danger">Iniciar Sesión</button>
            </form>
        </div>
    </section>
    
</body>
</html>