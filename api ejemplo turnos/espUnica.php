<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include('bd.php');


/////////////////////////PROFESIONAL-ESPECIALIDAD////////////////////
if(isset($_GET['proEsp'])){
    $id_esp = $_GET['proEsp'];

    try{

        $sqlPro = mysqli_query($conexionBD,"SELECT num_matricula, nombre, apellido FROM profesional WHERE id_especialidad = $id_esp");
        if(mysqli_num_rows($sqlPro)>0){
            $pros = mysqli_fetch_all($sqlPro,MYSQLI_ASSOC);
            echo json_encode($pros);
            
        }
        else{  echo json_encode(["0"]); }
    
    }catch(Exception $e){
       echo json_encode($e -> getMessage());
    }

    exit();
}

//////////////////////////////CONTAR-ESPECIALIDADES///////////////////////
if(isset($_GET['contarEsp'])){
      
        
    try{

      $sqlCuenta= ("SELECT COUNT(id_especialidad) total FROM especialidad");
      if (!$result = $conexionBD->query($sqlCuenta)) {printf("Error: %s\n", $conexionBD->error); exit;}
      // recuperamos el resultado
        $total = $result->fetch_assoc()['total'];

        // mostramos el resultado
        echo $total;

    }catch(Exception $e){
      echo json_encode($e -> getMessage());
    }


    exit();
  }


try{

    $sqlEsp = mysqli_query($conexionBD,"SELECT * FROM especialidad WHERE id_especialidad =".$_GET["consultar"]);
    if(mysqli_num_rows($sqlEsp)>0){
        $especialidadd = mysqli_fetch_all($sqlEsp,MYSQLI_ASSOC);
        echo json_encode($especialidadd);
        
    }
    else{  echo json_encode(["Esta especialidad no está disponible"]); }

}catch(Exception $e){
   echo json_encode($e -> getMessage());
}



?>