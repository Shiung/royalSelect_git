<?php  
ob_start();
session_start();
date_default_timezone_set("Asia/Taipei");

// 程式
include("../config.php");
include("../model/DB.php");
include("../class/orderClass.php");
include("../class/productClass.php");

if(isset($_REQUEST["product_no"])){ //存在
	$productNO = $_REQUEST["product_no"];
}

$status = $_REQUEST["status"];


switch ($status) {
	case 'addCartOnly':   //快速加入購物車 只存一筆更物清單
		$array =[];
		$pid = $_REQUEST["product_no"];
		$productSpecNo = $_REQUEST["product_spec_no"];
		$quanty = $_REQUEST["quanty"];
		// $price = $_REQUEST["price"];
		$priceStatus = $_REQUEST["price_status"];

		//確認是否有cookie確認碼存在(header儲存用於檢查)
        if (!isset($_COOKIE["CookieCheck"])){ //瀏覽器關閉cookie 功能改用session存
           	$_SESSION["orders"][$pid][$productSpecNo]["product_no"] = $pid;
			// $_SESSION["orders"][$pid][$productSpecNo]["price"]= $price; //最終售價
			$_SESSION["orders"][$pid][$productSpecNo]["price_status"]= $priceStatus; //檢查價錢是否與資料庫相同
			$_SESSION["orders"][$pid][$productSpecNo]["product_spec_no"]= $productSpecNo; //規格編號
			$_SESSION["orders"][$pid][$productSpecNo]["quanty"]=$quanty; //數量

			echo false;
        }else{  //使用cookie 儲存購物車訂單資訊
        	// 1.刪除session清單
        	if(isset($_SESSION["orders"])){ //存在舊的紀錄 刪除
				unset($_SESSION["orders"]);
			}
			// 2.刪除cookie清單
			if(isset($_COOKIE["orders"])){ //有存在購物清單
				setcookie("orders","",time()-3600,"/");
			}

			// 3.儲存cookie
			$array[$pid][$productSpecNo]["product_no"] =  $pid;
			$array[$pid][$productSpecNo]["product_spec_no"] =  $productSpecNo;
			$array[$pid][$productSpecNo]["quanty"] =  $quanty;
			// $array[$pid][$productSpecNo]["price"] =  $price;
			$array[$pid][$productSpecNo]["price_status"]= $priceStatus; //檢查價錢是否與資料庫相同
		
			setcookie("orders",json_encode($array),time()+(60*60*24*30),"/");

			echo true;
        }  

		break;

    case "editCartDetail";  
    	$productNo = $_REQUEST["product_no"];
		$productSpecNo = $_REQUEST["product_spec_no"];
		$quanty = $_REQUEST["quanty"];

    	$orderlist = json_decode($_COOKIE["orders"], true) ;
    	$orderlist[$productNo][$productSpecNo]["quanty"] = $quanty;

    	setcookie("orders",json_encode($orderlist),time()+(60*60*24*30),"/");
	  		
		echo true;

		break;

	case "clearOldcartBeforeCheckOut":	
		if(isset($_SESSION["ordersCheckOut"])){ //存在舊的紀錄 刪除
			unset($_SESSION["ordersCheckOut"]);
		}
		echo true;
		break;
	case 'cartBeforeCheckOut':	//儲存DB前先行轉存session		
		$orderlist = json_decode($_COOKIE["orders"], true) ; 

		if( isset($_COOKIE["CookieCheck"]) ){
			$order = new orderObj(1);
		}else{
			$order = new orderObj(2);
		}
		$oCheckOut = $order->brief();
		
		foreach ($oCheckOut as $key => $value) {
			$productName = $value["product_name"];
			$productNo = $value["product_no"];
			$productSpecNo = $value["product_spec_no"];
			foreach ( $value["specList"] as $skey => $svalue) {
				if( $svalue["product_spec_no"] == $productSpecNo ){
					$productSpecInfo = $svalue["product_spec_info"];
				}
			}
			$price = $value["price"]; 	
			$quanty = $value["quanty"];
			$modelId = $value["model_id"];

			$_SESSION["ordersCheckOut"][$productNo][$productSpecNo]["product_name"] = $productName;
	       	$_SESSION["ordersCheckOut"][$productNo][$productSpecNo]["product_no"] = $productNo;
	       	$_SESSION["ordersCheckOut"][$productNo][$productSpecNo]["model_id"] = $modelId;
			$_SESSION["ordersCheckOut"][$productNo][$productSpecNo]["price"]= $price; //最終售價(單價)
			$_SESSION["ordersCheckOut"][$productNo][$productSpecNo]["product_spec_no"]= $productSpecNo;
			$_SESSION["ordersCheckOut"][$productNo][$productSpecNo]["product_spec_info"]= $productSpecInfo;
			$_SESSION["ordersCheckOut"][$productNo][$productSpecNo]["quanty"]=$quanty; //數量
		}
		echo true; //儲存成功

		break;

	case "checkSessionKey";	
		// ===儲存session 讓deliver.php 知道是從cart.php來的====
		$_SESSION["checkSessionKey"] = "ok";
		break;
	case "checkSessionKey-repay";	
		// ===儲存session 讓歷史清單裡未結帳的訂單重新結帳 
		$_SESSION["checkSessionKey-repay"] = "ok";
		break;	
	case "deleteCartDetail"	:
		$productNo = $_REQUEST['product_no'];
		$productSpecNo = $_REQUEST['product_spec_no'];

		if(isset($_COOKIE["orders"])){ //有存在購物清單
			$orderlist = json_decode($_COOKIE["orders"], true) ; 

			unset($orderlist[$productNo][$productSpecNo]);
			
			if(count($orderlist[$productNo]) == 0 ){
				unset($orderlist[$productNo]);
			}

			setcookie("orders",json_encode($orderlist),time()+(60*60*24*30),"/");
  		
			echo true;

			
		}else{ //沒有購物清單
			echo false ; 
		}
		

		break;
	case "clearAll":
		// 1.刪除session暫存
		if(isset($_SESSION["orders"])){ //存在舊的紀錄 刪除
			unset($_SESSION["orders"]);
		}else{
			echo "session don`t have";
		}
		// 2.刪除cookie清單
		if(isset($_COOKIE["orders"])){ //有存在購物清單
			setcookie("orders","",time()-3600,"/");
		}else{
			echo "cookie don`t have";
		}
		// 3.刪除session checkout before 暫存
		if(isset($_SESSION["ordersCheckOut"])){ //有存在購物清單
			unset($_SESSION["ordersCheckOut"]);
		}else{
			echo "cookie don`t have";
		}

		echo true;
		break; 	
	default:
		
		break;
}

?>