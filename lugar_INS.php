<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include_once 'conexionBD.php';
$pdo = new Conexion();


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sql="INSERT INTO lugar (nombre) 
    VALUES (:nombre)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':nombre', $_POST['nombre']);
    $stmt->execute();

    $id_lugar=$pdo->lastInsertId();

    if($id_lugar){
        header("HTTP/1.1 200 OK");
        echo json_encode($id_lugar);
    }
    exit;
}

?>