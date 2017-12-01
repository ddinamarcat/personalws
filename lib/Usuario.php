<?php
class Usuario {
	private $bdd;

	public function __construct(){
		$this->bdd = $this->conectar();
	}
	public function conectar(){
        global $namedb, $userdb, $passdb, $hostdb;
		return new BddMySql($hostdb,$userdb,$passdb,$namedb);
	}
	public function ingresar($a,$b){
		global $dbname;
		if($this->bdd->conectar()){

			$sql = "SELECT idusuario, user, email, pass, tipo, nombre, apellido FROM ".$dbname.".usuarios WHERE email = ? AND pass = ?";
			$tdp = "ss";
			$parametros = array($a,$b);
			$campos = array('idusuario','user','email','pass','tipo','nombre','apellido');
			$r = $this->bdd->ejecutar($sql,$parametros,$tdp,$campos[0],$campos[1],$campos[2],$campos[3],$campos[4],$campos[5],$campos[6]);
			if(count($r)!=0){
				$_SESSION['id'] = $r[0][0]; //id
				$_SESSION['user'] = $r[0][1];
                $_SESSION['email'] = $r[0][2];
                $_SESSION['tipo'] = $r[0][4];
                $_SESSION['nombre'] = $r[0][5];
                $_SESSION['apellido'] = $r[0][6];
				return true;
			}
			else{
				return false;
			}
		}
	}
}
?>
