<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST ,DELETE, UPDATE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include_once 'db.php';

//COMANDO MODIFICAR

$data = json_decode(file_get_contents("php://input"));

$lugar=(isset($data->id_lugar))?$data->id_lugar:$_GET["actualizar"];
$nombre=$data->nombre;




try {
    $lugarmodif= mysqli_query($conexionBD,"UPDATE lugar SET nombre='$nombre' WHERE id_lugar='$lugar'");

if($lugarmodif){echo json_encode(['lugar modificado']);
}
else{echo json_encode("ERROR");}

} catch (\Throwable $th) {
    echo json_encode('Ha ocurrido un error'.$th);
}







?>
