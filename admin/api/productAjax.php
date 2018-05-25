<?php 
ob_start();
session_start(); 

//導入程式
include("../../config.php");
include("../../model/DB.php");
include("../../class/productClass.php");

//test
//新增產品
// $_REQUEST["status"] = "createProduct";
// $_REQUEST["product_no"] = null;
// $_REQUEST["model_id"] = "apitest123";
// $_REQUEST["product_name"] = "api產品";
//修改產品

//test

$pid = $_REQUEST["product_no"];
$p = new productObj($pid); //產品物件建立

switch ( $_REQUEST["status"] ) {
	case 'viewProduct':
		$result = $p->brief();
		echo json_encode($result);
		break;
	case 'createProduct':
		$table = "product" ;
		$item = array(
			"model_id" => $_REQUEST["model_id"],
			"product_name"=>$_REQUEST["product_name"],
			"product_createtime"=>time()
		);
		$result = $p->create($table,$item);
		echo json_encode($result);
		break;
	case 'updateProduct': //產品編輯修改(編輯內頁)
		$table = "product" ;
		$item = array(
			"product_no" => $_REQUEST["product_no"],
			"model_id" => $_REQUEST["model_id"],
			"product_name" => $_REQUEST["product_name"],
			"product_subtitle" => $_REQUEST["product_subtitle"],
			"product_promote" => $_REQUEST["product_promote"],
			"product_describe" => $_REQUEST["product_describe"],
			"product_content" => $_REQUEST["product_content"],
			"collection_quantity" => $_REQUEST["collection_quantity"],
			"collection_start" =>  $_REQUEST["collection_start"],
			"collection_end" => $_REQUEST["collection_end"],
			"product_note" => $_REQUEST["product_note"],
			"img1" => $_REQUEST["img1"],
			"img2" => $_REQUEST["img2"],
			"img3" => $_REQUEST["img3"],
			"img4" => $_REQUEST["img4"],
			"img5" => $_REQUEST["img5"],
			"prodcut_price1" => $_REQUEST["prodcut_price1"],
			"prodcut_price2" => $_REQUEST["prodcut_price2"],
			"prodcut_price3" => $_REQUEST["prodcut_price3"],
			"product_status" => $_REQUEST["product_status"],	
			);
		$checkColumn = array("product_no");
		$p -> update($table,$item,$checkColumn);
		break;
	case 'updateProductGroup': //產品編輯匹次修改 (暫定 上架/下架)

		break;
	case 'updateProductStatusOnly': //產品狀態修改list頁 (暫定 上架/下架)
		$table = "product" ;
		$item = array(
			"product_no" => $_REQUEST["product_no"],
			"product_status" => $_REQUEST["product_status"]	
			);
		$checkColumn = array("product_no");
		$result = $p -> update($table,$item,$checkColumn);
		echo json_encode($result);
		break;	

	case 'updateSpec':
		$table = "product_spec" ;
		$productSpecNo = isset($_REQUEST[""])? $_REQUEST[""] : null ;
		$pInfo = $_REQUEST["product_spec_info"];
		if( $productSpecNo == null ){ //新增
			$item = array(
				"product_no" =>$pid ,
				"product_spec_info"=> $pInfo ,
				"product_spec_createtime"=>time()
			);
			$checkColumn = array("product_spec_no");
			$result = $p -> updateSpec($table,$item,$checkColumn);
			echo json_encode($result);
		}else{ //修改
			$item = array(
				"product_spec_no" => $productSpecNo,
				"product_spec_info"=> $pInfo ,
			);
			$checkColumn = array("product_spec_no");
			// print_r($p -> updateSpec($table,$item,$checkColumn));
			echo "修改";
		}
		break;
	case 'deleteSpec':
		
		break;		

	default:
		# code...
		break;
}

?>