<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST, DELETE, UPDATE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

date_default_timezone_set('America/Argentina/Buenos_Aires');
include('bd.php');

///////////////NUEVO TURNO KINESIOLOGIA////////////
if(isset($_GET['nuevoTurnoK'])){

    $data = json_decode(file_get_contents("php://input"));

    $fecha_hora = $data -> fecha_hora;
    $tipo_turno = $data -> tipo_turno_k;
    $matricula = $data -> num_matricula_k;
    $estado = $data -> estado_turnoK;

    try{

        $sqlExiste = mysqli_query($conexionBD, "SELECT id_turno_kinesio from turno_kinesio WHERE
        fecha_hora = '$fecha_hora' AND num_matricula_k = '$matricula' ");

        if(mysqli_num_rows($sqlExiste)> 0){
            echo json_encode("YA EXISTE UN TURNO CREADO PARA ESTA FECHA DE ESTE PROFESIONAL");
        }else{

            $sqlTurnoK = mysqli_query($conexionBD, "INSERT INTO turno_kinesio(tipo_turno_k, fecha_hora, num_matricula_k,
            estado_turnoK) VALUES ($tipo_turno, '$fecha_hora', '$matricula', $estado) ");

            if($sqlTurnoK){
                echo json_encode("TURNOS DE KINESIOLOGIA CREADOS CORRECTAMENTE");
            }else{
                echo json_encode("ERROR");
            }

        }


    }catch(Exception $e){
        echo json_encode($e -> getMessage());
    }

    exit();
}

/////////////listar todos los turnos de un prof/////////////
if(isset($_GET['listarTodos'])){

    

    $matricula = $_GET['listarTodos'];

    try{
        $sqlListar = mysqli_query($conexionBD, "SELECT turno_kinesio.id_turno_kinesio,
        turno_kinesio.fecha_hora, turno_kinesio.num_matricula_k, estado_turno.estado as estado_turnoK
        FROM estado_turno INNER JOIN turno_kinesio on estado_turno.id_estado_turno =  turno_kinesio.estado_turnoK
        WHERE turno_kinesio.num_matricula_k = '$matricula' order by turno_kinesio.fecha_hora asc ");

        if(mysqli_num_rows($sqlListar)>0){
            $turnosK = mysqli_fetch_all($sqlListar, MYSQLI_ASSOC);
            echo json_encode($turnosK);
        }
        else{
            echo json_encode(["NO HAY TURNOS DISPONIBLES"]);
        }

    }catch(Exception $e){

        echo json_encode($e ->getMessage());
    }


    exit();
}

////////////////LISTAR TURNOS PROFESIONAL SEGUN ESTADO//////////
if(isset($_GET['turnoEstadoK'])){

    $data = json_decode(file_get_contents("php://input"));

    $matricula = $data -> id_pro;
    $estado = $data -> estado_turno;

    try{
        $sqlLista=mysqli_query($conexionBD,"SELECT turno_kinesio.id_turno_kinesio,
        turno_kinesio.fecha_hora, turno_kinesio.num_matricula_k, estado_turno.estado as estado_turnoK
        FROM estado_turno INNER JOIN turno_kinesio on estado_turno.id_estado_turno =  turno_kinesio.estado_turnoK
        WHERE turno_kinesio.num_matricula_k = '$matricula'
        AND turno_kinesio.estado_turnoK = $estado order by turno_kinesio.fecha_hora asc ");

        if(mysqli_num_rows($sqlLista)>0){
            $turnos = mysqli_fetch_all($sqlLista,MYSQLI_ASSOC);
            echo json_encode($turnos);
            
        }
        else{  echo json_encode([$estado]); }

    }catch(Exception $e){
        echo json_encode("OCURRIÓ UN ERROR");
    }


    exit();
}


//////////////////MARCAR TURNOS KINESIO COMO EXPIRADOS/////////////
   if(isset($_GET['turnosKExp'])){
    
    
    $fecha_limite = $_GET['turnosKExp'];

    try{
        $sqlExp = mysqli_query($conexionBD, "UPDATE turno_kinesio SET estado_turnoK = IF(fecha_hora < '$fecha_limite' AND
        estado_turnoK = 4, 5, estado_turnoK)");

if($sqlExp){
    echo json_encode("TURNOS KINESIO ACTUALIZADOS CORRECTAMENTE");
  }else{
    echo json_encode("ERROR");
  }
    }catch(Exception $e){
        echo json_encode("$e -> getMessage()");

    }

    exit();
   } 

   /////////////////BORRAR TURNOS EXPIRADOS//////////////////
   if(isset($_GET['borrarExpK'])){
    $data = json_decode(file_get_contents("php://input"));

    $matricula = $data -> id_pro;

    try{
        $sqlBorra= mysqli_query($conexionBD, "DELETE from turno_kinesio WHERE num_matricula_k = 
        '$matricula' and estado_turnoK = 5 ");

        if($sqlBorra){
            echo json_encode("TURNOS KINESIO BORRADOS CORRECTAMENTE");
        }else{
            echo json_encode("OCURRIÓ UN ERROR");
        }

    }catch(Exception $e){

        echo json_encode($e -> getMessage());
    }

    exit();
   }

   //////////////ASIGNAR TURNO DESDE ADMIN////////////////
   if(isset($_GET['asignarTK'])){
    $data = json_decode(file_get_contents("php://input"));

        

    exit();
   }

?>