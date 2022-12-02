<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include('bd.php');
if(isset($_GET['contarPac'])){
      
        
    try{

      $sqlCuenta= ("SELECT COUNT(num_historia_clinica) total FROM paciente");
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

$sqlPacientes= mysqli_query($conexionBD,"SELECT num_historia_clinica, nombre, apellido, DNI, tel_celular,
email, fecha_nacimiento, tipo_usuario FROM paciente ");
if(mysqli_num_rows($sqlPacientes) > 0){
    $pacientes = mysqli_fetch_all($sqlPacientes,MYSQLI_ASSOC);
    echo json_encode($pacientes);
}
else{ echo json_encode([["success"=>0]]); }

?>