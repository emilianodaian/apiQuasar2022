<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST, DELETE, UPDATE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

date_default_timezone_set('America/Argentina/Buenos_Aires');
include('bd.php');


///////////////LOGIN PROVISORIO ADMIN///////////////
if(isset($_GET['loginAdmin'])){

    $data = json_decode(file_get_contents("php://input"));

    $user = $data -> user;
    $pass = $data -> pass;

    try{
        $sqlLogin = mysqli_query($conexionBD, "SELECT ID_admin FROM administrador WHERE email = '$user' AND
        pass = '$pass'");

        if(mysqli_num_rows($sqlLogin)>0){
            echo json_encode ("BIEN");
        }else{
            echo json_encode ("ERROR, CONTRASEÑA O USUARIO INCORRECTOS");
        }
    }catch(Exception $e){
        echo json_encode($e -> getMessage());
    }

    exit();
}

?>