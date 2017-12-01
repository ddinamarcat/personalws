<?php
class BddMySql{
	private $host;	 	//
	private $usuario;	//Datos para
	private $clave;		//la conexion
	private $bdd;		//
	private $stmt; // Objeto del tipo mysqli_stmt
	private $ref; // Objeto ReflectionClass de mysqli_stmt
	private $db;
	public $res; // Datos de la consulta (si es que es un select)

 	/* Funciona bien - Revisado */
	public function __construct($h,$u,$c,$b){
		$this->host = $h;
		$this->usuario = $u;
		$this->clave = $c;
		$this->bdd = $b;
		$this->stmt = false;
		$this->db = new mysqli();
		$this->ref = new ReflectionClass('mysqli_stmt');
		$this->res = array();
	}
 	/* Funciona bien - Revisado */
	public function conectar() {
		$this->db->init();
		//$this->db->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE,1,1);
		if(!$this->db->real_connect($this->host, $this->usuario, $this->clave, $this->bdd)){
			echo "La conexi&oacute;n a la base de datos <strong>'".$this->host."'</strong> ha fallado, verifique la configuraci&oacute;n... <br/>";
			return false;
		}
        $this->db->set_charset("utf8");
		return true;
	}
 	/* Funciona bien - Revisado */
	public function preparar($d,$sql) {
		$this->stmt = $this->db->prepare($sql);
		$this->ref = new ReflectionClass('mysqli_stmt');
		$m = $this->ref->getMethod('bind_param');
        if($d[0] == null) return true;
		if($m->invokeArgs($this->stmt, $d)){
			return true;
		}
		return false;

	}

	public function obtenerDatos($c) {
		$this->res = array();
		$this->stmt->execute();
		$this->stmt->store_result();
		$m = $this->ref->getMethod('bind_result');
		$m->invokeArgs($this->stmt, $c);
		$j = 0;
		while($this->stmt->fetch()) {
			$i = 0;
			foreach($c as $t){
				$this->res[$j][] = $t;
				$i++;
			}
			$j++;
		}
	}

	public function finalizar() {
		if(!$this->stmt){
			echo "No ha preparado la consulta.<br/>";
		}
		else{
			$this->stmt->close();
			$this->db->close();
		}
	}

 	/* Ejecuta una sentencia SQL y los almacena en $this->res
	 * $sql = string con la sentencia SQL con ? como valores de los parametros
	 * $parametros = array con los valores de los parametros a ser reemplazados en
	 *		 los ? respectivos (deben ir en el mismo orden).
	 * $tdp = string que representa los tipos de datos de los parametros, por ejemplo:
	 *        - $tdp = "idsbss" Parametros (1: entero, 2:double, 3:string, 4:blob, 5:string, 6:string)
	 * $campos = array("nombre","apellido","email"); llevan como valores los nombres de los atributos requeridos
	 */
	public function ejecutar($sql, $parametros, $tdp, &...$campos) {
		//Inicio de crear un array que contiene elementos correspondiente a las referencias
		//de los elementos de $parametros que podra ser usado por invokeArgs.
		$d = array(&$tdp);
		$i = 0;
		$total = count($parametros);
		for($i = 0; $i < $total;$i++){
			$d[$i+1] = &$parametros[$i];
		}
		//Fin de crear un array que contiene elementos correspondiente a las referencias
		//de los elementos de $parametros que podra ser usado por invokeArgs.
		$this->preparar($d,$sql);

		if($campos){
			foreach($campos as $a){
				$c[] = $a;
			}
			$this->obtenerDatos($campos);
			return $this->res;

		}

	}

	public function ejecutarSentencia() {
		$this->res = array();
		$this->stmt->execute();
		$this->stmt->store_result();
	}


	public function insertar($tabla, $parametros, $tdp, $campos=False) {
		//Inicio de crear la sentencia SQL, para insertar en una tabla, colocando los nombres
		//correspondientes de la tabla, atributos y '?'s dependiendo del numero de campos.
		$total = 0;
		foreach($campos as $a){
			if($total>0){
				$tparam .= ", ?";
				$tcampos.= ", ".$a;
			}
			else{
				$tparam = "?";
				$tcampos = $a;
			}
			$total++;
		}

		$sql = "INSERT INTO ".$this->bdd.".".$tabla."(".$tcampos.") VALUES (".$tparam.")";
		//Fin de crear la sentencia SQL, para insertar en una tabla, colocando los nombres
		//correspondientes de la tabla, atributos y '?'s dependiendo del numero de campos.

		//Inicio de crear un array que contiene elementos correspondiente a las referencias
		//de los elementos de $parametros que podra ser usado por invokeArgs.
		$d = array(&$tdp);
		$i = 0;
		for($i = 0; $i < $total;$i++){
			$d[$i+1] = &$parametros[$i];
		}
		//Fin de crear un array que contiene elementos correspondiente a las referencias
		//de los elementos de $parametros que podra ser usado por invokeArgs.
		$this->preparar($d,$sql);

		$this->ejecutarSentencia();

		//Detecta si hubo una insercion o no (NO USAR IGNORE)
		if($this->stmt->affected_rows>0){
			return 1;
		}
		else{
			return 0;
		}
	}
	//escribir condiciones como texto de la forma "x=? AND y=?"
	public function actualizar($tabla, $parametrosSet, $camposSet=False,$parametrosWhere,$condiciones, $tdp) {
		//Inicio de crear la sentencia SQL, para actualizar en una tabla, colocando los nombres
		//correspondientes de la tabla, atributos y '?'s dependiendo del numero de campos.
		$total = 0;
		foreach($camposSet as $a){
			if($total>0){
				$tcamposSet.= ", ".$a."=?";
			}
			else{
				$tcamposSet = $a."=?";
			}
			$total++;
		}
		$total = $total + count($parametrosWhere);
		$parametros = array_merge($parametrosSet,$parametrosWhere);

		$sql = "UPDATE ".$this->bdd.".".$tabla." SET ".$tcamposSet." WHERE ".$condiciones;
		//Fin de crear la sentencia SQL, para actualizar en una tabla, colocando los nombres
		//correspondientes de la tabla, atributos y '?'s dependiendo del numero de campos.

		//Inicio de crear un array que contiene elementos correspondiente a las referencias
		//de los elementos de $parametros que podra ser usado por invokeArgs.
		$d = array(&$tdp);
		$i = 0;
		for($i = 0; $i < $total;$i++){
			$d[$i+1] = &$parametros[$i];
		}
		//Fin de crear un array que contiene elementos correspondiente a las referencias
		//de los elementos de $parametros que podra ser usado por invokeArgs.

		$this->preparar($d,$sql);

		$this->ejecutarSentencia();

		//Detecta si hubo una actualizacion o no (NO USAR IGNORE)
		if($this->stmt->affected_rows>0){
			return $this->stmt->affected_rows;
		}
		else{
			return 0;
		}
	}

	public function eliminar($tabla, $parametros,$condiciones, $tdp) {
		//Inicio de crear la sentencia SQL, para eliminar en una tabla, colocando los nombres
		//correspondientes de la tabla, atributos y '?'s dependiendo del numero de campos.
		$total = count($parametros);

		$sql = "DELETE FROM ".$this->bdd.".".$tabla." WHERE ".$condiciones;
		//Fin de crear la sentencia SQL, para eliminar en una tabla, colocando los nombres
		//correspondientes de la tabla, atributos y '?'s dependiendo del numero de campos.

		//Inicio de crear un array que contiene elementos correspondiente a las referencias
		//de los elementos de $parametros que podra ser usado por invokeArgs.
		$d = array(&$tdp);
		$i = 0;
		for($i = 0; $i < $total;$i++){
			$d[$i+1] = &$parametros[$i];
		}
		//Fin de crear un array que contiene elementos correspondiente a las referencias
		//de los elementos de $parametros que podra ser usado por invokeArgs.
		$this->preparar($d,$sql);

		$this->ejecutarSentencia();

		//Detecta si hubo registros eliminados o no (NO USAR IGNORE)
		if($this->stmt->affected_rows>0){
			return $this->stmt->affected_rows;
		}
		else{
			return 0;
		}
	}
    function getLastInsertID($table){
        $result = "id";
        $va = "1";
        $tdp = "i";
        $sql    = $this->db->prepare("SELECT LAST_INSERT_ID() AS id FROM ".$this->host.".".$table."WHERE 1=?");
        $this->stmt->bind_param($tdp,$va);
        $sql->execute();
        $sql->bind_result($result);
        $sql->fetch();
        return $result;
    }
}
/*
//Ejemplo de como debe ser una conexion y una insercion

$bdd = new BddMySql('localhost','root','clave','dentosistema');
$longitud_salto = 5;
$clave = "12345";
$salto = substr(uniqid(rand(),true),0,$longitud_salto);

$hash_clave = hash('sha1',$clave.$salto);
if($bdd->conectar()){
	$tdp = "isssssisis";
	$parametros = array(17140943, 'jaimefortega', $hash_clave, 'Jaime', 'Ortega', 'jjortega@gmaill.coomm', 0, '2014-01-28 00:00:00', 0, '64');
	$campos = array('rut', 'usuario', 'hash', 'nombre', 'apellido', 'email', 'tipoDeUsuario', 'fechaDeIngreso', 'esDocente', 'rutId');
	echo "<br/>Insertados: ";
	echo $bdd->insertar('usuarios',$parametros,$tdp,$campos);
	$bdd->finalizar();
}

// Ejemplo de como debe ser una conexion y una actualizacion
$bdd = new BddMySql('localhost','root','clave','dentosistema');
if($bdd->conectar()){
	$tdp = "ssi";
	$condiciones = "tipoDeUsuario=?";
	$parametrosSet = array('2014-05-22 00:08:00','79');
	$camposSet = array('fechaDeIngreso','rutId');
	$parametrosWhere = array(0);
	echo "<br/>Actualizados: ";
	echo $bdd->actualizar('usuarios',$parametrosSet,$camposSet,$parametrosWhere,$condiciones,$tdp);
	$bdd->finalizar();
}
$bdd = new BddMySql('localhost','root','clave','dentosistema');
if($bdd->conectar()){
	$tdp = "s";
	$condiciones = "email=?";
	$parametros = array('jjortega@gmaill.coommm');
	echo "<br/>Eliminados: ";
	echo $bdd->eliminar('usuarios',$parametros,$condiciones,$tdp);
	$bdd->finalizar();
}
*/
?>
