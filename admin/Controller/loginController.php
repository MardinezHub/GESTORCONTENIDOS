<?php
session_start();

include_once '../Model/loginModel.php';

function login($dniusuario, $contrasenia) {
    $usuarioModel = new loginModel();
    $usuario = $usuarioModel->obtenerUsuarioPorDNIyContrasenia($dniusuario, $contrasenia);

    if ($usuario && $usuario['estado'] == 1) {
        $_SESSION['userId'] = $usuario['dniusuario'];
        $_SESSION['rol'] = $usuario['fk_idrol'];

        switch ($usuario['fk_idrol']) {
            case 1:
                header('Location: ../Views/Admin/indexadmin.php');
                break;
            case 2:
                header('Location: ../Views/Personal/indexpersonal.php');
                break;
            default:
                header('Location: ../error.php?msg=Usuario no Encontrado');
                break;
        }
    } elseif ($usuario && $usuario['estado'] == 0) {
        echo '<script>
              alert("El usuario está inactivo");
              window.location.href = "../index.php";
              </script>';
        exit;
    } else {
        echo '<script>
              alert("El usuario y contraseña son incorrectas o su cuenta esta inactiva. Hable con el encargado administrador que le habilite la cuenta... ");
              window.location.href = "../index.php";
              </script>';
        exit;
    }
    $usuarioModel->cerrarConexion();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dniusuario']) && isset($_POST['contrasenia'])) {
        login($_POST['dniusuario'], $_POST['contrasenia']);
    } else {
        header('Location: ../index.php?error=Datos incompletos');
    }
}
?>
