<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST,DELETE, UPDATE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include('bd.php');



$sqlEsp= mysqli_query($conexionBD,"SELECT * FROM especialidad");
if(mysqli_num_rows($sqlEsp) > 0){
    $especialidades = mysqli_fetch_all($sqlEsp,MYSQLI_ASSOC);
    echo json_encode($especialidades);
}
else{ echo json_encode([["NO HAY ESPECIALIDADES REGISTRADAS"]]); }

?>