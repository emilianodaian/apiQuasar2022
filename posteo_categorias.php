<?php
    include 'conexionBD.php';

    $pdo = new Conexion();


    //METODO GET PARA CONSULTAR X ID Y TOTAL
    if($_SERVER['REQUEST_METHOD'] == 'GET'){

            if(isset($_GET['id'])){
                $sql = $pdo->prepare("SELECT * FROM posteo_categorias WHERE id_posteo_categorias=:id");
                $sql->bindValue(':id', $_GET['id']);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchAll());
                exit;
            }

            else{
                $sql = $pdo->prepare("SELECT * FROM posteo_categorias");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchAll());
                exit;
            }
        }
    
    
        //METODO POST PARA REALIZAR INSERT
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql="INSERT INTO posteo_categorias (id_posteo, id_categoria) 
        VALUES (:id_posteo, :id_categoria)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_posteo', $_POST['id_posteo']);
        $stmt->bindValue(':id_categoria', $_POST['id_categoria']);
        $stmt->execute();

        $idPost=$pdo->lastInsertId();

        if($idPost){
            header("HTTP/1.1 200 OK");
            echo json_encode($idPost);
        }
        exit;
    }

    //METODO PUT PARA ACTUALIZAR UN REGISTRO
    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql="UPDATE posteo_categorias SET id_posteo=:id_posteo, id_categoria=:id_categoria WHERE id_posteo_categorias=:id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id_posteo', $_GET['id_posteo']);
        $stmt->bindValue(':id_categoria', $_GET['id_categoria']);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();       
        header("HTTP/1.1 200 OK");
        exit;
    }

    //METODO DELETE PARA ELIMINAR UN REGISTRO
    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql="DELETE FROM posteo_categorias WHERE id_posteo_categorias=:id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();       
        header("HTTP/1.1 200 OK");
        exit;
    }

?>