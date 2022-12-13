<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include_once 'db.php';
$pdo = new Conexion();


 //METODO DELETE PARA ELIMINAR UN REGISTRO
 if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    $sql="DELETE FROM lugar WHERE id_lugar=:id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();       
    header("HTTP/1.1 200 OK");
    exit;
}


?>