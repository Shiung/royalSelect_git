<?php  

//導入程式
include("../../config.php");
include("../../model/DB.php");
include("../../class/orderClass.php");

//webgolds 提供 PHP 陣列輸出 JSON格式參考範例
$draw = isset ( $_REQUEST['draw'] ) ? intval( $_REQUEST['draw'] ) : 0;
$start = isset($_REQUEST['start'] ) ? $_REQUEST['start']  : 0;
$length = isset($_REQUEST['length'] ) ?  $_REQUEST['length'] : 10;
$search = isset($_REQUEST['search']['value'] ) ?  $_REQUEST['search']['value'] : null;
$searchCount = 0; //seach 計時器

if( $length == -1 ){ //filter 全部
	$length = null ;
}


// ===搜尋升降冪====
$dir = isset($_REQUEST['order'][0]["dir"]) ? $_REQUEST['order'][0]["dir"] : "desc";

// =====商品狀態搜尋=====
$columns3Search = isset($_REQUEST['columns'][3]['search']['value'] ) ?  $_REQUEST['columns'][3]['search']['value'] : null;


date_default_timezone_set("Asia/Taipei");
$sql = "SELECT * from order_list order by order_no ".$dir;
$db = new DB();
$result = $db->DB_Query($sql);
$orders = [];
$searchCheck = []; //for search 使用
if($result){		
	foreach ($result as $key => $value) {
		$multiCount = 0;//seach 重複內容計時器(Multi)

		//組合產品陣列
		$orders[$key]["order_no"] = $value["order_no"];
        $orders[$key]["mem_no"] = $value["mem_no"];
        $orders[$key]["order_pay_status"] = $value["order_pay_status"];
        $orders[$key]["order_status"] = $value["order_status"];
		$orders[$key]["order_group"] = $value["order_group"];
		$orders[$key]["order_email"] = $value["order_email"];
        $orders[$key]["order_recipient"] = $value["order_recipient"];
        $orders[$key]["order_price"] = $value["order_price"];
		$orders[$key]["order_createtime"] = $value["order_createtime"];
		// $searchCheck = array($value["product_no"],$value["model_id"],$value["product_name"]);

		// // ========搜尋 search bar =======
		// if(trim($search) != null ){
		// 	if(strpos(strtolower(implode(",",array_values($searchCheck))),strtolower(trim($search))) === false){ //配對不上相同字串
		// 		unset($orders[$key]);
		// 	}else{  //配對上相同字串
		// 		if( $multiCount == 0 ){
		// 			$searchCount++ ;
		// 			$multiCount++ ;
		// 		}	
		// 	}
		// }	

	}
	
	if($searchCount == 0){
		$recordsFiltered = count($result);
	}else{
		$recordsFiltered = $searchCount ;
	}
	

	$array = array("draw"=>$draw,"recordsTotal"=>count($result),"recordsFiltered"=>$recordsFiltered,"search"=>$search);
	$array["data"]=array_slice($orders,$start,$length);
	
	$jsonStr = json_encode($array);
	echo $jsonStr;
	
}else{
	$array["data"]=array_slice($orders,$start,$length);
	
	$jsonStr = json_encode($array);
	echo $jsonStr;
}



?>