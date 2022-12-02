<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST, DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include('bd.php');


try{
$sqlPac = mysqli_query($conexionBD,"DELETE FROM paciente WHERE num_historia_clinica=".$_GET["borrar"]);

if($sqlPac){
    echo json_encode("PACIENTE BORRADO CORRECTAMENTE");
    
}
else{  echo json_encode("Algo Falló"); }

}catch(Exception $e){

    echo json_encode($e->getMessage());
}



?>