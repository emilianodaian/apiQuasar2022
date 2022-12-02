<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include('bd.php');

// Consulta datos de un paciente en particular



try{

    $sqlPac = mysqli_query($conexionBD,"SELECT  num_historia_clinica, nombre, apellido, DNI, tel_celular,
    email, fecha_nacimiento, tipo_usuario FROM paciente WHERE num_historia_clinica =".$_GET["consultar"]);
    if(mysqli_num_rows($sqlPac)>0){
        $pacientees = mysqli_fetch_all($sqlPac,MYSQLI_ASSOC);
        echo json_encode($pacientees);
        
    }
    else{  echo json_encode(["Este Paciente no está disponible"]); }

}catch(Exception $e){
   echo json_encode($e -> getMessage());
}



?>