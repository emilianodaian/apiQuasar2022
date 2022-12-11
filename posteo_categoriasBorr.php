<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST, DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include('conexionBD.php');

$sqlPosteocategorias = mysqli_query($conexionBD,"DELETE FROM posteo_categorias WHERE id_posteocategorias=".$_GET["borrar"]);

if(window.confirm("Esta seguro de eliminar este registro?")){
    if($sqlPosteocategorias){
        echo json_encode("POSTEO BORRADO CORRECTAMENTE");
        
    }
    else{  echo json_encode("Algo Falló"); 
    }
}




?>