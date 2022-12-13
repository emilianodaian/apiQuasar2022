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
        $sql="UPDATE posteo SET Titulo=:Titulo, Epigrafe=:Epigrafe, Copete=:Copete, 
        Cuerpo=:Cuerpo, id_lugar=:id_lugar, Fuentes=:Fuentes, Visible=:Visible, ImagenDestacada=:ImagenDestacada, 
        Etiquetas=:Etiquetas, Id_Usuario=:Id_Usuario  WHERE id_Posteo=:id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':Titulo', $_GET['Titulo']);
        $stmt->bindValue(':Epigrafe', $_GET['Epigrafe']);
        $stmt->bindValue(':Copete', $_GET['Copete']);
        $stmt->bindValue(':Cuerpo', $_GET['Cuerpo']);
        $stmt->bindValue(':id_lugar', $_GET['id_lugar']);
        $stmt->bindValue(':Fuentes', $_GET['Fuentes']);
        $stmt->bindValue(':Visible', $_GET['Visible']);
        $stmt->bindValue(':ImagenDestacada', $_GET['ImagenDestacada']);
        $stmt->bindValue(':Etiquetas', $_GET['Etiquetas']);
        $stmt->bindValue(':Id_Usuario', $_GET['Id_Usuario']);
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
