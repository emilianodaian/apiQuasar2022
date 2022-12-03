<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'db.php';

if (isset($_GET["consultar"])){
    $sqlcategoria = mysqli_query($conexionBD,"SELECT * FROM categorias WHERE idcategorias=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlcategoria) > 0){
        $categoria = mysqli_fetch_all($sqlcategoria,MYSQLI_ASSOC);
        echo json_encode($categoria);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//borrar pero se le debe de enviar una clave ( para borrado )
if (isset($_GET["borrar"])){
    $sqlcategoria = mysqli_query($conexionBD,"DELETE FROM categorias WHERE idcategorias=".$_GET["borrar"]);
    if($sqlcategoria){
        echo json_encode(["success"=>1]);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//Inserta un nuevo registro y recepciona en método post los datos de nombre y correo
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $id_tipousuario=$data->tipousuario;
    $id_catusuario=$data->catusuario;
        if(($correo!="")&&($nombre!="")){
            
    $sqlcategoria = mysqli_query($conexionBD,"INSERT INTO categorias(nombre) VALUES('$nombre') ");
    echo json_encode(["success"=>1]);
        }
    exit();
}
// Actualiza datos pero recepciona datos de nombre, correo y una clave para realizar la actualización
if(isset($_GET["actualizar"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $id=(isset($data->id))?$data->id:$_GET["actualizar"];
    $id_tipousuario=$data->nombre;
    $id_catusuario=$data->correo;
    
    $sqlcategoria = mysqli_query($conexionBD,"UPDATE categorias SET categorias='$categoria',nombre='$nombre' WHERE id='$id'");
    echo json_encode(["success"=>1]);
    exit();
}
// Consulta todos los registros de la tabla empleados
$sqlcategoria = mysqli_query($conexionBD,"SELECT * FROM  ");
if(mysqli_num_rows($sqlcategoria) > 0){
    $categoria = mysqli_fetch_all($sqlcategoria,MYSQLI_ASSOC);
    echo json_encode($categoria);
}
else{ echo json_encode([["success"=>0]]); }
?>