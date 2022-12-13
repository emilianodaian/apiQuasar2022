<?php
    include 'conexionBD.php';

    $pdo = new Conexion();

    if($_SERVER['REQUEST_METHOD'] == 'GET'){

            if(isset($_GET['id'])){
                $sql = $pdo->prepare("SELECT * FROM tipo_usuario WHERE id_tipoUsuario=:id");
                $sql->bindValue(':id', $_GET['id']);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchAll());
                exit;
            }

            else{
                $sql = $pdo->prepare("SELECT * FROM tipo_usuario");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchAll());
                exit;
            }
        }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql="INSERT INTO tipo_usuario (cat_usuario)
        VALUES (:cat_usuario)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':cat_usuario', $_POST['cat_usuario']);
        $stmt->execute();

        $idPost=$pdo->lastInsertId();

        if($idPost){
            header("HTTP/1.1 200 OK");
            echo json_encode($idPost);
        }
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql="UPDATE tipo_usuario SET cat_usuario=:cat_usuario WHERE id_tipoUsuario=:id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':cat_usuario', $_GET['cat_usuario']);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();       
        header("HTTP/1.1 200 OK");
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql="DELETE FROM tipo_usuario WHERE id_tipoUsuario=:id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();       
        header("HTTP/1.1 200 OK");
        exit;
    }

?>