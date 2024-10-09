<?php
    include_once '../Model/registroModel.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $registroModel = new registroModel();
        $data = [
            'dniusuario' => $_POST['dniusuario'],
            'nombreusuario' => $_POST['nombreusuario'],
            'apellidousuario' => $_POST['apellidousuario'],
            'correousuario' => $_POST['correousuario'],
            'contrasenia' => $_POST['contrasenia'],
            'telefono' => $_POST['telefono'],
            'direccion' => $_POST['direccion'],
        ];

        $resultado = $registroModel->insertUser($data);
        
        if ($resultado === true) {
            echo '<script>alert("¡Se realizo con exito el registro del Usuario!"); window.location.href = "../Views/Admin/usuariosadmin.php";</script>';
            exit();
        } else {
            echo $resultado;
        }
    }
?>