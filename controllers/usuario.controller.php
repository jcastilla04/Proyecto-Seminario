<?php
session_start();
require_once '../models/Usuario.php';

$colaborador = new Usuario();

if(isset($_GET['operacion'])){
  switch($_GET['operacion']){
    case 'login':
      $login = [
        "permitido" => false,
        "apepaterno" => "",
        "apematerno" => "",
        "nombres" => "",
        "idcolaborador" => "",
        "status" => ""
      ];

      $row = $colaborador->login(['nomusuario' => $_GET['nomusuario']]);
      if(count($row) == 0){
        $login["status"] = "No existe el usuario";
      }else{
        $claveEncriptada = $row[0]['passusuario'];
        $claveIngreso = $_GET['passusuario'];

        if(password_verify($claveIngreso, $claveEncriptada)){
          $login["permitido"] = true;
          $login["apepaterno"] = $row[0]["apepaterno"];
          $login["apematerno"] = $row[0]["apematerno"];
          $login["nombres"] = $row[0]["nombres"];
          $login["idcolaborador"] = $row[0]["idcolaborador"];
        }else{
          $login["status"] = "Contreaseña incorrecta";
        }
      }

      //Enviamos los datos
      $_SESSION['login'] = $login;
      echo json_encode($login);
      break;

      case 'destroy':
        session_unset();
        session_destroy();
        header('Location:http://localhost/ProyectoFinal/');
        break;
  }
}

if(isset($_POST['operacion'])){
  switch($_POST['operacion']){
    case 'add':
      $datos = [
        "idpersona" => $_POST['idpersona'],
        "idrol" => $_POST['idrol'],
        "nomusuario" => $_POST['nomusuario'],
        "passusuario" => $_POST['passusuario']
      ];
      $idobtenido = $colaborador->add($datos);
      echo json_encode(["idcolaborador" => $idobtenido]);
  }
}

if(isset($_GET['operacion'])){
  switch($_GET['operacion']){
    case 'listarPersona':
      echo json_encode($colaborador->listarPersona());
      break;
  }
}