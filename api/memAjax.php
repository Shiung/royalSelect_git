<?php  
ob_start();
session_start();
date_default_timezone_set("Asia/Taipei");
// 程式
include("../config.php");
include("../model/DB.php");
include("../class/memClass.php");

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


switch ($_REQUEST["status"]) {
	case "memMailCheck":

		$user = new userObj();
		$email = $_REQUEST["mem_email"];
		$table = "member";
		$result = $user->memCheck( $email );

		echo $result ; //true 有帳號 , false 沒有帳號
		
		break;

	case "memCreate" :
		$table = "member";	
		$email = $_REQUEST["mem_email"];
		$psw = $_REQUEST["mem_password"];
		$memTel = $_REQUEST["mem_tel"];
		$memLastName = $_REQUEST["mem_lastname"];
		$memFirstName = $_REQUEST["mem_firstname"];
		$memNote = isset($_REQUEST["mem_note"]) ?  $_REQUEST["mem_note"] : null ;
		$user = new userObj();
		//1. 確認是否有重複帳號
		$checkAcc = $user->memCheck( $email );
		if( $checkAcc ){
			echo "existAllready";
			break ;
		}

		$item = array(
			"mem_email" => $email,
			"mem_password" => md5($psw),
			"mem_firstname" => $memFirstName,
			"mem_lastname" => $memLastName,
			"mem_tel" => $memTel,
			"mem_status" => 1,
			"mem_createtime" =>time(), 
			"mem_loginIP"=> $ipAdd
			);
		!$memNote ? null : 	$item["mem_note"] = $memNote;

		$createFeedBack =  $user->createMem( $table , $item );
		if( !$createFeedBack ){
			echo "exist"; //重複ID
			break ;
		}else{
			if( $createFeedBack == 'createfail' ){
				echo "createfail"; //建立失敗
				break ;
			}else{
				$newUserNo = $createFeedBack;
				echo $newUserNo; //建立成功回傳建立的useID
				break ;
			}
		}
		break;

	case "memUpdate":
		$table = "member";
		$memNo = $_REQUEST["mem_no"];
		$memMail = isset($_REQUEST["mem_mail"])? $_REQUEST["mem_mail"] : null  ;
		$memPsw = isset($_REQUEST["mem_password"])? md5($_REQUEST["mem_password"]) : null  ;
		$memTel = isset($_REQUEST["mem_tel"]) ? $_REQUEST["mem_tel"] : null ;
		$memLastName = isset($_REQUEST["mem_lastname"]) ? $_REQUEST["mem_lastname"] : null;
		$memFirstName = isset($_REQUEST["mem_firstname"]) ? $_REQUEST["mem_firstname"] : null ;
		$memNote = isset($_REQUEST["mem_note"])? $_REQUEST["mem_note"] : null ;
		$memToken = isset($_REQUEST["rs_token"]) ? $_REQUEST["rs_token"] : null ;
		$memLoginTime = isset($_REQUEST["mem_LoginTime"]) ? time() : null ;
		$memLoginIp = isset($_REQUEST["mem_LoginIp"]) ? $ipAdd : null ;
		
		$item = array(
			"mem_no" => $memNo,
		);
		!$memMail ? null : $item["mem_mail"] = $memMail;
		!$memPsw ? null : $item["mem_password"] = $memPsw;
		!$memTel ? null : $item["mem_tel"] = $memTel;
		!$memLastName ? null : $item["mem_lastname"] = $memLastName;
		!$memFirstName ? null : $item["mem_firstname"] = $memFirstName;
		!$memToken ? null : $item["mem_token"] = $memToken;
		!$memLoginTime ? null : $item["mem_lastlogintime"] = $memLoginTime;
		!$memLoginIp ? null : $item["mem_loginIP"] = $memLoginIp;

		$checkColumn = array("mem_no");

		$user = new userObj($memNo);
		$edit = $user->editMem( $table , $item , $checkColumn );
		
		if($edit){
			echo true;
		}else{
			echo false;
		}

		break;
	case "memLogin" : 
		$table = "member";
		$memNo = $_REQUEST["mem_no"];
		$user = new userObj($memNo);
		print_r($user->brief());
		break;
	//=======發送mail==========
	case "sendOrderMail":		
		$orderNo = $_REQUEST["order_no"];
		$orderName =  $_REQUEST["order_name"] ;
		$orderTel =  $_REQUEST["order_tel"] ;
		$orderAddress =  $_REQUEST["order_address"] ;
		$orderEmail =  $_REQUEST["order_email"] ;
		// $orderPay =  $_REQUEST["order_pay"] ;
		switch ($_REQUEST["order_pay"]) {
			case '0':
				$orderPay ="信用卡付款";
				break;			
			default:
				break;
		}


		$content = '';
		$finalPrice = 0; 

		$title ="這是標題";
		$receiverArray = array($orderEmail,"info@tgilive.com","info@tgilive.co.uk");
		// echo json_encode(sendMail($title,$content,$receiverArray,$orderName));
		echo true;
			break;	


	default:

		break;
}



?>