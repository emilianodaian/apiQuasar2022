<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include('bd.php');


        $data = json_decode(file_get_contents("php://input"));
        
    $id_posteocategorias=$data->id_posteocategorias;
    $id_posteo=$data->id_posteo;
    $id_categoria=$data ->id_categoria;
  
        $sqlPosteocategorias = mysqli_query($conexionBD,"INSERT INTO posteo_categorias(id_posteocategorias, id_posteo, id_categoria)
            VALUES('$id_posteocategorias','$id_posteo','$id_categoria') ");
        echo json_encode("POSTEO INSERTADO CORRECTAMENTE");
?>
