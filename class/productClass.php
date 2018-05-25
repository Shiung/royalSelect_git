<?php  

date_default_timezone_set("Asia/Taipei");

class productObj{
	public $productNo;
	public $productModelId;
	public $productName ;
	public $productSubtitle ;
	public $productPromote ;
	public $productDescribe ;
	public $productContent ;
	public $productNote ;
	public $productStatus ;
	public $image =[] ;
	public $spec = [];
	public $productUpdateTime ;
	public $collectionQuantity ; //商品集貨數量基準
	public $collectionStart ; //集貨開始時間
	public $collectionEnd ; //集貨結束時間
	public $createtime ; //集貨結束時間
	public $updatetime ; //集貨結束時間
	public $price =[] ;


	public $productExistNone ;
	
	public function __construct($pid=null){
		if( $pid ){ 
			$db = new DB();
			$sql = "SELECT * FROM product where product_no = :product_no";
			$dic = array(":product_no"=>$pid);
			$result = $db -> DB_Query($sql,$dic);
			if( count($result) != 0 ){
				foreach ($result as $key => $value) {
					$this->productNo =  $value["product_no"];
					$this->productModelId =  $value["model_id"];
					$this->productName =  $value["product_name"];
					$this->productSubtitle =  $value["product_subtitle"];
					$this->productPromote =  $value["product_promote"];
					$this->productDescribe =  $value["product_describe"];
					$this->productContent =  $value["product_content"];
					$this->productNote =  $value["product_note"];
					$this->productStatus =  $value["product_status"];
					$this->collectionQuantity = $value["collection_quantity"];
					$this->collectionStart = $value["collection_start"];
					$this->collectionEnd = $value["collection_end"];
					$this->createtime = $value["product_createtime"];
					$this->updatetime = $value["product_updatetime"];
					for ($i= 1; $i <= 5; $i++) { 
						if(trim($value["img".$i]) != null || trim($value["img".$i]) != ""){
							// array_push( $this->image , $value["img".$i] );
							$this->image["img".$i] = $value["img".$i];
						};
					};
					for ($i= 1; $i <= 3; $i++) { 
						if(trim($value["prodcut_price".$i]) != null || trim($value["prodcut_price".$i]) != ""){
							// array_push( $this->price , $value["prodcut_price".$i] );
							$this->price["price".$i] = $value["prodcut_price".$i];
						};
					};
					$this->specUseInfo($pid);
				}
			}else{
				$this->productExistNone = "1"; //找不到商品
			} 
			
			
		}else{	
			$this->productExistNone = "1";	//找不到商品
		} 
		
	}

	public function brief(){
		if(!$this->productExistNone){
			return array(
				"product_no" => $this->productNo,
				"model_id" => $this->productModelId,
			 	"product_name" => $this->productName,
			    "product_subtitle" => $this->productSubtitle,
			    "product_promote" => $this->productPromote,
				"product_describe" => $this->productDescribe,
				"product_content" => $this->productContent,
				"product_note" => $this->productNote,
				"collection_quantity" => $this->collectionQuantity,
				"collection_start" => date("Y-m-d",$this->collectionStart),
				"collection_end" => date("Y-m-d",$this->collectionEnd),
				"product_createtime" => date("Y-m-d H:i:s",$this->createtime),
				"product_updatetime" => $this->updatetime,
				"product_status" => $this->productStatus,
				"product_img" => $this->image,
				"spec" => $this->spec,
				"price" => $this->price,
			);
		}else{
			return false;//"沒有商品";
		}
	}


	public function specUseInfo($pid){
		$db = new DB();
		$sql = "SELECT * FROM product_spec WHERE product_no= ".$pid;
		$result = $db -> DB_Query($sql);
		if( count($result) != 0  ){
			foreach ($result as $key => $value) {
				array_push( $this->spec , $value );
			}	
		}

	}


	//建立新產品
	public function create($table,$data){
		if($this->productExistNone){ //新建商品
			$db = new DB();
			return $db-> DB_Insert($table,$data);
		}else{
			return false;//"有重複";
		}
	}

	//產品更新
	public function update($table,$data,$checkColumn){
		if(!$this->productExistNone){ //產品更新
			$db = new DB();
			return $db->DB_Update($table,$data,$checkColumn);
		}else{
			return false;//"找不到";
		}
	}

	// 產品規格
		//1.建立/更改規格
	public function updateSpec($table,$data,$checkColumn){
		if(!$this->productExistNone){ //規格更新/新增
			$db = new DB();
			return $db->DB_Update($table,$data,$checkColumn);
		}else{
			return false;//"找不到產品ID";
		}
	}
		//2.刪除規格
	public function deleteSpec($table,$productSpecNo){
		$db = new DB();
		$sql = "DELETE FROM ".$table." WHERE product_spec_no='".$productSpecNo."'";
		return $db -> exec($sql);
	}

}	


//test
	// 1.查詢
// echo "<pre>";
// $p = new productObj(4);
// print_r($p->brief());
// echo "</pre>";
	// 2.新建商品
// echo "<pre>";		
// $p = new productObj();
// $table = "product" ;
// $item = array(
// 	"model_id" =>"test12345" ,//$_REQUEST["model_id"],
// 	"product_name"=>"新產品二" ,//$_REQUEST["product_name"],
// 	"product_createtime"=>time()
// 	);
// print_r($p -> create($table,$item));

// echo "</pre>";

	// 3.修改商品內容
// $p = new productObj(4);
// $table = "product" ;
// $item = array(
// 	"product_no" => 4,
// 	"model_id" => "test22222",
// 	"product_name" => "新產品二修改",
// 	"product_subtitle" => null,
// 	"product_promote" => null,
// 	"product_describe" => null,
// 	"product_content" => "<div style='background-color:#ccc;'>hello</div>",
// 	"collection_quantity" => 20,
// 	"collection_start" => 1527064898,
// 	"collection_end" => 1527364898,
// 	"product_note" => null,
// 	"img1" => "t1.jpg",
// 	"img2" => "t2.jpg",
// 	"img3" => "t3.jpg",
// 	"img4" => "t4.jpg",
// 	"img5" => "t5.jpg",
// 	"prodcut_price1" => 10000,
// 	"prodcut_price2" => 9000,
// 	"prodcut_price3" => null,
// 	"product_status" => 1,	
// 	);
// $checkColumn = array("product_no");
// print_r($p -> update($table,$item,$checkColumn));


	// 4.新增/修改 規格
// echo "<pre>";		
// $p = new productObj(4);
// $table = "product_spec" ;
// $productSpecNo = 8; //null // 7
// if( $productSpecNo == null ){ //新增
// 	$item = array(
// 		"product_no" =>3 ,
// 		"product_spec_info"=>"新產品三規格" ,
// 		"product_spec_createtime"=>time()
// 	);
// 	$checkColumn = array("product_spec_no");
// 	print_r($p -> updateSpec($table,$item,$checkColumn));
// }else{ //修改
// 	$item = array(
// 		"product_spec_no" => 8,
// 		"product_spec_info"=>"新產品二規格fix2" ,
// 	);
// 	$checkColumn = array("product_spec_no");
// 	print_r($p -> updateSpec($table,$item,$checkColumn));
// }
// echo "</pre>";

	// 5.刪除 規格
// echo "<pre>";
// $p = new productObj(3);
// $table = "product_spec" ;
// $productSpecNo = 1;
// print_r($p -> deleteSpec($table,$productSpecNo));
// echo "</pre>";


//test
?>