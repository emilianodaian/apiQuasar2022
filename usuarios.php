<?php
    include 'conexionBD.php';

    $pdo = new Conexion();

    if($_SERVER['REQUEST_METHOD'] == 'GET'){

            if(isset($_GET['id'])){
                $sql = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuarios=:id");
                $sql->bindValue(':id', $_GET['id']);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchAll());
                exit;
            }

            else{
                $sql = $pdo->prepare("SELECT * FROM usuarios");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchAll());
                exit;
            }
        }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql="INSERT INTO usuarios (nombres, apellidos, usuario, contrasenia, id_tipoUsuario) 
        VALUES (:nombres, :apellidos, :usuario, :contrasenia, :id_tipoUsuario)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nombres', $_POST['nombres']);
        $stmt->bindValue(':apellidos', $_POST['apellidos']);
        $stmt->bindValue(':usuario', $_POST['usuario']);
        $stmt->bindValue(':contrasenia', $_POST['contrasenia']);
        $stmt->bindValue(':id_tipoUsuario', $_POST['id_tipoUsuario']);
        $stmt->execute();

        $idPost=$pdo->lastInsertId();

        if($idPost){
            header("HTTP/1.1 200 OK");
            echo json_encode($idPost);
        }
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql="UPDATE usuarios SET nombres=:nombres, apellidos=:apellidos, usuario=:usuario, 
        contrasenia=:contrasenia, id_tipoUsuario=:id_tipoUsuario WHERE id_usuarios=:id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nombres', $_GET['nombres']);
        $stmt->bindValue(':apellidos', $_GET['apellidos']);
        $stmt->bindValue(':usuario', $_GET['usuario']);
        $stmt->bindValue(':contrasenia', $_GET['contrasenia']);
        $stmt->bindValue(':id_tipoUsuario', $_GET['id_tipoUsuario']);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();       
        header("HTTP/1.1 200 OK");
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql="DELETE FROM usuarios WHERE id_usuarios=:id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();       
        header("HTTP/1.1 200 OK");
        exit;
    }

?>