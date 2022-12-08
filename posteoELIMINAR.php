<?php
    include 'conexionBD.php';

    $pdo = new Conexion();

    //METODO DELETE PARA ELIMINAR UN REGISTRO
    if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
        $sql="DELETE FROM posteo WHERE id_posteo=:id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();       
        header("HTTP/1.1 200 OK");
        exit;
    }

?>