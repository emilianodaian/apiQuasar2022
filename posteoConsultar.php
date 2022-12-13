<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


    include 'conexionBD.php';

    $pdo = new Conexion();
    
       //METODO GET PARA CONSULTAR X ID Y TOTAL
    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        if(isset($_GET['id'])){
            $sql = $pdo->prepare("SELECT * FROM posteo WHERE id_posteo=:id");
            $sql->bindValue(':id', $_GET['id']);
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            header("HTTP/1.1 200 OK");
            echo json_encode($sql->fetchAll());
            exit;
        }

        else{
            $sql = $pdo->prepare("SELECT * FROM posteo");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            header("HTTP/1.1 200 OK");
            echo json_encode($sql->fetchAll());
            exit;
        }
    }


?>




