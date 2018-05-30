<?php  
//連結db 、 productClass 、 config
date_default_timezone_set("Asia/Taipei");

class orderObj{
	public $orderList =[] ;

	public function __construct($status){ //1: cookie  , 2: session 
		switch ($status) {
			case 1://cookie
				if(isset($_COOKIE["orders"])){ //有存在購物清單
					$orders = json_decode($_COOKIE["orders"], true);
					// 確認訂單資訊
					if($this->orderCheck( $orders , 1 )){
						$this->bindListInfo();
					}else{
						$this->bindListInfo();
					}			
				}

				break;
			case 2://session
				if(isset($_SESSION["orders"])){ //有存在購物清單
					$orders = $_SESSION["orders"] ;
					// 確認訂單資訊
					if($this->orderCheck( $orders , 2 )){
						$this->bindListInfo();
					}else{
						$this->bindListInfo();
					}
				}
				break;
			default:
				# code...
				break;
		}
	}

	public function brief(){
		return $this->orderList;
	}
	public function bindListInfo(){
		$orders = json_decode($_COOKIE["orders"], true);
		foreach ($orders as $orderskey => $ordersvalue) {
			foreach ($ordersvalue as $key => $value) {
				$productSpecNo = $key ;
				$productNo = $orderskey ;
				$priceStatus = $value["price_status"];
				$p = new productObj( $value["product_no"] );
				$pInfo = $p -> brief();
				$value["model_id"] = $pInfo["model_id"];
				$value["product_name"] = $pInfo["product_name"];
				$value["product_describe"] = $pInfo["product_describe"];
				$value["img1"] = $pInfo["product_img"]["img1"];
				$value["price"] = $pInfo["price"][$priceStatus];
				$value["specList"] = $pInfo["spec"];
				array_push($this->orderList ,$value);
			}		
		}
	}

	public function orderCheck( $o , $status  ){
		switch ($status) {
			case 1:

				//連結productDB 確認資料庫是否存在資料
				$deletCount = 0 ;
				foreach ($o as $okey => $ovalue) {
					foreach ($ovalue as $key => $value) {
						$p = new productObj( $value["product_no"] );
						$pCheck = $p -> brief();						
						if( isset($pCheck["product_no"]) ){
							$productSpecNo = $key ;
							$productNo = $okey ;
							$pSpecNO = [];  
							foreach ($pCheck["spec"] as $skey => $svalue) {
								array_push( $pSpecNO , $svalue["product_spec_no"]);
							}
							if (!in_array($productSpecNo, $pSpecNO)){
								//配對不上刪除 清單
							  	unset($o[$productNo][$productSpecNo]);
								if(count($o[$productNo]) == 0 ){
									unset($o[$productNo]);
								}
								$deletCount ++ ;
							}
						}else{
							$productNo = $okey ;
							$productSpecNo = $key ;
							//配對不上刪除 清單
							unset($o[$productNo][$productSpecNo]);
							if(count($o[$productNo]) == 0 ){
								unset($o[$productNo]);
							}
							$deletCount ++ ;
						}
					}		
				} 
				if( $deletCount != 0 ){
					setcookie("orders",json_encode($o),time()+(60*60*24*30),"/");
					return false;
				}else{
					return true;
				}
				
				break;
			case 2:
				# code...
				break;

			default:
				# code...
				break;
		}
	}

	public function orderCreateDB( $table , $data ){
		$db = new DB();
		return $db-> DB_Insert($table,$data);
		// return $db->lastId;
	}


}

?>