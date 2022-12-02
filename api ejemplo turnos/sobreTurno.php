<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST, DELETE, UPDATE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

date_default_timezone_set('America/Argentina/Buenos_Aires');
include('bd.php');


////////////////////ASIGNAR SOBRE TURNO/////////////////////
if(isset($_GET['asignarSobreT'])){

    $data = json_decode(file_get_contents("php://input"));

    $fecha_sobreTurno = $data -> fecha_hora;
    $num_matricula = $data -> num_matricula;
    $num_paciente = $data -> num_historia;
    $estado = $data -> estado;
    $id_alta = 1;
    $fecha_horaAlta = $_GET['asignarSobreT'];

    try{

        $sqlBusca = mysqli_query($conexionBD, "SELECT fecha_hora from sobreturno WHERE 
        fecha_hora = '$fecha_sobreTurno' AND num_matricula = '$num_matricula'");

        if(mysqli_num_rows($sqlBusca)>0){
            echo json_encode("YA EXISTE UN SOBRETURNO EN ESTA FECHA");
        }else{

            $sqlAsignarSobreT = mysqli_query($conexionBD,"INSERT INTO sobreturno(fecha_hora, fecha_hora_alta,
            num_historia, num_matricula,
            id_alta, estado) VALUES ('$fecha_sobreTurno',' $fecha_horaAlta', $num_paciente, '$num_matricula',
            $id_alta, $estado)");

            if($sqlAsignarSobreT){
                echo json_encode("SOBRETURNO ASIGNADO CORRECTAMENTE");
            }else{
                echo json_encode("ERROR");
            }

        }

    }
        catch(Exception $e){
        echo json_encode($e -> getMessage());
    }


    exit();
}


////////////LISTAR TODOS LOS SOBRETURNOS////////////////////
if(isset($_GET['listarTodos'])){

    try{

         $sqlListarTodos = mysqli_query($conexionBD, "SELECT id_sobreturno, fecha_hora, num_historia, num_matricula,
         estado FROM sobreturno");

         if(mysqli_num_rows($sqlListarTodos) > 0){

            $sobreturnos = mysqli_fetch_all($sqlListarTodos, MYSQLI_ASSOC);
            echo json_encode($sobreturnos);
         }else{
            echo json_encode(['NO HAY SOBRETURNOS']);
         }

    }catch(Exception $e){
        echo json_encode($e ->getMessage());
    }


    exit();
}

///////////////////LISTAR SOBRE TURNOS SEGUN PROFESIONAL////////////////////////////
if(isset($_GET['listarSTpro'])){

    $num_matricula = $_GET['listarSTpro'];

    try{
        $sqlLista=mysqli_query($conexionBD,"SELECT sobreturno.id_sobreturno, 
       sobreturno.fecha_hora, 
       sobreturno.num_historia, sobreturno.num_matricula, estado_turno.estado
         FROM estado_turno INNER JOIN sobreturno ON estado_turno.id_estado_turno = sobreturno.estado
          WHERE sobreturno.num_matricula = '$num_matricula' ORDER BY sobreturno.fecha_hora asc");

        if(mysqli_num_rows($sqlLista)>0){
            $sobreturnos = mysqli_fetch_all($sqlLista,MYSQLI_ASSOC);
            echo json_encode($sobreturnos);
            
        }
        else{  echo json_encode(["NO HAY SOBRETURNOS PARA MOSTRAR"]); }

    }catch(Exception $e){
        echo json_encode("OCURRIÓ UN ERROR");
    }


    exit();
}

////////LISTAR SOBRETURNO SEGUN PRO Y ESTADO///////////////////
if(isset($_GET['STest'])){

    $estado = $_GET['STest'];
    $num_matricula= $_GET['STpro'];

    try{
        $sqlLista=mysqli_query($conexionBD,"SELECT sobreturno.id_sobreturno, 
       sobreturno.fecha_hora, 
       sobreturno.num_historia, sobreturno.num_matricula, estado_turno.estado
         FROM estado_turno INNER JOIN sobreturno ON estado_turno.id_estado_turno = sobreturno.estado
          WHERE sobreturno.num_matricula = '$num_matricula' AND sobreturno.estado = $estado
           ORDER BY sobreturno.fecha_hora asc");

        if(mysqli_num_rows($sqlLista)>0){
            $sobreturnos = mysqli_fetch_all($sqlLista,MYSQLI_ASSOC);
            echo json_encode($sobreturnos);
            
        }
        else{  echo json_encode(["NO HAY SOBRETURNOS PARA MOSTRAR"]); }

    }catch(Exception $e){
        echo json_encode("OCURRIÓ UN ERROR");
    }
    
    exit();
}

/////////////////////////OBTENER SOBRETURNO ÚNICO//////////////////////////
if(isset($_GET['sobreTunico'])){

    $id_sobreturno = $_GET['sobreTunico'];

    try{
        $sqlLista=mysqli_query($conexionBD,"SELECT sobreturno.id_sobreturno, 
        sobreturno.fecha_hora, sobreturno.fecha_hora_alta,
         sobreturno.fecha_hora_cancela, sobreturno.hora_recepcion, sobreturno.hora_comienzo_atencion,
         adminCancela.apellido as adminCancel, adminCancela.nombre as adminCancelNom,
        adminAlta.apellido as adminApel, adminAlta.nombre as adminAltaNom
         ,paciente.DNI, profesional.apellido, sobreturno.monto, estado_turno.estado
         FROM sobreturno 
         LEFT JOIN administrador as adminAlta ON sobreturno.id_alta = adminAlta.ID_admin
         LEFT JOIN administrador as adminCancela ON sobreturno.id_cancela = adminCancela.ID_admin
         LEFT JOIN estado_turno ON sobreturno.estado = estado_turno.id_estado_turno
         LEFT JOIN paciente ON sobreturno.num_historia = paciente.num_historia_clinica
         LEFT JOIN profesional ON sobreturno.num_matricula = profesional.num_matricula
          WHERE sobreturno.id_sobreturno = $id_sobreturno ORDER BY sobreturno.fecha_hora desc");

        if(mysqli_num_rows($sqlLista)>0){
            $sobreturnos = mysqli_fetch_all($sqlLista,MYSQLI_ASSOC);
            echo json_encode($sobreturnos);
            
        }
        else{  echo json_encode([$id_sobreturno]); }

    }catch(Exception $e){
        echo json_encode(["OCURRIÓ UN ERROR"]);
    }

    exit();


}

 ////////////////////////////CANCELAR SOBRETURNO/////////////////////
 if(isset($_GET['cancelST'])){

    $idST = $_GET['cancelST'];
    $hora_cancela = $_GET['hora_cancela'];
    $idAdmin = 1;

    try{
        $sqlExiste = mysqli_query($conexionBD, "SELECT fecha_hora from sobreturno where id_sobreturno = $idST");

        if(mysqli_num_rows($sqlExiste)<0){
            echo json_encode("NO EXISTE");

   }else{
            $sqlCancela = mysqli_query($conexionBD, "UPDATE sobreturno set estado = 3, id_cancela = $idAdmin,
           fecha_hora_cancela = '$hora_cancela' where 
            id_sobreturno = $idST");

            if($sqlCancela){
                echo json_encode("SOBRETURNO CANCELADO CORRECTAMENTE");
            }else{
                echo json_encode("ERROR");
            }

   } }
   catch(Exception $e){
    echo json_encode($e -> getMessage());
   }


    exit();
 }

/////////////////////////BORRAR SOBRETURNO///////////////////////////////
if(isset($_GET['borrarST'])){

    $idST = $_GET['borrarST'];

    try{

        $sqlBorra = mysqli_query($conexionBD, "DELETE from sobreturno WHERE id_sobreturno = $idST");

        if($sqlBorra){

            echo json_encode("SOBRETURNO BORRADO CORRECTAMENTE");
        }else{
            echo json_encode("ERROR");
        }
    }catch(Exception $e){
        echo json_encode($e -> getMessage());
    }

    exit();
}
?>