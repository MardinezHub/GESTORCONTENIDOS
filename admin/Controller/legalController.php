<?php
    include_once __DIR__ . '/../Model/legalModel.php';

    class legalController{
        private $legalModel;

        public function __construct()
        {
            $this->legalModel = new legalModel();
        }

        //ADMINISTRADOR
        public function insertarMarco($data){
            $this->legalModel->insertarMarco($data);
        }

        public function updateMarco($data){
            $this->legalModel->updateMarco(
                $data['idmarco'],
                $data['nombremarco'],
                $data['nombrearchivo']
            );
        }

        public function eliminarMarco($idmarco){
            $this->legalModel->eliminarMarco($idmarco);
        }

        //PERSONAL
        public function insertarMarcoPersonal($data){
            $this->legalModel->insertarMarcoPersonal($data);
        }

        public function updateMarcoPersonal($data){
            $this->legalModel->updateMarcoPersonal(
                $data['idmarco'],
                $data['nombremarco'],
                $data['nombrearchivo']
            );
        }

    }

    $controller = new legalController();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['accion']) && $_POST['accion'] === 'registrar'){
            $data = array(
                'nombremarco' => $_POST['nombremarco'],
                'nombrearchivo' => $_POST['nombrearchivo']
            );

            $controller->insertarMarco($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'update'){
            $data = array(
                'idmarco' => $_POST['idmarco'],
                'nombremarco' => $_POST['nombremarco'],
                'nombrearchivo' => $_POST['nombrearchivo']
            );

            $controller->updateMarco($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === "eliminar"){
            $idmarco = $_POST['idmarco'];
            $controller->eliminarMarco($idmarco);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'registrar2'){
            $data = array(
                'nombremarco' => $_POST['nombremarco'],
                'nombrearchivo' => $_POST['nombrearchivo']
            );

            $controller->insertarMarcoPersonal($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'update2'){
            $data = array(
                'idmarco' => $_POST['idmarco'],
                'nombremarco' => $_POST['nombremarco'],
                'nombrearchivo' => $_POST['nombrearchivo']
            );

            $controller->updateMarcoPersonal($data);
        }
    }
?>
