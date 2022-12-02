<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'db.php';

//PRUEBA COMMIT ! 

if (isset($_POST["consultar"])){
    $sqlPosteo = mysqli_query($conexionBD,"SELECT * FROM posteo WHERE id_posteo=1");
    if(mysqli_num_rows($sqlPosteo) > 0){
        $posteos = mysqli_fetch_all($sqlPosteo,MYSQLI_ASSOC);
        echo json_encode($posteos);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//borrar pero se le debe de enviar una clave ( para borrado )
if (isset($_GET["borrar"])){
    $sqlPosteo = mysqli_query($conexionBD,"DELETE FROM posteo WHERE id_posteo=".$_GET["borrar"]);
    if($sqlPosteo){
        echo json_encode(["success"=>1]);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//Inserta un nuevo registro y recepciona en método post los datos del POSTEO
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $titulo=$data->titulo;
    $epigrafe=$data->epigrafe;
    $copete = $data->copete;
    $cuerpo=$data->cuerpo;
    $idLugar=$data->lugar;
    $fuentes=$data->fuentes;
    $img=$data->imagen;
    $etiquetas=$data->etiquetas;
    $id_Usuario=$data->id_Usuario;

        if(($titulo!="")&&($epigrafe!="")&&($copete!="")&&($cuerpo!="")&&($cuerpo!="")&&($idLugar!="")&&($fuentes!="")&&($img!="")&&($etiquetas!="")&&($id_Usuario!="")){
            
    $sqlPosteo = mysqli_query($conexionBD,"INSERT INTO posteo(titulo,epigrafe,copete,cuerpo,id_lugar,Fuentes,ImagenDestacada,Etiquetas,id_Usuario) VALUES('$titulo','$epigrafe','$titulo','$copete','$cuerpo','$idLugar','$fuentes','$img','$etiquetas','$id_Usuario')");
    echo json_encode(["success"=>1]);
        }
    exit();
}
// Actualiza datos pero recepciona datos de nombre, correo y una clave para realizar la actualización
if(isset($_GET["actualizar"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $id=(isset($data->id))?$data->id:$_GET["actualizar"];
    $data = json_decode(file_get_contents("php://input"));
    $titulo=$data->titulo;
    $epigrafe=$data->epigrafe;
    $copete = $data->copete;
    $cuerpo=$data->cuerpo;
    $idLugar=$data->lugar;
    $fuentes=$data->fuentes;
    $img=$data->imagen;
    $etiquetas=$data->etiquetas;
    $id_Usuario=$data->id_Usuario;
    
    $sqlPosteo = mysqli_query($conexionBD,"UPDATE posteo SET titulo='$titulo',epigrafe='$epigrafe',copete='$copete',cuerpo='$cuerpo',id_lugar='$idlugar',Fuentes='$fuentes',ImagenDestacada='$img',Etiquetas='$etiquetas',id_usuarios=$id_Usuario WHERE id_posteo='$id'");
    echo json_encode(["success"=>1]);
    exit();
}
// Consulta todos los registros de la tabla empleados
$sqlPosteo = mysqli_query($conexionBD,"SELECT * FROM posteo ");
if(mysqli_num_rows($sqlPosteo) > 0){
    $posteos = mysqli_fetch_all($sqlPosteo,MYSQLI_ASSOC);
    echo json_encode($posteos);
}
else{ echo json_encode([["success"=>0]]); }


?>