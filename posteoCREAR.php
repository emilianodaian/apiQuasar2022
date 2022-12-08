<?php
    include 'conexionBD.php';

    $pdo = new Conexion();
    
        //METODO POST PARA REALIZAR INSERT
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql="INSERT INTO posteo(titulo,epigrafe,copete,cuerpo,id_lugar,Fuentes,ImagenDestacada,Etiquetas,id_Usuario) 
        VALUES (:titulo, :epigrafe, :copete, :cuerpo, :lugar,:fuentes, :imagen, :etiquetas, :id_Usuario)";

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
        $stmt->execute();

        $idPost=$pdo->lastInsertId();

        if($idPost){
            header("HTTP/1.1 200 OK");
            echo json_encode($idPost);
        }
        exit;
    }
?>