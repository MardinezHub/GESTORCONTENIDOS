<?php
    include_once __DIR__ . '../../conexion.php';

    class noticiaModel{
        private $conn;
        private $table_name = "tbnoticia";

        public function __construct()
        {
            $this->conn = conectarse();
        }

        //ADMINISTRADOR
        public function ListarNoticia(){
            $query = "SELECT * FROM " . $this->table_name;
            $result = $this->conn->query($query);

            $noticias = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $noticias[] = $row;
                }
            }

            return $noticias;
        }

        public function insertarNoticia($data){
            $titulo = $this->conn->real_escape_string($data['titulo']);
            $descripcion = $this->conn->real_escape_string($data['descripcion']);
            $foto = $this->conn->real_escape_string($data['foto']);
            $fechapubli = $this->conn->real_escape_string($data['fechapubli']);

            $query = "INSERT INTO " . $this->table_name . "
                      (titulo,descripcion,foto,fechapubli) VALUES(?,?,?,?)";
            
            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssss",$titulo,$descripcion,$foto,$fechapubli);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se registró correctamente la Noticia.');
                                window.location.href = '../Views/Admin/noticiaadmin.php';
                          </script>";
                    exit();
                }else{
                    echo "<script>
                                window.alert('No se registró correctamente la Noticia.');
                                window.location.href = '../Views/Admin/noticiaadmin.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la preparacion de la consulta: " . $this->conn->error;
            }
        }

        public function updateNoticia($idnoticia,$titulo,$descripcion,$fechapubli){
            $idnoticia = $this->conn->real_escape_string($idnoticia);
            $titulo = $this->conn->real_escape_string($titulo);
            $descripcion = $this->conn->real_escape_string($descripcion);
            $fechapubli = $this->conn->real_escape_string($fechapubli);

            $query = "UPDATE " . $this->table_name . "
                      SET titulo = ?, descripcion = ?, fechapubli = ?
                      WHERE idnoticia = ?";
            
            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("sssi",$titulo,$descripcion,$fechapubli,$idnoticia);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se actualizo correctamente la Noticia.');
                                window.location.href = '../Views/Admin/noticiaadmin.php';
                          </script>";
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente la Noticia.');
                                window.location.href = '../Views/Admin/noticiaadmin.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la preparacion de la consulta: " . $this->conn->error;
            }
        }

        public function eliminarNoticia($idnoticia){
            $query = "DELETE FROM " . $this->table_name . " WHERE idnoticia = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("i", $idnoticia);

                if($stmt->execute()){
                    return true;
                }else{
                    echo "Error al eliminar la noticia: " . $stmt->error;
                    return false;
                }

            }else{
                echo "Error en la preparacion de la consulta: " . $this->conn->error;
            }
        }

        //PERSONAL
        public function insertarNoticiaPersonal($data){
            $titulo = $this->conn->real_escape_string($data['titulo']);
            $descripcion = $this->conn->real_escape_string($data['descripcion']);
            $foto = $this->conn->real_escape_string($data['foto']);
            $fechapubli = $this->conn->real_escape_string($data['fechapubli']);

            $query = "INSERT INTO " . $this->table_name . "
                      (titulo,descripcion,foto,fechapubli) VALUES(?,?,?,?)";
            
            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssss",$titulo,$descripcion,$foto,$fechapubli);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se registró correctamente la Noticia.');
                                window.location.href = '../Views/Personal/noticiapersonal.php';
                          </script>";
                    exit();
                }else{
                    echo "<script>
                                window.alert('No se registró correctamente la Noticia.');
                                window.location.href = '../Views/Personal/noticiapersonal.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la preparacion de la consulta: " . $this->conn->error;
            }
        }

        public function updateNoticiaPersonal($idnoticia,$titulo,$descripcion,$fechapubli){
            $idnoticia = $this->conn->real_escape_string($idnoticia);
            $titulo = $this->conn->real_escape_string($titulo);
            $descripcion = $this->conn->real_escape_string($descripcion);
            $fechapubli = $this->conn->real_escape_string($fechapubli);

            $query = "UPDATE " . $this->table_name . "
                      SET titulo = ?, descripcion = ?, fechapubli = ?
                      WHERE idnoticia = ?";
            
            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("sssi",$titulo,$descripcion,$fechapubli,$idnoticia);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se actualizo correctamente la Noticia.');
                                window.location.href = '../Views/Personal/noticiapersonal.php';
                          </script>";
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente la Noticia.');
                                window.location.href = '../Views/Personal/noticiapersonal.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la preparacion de la consulta: " . $this->conn->error;
            }
        }
    }


?>