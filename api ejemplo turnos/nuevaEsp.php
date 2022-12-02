<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include('bd.php');


  $data = json_decode(file_get_contents("php://input"));
           
    $nombre=$data->nombre;
    $descripcion=$data->descripcion;
    
   
    if($nombre == ""){
      echo json_encode("ERROR");
    }else{

      try{
        $sqlExiste = mysqli_query($conexionBD, "SELECT nombre FROM especialidad WHERE nombre ='$nombre'");
         
     if(mysqli_num_rows($sqlExiste) > 0){
       echo json_encode("YA EXISTE UNA ESPECIALIDAD CON ESTE NOMBRE");  
      
     }else{ 
         $sqlEspecialidad = mysqli_query($conexionBD,"INSERT INTO especialidad(nombre, descripcion)
       VALUES('$nombre','$descripcion') ");
      echo json_encode("ESPECIALIDAD REGISTRADA CORRECTAMENTE");

  }
}catch(Exception $e){

         echo json_encode($e->getMessage());
     }
    }
    

        
          
        



?>