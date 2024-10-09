<?php
    include_once __DIR__ . '../../conexion.php';

    class legalModel {
        private $conn;
        private $table_name = "tbmarcolegal";

        public function __construct() {
            $this->conn = conectarse();
        }

        //ADMINISTRADOR

        public function ListarMarco() {
            $query = "SELECT * FROM " . $this->table_name;
            $result = $this->conn->query($query);

            $marcos = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $marcos[] = $row;
                }
            }

            return $marcos;
        }

        public function insertarMarco($data) {
            $nombremarco = $this->conn->real_escape_string($data['nombremarco']);
            $nombrearchivo = $this->conn->real_escape_string($data['nombrearchivo']);

            $query = "INSERT INTO " . $this->table_name . "
                      (nombremarco,nombrearchivo) VALUES (?,?)";

            if($stmt = $this->conn->prepare($query))
            {
                $stmt->bind_param("ss",$nombremarco, $nombrearchivo);

                if($stmt->execute())
                {
                    echo "<script>
                                window.alert('Se registró correctamente el Marco Legal.');
                                window.location.href = '../Views/Admin/legaladmin.php';
                          </script>"; 
                    exit();
                }
                else
                {
                    echo "<script>
                                window.alert('No se registró correctamente el Marco Legal.');
                                window.location.href = '../Views/Admin/legaladmin.php';
                          </script>";
                }

                $stmt->close();
            }
            else
            {
                echo "Error en la preparacion de la declaracion: " . $this->conn->error;
            }
        }
        
        public function updateMarco($idmarco,$nombremarco,$nombrearchivo) {
            $idmarco = $this->conn->real_escape_string($idmarco);
            $nombremarco = $this->conn->real_escape_string($nombremarco);
            $nombrearchivo = $this->conn->real_escape_string($nombrearchivo);

            $query = "UPDATE " . $this->table_name . "
                      SET nombremarco = ?, nombrearchivo = ?
                      WHERE idmarco = ?";
                      
            if($stmt = $this->conn->prepare($query))
            {
                $stmt->bind_param("ssi",$nombremarco,$nombrearchivo,$idmarco);

                if($stmt->execute())
                {
                    echo "<script>
                                window.alert('Se actualizo correctamente el Marco Legal.');
                                window.location.href = '../Views/Admin/legaladmin.php';
                          </script>"; 
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente el Marco Legal.');
                                window.location.href = '../Views/Admin/legaladmin.php';
                          </script>"; 
                }

                $stmt->close();
            }else{
                echo "Error en la actualizacion del archivo legal: " . $this->conn->error;
            }          
        }

        public function eliminarMarco($idmarco){
            $query = "DELETE FROM " . $this->table_name . " WHERE idmarco = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("i", $idmarco);

                if($stmt->execute()){
                    return true;
                }else{
                    echo "Error al eliminar el marco legal: " . $stmt->error;
                    return false;
                }
                
            }else{
                echo "Error al preparar la consulta de eliminación: " . $this->conn->error;
                return false;
            }
        }

        //PERSONAL
        public function insertarMarcoPersonal($data) {
            $nombremarco = $this->conn->real_escape_string($data['nombremarco']);
            $nombrearchivo = $this->conn->real_escape_string($data['nombrearchivo']);

            $query = "INSERT INTO " . $this->table_name . "
                      (nombremarco,nombrearchivo) VALUES (?,?)";

            if($stmt = $this->conn->prepare($query))
            {
                $stmt->bind_param("ss",$nombremarco, $nombrearchivo);

                if($stmt->execute())
                {
                    echo "<script>
                                window.alert('Se registro correctamente el Marco Legal.');
                                window.location.href = '../Views/Personal/legalpersonal.php';
                          </script>"; 
                    exit();
                }
                else
                {
                    echo "<script>
                                window.alert('No se registro correctamente el Marco Legal.');
                                window.location.href = '../Views/Personal/legalpersonal.php';
                          </script>"; 
                }

                $stmt->close();
            }
            else
            {
                echo "Error en la preparacion de la declaracion: " . $this->conn->error;
            }
        }
        

        public function updateMarcoPersonal($idmarco,$nombremarco,$nombrearchivo) {
            $idmarco = $this->conn->real_escape_string($idmarco);
            $nombremarco = $this->conn->real_escape_string($nombremarco);
            $nombrearchivo = $this->conn->real_escape_string($nombrearchivo);

            $query = "UPDATE " . $this->table_name . "
                      SET nombremarco = ?, nombrearchivo = ?
                      WHERE idmarco = ?";
                      
            if($stmt = $this->conn->prepare($query))
            {
                $stmt->bind_param("ssi",$nombremarco,$nombrearchivo,$idmarco);

                if($stmt->execute())
                {
                    echo "<script>
                                window.alert('Se actualizo correctamente el Marco Legal.');
                                window.location.href = '../Views/Personal/legalpersonal.php';
                          </script>"; 
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente el Marco Legal.');
                                window.location.href = '../Views/Personal/legalpersonal.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la actualizacion del archivo legal: " . $this->conn->error;
            }          
        }
    }
?>