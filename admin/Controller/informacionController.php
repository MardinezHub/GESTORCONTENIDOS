<?php
    include_once __DIR__ . '/../Model/informacionModel.php';

    class informacionController{
        private $informacionModel;

        public function __construct()
        {
            $this->informacionModel = new informacionModel();
        }

        //ADMINISTRADOR
        public function insertarinformacion($data){
            $this->informacionModel->insertarinformacion($data);
        }

        public function updateinformacion($data){
            $this->informacionModel->updateinformacion(
                $data['idinformacion'],
                $data['titulo'],
                $data['informacion'],
                $data['fk_idpagina'],
                $data['fk_idsubpagina']
            );
        }

        public function eliminarinformacion($idinformacion){
            $this->informacionModel->eliminarinformacion($idinformacion);
        }

        //PERSONAL
        public function insertarinformacionPersonal($data){
            $this->informacionModel->insertarinformacionPersonal($data);
        }

        public function updateinformacionPersonal($data){
            $this->informacionModel->updateinformacionPersonal(
                $data['idinformacion'],
                $data['titulo'],
                $data['informacion'],
                $data['fk_idpagina'],
                $data['fk_idsubpagina']
            );
        }
    }

    $controller = new informacionController();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['accion']) && $_POST['accion'] === "registrarinformacion"){
            $data = array(
                'titulo' => $_POST['titulo'],
                'informacion' => $_POST['informacion'],
                'fk_idpagina' => $_POST['fk_idpagina'],
                'fk_idsubpagina' => $_POST['fk_idsubpagina']
            );

            $controller->insertarinformacion($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === "updateinformacion"){
            $data = array(
                'idinformacion' => $_POST['idinformacion'],
                'titulo' => $_POST['titulo'],
                'informacion' => $_POST['informacion'],
                'fk_idpagina' => $_POST['fk_idpagina'],
                'fk_idsubpagina' => $_POST['fk_idsubpagina']
            );

            $controller->updateinformacion($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === "eliminarinformacion"){
            $idinformacion = $_POST['idinformacion'];
            
            $controller->eliminarinformacion($idinformacion);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'registrarinformacionpersonal'){
            $data = array(
                'titulo' => $_POST['titulo'],
                'informacion' => $_POST['informacion'],
                'fk_idpagina' => $_POST['fk_idpagina'],
                'fk_idsubpagina' => $_POST['fk_idsubpagina']
            );

            $controller->insertarinformacionPersonal($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'updateinformacionpersonal'){
            $data = array(
                'idinformacion' => $_POST['idinformacion'],
                'titulo' => $_POST['titulo'],
                'informacion' => $_POST['informacion'],
                'fk_idpagina' => $_POST['fk_idpagina'],
                'fk_idsubpagina' => $_POST['fk_idsubpagina']
            );

            $controller->updateinformacionPersonal($data);
        }
    }
?>