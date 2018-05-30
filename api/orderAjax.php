<?php  
ob_start();
session_start();
date_default_timezone_set("Asia/Taipei");
// 程式
include("../config.php");
include("../model/DB.php");
include("../class/orderClass.php");
include("../class/productClass.php");


if (!function_exists('eregi'))
{
    function eregi($pattern, $string)
    {
        return preg_match('/'.$pattern.'/i', $string);
    }
}
// ====ip get======
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
// ======create=======
	case "createOrderItem" :
		
		$Info = $_REQUEST["info"];

		$model = $_REQUEST["model_id"] ;
		$memNo = $Info[0] == "" ? null : $Info[0] ;
		$orderEmail = $Info[1];
		$orderRecipient =  $Info[2];
		$orderAddress = $Info[3];
		$orderTel = $Info[4];
		$orderMemo = $Info[5] == "" ? null : $Info[5] ;
		$pay = $Info[6];
		$orderUniStatus = $_REQUEST["order_uni_status"];
		$orderUniNo = $_REQUEST["order_uni_no"] == "" ? null : $_REQUEST["order_uni_no"] ;
		$orderUniTitle = $_REQUEST["order_uni_title"] == "" ? null : $_REQUEST["order_uni_title"] ;
		$orderInvoiceAddress = $_REQUEST["order_invoice_address"];
		$orderCreatetime = time();
		$orderGroup = $model.$orderCreatetime;


		//session 抓取checkout 訂單資訊
		foreach ($_SESSION["ordersCheckOut"] as $key => $value) {
			foreach ($value as $skey => $svalue) {
				$item = array(
					"mem_no" => $memNo,
					"order_group" => $orderGroup,
					"order_email" => $orderEmail,
					"order_recipient" => $orderRecipient,
					"order_address" => $orderAddress,
					"order_memo" => $orderMemo,
					"order_tel" => $orderTel,
					"product_price" => $svalue["price"] ,
					"order_quantity" => $svalue["quanty"] ,
					"product_no" => $svalue["product_no"] ,
					"product_name" => $svalue["product_name"] ,
					"product_spec_no" => $svalue["product_spec_no"] ,
					"product_spec" => $svalue["product_spec_info"] ,
					"order_uni_status" => $orderUniStatus,
					"order_uni_no" => $orderUniNo,
					"order_uni_title" => $orderUniTitle,
					"order_invoice_address" => $orderInvoiceAddress,
					"order_pay" => 0,
					"order_pay_status" => 0,
					"order_status" => $pay,
					"order_createtime" => $orderCreatetime,
				);	
			}			
		}
		// echo json_encode($item);
		
		$table = "order_list";
		$order	= new orderObj(null); 
		$result = $order -> orderCreateDB( $table , $item );
		if(!$result){
 			echo false;
		}else{
			echo $orderGroup;
		}
			
			break;

// ========查詢=============
	case "查詢":
		
	break;
} //---end switch case




?>