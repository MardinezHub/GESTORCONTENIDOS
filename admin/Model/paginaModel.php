<?php 
include_once __DIR__ . '../../conexion.php';

class paginaModel{
    private $conn;

    public function __construct()
    {
        $this->conn = conectarse();
    }

    //ADMINISTRADOR
    //METODOS PARA PAGINAS
    public function ListarPaginas(){
        $query = "SELECT * FROM  tbpagina";
        $result = $this->conn->query($query);

        $paginas = array();

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $paginas[] = $row;
            }
        }

        return $paginas;
    }

    public function insertarPagina($data){
        $nombrepagina = $this->conn->real_escape_string($data['nombrepagina']);
        $archivo = $this->conn->real_escape_string($nombrepagina . '.php');
    
        $query = "INSERT INTO tbpagina(nombrepagina, archivo) VALUES (?, ?)";
    
        if($stmt = $this->conn->prepare($query)){
            $stmt->bind_param("ss", $nombrepagina, $archivo);
    
            if($stmt->execute()){
                $paginaPrincipalId = $stmt->insert_id;
                $this->crearPagina($archivo, $paginaPrincipalId);
                echo "<script>
                                window.alert('Se registró correctamente la Pagina Principal.');
                                window.location.href = '../Views/Admin/paginasadmin.php';
                          </script>";
                exit();
            }else{
                echo "<script>
                                window.alert('No se registró correctamente la Pagina Principal.');
                                window.location.href = '../Views/Admin/paginasadmin.php';
                          </script>";
            }
    
            $stmt->close();
        }else{
            echo "Error en la preparacion de la declaracion " . $this->conn->error;
        }
    }

    public function updatePagina($idpagina, $nuevoNombrepagina){
        $idpagina = $this->conn->real_escape_string($idpagina);
        $nuevoNombrepagina = $this->conn->real_escape_string($nuevoNombrepagina);
        $nuevoArchivo = $this->conn->real_escape_string($nuevoNombrepagina . '.php');

        $querySelect = "SELECT nombrepagina, archivo FROM tbpagina WHERE idpagina = ?";
        if ($stmtSelect = $this->conn->prepare($querySelect)) {
            $stmtSelect->bind_param("i", $idpagina);
            $stmtSelect->execute();
            $stmtSelect->bind_result($nombrepaginaActual, $archivoActual);
            $stmtSelect->fetch();
            $stmtSelect->close();
        }

        $query = "UPDATE tbpagina
                  SET nombrepagina = ?, archivo = ?
                  WHERE idpagina = ?";

        if($stmt = $this->conn->prepare($query)){
            $stmt->bind_param("ssi", $nuevoNombrepagina, $nuevoArchivo, $idpagina);

            if($stmt->execute()){
                if ($archivoActual != $nuevoArchivo) {
                    $this->renombrarPagina($archivoActual, $nuevoArchivo);
                }
                echo "<script>
                            window.alert('Se actualizo correctamente la Pagina Principal.');
                            window.location.href = '../Views/Admin/paginasadmin.php';
                      </script>";
                exit();
            }else{
                echo "<script>
                            window.alert('No se actualizo correctamente la Pagina Principal.');
                            window.location.href = '../Views/Admin/paginasadmin.php';
                    </script>";
            }

            $stmt->close();
        }else{
            echo "Error en la actualizacion del titulo de la pagina " . $this->conn->error;
        }
    }

    public function eliminarPagina($idpagina){
        $querySelect = "SELECT archivo FROM tbpagina WHERE idpagina = ?";
        if ($stmtSelect = $this->conn->prepare($querySelect)) {
            $stmtSelect->bind_param("i", $idpagina);
            $stmtSelect->execute();
            $stmtSelect->bind_result($archivo);
            $stmtSelect->fetch();
            $stmtSelect->close();
        }

        $query = "DELETE FROM tbpagina WHERE idpagina = ?";

        if($stmt = $this->conn->prepare($query)){
            $stmt->bind_param("i", $idpagina);

            if($stmt->execute()){
                $this->eliminarArchivoPagina($archivo);
                return true;
            }else{
                echo "Error al eliminar la pagina " . $stmt->error;
                return false;
            }
            
        }else{
            echo "Error al preparar la consulta de eliminacion " . $this->conn->error;
            return false;
        }
    }

    //METODOS PARA LAS SUBPAGINAS
    public function ListarSubpaginas(){
        $query = "SELECT tbsubpagina.idsubpagina, tbsubpagina.nombresub, tbsubpagina.fk_idpagina,
                  tbsubpagina.archivo, tbpagina.idpagina, tbpagina.nombrepagina
                  FROM tbsubpagina
                  INNER JOIN tbpagina
                  ON tbpagina.idpagina = tbsubpagina.fk_idpagina";
        $result = $this->conn->query($query);

        $subpaginas  = array();

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $subpaginas[] = $row;
            }
        }

        return $subpaginas;
    }

    public function insertarSubpagina($data){
        $nombresub = $this->conn->real_escape_string($data['nombresub']);
        $fk_idpagina = $this->conn->real_escape_string($data['fk_idpagina']);
        $archivo = $this->conn->real_escape_string($nombresub . '.php');
    
        $query = "INSERT INTO tbsubpagina(nombresub, fk_idpagina, archivo) VALUES(?, ?, ?)";
    
        if($stmt = $this->conn->prepare($query)){
            $stmt->bind_param("sss", $nombresub, $fk_idpagina, $archivo);
    
            if($stmt->execute()){
                $subpaginaId = $stmt->insert_id;
                $this->crearSubpagina($archivo, $subpaginaId);
                echo "<script>
                            window.alert('Se registró correctamente la SubPagina de la Pagina Principal.');
                            window.location.href = '../Views/Admin/paginasadmin.php';
                      </script>";
                exit();
            }else{
                echo "<script>
                            window.alert('No se registró correctamente la SubPagina de la Pagina Principal.');
                            window.location.href = '../Views/Admin/paginasadmin.php';
                      </script>";
            }
    
            $stmt->close();
        }else{
            echo "Error en la preparacion de la declaracion " . $this->conn->error;
        }
    }

    public function updateSubpagina($idsubpagina, $nombresub, $fk_idpagina){
        $idsubpagina = $this->conn->real_escape_string($idsubpagina);
        $nombresub = $this->conn->real_escape_string($nombresub);
        $fk_idpagina = $this->conn->real_escape_string($fk_idpagina);
        $archivo = $this->conn->real_escape_string($nombresub . '.php');

        $querySelect = "SELECT nombresub, archivo FROM tbsubpagina WHERE idsubpagina = ?";
        if ($stmtSelect = $this->conn->prepare($querySelect)) {
            $stmtSelect->bind_param("i", $idsubpagina);
            $stmtSelect->execute();
            $stmtSelect->bind_result($nombresubActual, $archivoActual);
            $stmtSelect->fetch();
            $stmtSelect->close();
        }

        $query = "UPDATE " . $this->subpaginas_table . "
                  SET nombresub = ?, fk_idpagina = ?, archivo = ?
                  WHERE idsubpagina = ?";

        if($stmt = $this->conn->prepare($query)){
            $stmt->bind_param("sssi", $nombresub, $fk_idpagina, $archivo, $idsubpagina);

            if($stmt->execute()){
                if ($archivoActual != $archivo) {
                    $this->renombrarSubpagina($archivoActual, $archivo);
                }
                echo "<script>
                            window.alert('Se actualizo correctamente la SubPagina de la Pagina Principal.');
                            window.location.href = '../Views/Admin/paginasadmin.php';
                      </script>";
                exit();
            }else{
                echo "<script>
                            window.alert('No se actualizo correctamente la SubPagina de la Pagina Principal.');
                            window.location.href = '../Views/Admin/paginasadmin.php';
                      </script>";
            }

            $stmt->close();
        }else{
            echo "Error en la actualizacion de la SubPagina: " . $this->conn->error;
        }
    }

    public function eliminarSubpagina($idsubpagina){
        $querySelect = "SELECT archivo FROM tbsubpagina WHERE idsubpagina = ?";
        if ($stmtSelect = $this->conn->prepare($querySelect)) {
            $stmtSelect->bind_param("i", $idsubpagina);
            $stmtSelect->execute();
            $stmtSelect->bind_result($archivo);
            $stmtSelect->fetch();
            $stmtSelect->close();
        }

        $query = "DELETE FROM tbsubpagina WHERE idsubpagina = ?";

        if($stmt = $this->conn->prepare($query)){
            $stmt->bind_param("i", $idsubpagina);

            if($stmt->execute()){
                $this->eliminarArchivoSubpagina($archivo);
                return true;
            }else{
                echo "Error al eliminar la subpagina " . $stmt->error;
                return false;
            }
            
        }else{
            echo "Error al preparar la consulta de eliminacion " . $this->conn->error;
            return false;
        }
    }

    //METODOS PARA LA GENERACION Y MANIPULACION DE ARCHIVOS DE LAS PAGINAS Y SUBPAGINAS
    private function crearPagina($archivo, $paginaPrincipalId) {
        $filename = '../../' . $archivo;
        $fileContent = $this->generarContenidoPlantilla($paginaPrincipalId, 0);
    
        file_put_contents($filename, $fileContent);
    }
    
    private function crearSubpagina($archivo, $subpaginaId) {
        $filename = '../../' . $archivo;
        $fileContent = $this->generarContenidoPlantilla(0, $subpaginaId);
    
        file_put_contents($filename, $fileContent);
    }
    

    private function renombrarPagina($archivoActual, $archivoNuevo){
        $archivoActual = '../../' . $archivoActual;
        $archivoNuevo = '../../' . $archivoNuevo;

        if (file_exists($archivoActual)) {
            rename($archivoActual, $archivoNuevo);
        }
    }

    private function renombrarSubpagina($archivoActual, $archivoNuevo){
        $archivoActual = '../../' . $archivoActual;
        $archivoNuevo = '../../' . $archivoNuevo;

        if (file_exists($archivoActual)) {
            rename($archivoActual, $archivoNuevo);
        }
    }

    private function eliminarArchivoPagina($archivo){
        $archivo = '../../' . $archivo;
        
        if (file_exists($archivo)) {
            unlink($archivo);
        }
    }

    private function eliminarArchivoSubpagina($archivo){
        $archivo = '../../' . $archivo;
        
        if (file_exists($archivo)) {
            unlink($archivo);
        }
    }

    // Plantilla común para páginas y subpáginas
    private function generarContenidoPlantilla($paginaPrincipalId, $subpaginaId) {
        return "<?php 
        define('INFO_DIV', \"<div class='information-info'>\");
        define('CLEAR_BOTH', \"<div style='clear:both;'></div>\");
        define('CLOSE_DIV', \"</div>\");
        define('LINE_BREAK', \"<br/>\");
        include_once 'admin/Model/informacionModel.php';
        include_once 'admin/Model/paginaModel.php';
        include_once 'admin/conexion.php';
    
        \$informacionModel = new informacionModel();
        \$paginaModel = new paginaModel();
    
        \$paginaPrincipalId = $paginaPrincipalId;
        \$subpaginaId = $subpaginaId;
    
        \$informacionesPrincipal = \$informacionModel->listarInformacionPorPagina(\$paginaPrincipalId);
        \$informacionesSubpagina = \$informacionModel->listarInformacionPorSubpagina(\$subpaginaId);
        \$listasPrincipal = \$paginaModel->obtenerListasPorPagina(\$paginaPrincipalId);
        \$listasSubpagina = \$paginaModel->obtenerListasPorSubpagina(\$subpaginaId);
    
        \$fotosPorPagina = 1;
        \$paginaActual = isset(\$_GET['pagina']) ? (int)\$_GET['pagina'] : 1;
    
        \$fotosTodas = (\$paginaPrincipalId != 0) ? \$paginaModel->obtenerFotosPorPagina(\$paginaPrincipalId) : \$paginaModel->obtenerFotosPorSubpagina(\$subpaginaId);
    
        \$fotosTotal = count(\$fotosTodas);
        \$offset = (\$paginaActual - 1) * \$fotosPorPagina;
        \$fotosMostradas = array_slice(\$fotosTodas, \$offset, \$fotosPorPagina);
        \$totalPaginas = ceil(\$fotosTotal / \$fotosPorPagina);
    
        \$paginaMostrar = 1;
        ?>
        <!DOCTYPE html>
        <html lang='es' dir='ltr'>
        <head>
            <?php include '_head.php'; ?>
            <style>
                .container-custom {
                    max-width: 1000px;
                    margin: 0 auto;
                }
                .information-info {
                    background-color: #f9f9f9;
                    padding: 40px;
                    border-radius: 10px;
                    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
                    margin-bottom: 20px;
                }
                .information-info h4 {
                    color: #333;
                    font-size: 28px;
                    font-weight: bold;
                    margin-bottom: 20px;
                    text-transform: uppercase;
                }
                .information-info a.button {
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #007bff;
                    color: #fff;
                    border-radius: 5px;
                    text-decoration: none;
                    transition: background-color 0.3s ease;
                }
                .information-info a.button:hover {
                    background-color: #0056b3;
                }
                .information-info b {
                    color: #555;
                }
                .information-info p {
                    color: #666;
                    margin-bottom: 20px;
                }
                .information-info ul {
                    list-style-type: none;
                    padding: 0;
                }
                .information-info ul li {
                    margin-bottom: 10px;
                }
                .information-info ul li i {
                    margin-right: 10px;
                    color: #007bff;
                }
                .information-info-left {
                    float: left;
                    width: 60%;
                }
                .information-info-right {
                    float: right;
                    width: 40%;
                }
                .photo-gallery {
                    text-align: center;
                    margin-top: 20px;
                }
                .photo-gallery img {
                    width: 100%;
                    max-width: 750px;
                    height: 500px;
                    object-fit: cover;
                    margin: 10px 0;
                }
                .pagination {
                    display: flex;
                    justify-content: center;
                    margin-top: 20px;
                    flex-wrap: wrap;
                }
                .pagination .page-item {
                    margin: 0 5px;
                }
                .pagination .page-item .page-link {
                    padding: 10px 15px;
                    border-radius: 5px;
                    border: 1px solid #ddd;
                    color: #007bff;
                }
                .pagination .page-item.active .page-link {
                    background-color: #007bff;
                    color: #fff;
                    border-color: #007bff;
                }
                .pagination-arrows {
                    display: none;
                }
                .pagination-arrows .page-link {
                    padding: 10px 15px;
                    border-radius: 5px;
                    border: 1px solid #ddd;
                    color: #007bff;
                }
                @media (max-width: 768px) {
                    .information-info {
                        padding: 20px;
                    }
                    .information-info-left,
                    .information-info-right {
                        float: none;
                        width: 100%;
                    }
                    .information-info-right {
                        margin-top: 20px;
                    }
                    .information-info-right img {
                        max-width: 100%;
                        height: auto;
                    }
                    .photo-gallery img {
                        height: 300px;
                        width: 400px;
                    }
                }
            </style>
        </head>
        <body>
            <?php include '_header.php'; ?>
            <main>
                <section class='about-area bottom-padding1 position-relative'>
                    <div class='container-custom'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='section-title mb-30'>
                                    <?php 
                                    if (\$paginaPrincipalId != 0 && \$informacionesPrincipal) {
                                        foreach (\$informacionesPrincipal as \$row) {
                                            echo INFO_DIV;
                                            echo \"<h4>{\$row['titulo']}</h4>\";
                                            echo \"<p>{\$row['informacion']}</p>\";                                            
                                            echo CLEAR_BOTH;
                                            echo CLOSE_DIV . LINE_BREAK;
                                        }
                                    } elseif (\$subpaginaId != 0 && \$informacionesSubpagina) {
                                        foreach (\$informacionesSubpagina as \$row) {
                                            echo INFO_DIV;
                                            echo \"<h4>{\$row['titulo']}</h4>\";
                                            echo \"<p>{\$row['informacion']}</p>\";
                                            echo CLEAR_BOTH;
                                            echo CLOSE_DIV . LINE_BREAK;
                                        }
                                    }
                                    ?>                           
                                </div>
                            </div>                    
                        </div>                       
                    </div>
                    <div class='container-custom'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='section-title mb-30'>
                                    <?php
                                    if (\$paginaPrincipalId != 0 && \$listasPrincipal) {
                                        foreach (\$listasPrincipal as \$lista) {
                                            echo INFO_DIV;
                                            echo \"<h4>{\$lista['titulo']}</h4>\";
                                            echo \"<ul>\";
                                            foreach (\$lista['opciones'] as \$opcion) {
                                                echo \"<li> - {\$opcion['descripcion']}</li>\";
                                            }
                                            echo \"</ul>\";                                            
                                            echo CLEAR_BOTH;
                                            echo CLOSE_DIV . LINE_BREAK;
                                        }
                                    } elseif (\$subpaginaId != 0 && \$listasSubpagina) {
                                        foreach (\$listasSubpagina as \$lista) {
                                            echo INFO_DIV;
                                            echo \"<h4>{\$lista['titulo']}</h4>\";
                                            echo \"<ul>\";
                                            foreach (\$lista['opciones'] as \$opcion) {
                                                echo \"<li> - {\$opcion['descripcion']}</li>\";
                                            }
                                            echo \"</ul>\";                                            
                                            echo CLEAR_BOTH;
                                            echo CLOSE_DIV . LINE_BREAK;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='container-custom'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class='photo-gallery'>
                                    <?php
                                    if (\$paginaPrincipalId != 0 || \$subpaginaId != 0) {
                                        foreach (\$fotosMostradas as \$foto) {
                                            echo \"<center><h3>Galeria de Fotos</h3></center>\";
                                            echo \"<img src='admin/source/img/Foto/{\$foto['foto']}' alt='Foto'>\";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='container-custom'>
                        <div class='row'>
                            <div class='col-md-12 text-center'>
                                <nav aria-label='Page navigation'>
                                    <ul class='pagination'>
                                        <?php
                                        if (\$paginaActual > 1) {
                                            echo \"<li class='page-item'><a class='page-link' href='?pagina=\" . (\$paginaActual - 1) . \"'>&laquo;</a></li>\";
                                        }
                                        for (\$i = max(1, \$paginaActual - 1); \$i <= min(\$paginaActual + 1, \$totalPaginas); \$i++) {
                                            echo \"<li class='page-item \" . (\$i == \$paginaActual ? 'active' : '') . \"'><a class='page-link' href='?pagina=\$i'>\$i</a></li>\";
                                        }
                                        if (\$paginaActual < \$totalPaginas) {
                                            echo \"<li class='page-item'><a class='page-link' href='?pagina=\" . (\$paginaActual + 1) . \"'>&raquo;</a></li>\";
                                        }
                                        ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </section>
            <?php include '_links.php'; ?>
            </main>
            <!-- Footer Start -->
            <?php include '_footer.php'; ?>
            <?php include '_redes.php'; ?>
            <div class=\"search-overlay\"></div>
            <!-- jquery -->
            <?php include '_js.php'; ?>
        </body>
        </html>";
    }
    

    public function obtenerPaginasPrincipales() {
        $query = "SELECT idpagina, nombrepagina, archivo FROM tbpagina";
        $result = $this->conn->query($query);

        $paginas = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $paginas[] = $row;
            }
        }

        return $paginas;
    }

    public function obtenerSubpaginas($idpagina) {
        $query = "SELECT idsubpagina, nombresub, archivo FROM tbsubpagina WHERE fk_idpagina = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idpagina);
        $stmt->execute();
        $result = $stmt->get_result();

        $subpaginas = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $subpaginas[] = $row;
            }
        }

        return $subpaginas;
    }

    //MODIFICAR HEADER INICIO
    public function headerlista() {
        $sql = "SELECT * FROM tbheader WHERE idheader = 1";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // Métodos para manejo de listas
    public function obtenerListasPorPagina($idPagina) {
        $query = "SELECT * FROM tblista WHERE fk_idpagina = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idPagina);
        $stmt->execute();
        $result = $stmt->get_result();

        $listas = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['opciones'] = $this->obtenerOpcionesPorLista($row['idlista']);
                $listas[] = $row;
            }
        }
        return $listas;
    }

    public function obtenerListasPorSubpagina($idSubpagina) {
        $query = "SELECT * FROM tblista WHERE fk_idsubpagina = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idSubpagina);
        $stmt->execute();
        $result = $stmt->get_result();

        $listas = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['opciones'] = $this->obtenerOpcionesPorLista($row['idlista']);
                $listas[] = $row;
            }
        }
        return $listas;
    }

    public function obtenerOpcionesPorLista($idLista) {
        $query = "SELECT * FROM tbopcion WHERE fk_idlista = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $idLista);
        $stmt->execute();
        $result = $stmt->get_result();

        $opciones = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $opciones[] = $row;
            }
        }
        return $opciones;
    }

    public function obtenerFotosPorPagina($paginaId) {
        $stmt = $this->conn->prepare("SELECT * FROM tbfoto WHERE fk_idpagina = ?");
        $stmt->bind_param("i", $paginaId);
        $stmt->execute();
        $result = $stmt->get_result();
        $fotos = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $fotos;
    }

    public function obtenerFotosPorSubpagina($subpaginaId) {
        $stmt = $this->conn->prepare("SELECT * FROM tbfoto WHERE fk_idsubpagina = ?");
        $stmt->bind_param("i", $subpaginaId);
        $stmt->execute();
        $result = $stmt->get_result();
        $fotos = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $fotos;
    }
        
}
?>
