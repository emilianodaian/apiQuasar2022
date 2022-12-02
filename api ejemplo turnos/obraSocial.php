<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST, DELETE, UPDATE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include('bd.php');

////////////////////////////////NUEVA OBRA ////////////////////////////////

if(isset($_GET['insertar'])){
    $data = json_decode(file_get_contents("php://input"));
           
    $nombre=$data->razon_social;
    $abreviatura=$data->razon_social_abrv;
    
   
    if($nombre == ""){
      echo json_encode("ERROR");
    }else{

      try{
        $sqlExiste = mysqli_query($conexionBD, "SELECT razon_social FROM obra_social WHERE razon_social ='$nombre'");
         
     if(mysqli_num_rows($sqlExiste) > 0){
       echo json_encode("YA EXISTE UNA OBRA CON ESTE NOMBRE");  
      
     }else{ 
         $sqlObra= mysqli_query($conexionBD,"INSERT INTO obra_social(razon_social, razon_social_abrv)
       VALUES('$nombre','$abreviatura') ");

    if($sqlObra){echo json_encode("OBRA SOCIAL REGISTRADA CORRECTAMENTE");
    }else{echo json_encode("OCURRIÓ UN ERROR EN EL REGISTRO");}

  }
}catch(Exception $e){

         echo json_encode($e->getMessage());
     }
    }
    
    exit();
}

//////////////////////BORRAR OBRA//////////////////////////////////
if(isset($_GET['borrar'])){

 


  try{
    $sqlObra = mysqli_query($conexionBD,"DELETE FROM obra_social WHERE ID_obra_social=".$_GET["borrar"]);
    
    if($sqlObra){
        echo json_encode("OBRA SOCIAL BORRADA CORRECTAMENTE");
        
    }
    else{  echo json_encode( "No puedes borrarla si tienes profesionales o pacientes bajo este servicio");
    }
    
    }catch(Exception $e){
    
        echo json_encode($e->getMessage());
    }

  exit();
}

////////////////OBRA UNICA/////////////////////////////

if(isset($_GET["consultar"])){

  try{
    $id_obra = $_GET["consultar"];
  
    $sqlObra = mysqli_query($conexionBD,"SELECT ID_obra_social, razon_social,
    razon_social_abrv FROM obra_social
     WHERE ID_obra_social= $id_obra");
    
    if(mysqli_num_rows($sqlObra)>0){
        $obras = mysqli_fetch_all($sqlObra,MYSQLI_ASSOC);
        echo json_encode($obras);
        
    }
    else{  echo json_encode(["Esta obra social no está disponible"]); }
  
  }catch(Exception $e){
   echo json_encode($e -> getMessage());
  }
  exit();
  }

  ///////////////////REGISTRAR OBRA-PROFESIONAL////////////////////

  if (isset($_GET['AgregarObProf'])){
    $data = json_decode(file_get_contents("php://input"));

    try{
      $matricula = $_GET['AgregarObProf'];
      $id_obra = $data -> AgregarObra;

      $sqlExiste = mysqli_query($conexionBD, "SELECT obra_social FROM obra_profesional WHERE 
      num_matricula_prof = '$matricula' AND obra_social=$id_obra");

      if(mysqli_num_rows($sqlExiste)>0){
        echo json_encode("ESTE PROFESIONAL YA OFRECE SERVICIO DE ESTA OBRA");
      }else{  
        
      $sqlObraProf = mysqli_query($conexionBD, "INSERT INTO obra_profesional (num_matricula_prof,
      obra_social) VALUES ('$matricula', $id_obra)");

      if($sqlObraProf){
        echo json_encode("OBRA SOCIAL REGISTRADA CORRECTAMENTE");
      }else{
        echo json_encode("OCURRIÓ UN ERROR");
        echo json_encode($id_obra);
      }
      }
 }
    catch(Exception $e){
      echo json_encode($e -> getMessage());
    } exit();
  }

  ////////////////////LISTAR OBRAS-PROFESIONAL/////////////////////
  if(isset($_GET['listarObProf'])){

    $matricula = $_GET['listarObProf'];

    try{

      $sqlObraProf = mysqli_query($conexionBD, "SELECT obra_social.razon_social_abrv, obra_social.ID_obra_social FROM obra_profesional 
     INNER JOIN obra_social ON obra_profesional.obra_social = obra_social.ID_obra_social
      WHERE obra_profesional.num_matricula_prof = '$matricula'");

  if(mysqli_num_rows($sqlObraProf)>0){
  $obrasProfs = mysqli_fetch_all($sqlObraProf,MYSQLI_ASSOC);
  echo json_encode($obrasProfs); 
  }

    else{  echo json_encode(["No hay nada para mostrar"]); }

    } 
    catch(Exception $e){
        echo json_encode($e -> getMessage());
    }
    exit();
  }


////////////////////////BORRAR OBRA PROFESIONAL////////////////

if(isset($_GET['borrarObProf'])){
  $data = json_decode(file_get_contents("php://input"));

  $matricula = $_GET['borrarObProf'];
  $id_obra = $data -> BorrarObra;

  try{
    $sqlBorrarObProf = mysqli_query($conexionBD, "DELETE FROM obra_profesional WHERE 
    num_matricula_prof = '$matricula' AND obra_social = $id_obra");

    if($sqlBorrarObProf){
      echo json_encode("SERVICIO ELIMINADO CORRECTAMENTE");
    }else{echo json_encode($id_obra);}
  }
  catch(Exception $e){ echo json_encode($e -> getMessage());}


  exit();
}

  ///////////////////REGISTRAR OBRA-PACIENTE////////////////////

  if (isset($_GET['AgregarObPac'])){
    $data = json_decode(file_get_contents("php://input"));

    try{
      $num_historia= $_GET['AgregarObPac'];
      $id_obra = $data -> AgregarObra;

      $sqlExiste = mysqli_query($conexionBD, "SELECT id_obra_social FROM obra_paciente WHERE 
      num_historia_pac = '$num_historia' AND id_obra_social=$id_obra");

      if(mysqli_num_rows($sqlExiste)>0){
        echo json_encode("ESTE PACIENTE YA CUENTA CON ESTA OBRA");
      }else{  
        
      $sqlObraProf = mysqli_query($conexionBD, "INSERT INTO obra_paciente (num_historia_pac,
      id_obra_social) VALUES ($num_historia, $id_obra)");

      if($sqlObraProf){
        echo json_encode("OBRA SOCIAL REGISTRADA CORRECTAMENTE");
      }else{
        echo json_encode("OCURRIÓ UN ERROR");
    
      }
      }
 }
    catch(Exception $e){
      echo json_encode($e -> getMessage());
    } exit();
  }

   ////////////////////LISTAR OBRAS-PACIENTE/////////////////////
   if(isset($_GET['listarObPac'])){

    $num_historia= $_GET['listarObPac'];

    try{

      $sqlObraPac = mysqli_query($conexionBD, "SELECT obra_social.razon_social_abrv, obra_social.ID_obra_social FROM obra_paciente 
     INNER JOIN obra_social ON obra_paciente.id_obra_social = obra_social.ID_obra_social
      WHERE obra_paciente.num_historia_pac = $num_historia");

  if(mysqli_num_rows($sqlObraPac)>0){
  $obrasPacs = mysqli_fetch_all($sqlObraPac,MYSQLI_ASSOC);
  echo json_encode($obrasPacs); 
  }

    else{  echo json_encode(["No hay nada para mostrar"]); }

    } 
    catch(Exception $e){
        echo json_encode($e -> getMessage());
    }
    exit();
  }

////////////////////BORRAR OBRA-PACIENTE//////////////////////////////////

if(isset($_GET['borrarObPac'])){
  $data = json_decode(file_get_contents("php://input"));

  $historia = $_GET['borrarObPac'];
  $id_obra = $data -> BorrarObra;

  try{
    $sqlBorrarObPac = mysqli_query($conexionBD, "DELETE FROM obra_paciente WHERE 
    num_historia_pac = $historia AND id_obra_social = $id_obra");

    if($sqlBorrarObPac){
      echo json_encode("SERVICIO ELIMINADO CORRECTAMENTE");
    }
    else{echo json_encode("OCURRIÓ UN ERROR");}
  }
  catch(Exception $e){ echo json_encode($e -> getMessage());}


  exit();
}

  //////////////////ACTUALIZAR OBRA///////////////////////////////
  if(isset($_GET["actualizar"])){

    $data = json_decode(file_get_contents("php://input"));

$id_obra=$_GET["actualizar"];
$nombre=$data->razon_social;
$abreviatura=$data->razon_social_abrv;

try{
  $sqlObra = mysqli_query($conexionBD, "UPDATE obra_social SET razon_social= '$nombre', razon_social_abrv = '$abreviatura' 
  WHERE ID_obra_social =$id_obra");

  if($sqlObra){
    echo json_encode("OBRA ACTUALIZADA CORRECTAMENTE");
  }else{
    echo json_encode("OCURRIÓ UN ERROR");
  }
}
catch(Exception $e){
  echo json_encode($e -> getMessage());  
}

    exit();
  }

  ///////////////////CONTAR OBRA-PACIENTE/////////////////////
  if(isset($_GET['contarPac'])){
    $id_obra = $_GET['contarPac'];
    
    try{

      $sqlCuenta= ("SELECT COUNT(id_obra_pac) total FROM obra_paciente WHERE 
      id_obra_social=$id_obra");
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

///////////////////CONTAR OBRA-PROFESIONAL////////////////////
if(isset($_GET['contarPro'])){
  $id_obra = $_GET['contarPro'];
  
  try{

    $sqlCuenta= ("SELECT COUNT(id_obra_prof) total FROM obra_profesional WHERE 
    obra_social=$id_obra");
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

////////////////////////////CONTAR PROFESIONALES////////////////////////////
if(isset($_GET['contarObra'])){
      
        
  try{

    $sqlCuenta= ("SELECT COUNT(ID_obra_social) total FROM obra_social");
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


////////////////////////LISTAR OBRAS///////////////////////////////

try{
  $sqlObra = mysqli_query($conexionBD, "SELECT * FROM obra_social");
  if(mysqli_num_rows($sqlObra)>0){
    $obras = mysqli_fetch_all($sqlObra, MYSQLI_ASSOC);

    echo json_encode($obras);
  }else{
    $obras = mysqli_fetch_all($sqlObra, MYSQLI_ASSOC);
  }
}catch(Exception $e){
  echo json_encode($e ->getMessage());
}



?>