<?php 
    include_once __DIR__ . '../../Model/listaModel.php';

    class listaController{
        private $listaModel;

        public function __construct()
        {
            $this->listaModel = new listaModel();
        }

        //METODOS DE LISTA
        //ADMINISTRADOR

        public function insertarLista($data){
            $this->listaModel->insertarLista($data);
        }

        public function updatelista($data){
            $this->listaModel->updatelista(
                $data['idlista'],
                $data['titulo'],
                $data['fk_idpagina'],
                $data['fk_idsubpagina']
            );
        }

        public function eliminarlista($idlista){
            $this->listaModel->eliminarlista($idlista);
        }

        //PERSONAL
        public function insertarListaPersonal($data){
            $this->listaModel->insertarListaPersonal($data);
        }

        public function updatelistaPersonal($data){
            $this->listaModel->updatelistaPersonal(
                $data['idlista'],
                $data['titulo'],
                $data['fk_idpagina'],
                $data['fk_idsubpagina']
            );
        }

        //METODOS DE OPCION
        //ADMINISTRADOR
        public function insertaropcion($data){
            $this->listaModel->insertaropcion($data);
        }

        public function updateopcion($data){
            $this->listaModel->updateopcion(
                $data['idopcion'],
                $data['descripcion'],
                $data['fk_idlista']
            );
        }

        public function eliminaropcion($idopcion){
            $this->listaModel->eliminaropcion($idopcion);
        }

        //PERSONAL
        public function insertaropcionPersonal($data){
            $this->listaModel->insertaropcionPersonal($data);
        }

        public function updateopcionPersonal($data){
            $this->listaModel->updateopcionPersonal(
                $data['idopcion'],
                $data['descripcion'],
                $data['fk_idlista']
            );
        }
    }

    $controller = new listaController();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['accion']) && $_POST['accion'] === 'registrarlista'){
            $data = array(
                'titulo' => $_POST['titulo'],
                'fk_idpagina' => $_POST['fk_idpagina'],
                'fk_idsubpagina' => $_POST['fk_idsubpagina']
            );

            $controller->insertarLista($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'updatelista'){
            $data = array(
                'idlista' => $_POST['idlista'],
                'titulo' => $_POST['titulo'],
                'fk_idpagina' => $_POST['fk_idpagina'],
                'fk_idsubpagina' => $_POST['fk_idsubpagina']
            );

            $controller->updatelista($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'eliminarlista'){
            $idlista = $_POST['idlista'];
            $controller->eliminarlista($idlista);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'registraropcion'){
            $data = array(
                'descripcion' => $_POST['descripcion'],
                'fk_idlista' => $_POST['fk_idlista']
            );

            $controller->insertaropcion($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'updateopcion'){
            $data = array(
                'idopcion' => $_POST['idopcion'],
                'descripcion' => $_POST['descripcion'],
                'fk_idlista' => $_POST['fk_idlista']
            );

            $controller->updateopcion($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'eliminaropcion'){
            $idopcion = $_POST['idopcion'];
            $controller->eliminaropcion($idopcion);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'registrarlistapersonal'){
            $data = array(
                'titulo' => $_POST['titulo'],
                'fk_idpagina' => $_POST['fk_idpagina'],
                'fk_idsubpagina' => $_POST['fk_idsubpagina']
            );

            $controller->insertarListaPersonal($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'updatelistapersonal'){
            $data = array(
                'idlista' => $_POST['idlista'],
                'titulo' => $_POST['titulo'],
                'fk_idpagina' => $_POST['fk_idpagina'],
                'fk_idsubpagina' => $_POST['fk_idsubpagina']
            );

            $controller->updatelistaPersonal($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'registraropcionpersonal'){
            $data = array(
                'descripcion' => $_POST['descripcion'],
                'fk_idlista' => $_POST['fk_idlista']
            );

            $controller->insertaropcionPersonal($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'updateopcionpersonal'){
            $data = array(
                'idopcion' => $_POST['idopcion'],
                'descripcion' => $_POST['descripcion'],
                'fk_idlista' => $_POST['fk_idlista']
            );

            $controller->updateopcionPersonal($data);
        }
    }
?>