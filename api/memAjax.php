<?php  
ob_start();
session_start();
date_default_timezone_set("Asia/Taipei");
// 程式
include("../config.php");
include("../model/DB.php");
include("../class/orderClass.php");
include("../class/productClass.php");

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

		$table = "member";
		$email = $_REQUEST["mem_email"];
		$check = checkMemMail($table,$email);

		if($check){
			echo json_encode($check);
		}else{
			echo false;
		}
		
		break;

	case "memCreate" :
		$table = "member";	
		$email = $_REQUEST["mem_email"];
		$psw = $_REQUEST["mem_password"];
		$memTel = $_REQUEST["mem_tel"];
		$memLastName = $_REQUEST["mem_lastname"];
		$memFirstName = $_REQUEST["mem_firstname"];
		$memAddress = $_REQUEST["mem_address"];

		$item = array(
			"mem_mail" => $email,
			"mem_password"=> md5($psw),
			"mem_firstname"=> $memFirstName,
			"mem_lastname"=> $memLastName ,
			"mem_tel" =>$memTel,
			"mem_address" =>$memAddress,
			"mem_status" => 1, 
			"mem_createtime" =>time(), 
			"mem_loginIP"=> $ipAdd
			);
		echo json_encode(create($table,$email,$item));

		break;

	case "memInfoEdit":
		$table = $_REQUEST["table"];
		$memNo = $_REQUEST["mem_no"];
		$memMail = $_REQUEST["mem_mail"];
		$memTel = $_REQUEST["mem_tel"];
		$memLastName = $_REQUEST["mem_lastname"];
		$memFirstName = $_REQUEST["mem_firstname"];
		$memAddress = $_REQUEST["mem_address"];

		$item = array(
			"mem_no" => $memNo,
			"mem_firstname"=> $memFirstName,
			"mem_lastname"=> $memLastName ,
			"mem_tel" =>$memTel,
			"mem_address" =>$memAddress
		);
		$result = edit($table,$memMail,$item);
		if($result){
			// =====修改session======
			$_SESSION["memFirstName"] =$memFirstName;
			$_SESSION["memLastName"] =$memLastName;
			echo  true; //成功
		}else{
			echo  false; //更新失敗
		}

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

		$title ="TGI Live 訂單通知";
		$receiverArray = array($orderEmail,"info@tgilive.com","info@tgilive.co.uk");
		// echo json_encode(sendMail($title,$content,$receiverArray,$orderName));
		echo true;
			break;	


	case "pswChange":
		$table = $_REQUEST["table"];
		$memNo = $_REQUEST["mem_no"];
		$memMail = $_REQUEST["mem_mail"];
		$memPsw = $_REQUEST["mem_password"];
		$memName = $_REQUEST["mem_name"];

		$count = strlen( $memPsw );
		$replace = "";
		for ($i=4; $i < $count ; $i++) { 
			$replace .= "*";
		}
		$pswSend  = substr_replace ( $memPsw ,  $replace , 2 , $count-4 );

		$item = array(
			"mem_no" => $memNo,
			"mem_password"=>md5($memPsw)
		);
		$result = edit($table,$memMail,$item);
		if($result){
			$title ="TGI Live會員密碼更新";
			// $content = "<p><span>TGI live 登入密碼 : </span><span>$tempPsw</span></p><p>請登入後重新設定密碼</p>" ;
			$content = '<p><img src="https://www.tgilive.com/image/frontend/EC-logo.png" width="100"><span style="width: calc( 100% - 110px );height: 3px; background-color: #FDC5CD;display: inline-block;margin-left: 10px;"></span></p><p>hello,'.$memName.'</p><p>您帳號的密碼已變更</p><p><span style="color: rgb(0, 0, 0); font-family: &quot;PingFang TC&quot;; font-size: medium;">新密碼 :&nbsp;</span><span style="color: rgb(0, 0, 0); font-family: &quot;PingFang TC&quot;; font-size: medium;">'.$pswSend.'</span></p><p>※提醒：此信件為系統發出信件，若有問題請請來信至客服信箱（ <a href="mailto:info@tgilive.com" target="_blank" >info@tgilive.com</a> ），我們將盡快為您處理，謝謝。</p><p>TGiLive居生活團隊 敬上</p><span style="width: calc( 100% );height: 3px; background-color: #FDC5CD;display: inline-block;"></span>';
			
			$receiverArray = array($memMail);
			echo json_encode(sendMail($title,$content,$receiverArray,$memName));
			// echo  true; //成功
		}else{
			echo  false; //更新失敗
		}
		break;
	case "createTempPsw":
		//建立新的密碼並儲存
		$table = "member";
		$email = $_REQUEST["mem_email"];
		$memNo = $_REQUEST["mem_no"];
		$memName = $_REQUEST["mem_name"];
		$tempPsw = "temp".rand(10,10000);

		$item = array(
			"mem_no" => $memNo,
			"mem_password" => md5($tempPsw)
		);
		$result = edit($table,$email,$item);

		if($result){ //true
			//發送email
			$title ="TGI Live會員密碼重置";
			// $content = "<p><span>TGI live 登入密碼 : </span><span>$tempPsw</span></p><p>請登入後重新設定密碼</p>" ;
			$content = '<p><img src="https://www.tgilive.com/image/frontend/EC-logo.png" width="100"><span style="width: calc( 100% - 110px );height: 3px; background-color: #FDC5CD;display: inline-block;margin-left: 10px;"></span></p><p>hello,'.$memName.'</p><p>當您收到這封 Email 是因為您提出忘記密碼的申請，請利用下方系統隨機產生的臨時密碼，前往官網後台登入並更新您的密碼，以確保您的帳戶資料安全。</p><p><span style="color: rgb(0, 0, 0); font-family: &quot;PingFang TC&quot;; font-size: medium;">臨時密碼 :&nbsp;</span><span style="color: rgb(0, 0, 0); font-family: &quot;PingFang TC&quot;; font-size: medium;">'.$tempPsw.'</span></p><p>提醒您：</p><ol><li>如果您沒有變更密碼，請馬上用此密碼登入後，修改密碼。</li><li>如果您無法利用此密碼登入或有其他問題，請勿直接回覆本信件，請來信至客服信箱（ <a href="mailto:info@tgilive.com" target="_blank" >info@tgilive.com</a> ），我們將盡快為您處理，謝謝。</li></ol><p>TGiLive居生活團隊 敬上</p><span style="width: calc( 100% );height: 3px; background-color: #FDC5CD;display: inline-block;"></span>';

			$receiverArray = array($email);
			echo json_encode(sendMail($title,$content,$receiverArray,$memName));
			// echo $memName ;

		}else{ //更新失敗
			echo false;
		}
		
		
	 	break;	
	case "sendOrderCheckOutMail": 
		
		$now = date("Y-m-d H:i:s");
		$memName =  $_REQUEST["order_name"];
		$orderNo =  $_REQUEST["order_no"];
		$price = $_REQUEST["order_price"];
		$orderEmail = $_REQUEST["order_mail"];

		//發送email
		$content = '<p><img src="https://www.tgilive.com/image/frontend/EC-logo.png" width="100"><span style="width: calc( 100% - 120px );height: 3px; background-color: #FDC5CD;display: inline-block;margin-left: 10px;"></span></p><p>hello,'.$memName.'</p><p style="margin:30px 0;">感謝您在TGiLive居生活訂購我們的商品！您的訂單已經付款成功，我們將立即為您安排出貨！下方為您的付款資訊：</p><p style="margin:5px 0;"><span style="color: rgb(0, 0, 0); font-family: &quot;PingFang TC&quot;; font-size: medium;">訂單編號：&nbsp;</span><span style="color: rgb(0, 0, 0); font-family: &quot;PingFang TC&quot;; font-size: medium;">'.$orderNo.'</span></p><p style="margin:5px 0;"><span style="color: rgb(0, 0, 0); font-family: &quot;PingFang TC&quot;; font-size: medium;">交易金額：&nbsp;</span><span style="color: rgb(0, 0, 0); font-family: &quot;PingFang TC&quot;; font-size: medium;">'.$price.'</span></p><p style="margin:5px 0;"><span style="color: rgb(0, 0, 0); font-family: &quot;PingFang TC&quot;; font-size: medium;">交易完成時間：&nbsp;</span><span style="color: rgb(0, 0, 0); font-family: &quot;PingFang TC&quot;; font-size: medium;">'.$now.'</span></p><p>如需查詢訂單處理狀態，請至<a href="https://www.tgilive.com/" target="_blank" style="color:#00f;">TGiLive官網</a>登入後前往會員專區>訂單記錄，即可查詢您的訂單內容與配送狀態。</p><p style="font-weight: bold; ">※一般商品將於2~5個工作天以宅配方式送達（不含六日及國定假日），商品頁標示為「預購」商品，將以實際出貨或製作日標示為主，出貨時您將會收到系統送出的出貨通知。</p><p style="font-weight: bold; ">※提醒：此信件為系統發出信件，若有問題請請來信至客服信箱（ <a href="mailto:info@tgilive.com" target="_blank" >info@tgilive.com</a> ），我們將盡快為您處理，謝謝。</p><p>我們的客服回覆時間： 週一至週五10:00am-18:00pm</p><p style="margin:40px 0;">TGiLive居生活團隊 敬上</p><span style="width: calc( 100% );height: 3px; background-color: #FDC5CD;display: inline-block;"></span>';

		$title ="TGiLive居生活訂單付款成功！";


		$receiverArray = array($orderEmail,"info@tgilive.com","info@tgilive.co.uk");
		echo json_encode(sendMail($title,$content,$receiverArray,$memName));
		break;	


	case "newMemMail":  //公司內部信件
		
		$memName =  $_REQUEST["mem_lastname"].$_REQUEST["mem_firstname"];
		$memEmail = $_REQUEST["mem_email"];
		$memTel = $_REQUEST["mem_tel"];

		//發送email
		$content = '<p>TGiLive居生活新註冊客戶：<span></span></p><p>姓名：<span>'.$memName.'</span></p><p>Email：<span>'.$memEmail.'</span></p><p>電話：<span>'.$memTel.'</span></p>';

		$title ="新加入會員通知";


		$receiverArray = array("info@tgilive.com","info@tgilive.co.uk");
		echo json_encode(sendMail($title,$content,$receiverArray,$memName));
		break;		
	 	//=======發送mail==========


	default:

		break;
}



?>