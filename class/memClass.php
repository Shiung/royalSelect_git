<?php 

date_default_timezone_set("Asia/Taipei");

class userObj{
	public $mem_no;
	public $mem_email;
	public $mem_firstname ;
	public $mem_lastname ;
	public $mem_tel ;
	public $mem_note ;
	public $mem_status ;
	public $mem_createtime ;
	public $mem_updatetime ;
	public $mem_lastlogintime ;
	public $mem_token ;
	public $mem_loginIP ;

	public $memExistNone ;
	
	public function __construct($uid=null){
		if( $uid ){ 
			$db = new DB();
			$sql = "SELECT * FROM member where mem_no = :mem_no";
			$dic = array(":mem_no"=>$uid);
			$result = $db -> DB_Query($sql,$dic);
			if( count($result) != 0 ){
				foreach ($result as $key => $value) {
					$this->mem_no =  $value["mem_no"];
					$this->mem_email =  $value["mem_email"];
					$this->mem_firstname =  $value["mem_firstname"];
					$this->mem_lastname =  $value["mem_lastname"];
					$this->mem_tel =  $value["mem_tel"];
					$this->mem_note =  $value["mem_note"];
					$this->mem_status =  $value["mem_status"];
					$this->mem_createtime =  $value["mem_createtime"];
					$this->mem_updatetime =  $value["mem_updatetime"];
					$this->mem_lastlogintime = $value["mem_lastlogintime"];
					$this->mem_token = $value["mem_token"];
					$this->mem_loginIP = $value["mem_loginIP"];
				}
			}else{
				$this->memExistNone = "1"; //找不到會員資料
			} 
			
			
		}else{	
			$this->memExistNone = "1";	//找不到會員資料
		} 
		
	}

	public function brief(){
		if(!$this->memExistNone){
			return array(
				"mem_no" => $this->mem_no,
				"mem_email" => $this->mem_email,
			 	"mem_firstname" => $this->mem_firstname,
			    "mem_lastname" => $this->mem_lastname,
			    "mem_tel" => $this->mem_tel,
				"mem_note" => $this->mem_note,
				"mem_status" => $this->mem_status,
				"mem_createtime" => date("Y-m-d H:i:s",$this->mem_createtime),
				"mem_updatetime" => $this->mem_updatetime,
				"mem_lastlogintime" => date("Y-m-d H:i:s",$this->mem_lastlogintime),
				"mem_token" => $this->mem_token,
				"mem_loginIP" => $this->mem_loginIP,
			);
		}else{
			return false;//"沒有會員資料";
		}
    }
    
	public function memLoginCheck( $mail , $psw ){ //確認帳號密碼是否存在
		$mem_email = $mail;
		$mem_psw = $psw;
        $db = new DB();
        $sql = "SELECT * from member where mem_email = :mem_email and mem_password = :mem_password ";
        $dic = array(
			":mem_email" => $mem_email ,
			":mem_password" => $mem_psw
		);
		$result = $db -> DB_Query($sql,$dic);
		if( $result ){
            return $result ;//"有帳號"; 回傳會員資料
        }else{
            return false ;//"無帳號";
		} 
	}


    public function memCheck( $mail ){ //確認會員帳號是否已經使用
        $mem_email = $mail;
        $db = new DB();
        $sql = "SELECT * from member where mem_email = :mem_email";
        $dic = array(":mem_email" => $mem_email );
        $result = $db -> DB_Query($sql,$dic);
        if( $result ){
            return true ;//"有帳號";
        }else{
            return false ;//"無帳號";
        } 
    }

    public function createMem( $table , $data ){ //新增會員
        if( $this->memExistNone ){
            $db = new DB();
            if( !$db-> DB_Insert($table,$data) ){ //false 更新失敗
                return "createfail";
            }else{ //更新成功
                return $db->lastId ; // 更新的user ID
            }
        }else{
            return false ; //有重複ID
        }
    }

    public function editMem( $table , $data , $checkColumn ){ //更新資料
        if( !$this->memExistNone ){
            $db = new DB();
            if( $db -> DB_Update($table,$data,$checkColumn) ){ 
                return true;
            }else{
                return false;
            }
        }else{
            // return false ; //找不到帳號ID
            echo "不存在唷";
        }
    }

}	

?>