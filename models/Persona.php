<?php

require_once 'Conexion.php';

class Persona extends Conexion{

  private $pdo;

  public function __CONSTRUCT(){
    $this->pdo = parent::getConexion();
  }

  public function add($params = []):int{
    $idgenerate = null;
    try{
      $query = $this->pdo->prepare("CALL spu_registrar_persona(?,?,?,?,?,?)");
      $query->execute(
        (array(
          $params['apepaterno'],
          $params['apematerno'],
          $params['nombres'],
          $params['nrodocumento'],
          $params['telprincipal'],
          $params['telsecundario']
        ))
      );
      $row = $query->fetch(PDO::FETCH_ASSOC);
      $idgenerate = $row['idpersona']; 
    }
    catch(Exception $e){
       $idgenerate = -1;
    }

    return $idgenerate;
  }

  public function buscarPorDni($params = []):array{
    try{
      $query = $this->pdo->prepare("CALL spu_usuario_buscar_dni(?)");
      $query->execute(
        array(
          $params['nrodocumento'])
        );
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }
}