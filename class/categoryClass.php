<?php  

date_default_timezone_set("Asia/Taipei");

class category{
	public $cateNo ;
	public $cateName ;
	public $cateParent ;
	public $cateType = []; 
	public $cateLevel ;
	public $cateLogoImg ;
	public $cateBannerImg;
	public $cateDescribe;
	public $cateUpdateTime ;
	public $products = []; //產品內容
	public $articles = []; //文章內容

	//分頁
	public $pageSql ;

	public $record_count ;
	public $total_page ;
	public $page_no ;
	//分頁 

	public $categoryExistNone ;
	
	public function __construct($cid=null){
		if( $cid ){
			$db = new DB();
			$sql = "SELECT * FROM category where cate_no = :cate_no";
			$dic = array(":cate_no" => $cid );
			$result = $db -> DB_query($sql,$dic);
			if( count($result) != 0 ){
				foreach ($result as $key => $value) {
					$this->cateNo = $value["cate_no"];
					$this->cateName = $value["cate_name"];
					$this->cateParent = $value["cate_parents"];
					$this->cateLevel = $value["cate_level"];
					$this->cateLogoImg = $value["cate_logo_img"];
					$this->cateBannerImg = $value["cate_banner_img"];
					$this->cateDescribe = $value["cate_describe"];
					if( $value["cate_level"] == 0 ){ //主要大分類的ID
						$this->cateType["cate_no"] = $value["cate_no"];
						$this->cateType["cate_name"] = $value["cate_name"];
					}else{ //搜尋此分類的大分類ID
						$this->cateType( $value["cate_parents"] );
					}
				}
			}else{
				$this->categoryExistNone = "1"; // 找不到分類
			}	
		}else{
			$this->categoryExistNone = "1"; // 找不到分類
		}
	}

	public function getCateInfoByCateID(){
		if( !$this->categoryExistNone ){ 
			return array(
				"cate_no" => $this->cateNo,
				"cate_name" => $this->cateName,
			 	"cate_parents" => $this->cateParent,
			    "cate_level" => $this->cateLevel,
			    "cate_logo_img" => $this->cateLogoImg,
				"cate_banner_img" => $this->cateBannerImg,
				"cate_describe" => $this->cateDescribe,
				"cate_type"=> $this->cateType,
			);
		}else{
			return false;//"找不到分類"
		}
		
	}

	public function cateType( $parentCid ){
		if( !$this->categoryExistNone ){ 
			$result = $this->cateFatherQuery( $parentCid );
			if( $result[0]["cate_parents"] == 0 && $result[0]["cate_level"] == 0 ){ //大分類層
				$this->cateType["cate_no"] =  $result[0]["cate_no"];
				$this->cateType["cate_name"] =  $result[0]["cate_name"];
			}else{ //父層不是大分類層
				$result2 = $this->cateFatherQuery( $result[0]["cate_parents"] );
				$this->cateType["cate_no"] =  $result2[0]["cate_no"];
				$this->cateType["cate_name"] =  $result2[0]["cate_name"];
			}
		}else{
			return false;//沒有分類項目
		}
		
	}

	public function cateFatherQuery($cid){ //找父層
		if(!$this->categoryExistNone){ // 有分類項目
			$db = new DB();
			$sql = "SELECT * from category where cate_no ='".$cid."'";
			$result = $db->DB_Query($sql) ;
			if(!count($result)){
				return false ;//echo "沒有父層"; 
			}else{
				return $result;
			}
		}else{//無分類項目
			return false ;//echo "無分類項目"
		}		
	} 

	public function getChildLevelbyCateID($parentCid , $without=null){
		if( !$this->categoryExistNone ){
			$withoutStr = "";
			if( isset($without) ){
				foreach ($without as $key => $value) {
					$withoutStr .= " and cate_no != '" .$value."' ";
				}
			}
			$db = new DB();
			$sql = "SELECT * from category where cate_parents = '".$parentCid."' ". $withoutStr;
			$result = $db->DB_Query($sql) ;
			if(!count($result)){
				return false ;//echo "沒有子層"; 
			}else{
				return $result;
			}
		}else{

		}
	}


	public function pagenation($page,$recPerPage){
		//當前頁數
		$pageNo = isset($page)? $page : 1;
		$this->page_no = $pageNo;
		//總共query數量
		$totalRecord = $this->record_count;
		//每頁有幾筆
		$recPerPage = isset($recPerPage)? $recPerPage : 5;
		//共有幾頁
		$totalPage = ceil($totalRecord/$recPerPage);
		$this->total_page = $totalPage;

		$pageStart = ($pageNo-1) * $recPerPage;
		$pageSql = "limit $pageStart,$recPerPage";
	
		$this->pageSql = $pageSql;

		$result = array(
			"recordsTotal" => $this->record_count,
			"totalPage" =>  $this->total_page,
			"pageNo" => $this->page_no,
			);
		return $result;
	}

		
}

?>	