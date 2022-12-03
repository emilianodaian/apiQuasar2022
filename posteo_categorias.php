<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'db.php';

//consultar por id_posteocategorias
if (isset($_GET["consultar"])){
    $sqlPosteoCategorias = mysqli_query($conexionBD,"SELECT * FROM posteo_categorias WHERE id_posteocategorias=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlPosteocategorias) > 0){
        $posteocategorias = mysqli_fetch_all($sqlPosteoCategorias,MYSQLI_ASSOC);
        echo json_encode($posteocategorias);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}

//borrado de un registro por id_posteocategorias
if (isset($_GET["borrar"])){
    $sqlPosteoCategorias = mysqli_query($conexionBD,"DELETE FROM posteo_categorias WHERE idposteocategorias=".$_GET["borrar"]);
    if($sqlPosteoCategorias){
        echo json_encode(["success"=>1]);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}

//agregar un posteo
$data = json_decode(file_get_contents("php://input"));
    $id_posteocategorias->data->id_posteocategorias;    
    $id_posteo=$data->id_posteo;
    $id_categoria=$data->id_categoria;
        
        $sqlPosteocategorias = mysqli_query($conexionBD,"INSERT INTO posteo_categorias(id_posteocategorias, id_posteo, id_categoria)
            VALUES('$id_posteocategorias','$id_posteo','$id_categoria') ");
            echo json_encode("REGISTRADO CORRECTAMENTE");
            

//actualizar los datos de un posteo
if(isset($_GET["actualizar"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $id_posteocategorias=(isset($data->id_posteocategorias))?$data->id_posteocategorias:$_GET["actualizar"];
    $id_posteo=$data->id_posteo;
    $id_categoria=$data->id_categoria;
    
    $sqlPostoCategorias = mysqli_query($conexionBD,"UPDATE posteo_categorias SET id_posteo='$id_posteo',id_categoria='$id_categoria' WHERE id_posteocategorias='$id_posteocategorias'");
    echo json_encode(["success"=>1]);
    exit();
}
//Listado de posteo_categorias
$sqlPosteoCategorias = mysqli_query($conexionBD,"SELECT * FROM posteo_categorias ");
if(mysqli_num_rows($sqlPosteoCategorias) > 0){
    $posteocategorias = mysqli_fetch_all($sqlPosteoCategorias,MYSQLI_ASSOC);
    echo json_encode($posteocategorias);
}
else{ echo json_encode([["success"=>0]]); }



?>