<?php

class DB {
	public $db_host ;
	public $database ;
	public $user ;
	public $password ;
	public $pdo ;
	public $error;
	public $lastId;

	public function __construct() {
		try {
			$this->db_host = DB_HOSTNAME;
	        $this->database = DB_DATABASE;
	        $this->user = DB_USERNAME;
	        $this->password = DB_PASSWORD;
	        $this->db_port = DB_PORT;
	        $dsn = "mysql:host=".$this->db_host.";port=".$this->db_port.";dbname=".$this->database.";charset=utf8";
	        $options = array(
						PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
						);
	        $this->pdo = new PDO($dsn,$this->user,$this->password,$options);
		} catch (Exception $e) {
			$this->error = $e->getMessage();
		}
        
    }

    public function DB_Query($sql,$dic=null){
    	$pdo = $this->pdo;
		$object = $pdo->prepare($sql);
		if($dic){
			foreach ($dic as $key=>$value) {
				$object -> bindValue($key,$value);
			}
		}
		if($object -> execute()){
			return 	$object -> fetchAll(PDO::FETCH_ASSOC);
		}else{
			$this->error = $object -> errorCode();
			return false;
		}

    }

	public function DB_Insert($table,$data){
		$pdo = $this->pdo;
		$sql="insert into ".$table." (".implode(',',array_keys($data)).") values(:".implode(',:',array_keys($data)).")";
		$object = $pdo->prepare($sql);
		foreach ($data as $key => $value) {
			$object ->bindValue(":".$key,$value);
		}
		$result = $object -> execute();
		$this->lastId = $pdo->lastInsertId();
		if(!$result){
			$this->error = $object -> errorCode();
		}
		return $result ;
	}

	public function DB_UpdateOnly($table,$data,$checkColumn){
		$pdo = $this->pdo;
		$dateBind = array();
		$checkBind = array();
    	foreach ($data as $key => $value) {
	    	if (in_array($key, $checkColumn)){
		    	array_push($checkBind, $key." = :".$key);
	    	}else{
		    	array_push($dateBind, $key." = :".$key);
	    	}
		}
    	$sql = sprintf("update %s set %s where %s ",$table,implode(',',$dateBind),implode(' and ',$checkBind));
    	$object = $pdo->prepare($sql);
    	foreach ($data as $key => $value) {
    		$object->bindValue(":".$key,$value);
    	}
    	$result = $object->execute();
    	if(!$result){
    		$this->error = $object->errorCode();
    		return false;
    	}else{
    		return $result;
    	}
	}


    public function DB_Update($table,$data,$checkColumn){
    	$pdo = $this->pdo;

		//<---insert into table (keys) values (values) on duplicate key update key=value-->;
		$updateBind = array();
    	foreach ($data as $key => $value) {
    		if(!in_array($key,$checkColumn)){
    			array_push($updateBind,$key."=:".$key);
    		}
    	}
    	$sql = sprintf("insert into %s ( %s ) values(:%s ) ON DUPLICATE KEY UPDATE %s",$table,implode(',',array_keys($data)),implode(',:',array_keys($data)),implode(",",$updateBind));
    	$object = $pdo->prepare($sql);
    	// print_r($data) ;
    	foreach ($data as $key => $value) {
    		$object->bindValue(":".$key,$value);	
    	}	
    	$result = $object->execute();
    	$this->lastId = $pdo->lastInsertId();
    	// echo $this->lastId;
    	if(!$result){
    		$this->error = $object->errorCode();
    		return false;
    	}else{
    		return $result;
    	}
    }

    public function exec($sql){
    	$pdo = $this->pdo;
    	return $pdo->exec($sql);
    }
}



?>