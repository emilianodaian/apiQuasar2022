<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST ,DELETE, UPDATE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


    include 'conexionBD.php';

    $pdo = new Conexion();

    //METODO PUT PARA ACTUALIZAR UN REGISTRO
    if($_SERVER['REQUEST_METHOD'] == 'PUT'){
        $sql="UPDATE posteo SET titulo=:titulo, epigrafe=:epigrafe, copete=:copete, 
        cuerpo=:cuerpo, lugar=:lugar, fuentes=:fuentes, imagen=:imagen, etiquetas=:etiquetas, id_Usuario=:id_Usuario  WHERE id_posteo=:id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':titulo', $_POST['titulo']);
        $stmt->bindValue(':epigrafe', $_POST['epigrafe']);
        $stmt->bindValue(':copete', $_POST['copete']);
        $stmt->bindValue(':cuerpo', $_POST['cuerpo']);
        $stmt->bindValue(':lugar', $_POST['lugar']);
        $stmt->bindValue(':fuentes', $_POST['fuentes']);
        $stmt->bindValue(':imagen', $_POST['imagen']);
        $stmt->bindValue(':etiquetas', $_POST['etiquetas']);
        $stmt->bindValue(':id_Usuario', $_POST['id_Usuario']);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();      
        header("HTTP/1.1 200 OK");
        exit;
    }

?>



















//METODO PUT PARA ACTUALIZAR UN REGISTRO
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
