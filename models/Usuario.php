<?php

require_once 'Conexion.php';

class Usuario extends Conexion{
  private $pdo;

  public function __CONSTRUCT(){
    $this->pdo = parent::getConexion();
  }

  public function login($params = []):array{
    try{
      $query = $this->pdo->prepare("CALL spu_colaborador_login(?)");
      $query->execute(array($params['nomusuario']));
      return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function add($params = []):int{
    $idcolaborador = null;
    try{
      $query = $this->pdo->prepare("CALL spu_registrar_colaborador(?,?,?,?)");
      $query->execute(
        array(
        $params['idpersona'],
        $params['idrol'],
        $params['nomusuario'],
        password_hash($params['passusuario'], PASSWORD_BCRYPT)
        )
      );
      $row = $query->fetch(PDO::FETCH_ASSOC);
      $idcolaborador = $row['idcolaborador'];
    }catch(Exception $e){
      $idcolaborador = -1;
    }
    return $idcolaborador;
  }

  public function listarPersona(){
    try{
      $consulta = $this->pdo->prepare("CALL spu_colaboradores_listar()");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      die($e->getMessage());
    }
  }
}