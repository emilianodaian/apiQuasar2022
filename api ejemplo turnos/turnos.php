<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST, DELETE, UPDATE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

date_default_timezone_set('America/Argentina/Buenos_Aires');
include('bd.php');

/////NUEVO TURNO/////////////////////

if(isset($_GET['nuevoTurno'])){

    $data = json_decode(file_get_contents("php://input"));

    $fecha_hora = $data -> fecha_hora; 
    $num_matricula= $data -> num_matricula;
    $estado =$data ->estado;
    $descripcion =null;
    $hora_recp = null;
    $fecha_hora_cancelado = null;
    $num_historia_pac = null;
    $monto = null;
    $tipo_turno = $data -> tipo_turno_t;


    try {
        $sqlBusca = mysqli_query($conexionBD, "SELECT id_turno, fecha_hora from turno WHERE
            fecha_hora =' $fecha_hora ' and num_matricula = '$num_matricula'");

        if(mysqli_num_rows($sqlBusca)>0){
            echo json_encode("YA EXISTEN TURNOS CREADOS PARA ESTA FECHA Y HORA");
        }else{
            $sqlTurno = mysqli_query($conexionBD, "INSERT INTO turno(tipo_turno_t, descripcion, fecha_hora, hora_recepcion,
            fecha_hora_cancelado, num_historia_pac, num_matricula, monto, estado) VALUES ($tipo_turno, null, '$fecha_hora',
            null, null, null, '$num_matricula', null, 4)");
    
            if($sqlTurno){
                echo json_encode("TURNO REGISTRADO CORRECTAMENTE");
            }
            else{echo json_encode("ERROR");}
        }
        } catch (Exception $e) {
    
            echo json_encode($e->getMessage());
    
        }

       

    exit();
}

////////////////LISTAR TODOS LOS TURNOS DE UN PROFESIONAL///////////////////
if(isset($_GET['listar'])){

    $num_matricula = $_GET['listar'];

    try{
        $sqlLista=mysqli_query($conexionBD,"SELECT turno.id_turno, turno.descripcion, turno.fecha_hora, turno.hora_recepcion,
        turno.fecha_hora_cancelado, turno.num_historia_pac, turno.num_matricula, turno.monto, estado_turno.estado
         FROM estado_turno INNER JOIN turno ON estado_turno.id_estado_turno = turno.estado
          WHERE turno.num_matricula = '$num_matricula' ORDER BY turno.fecha_hora asc");

        if(mysqli_num_rows($sqlLista)>0){
            $turnos = mysqli_fetch_all($sqlLista,MYSQLI_ASSOC);
            echo json_encode($turnos);
            
        }
        else{  echo json_encode(["NO HAY TURNOS PARA MOSTRAR"]); }

    }catch(Exception $e){
        echo json_encode("OCURRIÓ UN ERROR");
    }


    exit();
}
//////////////////LISTAR TURNOS PROFESIONAL SEGÚN EL ESTADO////////////////////
if(isset($_GET['listarEstado'])){
   
   $num_matricula = $_GET['Mat'];
    $estado =$_GET['listarEstado'];

    try{
        $sqlLista=mysqli_query($conexionBD,"SELECT turno.id_turno, turno.descripcion, turno.fecha_hora, turno.hora_recepcion,
        turno.fecha_hora_cancelado, turno.num_historia_pac, turno.num_matricula, turno.monto, estado_turno.estado
         FROM estado_turno INNER JOIN turno ON estado_turno.id_estado_turno = turno.estado
          WHERE turno.estado= $estado AND turno.num_matricula = '$num_matricula' ORDER BY turno.fecha_hora desc");

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

////////////////////LISTAR ESTADO-TURNO/////////////////////////
if(isset($_GET['listEst'])){

    try{
        $sqlLista=mysqli_query($conexionBD,"SELECT * FROM estado_turno");

        if(mysqli_num_rows($sqlLista)>0){
            $estado = mysqli_fetch_all($sqlLista,MYSQLI_ASSOC);
            echo json_encode($estado);
            
        }
        else{  echo json_encode(["NO HAY ESTADOS PARA MOSTRAR"]); }

    }catch(Exception $e){
        echo json_encode("OCURRIÓ UN ERROR");
    }
    

    exit();
}

////////////////////////////MOSTRAR TURNO UNICO//////////////////////
if(isset($_GET['unico'])){

    $id_turno= $_GET['unico'];

    try{
        $sqlLista=mysqli_query($conexionBD,"SELECT turno.id_turno, tipo_turno.tipo_de_turno ,turno.descripcion, turno.fecha_hora, turno.hora_recepcion,
         turno.fecha_hora_cancelado, adminCancela.apellido as adminCancel, adminCancela.nombre as adminCancelNom
        ,adminAlta.apellido as adminApel, adminAlta.nombre as adminAltaNom , turno.fecha_hora_alta
         ,paciente.DNI, profesional.apellido, turno.monto, estado_turno.estado
         FROM turno 
         LEFT JOIN administrador as adminAlta ON turno.id_admin_alta = adminAlta.ID_admin
         LEFT JOIN administrador as adminCancela ON turno.id_admin_cancel = adminCancela.ID_admin
         LEFT JOIN estado_turno ON turno.estado = estado_turno.id_estado_turno
         LEFT JOIN paciente ON turno.num_historia_pac = paciente.num_historia_clinica
         LEFT JOIN profesional ON turno.num_matricula = profesional.num_matricula
         LEFT JOIN tipo_turno ON   turno.tipo_turno_t = tipo_turno.id_tipo_turno
          WHERE turno.id_turno = $id_turno ORDER BY turno.fecha_hora desc");

        if(mysqli_num_rows($sqlLista)>0){
            $turnos = mysqli_fetch_all($sqlLista,MYSQLI_ASSOC);
            echo json_encode($turnos);
            
        }
        else{  echo json_encode([$id_turno]); }

    }catch(Exception $e){
        echo json_encode("OCURRIÓ UN ERROR");
    }


    exit();
}

////////////////////////ACTUALIZA ESTADOS DE TURNOS/////////////////
if(isset($_GET['Expirado'])){
    
    

    $fecha_limite = $_GET['Expirado'];

    try{
        $sqlExp = mysqli_query($conexionBD, "UPDATE turno SET estado = IF(fecha_hora < '$fecha_limite' AND
        estado = 4, 5, estado)");

if($sqlExp){
    echo json_encode("TURNOS ACTUALIZADOS CORRECTAMENTE");
  }else{
    echo json_encode("ERROR");
  }
    }catch(Exception $e){
        echo json_encode("$e -> getMessage()");

    }

    exit();
}

/////////////////////BUSCAR AÑO TURNO//////////////////
if(isset($_GET['anio'])){

$num_matricula = $_GET['anio'];
$tipo_turno = $_GET['tipoT'];

try{
    $sqlYear=mysqli_query($conexionBD,"SELECT DISTINCT LEFT (fecha_hora, 4) as anio FROM turno WHERE num_matricula = '$num_matricula'
    and estado= 4 
    and tipo_turno_t = $tipo_turno order by fecha_hora asc");

    if(mysqli_num_rows($sqlYear)>0){
        $anios = mysqli_fetch_all($sqlYear,MYSQLI_ASSOC);
        echo json_encode($anios);
        
    }
    else{  echo json_encode(["NO HAY AÑOS DISPONIBLES PARA MOSTRAR"]); }

}catch(Exception $e){
    echo json_encode("OCURRIÓ UN ERROR");
}

}

///////////////////BUSCAR MES TURNO////////////////////////
if(isset($_GET['mes'])){

    $num_matricula = $_GET['matricula'];
    $anio = $_GET['mes'];
    $tipo_turno = $_GET['tt'];
    try{
        $sqlMes=mysqli_query($conexionBD,"SELECT DISTINCT SUBSTRING(fecha_hora, 6, 2) as mes FROM turno WHERE num_matricula = '$num_matricula'
        AND estado = 4 AND tipo_turno_t = $tipo_turno
        AND fecha_hora like '%$anio%' order by fecha_hora asc");
    
        if(mysqli_num_rows($sqlMes)>0){
            $meses = mysqli_fetch_all($sqlMes,MYSQLI_ASSOC);
            echo json_encode($meses);
            
        }
        else{  echo json_encode(["NO HAY MESES DISPONIBLES PARA MOSTRAR"]); }
    
    }catch(Exception $e){
        echo json_encode("OCURRIÓ UN ERROR");
    }
    
    exit();
    }
    
    ///////////////////BUSCAR DIA TURNO////////////////////////
if(isset($_GET['dia'])){

    $num_matricula = $_GET['dia'];
    $mes = $_GET['m3s'];
    $anio= $_GET['anyo'];
    $anioMes = $anio.'-'.$mes;
    $tipo_turno = $_GET["TT"];
    try{
        $sqlDia=mysqli_query($conexionBD,"SELECT DISTINCT SUBSTRING(fecha_hora, 9, 2) as dia FROM turno WHERE num_matricula = '$num_matricula'
        AND estado = 4 AND tipo_turno_t = $tipo_turno
        AND fecha_hora like '%$anioMes%' order by fecha_hora asc");
    
        if(mysqli_num_rows($sqlDia)>0){
            $dias = mysqli_fetch_all($sqlDia,MYSQLI_ASSOC);
            echo json_encode($dias);
            
        }
        else{  echo json_encode(["NO HAY DÍAS PARA MOSTRAR"]); }
    
    }catch(Exception $e){
        echo json_encode("OCURRIÓ UN ERROR");
    }
    
    exit();
    }

     ///////////////////BUSCAR HORAS TURNO////////////////////////
if(isset($_GET['fecha'])){

    $fecha= $_GET['fecha'];
    $num_matricula = $_GET['matHoras'];
    $tipo_turno = $_GET['titu'];
    try{
        $sqlHora=mysqli_query($conexionBD,"SELECT DISTINCT SUBSTRING(fecha_hora, 12, 5) as horas FROM turno WHERE num_matricula = '$num_matricula'
        AND estado = 4 AND tipo_turno_t = $tipo_turno
        AND fecha_hora like '%$fecha%' order by fecha_hora asc");
    
        if(mysqli_num_rows($sqlHora)>0){
            $horas = mysqli_fetch_all($sqlHora,MYSQLI_ASSOC);
            echo json_encode($horas);
            
        }
        else{  echo json_encode(["OCURRIÓ UN ERROR"]); }
    
    }catch(Exception $e){
        echo json_encode("OCURRIÓ UN ERROR");
    }
    
    exit();
    }

    /////////////////////////ASIGNAR UN TURNO DESDE ADMIN/////////////////////////
    if(isset($_GET['asignarTurno'])){
        $fecha_hora = $_GET['asignarTurno'];
        $num_hist = $_GET['historiaAsignar'];
        $matricula = $_GET['matAsignar'];
        $id_alta = 1;
        $fecha_hora_alta = $_GET['fecha_hora_alta'];
        try{

            $sqlAsignar = mysqli_query($conexionBD, "UPDATE turno SET num_historia_pac = $num_hist,
           id_admin_alta = 1, fecha_hora_alta='$fecha_hora_alta', estado = 1  WHERE
            fecha_hora = '$fecha_hora' AND num_matricula = '$matricula'");
    
    if($sqlAsignar){
        echo json_encode("TURNO ASIGNADO CORRECTAMENTE");
      }else{
        echo json_encode("ERROR");
      }
        }catch(
            Exception $e){
                echo json_encode( $e -> getMessage());}

        exit();
    }

    ///////////////////////////CANCELAR UN TURNO DESDE ADMIN///////////////////////////
    if(isset($_GET['cancel'])){

           $id_turno = $_GET['cancel'];
           $idAdmin = 1;
           $fecha_hora = $_GET['momento'];

           
           try{
                $sqlExiste = mysqli_query($conexionBD, "SELECT fecha_hora from turno where id_turno = $id_turno");

                if(mysqli_num_rows($sqlExiste)<0){
                    echo json_encode("NO EXISTE");

           }else{
                    $sqlCancela = mysqli_query($conexionBD, "UPDATE turno set estado = 3, id_admin_cancel = $idAdmin,
                   fecha_hora_cancelado = '$fecha_hora' where 
                    id_turno = $id_turno");

                    if($sqlCancela){
                        echo json_encode("TURNO CANCELADO CORRECTAMENTE");
                    }else{
                        echo json_encode("ERROR");
                    }

           } }
           catch(Exception $e){
            echo json_encode($e -> getMessage());
           }

        exit();
    }

    ////////////////////////////////////////HABILITAR TURNO CANCELADO/////////////////////////////
    if(isset($_GET['habilitar'])){

        $idTurno = $_GET['habilitar'];

        try{
            $sqlExiste = mysqli_query($conexionBD, "SELECT fecha_hora from turno where id_turno = $idTurno");

            if(mysqli_num_rows($sqlExiste)<0){
                echo json_encode("NO EXISTE");

       }else{
                $sqlHabilita = mysqli_query($conexionBD, "UPDATE turno set estado = 4, id_admin_cancel = null,
               fecha_hora_cancelado = null, fecha_hora_alta = null, id_admin_alta= null,
               num_historia_pac = null where 
                id_turno = $idTurno");

                if($sqlHabilita){
                    echo json_encode("TURNO HABILITADO CORRECTAMENTE");
                }else{
                    echo json_encode("ERROR");
                }

       } }
       catch(Exception $e){
        echo json_encode($e -> getMessage());
       }

        exit();
    }

    ////////////////////BORRAR TURNOS EXPIRADOS//////////////////////
    if(isset($_GET['borrarExp'])){

        $matPro = $_GET['borrarExp'];

        try{
            $sqlBorra= mysqli_query($conexionBD, "DELETE from turno WHERE num_matricula = '$matPro' and
            estado = 5 ");

            if($sqlBorra){
                echo json_encode("TURNOS BORRADOS CORRECTAMENTE");
            }else{
                echo json_encode("OCURRIÓ UN ERROR");
            }

        }catch(Exception $e){

            echo json_encode($e -> getMessage());
        }

        exit();
    }

    ///////////////////////////////AGREGAR TIPO TURNO//////////////////

    if(isset($_GET['tipoTurno'])){

        $data = json_decode(file_get_contents("php://input"));

        $tipo_turno = $data -> tipo_de_turno;
        $duracion = $data -> duracion;

        try{

            $sqlExiste = mysqli_query($conexionBD, "SELECT tipo_de_turno from tipo_turno WHERE tipo_de_turno = '$tipo_turno'");

            if(mysqli_num_rows($sqlExiste)>0 ){
                echo json_encode("YA EXISTE UN TIPO DE TURNO CON ESTE NOMBRE");
            } else{
                 
                $sqlTipoT = mysqli_query($conexionBD, "INSERT into tipo_turno(tipo_de_turno, duracion)
                VALUES ('$tipo_turno', $duracion) ");

                if($sqlTipoT){
                    echo json_encode("REGISTRO EXITOSO");
                }else{ echo json_encode("ERROR");}

            }

        }catch(Exception $e){
            echo json_encode($e -> getMessage());
        }

        exit();
    }

//////////////////////////LISTAR TIPO DE TURNO////////////////////////
if(isset($_GET['listarTipoTurno'])){

    try{
        $listaTipoTurno = mysqli_query($conexionBD, "SELECT id_tipo_turno, tipo_de_turno, duracion from tipo_turno");

        if(mysqli_num_rows($listaTipoTurno)> 0){
            $tiposTurno = mysqli_fetch_all($listaTipoTurno,MYSQLI_ASSOC);
            echo json_encode($tiposTurno);
            
        }else{
            echo json_encode(["NO HAY TIPOS PARA MOSTRAR"]);
        }
    }catch(Exception $e){
        echo json_encode($e -> getMessage());
    }

    exit();
}

///////////////BORRAR TIPO DE TURNO///////////////////////
if(isset($_GET['borrarTipoTurno'])){

    $id_tipo = $_GET['borrarTipoTurno'];

    try{
        $sqlBorra = mysqli_query($conexionBD, "DELETE from tipo_turno WHERE id_tipo_turno = $id_tipo");

        if($sqlBorra){
            echo json_encode("BORRADO EXITOSAMENTE");
        }else{
            echo json_encode("ERROR");
        }

    }catch(Exception $e){
        echo json_encode($e -> getMessage());
    }

    exit();
}

/////////////////CAMBIAR DURACION TIPO DE TURNO///////////////////
if(isset($_GET['cambiarDuracionTT'])){

    $id_tipo = $_GET['cambiarDuracionTT'];
    $duracion = $_GET['duracion'];

try{
      


            $sqlTiempo = mysqli_query($conexionBD, "UPDATE tipo_turno SET duracion = $duracion WHERE
            id_tipo_turno = $id_tipo");

            if($sqlTiempo){
                echo json_encode("ACTUALIZADO CORRECTAMENTE");
            }else{
                echo json_encode("ERROR");
            }   
        
    
}catch(Exception $e){
    echo json_encode($e -> getMessage());

}


    exit();
}

////////////BUSCAR TIPO DE TURNO UNICO POR ID///////////
if(isset($_GET['buscarTipoTUnico'])){

    $id_tipo = $_GET['buscarTipoTUnico'];

    try{

        $sqlBuscaUnico = mysqli_query($conexionBD, "SELECT id_tipo_turno, tipo_de_turno, duracion FROM 
        tipo_turno WHERE id_tipo_turno = $id_tipo");

        if(mysqli_num_rows($sqlBuscaUnico)>0){
            $tipoTurno = mysqli_fetch_all($sqlBuscaUnico,MYSQLI_ASSOC);
            echo json_encode($tipoTurno);
                
        }else{
            echo json_encode(['NO EXISTE']);
        }

    }catch(Exception $e){
        echo json_encode($e -> getMessage());
    }

    exit();
}

?>