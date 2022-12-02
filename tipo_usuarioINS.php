<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include('bd.php');


        $data = json_decode(file_get_contents("php://input"));
        
    $cat_usuario=$data->categoriausuario;

        
        
            try{


                $sqlPacientes = mysqli_query($conexionBD,"INSERT INTO tipo_usuario(cat_usuario)
                VALUES('$cat_usuario)");
                echo json_encode("Tipo de usuario registrado");
            }

            catch(Exception $e){

                echo json_encode($e->getMessage());
            }
        


?>
