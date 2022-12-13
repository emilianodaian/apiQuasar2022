<?php
    include 'conexionBD.php';

    $pdo = new Conexion();

    if($_SERVER['REQUEST_METHOD'] == 'GET'){

            if(isset($_GET['id'])){
                $sql = $pdo->prepare("SELECT * FROM categorias WHERE id_categorias=:id");
                $sql->bindValue(':id', $_GET['id']);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchAll());
                exit;
            }

            else{
                $sql = $pdo->prepare("SELECT * FROM categorias");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchAll());
                exit;
            }
        }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql="INSERT INTO categorias (nombre) 
        VALUES (:nombre)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nombre', $_POST['nombre']);
        $stmt->execute();

        $idPost=$pdo->lastInsertId();

        if($idPost){
            header("HTTP/1.1 200 OK");
            echo json_encode($idPost);
        }
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql="UPDATE categorias SET nombre=:nombre WHERE id_categorias=:id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nombre', $_GET['nombre']);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();       
        header("HTTP/1.1 200 OK");
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql="DELETE FROM categorias WHERE id_categorias=:id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();       
        header("HTTP/1.1 200 OK");
        exit;
    }

?>