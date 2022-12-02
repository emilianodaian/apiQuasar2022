<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include_once 'db.php';

//Comando de consulta por ID
if (isset($_GET["consultar"])){
    $sqlEmpleaados = mysqli_query($conexionBD,"SELECT * FROM lugar WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlEmpleaados) > 0){
        $empleaados = mysqli_fetch_all($sqlEmpleaados,MYSQLI_ASSOC);
        echo json_encode($empleaados);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}

//Insertar
$data = json_decode(file_get_contents("php://input"));

    $nombre=$data->nombre;
        
            try{
                $sqlLugar = mysqli_query($conexionBD,"INSERT INTO lugar(nombre) VALUES('$nombre')");
                echo json_encode("LUGAR REGISTRADO CORRECTAMENTE");
            }catch(Exception $e){
                echo json_encode($e->getMessage());
            }

?>