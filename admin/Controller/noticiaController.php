<?php
    include_once __DIR__ . '/../Model/noticiaModel.php';

    class noticiaController{
        private $noticiaModel;

        public function __construct()
        {
            $this->noticiaModel = new noticiaModel();
        }

        //ADMINISTRADOR
        public function insertarNoticia($data){
            $foto = $_FILES['filenoticia'];

            if($foto['error'] !== UPLOAD_ERR_OK){
                echo "<script>
                        window.alert('No se registró correctamente la Noticia.');
                        window.location.href = '../Views/Admin/noticiaadmin.php';
                    </script>";

                return;
            }
            
            $nombreFoto = basename($foto['name']);
            $nombreFoto = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $nombreFoto);
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = pathinfo($nombreFoto, PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                echo "<script>
                        window.alert('El formato del archivo no está permitido.');
                        window.location.href = '../Views/Admin/noticiaadmin.php';
                    </script>";
                return;
            }

            $rutaDestino = realpath('../source/img/Noticia') . '/' . $nombreFoto;

            if(move_uploaded_file($foto['tmp_name'], $rutaDestino)){
                $data['foto'] = $nombreFoto;
                $this->noticiaModel->insertarNoticia($data);
            }else{
                echo "<script>
                        window.alert('No se subio la imagen correctamente en la noticia.');
                        window.location.href = '../Views/Admin/noticiaadmin.php';
                    </script>";
            }
        }

        public function updateNoticia($data){
            $this->noticiaModel->updateNoticia(
                $data['idnoticia'],
                $data['titulo'],
                $data['descripcion'],
                $data['fechapubli']
            );
        }

        public function eliminarNoticia($idnoticia){
            $this->noticiaModel->eliminarNoticia($idnoticia);
        }

        //PERSONAL
        public function insertarNoticiaPersonal($data){
            $foto = $_FILES['filenoticia'];

            if($foto['error'] !== UPLOAD_ERR_OK){
                echo "<script>
                        window.alert('No se registró correctamente la Noticia.');
                        window.location.href = '../Views/Personal/noticiapersonal.php';
                    </script>";

                return;
            }

            $nombreFoto = basename($foto['name']);
            $nombreFoto = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $nombreFoto);
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = pathinfo($nombreFoto, PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                echo "<script>
                        window.alert('El formato del archivo no está permitido.');
                        window.location.href = '../Views/Personal/noticiapersonal.php';
                    </script>";
                return;
            }

            $rutaDestino = realpath('../source/img/Noticia') . '/' . $nombreFoto;
            
            if(move_uploaded_file($foto['tmp_name'], $rutaDestino)){
                $data['foto'] = $nombreFoto;
                $this->noticiaModel->insertarNoticiaPersonal($data);
            }else{
                echo "<script>
                        window.alert('No se subio la imagen correctamente en la noticia.');
                        window.location.href = '../Views/Personal/noticiapersonal.php';
                    </script>";
            }
        }

        public function updateNoticiaPersonal($data){
            $this->noticiaModel->updateNoticiaPersonal(
                $data['idnoticia'],
                $data['titulo'],
                $data['descripcion'],
                $data['fechapubli']
            );
        }
    }

    $controller = new noticiaController();

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['accion']) && $_POST['accion'] === "registrar"){
            $data = array(
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'foto' => $_FILES['filenoticia']['name'],
                'fechapubli' => $_POST['fechapubli']
            );

            $controller->insertarNoticia($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'update'){
            $data = array(
                'idnoticia' => $_POST['idnoticia'],
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'fechapubli' => $_POST['fechapubli']
            );

            $controller->updateNoticia($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'eliminar'){
            $idnoticia = $_POST['idnoticia'];
            $controller->eliminarNoticia($idnoticia);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'registrar2'){
            $data = array(
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'foto' => $_FILES['filenoticia']['name'],
                'fechapubli' => $_POST['fechapubli']
            );

            $controller->insertarNoticiaPersonal($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === "update2"){
            $data = array(
                'idnoticia' => $_POST['idnoticia'],
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'fechapubli' => $_POST['fechapubli']
            );

            $controller->updateNoticiaPersonal($data);
        }
    }
?>