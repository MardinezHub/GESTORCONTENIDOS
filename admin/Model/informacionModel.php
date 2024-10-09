<?php
   include_once __DIR__ . '../../conexion.php';

    class informacionModel {
        private $conn;

        public function __construct() {
            $this->conn = conectarse();
        }

        //ADMINISTRADOR
        public function listarinformacion(){
            $query = "SELECT tbinformacion.idinformacion, tbinformacion.titulo,tbinformacion.informacion, tbinformacion.fk_idpagina, tbinformacion.fk_idsubpagina,
                      tbpagina.idpagina, tbpagina.nombrepagina, tbsubpagina.idsubpagina, tbsubpagina.nombresub
                      FROM tbinformacion
                      LEFT JOIN tbpagina ON tbpagina.idpagina = tbinformacion.fk_idpagina
                      LEFT JOIN tbsubpagina ON tbsubpagina.idsubpagina = tbinformacion.fk_idsubpagina";
            $result = $this->conn->query($query);
        
            $informaciones = array();
        
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $informaciones[] = $row;
                } 
            }
            return $informaciones;
        }
        

        public function insertarinformacion($data){
            $titulo = $this->conn->real_escape_string($data['titulo']);
            $informacion = $this->conn->real_escape_string($data['informacion']);
            $fk_idpagina = $this->conn->real_escape_string($data['fk_idpagina']);
            $fk_idsubpagina = $this->conn->real_escape_string($data['fk_idsubpagina']);

            $query = "INSERT INTO tbinformacion(titulo,informacion, fk_idpagina, fk_idsubpagina) VALUES(?,?,?,?)";

            if($stmt  = $this->conn->prepare($query)){
                $stmt->bind_param("ssss", $titulo,$informacion, $fk_idpagina, $fk_idsubpagina);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se registró correctamente la informacion en la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/informacionadmin.php';
                          </script>";
                    exit();
                }else{
                    echo "<script>
                                window.alert('No se registro correctamente la informacion en la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/informacionadmin.php';
                          </script>";
                }

                $stmt->close();
            }
            else{
                echo "Error en la preparacion de la consulta" . $this->conn->error;
            }
        }

        public function updateinformacion($idinformacion,$titulo,$informacion, $fk_idpagina, $fk_idsubpagina){
            $idinformacion = $this->conn->real_escape_string($idinformacion);
            $titulo = $this->conn->real_escape_string($titulo);
            $informacion = $this->conn->real_escape_string($informacion);
            $fk_idpagina = $this->conn->real_escape_string($fk_idpagina);
            $fk_idsubpagina = $this->conn->real_escape_string($fk_idsubpagina);

            $query = "UPDATE tbinformacion SET titulo = ?,informacion = ? , fk_idpagina = ?, fk_idsubpagina = ?
                      WHERE idinformacion = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssiii", $titulo,$informacion, $fk_idpagina, $fk_idsubpagina, $idinformacion);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se actualizo correctamente la informacion de la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/informacionadmin.php';
                          </script>";
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente la informacion de la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/informacionadmin.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la actualizacion de la informacion" . $this->conn->error;
            }
        }

        public function eliminarinformacion($idinformacion){
            $query = "DELETE FROM tbinformacion WHERE idinformacion = ? ";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("i", $idinformacion);

                if($stmt->execute()){
                    return true;
                }else{
                    echo "Error al eliminar la informacion" . $stmt->error;
                    return false;
                }

            }else{
                echo "Error al preparar la consulta de eliminacion" . $this->conn->error;
                return false;
            }
        }

        public function listarInformacionPorPagina($idPagina) {
            $sql = "SELECT * FROM tbinformacion WHERE fk_idpagina = ?";
            $stmt = $this->conn->prepare($sql);
            
            if ($stmt === false) {
                echo "Error en la preparación de la consulta: " . $this->conn->error;
                return false;
            }
            $stmt->bind_param("i", $idPagina);
            
            if (!$stmt->execute()) {
                echo "Error al ejecutar la consulta: " . $stmt->error;
                $stmt->close();
                return false;
            }
            
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $informaciones = array();
            
                while ($row = $result->fetch_assoc()) {
                    $informaciones[] = $row;
                }
                $stmt->close();
                return $informaciones;
            } else {
                $stmt->close();
                return [];
            }
        }
        
        public function listarInformacionPorSubpagina($idSubpagina) {
            $sql = "SELECT * FROM tbinformacion WHERE fk_idsubpagina = ?";
            if ($stmt = $this->conn->prepare($sql)) {
                $stmt->bind_param("i", $idSubpagina);
                $stmt->execute();
                $result = $stmt->get_result();
        
                if ($result->num_rows > 0) {
                    $informaciones = array();
                    while ($row = $result->fetch_assoc()) {
                        $informaciones[] = $row;
                    }
                    $stmt->close();
                    return $informaciones;
                } else {
                    $stmt->close();
                    return false;
                }
            } else {
                echo "Error en la preparación de la consulta: " . $this->conn->error;
                return false;
            }
        }

        //PERSONAL
        public function insertarinformacionPersonal($data){
            $titulo = $this->conn->real_escape_string($data['titulo']);
            $informacion = $this->conn->real_escape_string($data['informacion']);
            $fk_idpagina = $this->conn->real_escape_string($data['fk_idpagina']);
            $fk_idsubpagina = $this->conn->real_escape_string($data['fk_idsubpagina']);

            $query = "INSERT INTO tbinformacion(titulo,informacion, fk_idpagina, fk_idsubpagina) VALUES(?,?,?,?)";

            if($stmt  = $this->conn->prepare($query)){
                $stmt->bind_param("ssss", $titulo,$informacion, $fk_idpagina, $fk_idsubpagina);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se registró correctamente la informacion de la Pagina o SubPagina.');
                                window.location.href = '../Views/Personal/informacionpersonal.php';
                          </script>";
                    exit();
                }else{
                    echo "<script>
                                window.alert('No se registro correctamente la informacion de la Pagina o SubPagina.');
                                window.location.href = '../Views/Personal/informacionpersonal.php';
                          </script>";
                }

                $stmt->close();
            }
            else{
                echo "Error en la preparacion de la consulta" . $this->conn->error;
            }
        }

        public function updateinformacionPersonal($idinformacion,$titulo,$informacion, $fk_idpagina, $fk_idsubpagina){
            $idinformacion = $this->conn->real_escape_string($idinformacion);
            $titulo = $this->conn->real_escape_string($titulo);
            $informacion = $this->conn->real_escape_string($informacion);
            $fk_idpagina = $this->conn->real_escape_string($fk_idpagina);
            $fk_idsubpagina = $this->conn->real_escape_string($fk_idsubpagina);

            $query = "UPDATE tbinformacion SET titulo = ?,informacion = ? , fk_idpagina = ?, fk_idsubpagina = ?
                      WHERE idinformacion = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssiii", $titulo,$informacion, $fk_idpagina, $fk_idsubpagina, $idinformacion);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se actualizo correctamente la informacion de la Pagina o SubPagina.');
                                window.location.href = '../Views/Personal/informacionpersonal.php';
                          </script>";
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente la informacion de la Pagina o SubPagina.');
                                window.location.href = '../Views/Personal/informacionpersonal.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la actualizacion de la informacion" . $this->conn->error;
            }
        }
    }
?>