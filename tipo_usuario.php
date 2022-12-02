<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'db.php';

if (isset($_GET["consultar"])){
    $sqlUsuariostipo = mysqli_query($conexionBD,"SELECT * FROM tipo_usuarios WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlUsuariostipo) > 0){
        $tipousuario = mysqli_fetch_all($sqlUsuariostipo,MYSQLI_ASSOC);
        echo json_encode($tipousuario);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
?>