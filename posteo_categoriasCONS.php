<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include('bd.php');

// Consulta datos de un posteo en particular

    $sqlPosteocategorias = mysqli_query($conexionBD,"SELECT id_posteocategorias, id_posteo, id_categoria FROM posteo_categorias WHERE id_posteocategorias =".$_GET["consultar"]);
    if(mysqli_num_rows($sqlPosteocategorias)>0){
        $posteocategorias = mysqli_fetch_all($sqlPosteocategorias,MYSQLI_ASSOC);
        echo json_encode($posteocategorias);
    }
    else{  echo json_encode(["No existe este posteo"]);
    }

?>