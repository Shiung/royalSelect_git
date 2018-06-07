<?php  
ob_start();
session_start();

if(isset($_COOKIE['rs_token'])){
	include("config.php");
	include("model/DB.php");
	include("class/memClass.php");
	date_default_timezone_set("Asia/Taipei");
	// ====ip get======
	if (!function_exists('eregi'))
	{
	    function eregi($pattern, $string)
	    {
	        return preg_match('/'.$pattern.'/i', $string);
	    }
	}
	function get_real_ip(){
		 $ip=false;
		 if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		  	$ip = $_SERVER["HTTP_CLIENT_IP"];
		 }
		 if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		  	$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
			if($ip){
			array_unshift($ips, $ip); $ip = FALSE;
			}
			for($i = 0; $i < count($ips); $i++){
				if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])){
					$ip = $ips[$i];
					break;
				}
			}
		 }
		 return($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}
	$ipAdd = get_real_ip();

	$table = "member";
	$memtoken = $_COOKIE['rs_token'];
	$memTokenSql = "SELECT * From member where mem_status = 1 and mem_token = :memToken";
	$memTokenDic = array(":memToken" => $memtoken);
	$db = NEW DB();
	$result = $db -> DB_Query($memTokenSql,$memTokenDic);

	if($result){
		$memNo = $result[0]["mem_no"];
		$memMail = $result[0]["mem_email"];
		$memFirstName = $result[0]["mem_firstname"];
		$memLastName = $result[0]["mem_lastname"];
		$memToken = $result[0]["mem_token"];

		// 1.儲存session
		$_SESSION["memNo"] = $memNo;
		$_SESSION["memMail"] = $memMail;
		$_SESSION["memFirstName"] =$memFirstName;
		$_SESSION["memLastName"] =$memLastName;
		// 2.儲存登入時間和update 
		$item= array(
			"mem_no" => $memNo,
			"mem_lastLoginTime" =>time(),
			"mem_loginIP" => $ipAdd
		);
		$checkColumn = array("mem_no");
		$user = new userObj($memNo);
		$edit = $user->editMem( $table , $item , $checkColumn );
		if($edit){ //儲存成功
		// =====儲存3. cookie memToken====
			setcookie("rs_token",$memToken,time()+(60*60*24*30*12),"/");
		}
		

	}else{ //找不到對應的 token 或是權限已被停權
		//刪除cookie資訊並返回
		setcookie("rs_token","",time()+(60*60*24*30*12),"/");

		//刪除session資訊
		unset( $_SESSION["memNo"] ); 
		unset( $_SESSION["memMail"] ); 
		unset( $_SESSION["memFirstName"] ); 
		unset( $_SESSION["memLastName"] );
	}
}

$url = $_SESSION["where"];	
unset($_SESSION["where"]); //刪除轉來的該php程式位址會紀錄在session陣列裡,可以在程序完成後移除
header("location:$url");



?>