<?php
    include_once __DIR__ . '/../Model/multimediaModel.php';

    class multimediaController{
        private $multimediaModel;

        public function __construct()
        {
            $this->multimediaModel = new multimediaModel();
        }

        //ADMINISTRADOR
        public function insertarMultimedia($data){
            $this->multimediaModel->insertarMultimedia($data);
        }

        public function updateMultimedia($data){
            $this->multimediaModel->updateMultimedia(
                $data['idmulti'],
                $data['nombremultimedia'],
                $data['enlace']
            );
        }

        public function eliminarMultimedia($idmulti){
            $this->multimediaModel->eliminarMultimedia($idmulti);
        }

        //PERSONAL
        public function insertarMultimediaPersonal($data){
            $this->multimediaModel->insertarMultimediaPersonal($data);
        }

        public function updateMultimediaPersonal($data){
            $this->multimediaModel->updateMultimediaPersonal(
                $data['idmulti'],
                $data['nombremultimedia'],
                $data['enlace']
            );
        }
    }

    $controller = new multimediaController();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['accion']) && $_POST['accion'] === "registrar"){
            $data = array(
                'nombremultimedia' => $_POST['nombremultimedia'],
                'enlace' => $_POST['enlace']
            );

            $controller->insertarMultimedia($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === "update"){
            $data = array(
                'idmulti' => $_POST['idmulti'],
                'nombremultimedia' => $_POST['nombremultimedia'],
                'enlace' => $_POST['enlace']
            );
            $controller->updateMultimedia($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === "eliminar"){
            $idmulti = $_POST['idmulti'];
            $controller->eliminarMultimedia($idmulti);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'registrar2'){
            $data = array(
                'nombremultimedia' => $_POST['nombremultimedia'],
                'enlace' => $_POST['enlace']
            );

            $controller->insertarMultimediaPersonal($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'update2'){
            $data = array(
                'idmulti' => $_POST['idmulti'],
                'nombremultimedia' => $_POST['nombremultimedia'],
                'enlace' => $_POST['enlace']
            );
            $controller->updateMultimediaPersonal($data);
        }
    }


?>