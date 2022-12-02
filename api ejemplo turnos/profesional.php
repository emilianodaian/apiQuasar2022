<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST, DELETE, UPDATE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include('bd.php');


///////////////PROFESIONAL ÚNICO/////////////////////
if(isset($_GET["consultar"])){

try{
  $numMatricula = $_GET["consultar"];

  $sqlPro = mysqli_query($conexionBD,"SELECT num_matricula, nombre,
  apellido, DNI, tel_celular, email, fecha_nacimiento, descripcion, id_especialidad FROM profesional
   WHERE num_matricula = '$numMatricula'");
  
  if(mysqli_num_rows($sqlPro)>0){
      $profesionales = mysqli_fetch_all($sqlPro,MYSQLI_ASSOC);
      echo json_encode($profesionales);
      
  }
  else{  echo json_encode(["Este Paciente no está disponible"]); }

}catch(Exception $e){
 echo json_encode($e -> getMessage());
}
exit();
}

////////////////////////NUEVO PROFESIONAL/////////////////////////////

if(isset($_GET["insertar"])){


  $data = json_decode(file_get_contents("php://input"));
    
  $matricula = $data ->num_matricula;
  $nombre=$data->nombre;
  $apellido=$data->apellido;
  $dni=$data -> DNI;
  $correo= $data -> email;
  $password = $data -> pass;
  $celular = $data -> phone;
  $fn = $data -> Fn;
  $desc= $data ->descripcion;
  $id_esp= null;
  

  $tu = 3;
         
      
          try{
             $sqlBusca = mysqli_query($conexionBD, "SELECT DNI FROM profesional WHERE DNI =".$dni);

          if(mysqli_num_rows($sqlBusca)>0){
          echo json_encode("YA EXISTE UN PROFESIONAL CON ESTE DNI");  
       
          }else{

              $sqlPro = mysqli_query($conexionBD,"INSERT INTO profesional(num_matricula,nombre, apellido, DNI, 
              tel_celular, email, contrasena, fecha_nacimiento, descripcion ,tipo_usuario, id_especialidad)
               VALUES('$matricula','$nombre','$apellido','$dni','$celular','$correo','$password','$fn', 
                '$desc',3, 0) ");
              
              if($sqlPro){echo json_encode("REGISTRADO CORRECTAMENTE");
                }else{echo json_encode("OCURRIÓ UN ERROR");}
          }

          }catch(Exception $e){

              echo json_encode($e->getMessage());
          }

  exit();
}

/////////////////////////////BORRAR PROFESIONAL//////////////////////////////

if(isset($_GET['borrar'])){

  $matricula = $_GET['borrar'];
  try{
    $sqlPro = mysqli_query($conexionBD,"DELETE FROM profesional WHERE num_matricula='$matricula'");
    
    if($sqlPro){
        echo json_encode("PROFESIONAL BORRADO CORRECTAMENTE");
        
    }
    else{  echo json_encode("Algo Falló"); }
    
    }catch(Exception $e){
    
        echo json_encode($e->getMessage());
    }
    exit();
}

/////////////////////////////////////ACTUALIZAR///////////////////////

if(isset($_GET['actualizar'])){
$data = json_decode(file_get_contents("php://input"));

$matricula=(isset($data->num_matricula))?$data->num_matricula:$_GET["actualizar"];
$nombre=$data->nombre;
$apellido=$data->apellido;
$correo= $data -> email;
$celular = $data -> phone;
$desc= $data ->descripcion;
$id_esp= $data -> id_especialidad;

try {
    $sqlPac= mysqli_query($conexionBD,"UPDATE profesional SET nombre='$nombre', apellido='$apellido',
 tel_celular='$celular' ,email='$correo', descripcion = '$desc',
 id_especialidad = '$id_esp' WHERE num_matricula='$matricula'");
echo json_encode(['PROFESIONAL ACTUALIZADO CORRECTAMENTE']);

} catch (\Throwable $th) {
    echo json_encode('Ha ocurrido un error'.$th);
}

exit();
}

////////////////////////////ESPECIALIDADES/////////////////////////////


if(isset($_GET['especialidad'])){

  try{$sqlEsp= mysqli_query($conexionBD, "SELECT id_especialidad, nombre, descripcion FROM especialidad");
    if(mysqli_num_rows($sqlEsp) > 0){
      $espes = mysqli_fetch_all($sqlEsp, MYSQLI_ASSOC);
      echo json_encode($espes);
    
    } else{
      echo json_encode("NO SE ENCONTRARON ESPECIALIDADES");
    }
  } catch(Exception $e){
      echo json_encode($e-> getMessage());
    }

 exit();
}

////////////////////////////CONTAR PROFESIONALES////////////////////////////
if(isset($_GET['contarPro'])){
      
        
  try{

    $sqlCuenta= ("SELECT COUNT(num_matricula) total FROM profesional");
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

//////////////////////////////LISTAR PROFESIONALES////////////////////////////
$sqlProf= mysqli_query($conexionBD,"SELECT num_matricula, nombre, apellido,
DNI, tel_celular, email, fecha_nacimiento, descripcion, id_especialidad FROM profesional");
if(mysqli_num_rows($sqlProf) > 0){
    $pros = mysqli_fetch_all($sqlProf,MYSQLI_ASSOC);
    echo json_encode($pros);
}
else{ echo json_encode("NO HAY PROFESIONALES REGISTRADOS"); }
    




        
        


?>
