<?php  

//導入程式
include("../../config.php");
include("../../model/DB.php");
include("../../class/productClass.php");

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
$sql = "SELECT * from product order by product_no ".$dir;
$db = new DB();
$result = $db->DB_Query($sql);
$products = [];
$searchCheck = []; //for search 使用
if($result){		
	foreach ($result as $key => $value) {
		$multiCount = 0;//seach 重複內容計時器(Multi)

		//產品物件資訊
		$pid = $value["product_no"];
		$p = new productObj($pid); //產品物件建立
		$pro = $p->brief();
		//產品物件資訊

		//組合產品陣列
		$products[$key]["product_no"] = $pro["product_no"];
		$products[$key]["model_id"] = $pro["model_id"];
		$products[$key]["product_name"] = $pro["product_name"];
		$products[$key]["product_status"] = $pro["product_status"];
		$products[$key]["product_updatetime"] = $pro["product_updatetime"];
		$products[$key]["product_createtime"] = $pro["product_createtime"];
		$searchCheck = array($pro["product_no"],$pro["model_id"],$pro["product_name"]);

		// // ========搜尋 search bar =======
		if(trim($search) != null ){
			if(strpos(strtolower(implode(",",array_values($searchCheck))),strtolower(trim($search))) === false){ //配對不上相同字串
				unset($products[$key]);
			}else{  //配對上相同字串
				if( $multiCount == 0 ){
					$searchCount++ ;
					$multiCount++ ;
				}	
			}
		}	

		// // ========商品狀態搜尋 =======
		if(trim($columns3Search) != null ){	
			if(array_key_exists($key,$products)){ //判斷是否存在product 陣列
				if(strpos(strtolower($products[$key]["product_status"]),strtolower(trim($columns3Search))) === false ){ //配對不上相同字串
					unset($products[$key]);
				}else{  //配對上相同字串
					if( $multiCount == 0 ){
						$searchCount++ ;
						$multiCount++ ;
					}
				}
			}			
		}

	}
	
	if($searchCount == 0){
		$recordsFiltered = count($result);
	}else{
		$recordsFiltered = $searchCount ;
	}
	

	$array = array("draw"=>$draw,"recordsTotal"=>count($result),"recordsFiltered"=>$recordsFiltered,"search"=>$search);
	$array["data"]=array_slice($products,$start,$length);
	
	$jsonStr = json_encode($array);
	echo $jsonStr;
	
}else{
	$array["data"]=array_slice($products,$start,$length);
	
	$jsonStr = json_encode($array);
	echo $jsonStr;
}



?>