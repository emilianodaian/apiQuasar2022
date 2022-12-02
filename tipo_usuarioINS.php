<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

include('bd.php');


        $data = json_decode(file_get_contents("php://input"));
           
    $nombre=$data->nombre;
    $apellido=$data->apellido;
    $dni=$data -> DNI;
    $correo= $data -> email;
    $password = $data -> newpass;
    
    $celular = $data -> phone;
    $fn = $data -> dp;

    $tu = 2;
           
        
            try{
               $sqlBusca = mysqli_query($conexionBD, "SELECT  num_historia_clinica, nombre, apellido, DNI, tel_celular,
               email, fecha_nacimiento, tipo_usuario FROM paciente WHERE DNI =".$dni);
 
            if(mysqli_num_rows($sqlBusca)>0){
            echo json_encode("YA EXISTE UN PACIENTE CON ESTE DNI");  
         
            }else{

                $sqlPacientes = mysqli_query($conexionBD,"INSERT INTO paciente(nombre, apellido, DNI, tel_celular,
                email, contrasena, fecha_nacimiento, tipo_usuario)
                 VALUES('$nombre','$apellido','$dni','$celular','$correo','$password','$fn', $tu) ");
                echo json_encode("PACIENTE REGISTRADO CORRECTAMENTE");
            }

            }catch(Exception $e){

                echo json_encode($e->getMessage());
            }
        


?>
