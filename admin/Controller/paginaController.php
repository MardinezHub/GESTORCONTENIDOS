<?php
    include_once __DIR__ . '/../Model/paginaModel.php';

    class paginaController{
        private $paginaModel;

        public function __construct()
        {
            $this->paginaModel = new paginaModel();
        }

        //FUNCIONES DE PAGINA
        public function insertarPagina($data){
            $this->paginaModel->insertarPagina($data);
        }

        public function updatePagina($data){
            $this->paginaModel->updatePagina(
                $data['idpagina'],
                $data['nombrepagina']
            );
        }

        public function eliminarPagina($idpagina){
            $this->paginaModel->eliminarPagina($idpagina);
        }

        //FUNCIONES DE SUBPAGINA
        public function insertarSubpagina($data){
            $this->paginaModel->insertarSubpagina($data);
        }

        public function updateSubPagina($data){
            $this->paginaModel->updateSubPagina(
                $data['idsubpagina'],
                $data['nombresub'],
                $data['fk_idpagina']
            );
        }

        public function eliminarSubpagina($idsubpagina){
            $this->paginaModel->eliminarSubpagina($idsubpagina);
        }
    }

    $controller = new paginaController();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['accion']) && $_POST['accion'] === 'registrarpagina'){
            $data = array(
                'nombrepagina' => $_POST['nombrepagina']
            );

            $controller->insertarPagina($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'updatepagina'){
            $data = array(
                'idpagina' => $_POST['idpagina'],
                'nombrepagina' => $_POST['nombrepagina']
            );

            $controller->updatePagina($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'eliminarpagina'){
            $idpagina = $_POST['idpagina'];
            $controller->eliminarPagina($idpagina);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'registrarsubpagina'){
            $data = array(
                'nombresub' => $_POST['nombresub'],
                'fk_idpagina' => $_POST['fk_idpagina']
            );

            $controller->insertarSubpagina($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'updatesubpagina'){
            $data = array(
                'idsubpagina' => $_POST['idsubpagina'],
                'nombresub' => $_POST['nombresub'],
                'fk_idpagina' => $_POST['fk_idpagina']
            );
            $controller->updateSubPagina($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'eliminarsubpagina'){
            $idsubpagina = $_POST['idsubpagina'];
            $controller->eliminarSubpagina($idsubpagina);
        }
    }

?>