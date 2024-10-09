<?php 
    include_once __DIR__ . '../../conexion.php';

    class listaModel{
        private $conn;

        public function __construct()
        {
            $this->conn = conectarse();
        }

        //METODOS PARA LISTAS
        //ADMINISTRADOR
        public function Listarlista(){
            $query = "SELECT tblista.idlista, tblista.titulo,tblista.fk_idpagina,tblista.fk_idsubpagina,
                      tbpagina.idpagina, tbpagina.nombrepagina, tbsubpagina.idsubpagina, tbsubpagina.nombresub FROM tblista
                      LEFT JOIN tbpagina
                      ON tbpagina.idpagina = tblista.fk_idpagina
                      LEFT JOIN tbsubpagina
                      ON tbsubpagina.idsubpagina = tblista.fk_idsubpagina";

            $result = $this->conn->query($query);

            $listas = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $listas[] = $row;
                }
            }

            return $listas;
        }

        public function insertarLista($data){
            $titulo = $this->conn->real_escape_string($data['titulo']);
            $fk_idpagina = $this->conn->real_escape_string($data['fk_idpagina']);
            $fk_idsubpagina = $this->conn->real_escape_string($data['fk_idsubpagina']);

            $query = "INSERT INTO tblista(titulo,fk_idpagina,fk_idsubpagina) VALUES(?,?,?)";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("sss", $titulo, $fk_idpagina, $fk_idsubpagina);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se registró correctamente la lista en la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/listaadmin.php';
                          </script>"; 
                    exit();
                }else{
                    echo "<script>
                                window.alert('No se registró correctamente la lista en la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/listaadmin.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion " . $this->conn->error;
            }
        }

        public function updatelista($idlista, $titulo, $fk_idpagina, $fk_idsubpagina){
            $idlista = $this->conn->real_escape_string($idlista);
            $titulo = $this->conn->real_escape_string($titulo);
            $fk_idpagina = $this->conn->real_escape_string($fk_idpagina);
            $fk_idsubpagina = $this->conn->real_escape_string($fk_idsubpagina);

            $query = "UPDATE tblista SET titulo = ?, fk_idpagina = ?, fk_idsubpagina = ? WHERE idlista = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("sssi",$titulo,$fk_idpagina,$fk_idsubpagina, $idlista);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se actualizo correctamente la lista en la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/listaadmin.php';
                          </script>";
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente la lista en la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/listaadmin.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la actualizacion de la lista" . $this->conn->error;
            }
        }

        public function eliminarlista($idlista){
            $query = "DELETE FROM tblista WHERE idlista = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("i",$idlista);

                if($stmt->execute()){
                    return true;
                }else{
                    echo "Error al eliminar la lista" . $stmt->error;
                    return false;
                }

            }else{
                echo "Error al preparar la consulta de eliminacion: " . $this->conn->error;
                return false;
            }
        }

        //PERSONAL
        public function insertarListaPersonal($data){
            $titulo = $this->conn->real_escape_string($data['titulo']);
            $fk_idpagina = $this->conn->real_escape_string($data['fk_idpagina']);
            $fk_idsubpagina = $this->conn->real_escape_string($data['fk_idsubpagina']);

            $query = "INSERT INTO tblista(titulo,fk_idpagina,fk_idsubpagina) VALUES(?,?,?)";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("sss", $titulo, $fk_idpagina, $fk_idsubpagina);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se registró correctamente la lista en la Pagina o SubPagina');
                                window.location.href = '../Views/Personal/listapersonal.php';
                          </script>"; 
                    exit();
                }else{
                    echo "<script>
                                window.alert('No se registró correctamente la lista en la Pagina o SubPagina');
                                window.location.href = '../Views/Personal/listapersonal.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion " . $this->conn->error;
            }
        }

        public function updatelistaPersonal($idlista, $titulo, $fk_idpagina, $fk_idsubpagina){
            $idlista = $this->conn->real_escape_string($idlista);
            $titulo = $this->conn->real_escape_string($titulo);
            $fk_idpagina = $this->conn->real_escape_string($fk_idpagina);
            $fk_idsubpagina = $this->conn->real_escape_string($fk_idsubpagina);

            $query = "UPDATE tblista SET titulo = ?, fk_idpagina = ?, fk_idsubpagina = ? WHERE idlista = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("sssi",$titulo,$fk_idpagina,$fk_idsubpagina, $idlista);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se actualizo correctamente la lista en la Pagina o SubPagina.');
                                window.location.href = '../Views/Personal/listapersonal.php';
                          </script>";
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente la lista en la Pagina o SubPagina.');
                                window.location.href = '../Views/Personal/listapersonal.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la actualizacion de la lista" . $this->conn->error;
            }
        }

        //METODOS PARA OPCION
        //ADMINISTRADOR
        public function Listaropciones(){
            $query = "SELECT tbopcion.idopcion,tbopcion.descripcion,tbopcion.fk_idlista,
                      tblista.idlista,tblista.titulo 
                      FROM tbopcion
                      INNER JOIN tblista
                      ON tblista.idlista = tbopcion.fk_idlista";

            $result = $this->conn->query($query);

            $opciones = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $opciones[] = $row;
                }
            }

            return $opciones;
        }

        public function insertaropcion($data){
            $descripcion = $this->conn->real_escape_string($data['descripcion']);
            $fk_idlista = $this->conn->real_escape_string($data['fk_idlista']);

            $query = "INSERT INTO tbopcion(descripcion, fk_idlista) VALUES (?,?)";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ss", $descripcion, $fk_idlista);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se registró correctamente la opcion en la lista de la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/listaadmin.php';
                          </script>";
                    exit();
                }else{
                    echo "<script>
                                window.alert('No se registró correctamente la opcion en la lista de la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/listaadmin.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion" . $this->conn->error;
            }
        }

        public function updateopcion($idopcion, $descripcion, $fk_idlista){
            $idopcion = $this->conn->real_escape_string($idopcion);
            $descripcion = $this->conn->real_escape_string($descripcion);
            $fk_idlista = $this->conn->real_escape_string($fk_idlista);

            $query = "UPDATE tbopcion SET descripcion = ?, fk_idlista = ? WHERE idopcion = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssi", $descripcion, $fk_idlista, $idopcion);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se actualizo correctamente la opcion en la lista de la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/listaadmin.php';
                          </script>";
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente la opcion en la lista de la Pagina o SubPagina.');
                                window.location.href = '../Views/Admin/listaadmin.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la actualizacion de la opcion" . $this->conn->error;
            }
        }

        public function eliminaropcion($idopcion){
            $query = "DELETE FROM tbopcion WHERE idopcion = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("i", $idopcion);

                if($stmt->execute()){
                    return true;
                }else{
                    echo "Error al eliminar la opcion" . $stmt->error;
                    return false;
                }

            }else{
                echo "Error al preparar la consulta de eliminacion" . $this->conn->error;
                return false;
            }
        }

        //PERSONAL
        public function insertaropcionPersonal($data){
            $descripcion = $this->conn->real_escape_string($data['descripcion']);
            $fk_idlista = $this->conn->real_escape_string($data['fk_idlista']);

            $query = "INSERT INTO tbopcion(descripcion, fk_idlista) VALUES (?,?)";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ss", $descripcion, $fk_idlista);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se registró correctamente la opcion en la lista de la Pagina o SubPagina.');
                                window.location.href = '../Views/Personal/listapersonal.php';
                          </script>";
                    exit();
                }else{
                    echo "<script>
                                window.alert('No se registró correctamente la opcion en la lista de la Pagina o SubPagina.');
                                window.location.href = '../Views/Personal/listapersonal.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion" . $this->conn->error;
            }
        }

        public function updateopcionPersonal($idopcion, $descripcion, $fk_idlista){
            $idopcion = $this->conn->real_escape_string($idopcion);
            $descripcion = $this->conn->real_escape_string($descripcion);
            $fk_idlista = $this->conn->real_escape_string($fk_idlista);

            $query = "UPDATE tbopcion SET descripcion = ?, fk_idlista = ? WHERE idopcion = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("ssi", $descripcion, $fk_idlista, $idopcion);

                if($stmt->execute()){
                    echo "<script>
                                window.alert('Se actualizo correctamente la opcion en la lista de la Pagina o SubPagina.');
                                window.location.href = '../Views/Personal/listapersonal.php';
                          </script>";
                }else{
                    echo "<script>
                                window.alert('No se actualizo correctamente la opcion en la lista de la Pagina o SubPagina.');
                                window.location.href = '../Views/Personal/listapersonal.php';
                          </script>";
                }

                $stmt->close();
            }else{
                echo "Error en la actualizacion de la opcion" . $this->conn->error;
            }
        }
    }
?>