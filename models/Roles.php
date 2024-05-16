<?php

require_once 'Conexion.php';

class Roles extends Conexion{

  private $pdo;

  public function __CONSTRUCT(){
    $this->pdo = parent::getConexion();
  }

  public function getAll(){
    try{
      $query = $this->pdo->prepare("CALL spu_roles_listar()");
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }
}