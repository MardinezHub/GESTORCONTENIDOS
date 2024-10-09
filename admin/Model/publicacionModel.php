<?php
    include_once __DIR__ . '../../conexion.php';

    class publicacionModel {
        private $conn;
        private $table_name = "tbpublicacion";

        public function __construct() {
            $this->conn = conectarse();
        }

        //METODOS DE ADMINISTRADOR
        public function ListarPublicacion() {
            $query = "SELECT * FROM " . $this->table_name;
            $result = $this->conn->query($query);

            $publicaciones = array();

            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    $publicaciones[] = $row;
                }
            }

            return $publicaciones;
        }

        public function insertarPublicacion($data) {
           $titulo = $this->conn->real_escape_string($data['titulo']);
           $descripcion = $this->conn->real_escape_string($data['descripcion']);
           $foto = $this->conn->real_escape_string($data['foto']);
           $fechapubli = $this->conn->real_escape_string($data['fechapubli']);

           $query = "INSERT INTO " . $this->table_name . "
                    (titulo,descripcion,foto,fechapubli) VALUES(?,?,?,?)";
            
            if($stmt = $this->conn->prepare($query))
            {
                $stmt->bind_param("ssss",$titulo,$descripcion,$foto,$fechapubli);

                if($stmt->execute())
                {
                    echo "<script>
                            window.alert('Se registró correctamente el Comunicado.');
                            window.location.href = '../Views/Admin/publicacionadmin.php';
                        </script>";
                    exit();
                }else{
                    echo "<script>
                            window.alert('No se registró correctamente el Comunicado.');
                            window.location.href = '../Views/Admin/publicacionadmin.php';
                        </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion: " . $this->conn->error;
            }
        }

       public function updatePublicacion($idpublicacion,$titulo,$descripcion,$fechapubli){
            $idpublicacion = $this->conn->real_escape_string($idpublicacion);
            $titulo = $this->conn->real_escape_string($titulo);
            $descripcion = $this->conn->real_escape_string($descripcion);
            $fechapubli = $this->conn->real_escape_string($fechapubli);

            $query = "UPDATE " . $this->table_name . "
                    SET titulo = ?, descripcion = ?, fechapubli = ?
                    WHERE idpublicacion = ?";
            
            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("sssi",$titulo,$descripcion,$fechapubli,$idpublicacion);

                if($stmt->execute()){
                    echo "<script>
                            window.alert('Se actualizo correctamente el Comunicado.');
                            window.location.href = '../Views/Admin/publicacionadmin.php';
                        </script>";
                }else{
                    echo "<script>
                            window.alert('No se actualizo correctamente el Comunicado.');
                            window.location.href = '../Views/Admin/publicacionadmin.php';
                        </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la actualización del comunicado: " . $this->conn->error;
            }
       }

       public function eliminarPublicacion($idpublicacion){
        $query = "DELETE FROM " . $this->table_name . " WHERE idpublicacion = ?";

        if($stmt = $this->conn->prepare($query)){
            $stmt->bind_param("i", $idpublicacion);

            if($stmt->execute()){
                return true;
            }else{
                echo "Error al eliminar el comunicado: " . $stmt->error;
                return false;
            }

        }else{
            echo "Error al preparar la consulta de eliminación: " . $this->conn->error;
            return false;
        }

       }

       //METODOS DE PERSONAL

       public function insertarPublicacionPersonal($data) {
        $titulo = $this->conn->real_escape_string($data['titulo']);
        $descripcion = $this->conn->real_escape_string($data['descripcion']);
        $foto = $this->conn->real_escape_string($data['foto']);
        $fechapubli = $this->conn->real_escape_string($data['fechapubli']);

        $query = "INSERT INTO " . $this->table_name . "
                 (titulo,descripcion,foto,fechapubli) VALUES(?,?,?,?)";
         
         if($stmt = $this->conn->prepare($query))
         {
             $stmt->bind_param("ssss",$titulo,$descripcion,$foto,$fechapubli);

             if($stmt->execute())
             {
                echo "<script>
                            window.alert('Se registró correctamente el Comunicado.');
                            window.location.href = '../Views/Personal/publicacionpersonal.php';
                    </script>";
                 exit();
             }else{
                echo "<script>
                            window.alert('No se registró correctamente el Comunicado.');
                            window.location.href = '../Views/Personal/publicacionpersonal.php';
                    </script>";
             }

             $stmt->close();
         }else{
             echo "Error en la preparacion de la declaracion: " . $this->conn->error;
         }
        }

        public function updatePublicacionPersonal($idpublicacion,$titulo,$descripcion,$fechapubli){
            $idpublicacion = $this->conn->real_escape_string($idpublicacion);
            $titulo = $this->conn->real_escape_string($titulo);
            $descripcion = $this->conn->real_escape_string($descripcion);
            $fechapubli = $this->conn->real_escape_string($fechapubli);

            $query = "UPDATE " . $this->table_name . "
                    SET titulo = ?, descripcion = ?, fechapubli = ?
                    WHERE idpublicacion = ?";
            
            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("sssi",$titulo,$descripcion,$fechapubli,$idpublicacion);

                if($stmt->execute()){
                    echo "<script>
                            window.alert('Se actualizo correctamente el Comunicado.');
                            window.location.href = '../Views/Personal/publicacionpersonal.php';
                    </script>";
                }else{
                    echo "<script>
                            window.alert('No se actualizo correctamente el Comunicado.');
                            window.location.href = '../Views/Personal/publicacionpersonal.php';
                    </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la actualización del comunicado: " . $this->conn->error;
            }
        }

    }
?>