<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST, DELETE, UPDATE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include ('conexioBD.php');

$data = json_decode(file_get_contents("php://input"));

$id=(isset($data->posteo_categorias))?$data->posteo_categorias:$_GET["actualizar"];
$id_posteocategorias=$data->id_posteocategorias;
$id_posteo=$data ->id_posteo;
$id_categoria=$data->id_categoria;

if($sqlEsp){
    echo json_encode(['POSTEO ACTUALIZADO CORRECTAMENTE']);
}
else{  echo json_encode("Algo Falló"); }

?>