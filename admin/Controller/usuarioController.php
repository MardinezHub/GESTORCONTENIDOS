<?php
    include_once __DIR__ . '/../Model/usuarioModel.php';

    class usuarioController{
        private $usuarioModel;

        public function __construct()
        {
            $this->usuarioModel = new usuarioModel();
        }

        public function updateUsuario($data){
            $this->usuarioModel->updateUsuario(
                $data['dniusuario'],
                $data['nomusuario'],
                $data['apusuario'],
                $data['correousuario'],
                $data['telefono'],
                $data['direccion'],
                $data['estado']
            );
        }

        public function modificarPerfilAdmin($data){
            $this->usuarioModel->modificarPerfilAdmin(
                $data['dniusuario'],
                $data['nomusuario'],
                $data['apusuario'],
                $data['correousuario'],
                $data['telefono'],
                $data['direccion']
            );
        }

        public function modificarPerfilUsuario($data){
            $this->usuarioModel->modificarPerfilUsuario(
                $data['dniusuario'],
                $data['nomusuario'],
                $data['apusuario'],
                $data['correousuario'],
                $data['telefono'],
                $data['direccion']
            );
        }

        public function headerinicio($data){
            $this->usuarioModel->headerinicio(
                $data['correo'],
                $data['telefono'],
                $data['color']
            );
        }
    }

    $controller = new usuarioController();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['accion']) && $_POST['accion'] == "update"){
            $data = array(
                'dniusuario' => $_POST['dniusuario'],
                'nomusuario' => $_POST['nomusuario'],
                'apusuario' => $_POST['apusuario'],
                'correousuario' => $_POST['correousuario'],
                'telefono' => $_POST['telefono'],
                'direccion' => $_POST['direccion'],                
                'estado' => $_POST['estado']
            );

            $controller->updateUsuario($data);
        }
        elseif(isset($_POST['accion']) && $_POST['accion'] == "updateadmin")
        {
            $data = array(
                'dniusuario' => $_POST['dniusuario'],
                'nomusuario' => $_POST['nomusuario'],
                'apusuario' => $_POST['apusuario'],
                'correousuario' => $_POST['correousuario'],
                'telefono' => $_POST['telefono'],
                'direccion' => $_POST['direccion']
            );

            $controller->modificarPerfilAdmin($data);

        }
        elseif(isset($_POST['accion']) && $_POST['accion'] == "updateusuario")
        {
            $data = array(
                'dniusuario' => $_POST['dniusuario'],
                'nomusuario' => $_POST['nomusuario'],
                'apusuario' => $_POST['apusuario'],
                'correousuario' => $_POST['correousuario'],
                'telefono' => $_POST['telefono'],
                'direccion' => $_POST['direccion']
            );

            $controller->modificarPerfilUsuario($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] == "actualizarheader"){
            $data = array(
                'correo' => $_POST['correo'],
                'telefono' => $_POST['telefono'],
                'color' => $_POST['color']
            );

            $controller->headerinicio($data);
        }
    }


?>