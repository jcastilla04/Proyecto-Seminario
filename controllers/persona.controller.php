<?php
require_once '../models/Persona.php';

$persona = new Persona();

if(isset($_POST['operacion'])){
  switch($_POST['operacion']){
    case 'add':
      $datos = [
        "apepaterno" => $_POST['apepaterno'],
        "apematerno" => $_POST['apematerno'],
        "nombres" => $_POST['nombres'],
        "nrodocumento" => $_POST['nrodocumento'],
        "telprincipal" => $_POST['telprincipal'],
        "telsecundario" => $_POST['telsecundario']
      ];
      $idobtenido = $persona->add($datos);
      echo json_encode(['idpersona' => $idobtenido]);
      break;
  }
}

if(isset($_GET['operacion'])){
  switch($_GET['operacion']){
    case 'buscarPorDni':
      echo json_encode($persona->buscarPorDni(['nrodocumento' => $_GET['nrodocumento']]));
      break;
  }
}