<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST, DELETE, UPDATE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include ('bd.php');



$data = json_decode(file_get_contents("php://input"));

$id=(isset($data->id_especialidad))?$data->id_especialidad:$_GET["actualizar"];
$nombre=$data->nombre;
$desc=$data -> descripcion;



try {
    $sqlEsp= mysqli_query($conexionBD,"UPDATE especialidad SET nombre='$nombre', descripcion='$desc' 
    WHERE id_especialidad= $id");

if($sqlEsp){
    echo json_encode(['ESPECIALIDAD ACTUALIZADA CORRECTAMENTE']);
    
}
else{  echo json_encode("Algo Falló"); }

} catch (\Throwable $th) {
    echo json_encode('Ha ocurrido un error'.$th);
}







?>