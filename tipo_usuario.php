<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'db.php';

// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["consultar"])){
    $sqlTipoUsuarios = mysqli_query($conexionBD,"SELECT * FROM tipo_usuario WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlTipoUsuarios) > 0){
        $usuariosTipo = mysqli_fetch_all($sqlTipoUsuarios,MYSQLI_ASSOC);
        echo json_encode($usuariosTipo);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}

?>