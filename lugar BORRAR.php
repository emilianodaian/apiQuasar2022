<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include_once 'db.php';

//Borrar

try{
    $borrarLugar = mysqli_query($conexionBD,"DELETE FROM lugar WHERE id_lugar=".$_GET["borrar"]);
    
    if(window.confirm("¿Está seguro de eliminar este lugar?")){
        if($borrarLugar){
            echo json_encode("LUGAR BORRADO CORRECTAMENTE");
        }
        else{  echo json_encode("Algo Falló.Vuelva a intentarlo"); 
        }

    }catch(Exception $e){
    
        echo json_encode($e->getMessage());
    }
}

?>