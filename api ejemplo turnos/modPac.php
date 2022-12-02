<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST, DELETE, UPDATE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include ('bd.php');



$data = json_decode(file_get_contents("php://input"));

$hist=(isset($data->num_historia_clinica))?$data->num_historia_clinica:$_GET["actualizar"];
$nombre=$data->nombre;
$apellido=$data -> surname;
$dni =$data -> dni;
$correo=$data->mail;
$phone = $data -> phone;



try {
    $sqlPac= mysqli_query($conexionBD,"UPDATE paciente SET nombre='$nombre', apellido='$apellido',
DNI='$dni', tel_celular='$phone' ,email='$correo' WHERE num_historia_clinica='$hist'");

if($sqlPac){echo json_encode(['PACIENTE ACTUALIZADO CORRECTAMENTE']);
}
else{echo json_encode("ERROR");}

} catch (\Throwable $th) {
    echo json_encode('Ha ocurrido un error'.$th);
}







?>