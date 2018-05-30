<?php 

include("module/header.php");

//測試//
//-----假資料
// include("testInfo.php");

//-----假資料資料庫
$db = new DB();
$sql = "SELECT product_no from product ";
$result = $db->DB_query($sql);
$order = array(
	"3" => "30",
	"4" => "40",
	"5" => "20",
	"6" => "30",
	"7" => "30",
	);
$products = [];
foreach ($result as $key => $value) {
	$pid = $value["product_no"];
	$p = new productObj($pid); 
	$pro = $p->brief();
	$products[$pid] = $pro;
	$products[$pid]["order"] = $order[$pid];
}
//測試//
?>

<section id="s1">
	<div class="banner d-flex align-items-center justify-content-center">
		<div class="text-center">
			<div class="title color-w">歐洲代購最佳首選</div>
			<div class="content color-w">
				皇家嚴選為最專業的歐洲代購，以最低廉的海空運費<br>
				為大型商品海運代購的第一指標
			</div>
			<button type="button" class="btn banner-btn">VIEW COLLECTION</button>
		</div>
		
	</div>	
</section>
<section id="s2">
	<div class="container">
		<div class="row">
			<?php 
			foreach ($products as $key => $value) {
			?>
			<div class="col-xl-6 col-md-4 col-6">
				<div class="product-area row">
					<div class="col-xl-6 col-12">
						<div class="img-box">
							<div class="img-box-area" style="background-image: url('<?php echo "img/product/".$value["product_img"]["img1"]; ?>')"></div>	

							<!-- hover -->
							<div class="productHover">
								<div class="addCart" data-toggle="tooltip" data-placement="top" title="add to cart">
									<svg style="enable-background:new 0 0 128 128;" version="1.1" viewBox="0 0 128 128" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Layer_1"/><g id="refrigerator"/><g id="washer"/><g id="tv"/><g id="microwawe"/><g id="vacuum_cleaner"/><g id="Gift"/><g id="umbrella"/><g id="rocket"/><g id="basket"/><g id="shopping"/><g id="email"/><g id="message"/><g id="delivery"/><g id="store"/><g id="label"/><g id="phone"/><g id="imac"/><g id="laptop"/><g id="heart_like"/><g id="game"/><g id="wallet"/><g id="camera"/><g id="battery"/><g id="shoes"/><g id="t-shirt"/><g id="pencil"/><g id="people"/><g id="statistics"/><g id="blog"/><g id="rock"/><g id="like"/><g id="dislike"/><g id="speaker"/><g id="pc"/><g id="glasses"/><g id="headphones"/><g id="player"/><g id="book"/><g id="transfer"/><g id="mouse"/><g id="package"><g><g><path d="M106.456,120H21.544c-2.756,0-5.417-1.153-7.3-3.165c-1.884-2.012-2.86-4.742-2.68-7.491l3.947-60     C15.857,44.104,20.241,40,25.491,40h77.018c5.25,0,9.634,4.104,9.979,9.343l3.947,60.001c0.181,2.749-0.796,5.479-2.68,7.491     C111.873,118.847,109.212,120,106.456,120z M25.491,44c-3.15,0-5.78,2.463-5.987,5.606l-3.947,59.999     c-0.11,1.675,0.46,3.271,1.606,4.495c1.147,1.225,2.703,1.899,4.381,1.899h84.912c1.678,0,3.233-0.675,4.381-1.899     c1.146-1.225,1.717-2.82,1.606-4.495l-3.947-60c-0.207-3.143-2.837-5.605-5.987-5.605H25.491z" style="fill:#fff;"/></g><g><path d="M97,56c-1.104,0-2-0.896-2-2v-4.5C95,28.271,81.094,11,64,11S33,28.271,33,49.5V54     c0,1.104-0.896,2-2,2s-2-0.896-2-2v-4.5C29,26.065,44.701,7,64,7s35,19.065,35,42.5V54C99,55.104,98.104,56,97,56z" style="fill:#fff;"/></g></g></g><g id="exellent"/><g id="card"/><g id="induction"/><g id="revers_camera"/><g id="flesh_drive"/><g id="time"/><g id="sale"/><g id="tablet"/><g id="search"/></svg>
								</div>
								
								<div class="favor" data-toggle="tooltip" data-placement="top" title="add to favor">
									<i class="far fa-heart"></i>
								</div>
								
							</div>

							<!-- product status tag -->
							<div class="productStatusTag">團購中</div>

							<!-- form -->
							<form class="productForm" action="product.php" method="get">
								<input type="hidden" name="product_no" value="<?php echo $value["product_no"]; ?>">
							</form>
						</div>
					</div> 
					<div class="col-xl-6 col-12 productFlex">
						<div class="product-title"><?php echo $value["product_name"] ;?></div>
						<div class="product-content">
							<?php echo $value["product_describe"]; ?>
						</div>
						<div class="product-price">一口價<span class="priceShow">$<?php echo number_format($value["price"]["price1"]) ;?></span></div>
					</div>

					<div class="col-12">
						<div class="processBar" data-toggle="tooltip" data-placement="bottom" title="">
							<div class="bar"></div>
							<input type="hidden" name="collection-use" value="<?php echo $value["order"]; ?>">
							<input type="hidden" name="collection-all" value="<?php echo $value["collection_quantity"]; ?>">
						</div>
					</div>

					<!-- new tag -->
					<div class="newTag">NEW</div>

				</div> <!-- end .product-area -->
			</div>
			<?php }  ?>	

		</div>		
	</div>
</section>

<section id="s3">
	<div class="container">
		<div class="sucess-title">成功案例</div>

		<div class="slide-index">
			<div class="success-product">
				<div class="img-box">
					<div class="img-box-area" style="background-image: url('img/product/product-test1.jpg')"></div>	

					<div class="productStatus bg-blue-process">
						靠港日剩下35天
					</div>
				</div>
				<div class="product-title"><?php echo $value["product_name"] ;?></div>
				<div class="product-price"><span class="priceShow">$10000</span></div>
			</div>
			<div class="success-product">
				<div class="img-box">
					<div class="img-box-area" style="background-image: url('img/product/product-test2.jpg')"></div>	

					<div class="productStatus bg-blue-process">
						靠港日剩下15天
					</div>
				</div>
				<div class="product-title"><?php echo $value["product_name"] ;?></div>
				<div class="product-price"><span class="priceShow">$10000</span></div>
			</div>
			<div class="success-product">
				<div class="img-box">
					<div class="img-box-area" style="background-image: url('img/product/product-test3.jpg')"></div>	

					<div class="productStatus bg-blue-process">
						已靠港
					</div>
				</div>
				<div class="product-title"><?php echo $value["product_name"] ;?></div>
				<div class="product-price"><span class="priceShow">$10000</span></div>
			</div>
			<div class="success-product">
				<div class="img-box">
					<div class="img-box-area" style="background-image: url('img/product/product-test4.jpg')"></div>	

					<div class="productStatus bg-green-deliver">
						出貨中
					</div>
				</div>
				<div class="product-title"><?php echo $value["product_name"] ;?></div>
				<div class="product-price"><span class="priceShow">$10000</span></div>
			</div>
			<div class="success-product">
				<div class="img-box">
					<div class="img-box-area" style="background-image: url('img/product/product-test5.jpg')"></div>	

					<div class="productStatus bg-green-deliver">
						出貨中
					</div>
				</div>
				<div class="product-title"><?php echo $value["product_name"] ;?></div>
				<div class="product-price"><span class="priceShow">$10000</span></div>
			</div>


		</div>
	</div>	
</section> 	

<?php include("module/footer.php"); ?>