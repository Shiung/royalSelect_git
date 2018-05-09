<?php 
// 測試
include("testInfo.php");
// 測試

include("module/header.php") 
?>

<section id="productShow">
	<nav aria-label="breadcrumb" class="breadcrumb-area">
		<button type="button" class="btn btn-sm return-btn" onclick="history.back();"><i class="fas fa-angle-left mr-2"></i>BACK</button>
		<div class="container">
			<ol class="breadcrumb">
				  <!-- <li class="breadcrumb-item"><a href="" class="back-btn"><i class="fas fa-angle-left mr-2"></i>BACK</a></li> -->
				  <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
				  <li class="breadcrumb-item active">北歐單人沙發</li>
			</ol>
		</div>
	</nav>

	<div class="container mt-5">
		<div class="col-12">
			<div class="row">
				<div class="col-12 col-md-5">
					<div class="center slide-prodcut slider-for">
						<?php  
							foreach ($product as $key => $value){	
						?>
						<div>
							<div class="img-box">
								<div class="img-box-area" style="background-image: url('<?php echo $value["img"]; ?>');"">
								</div>
							</div>
						</div>
						
						<?php } ?>
					</div>
					<div class="center slide slider-nav">
						<?php  
							foreach ($product as $key => $value){	
						?>
						<div>
							<div class="img-box">
								<div class="img-box-area" style="background-image: url('<?php echo $value["img"]; ?>');"">
								</div>
							</div>
						</div>
						
						<?php } ?>
					</div>
				</div>

				<div class="col-12 col-md-7">
					<div class="row">
						<div class="col-12">
							<h5 class="product-title"><?php echo $value["prodcut_name"] ;?></h5>
						</div>
						<div class="col-12">
							<div class="product-price">
								<span class="priceShow">$<?php echo  number_format($value["price"]) ;?> NTD</span>
								<span class="productStatusTag">團購中</span>
							</div>
						</div>
						
						<div class="col-12 ">
							<div class="row">
								<div class="col-12"><div class="line"></div></div>
								
								<div class="col-lg-7 col-6">
									<select class="custom-select col-12" id="product-spec-select">
										<option value="0" selected="">黑</option>
										<option value="1" >咖啡</option>
										<option value="2" >白</option>
									</select>
								</div>

								<div class="input-group col-lg-4 offset-lg-1 col-6">
									<div class="input-group-prepend">
										<span id="plus-quantity" class="input-group-addon"><i class="fas fa-plus"></i></span>
									</div>
										<input type="number" class="form-control" id="product-quantity-select" value="1">
									<div class="input-group-append">
										<span id="minus-quantity" class="input-group-addon"><i class="fas fa-minus"></i></span>
									</div>
								</div>

								<div class="col-12">
									<ul class="buy-info">
										<li>價格包含物品費用、運費、稅金</li>
										<li>商品到手一口價，無需額外負擔運費手續費</li>
									</ul>
								</div>

								<div class="col-12">
									<div class="purchase-area row">
										<div class="col-6">
											 <button id="addToCart" type="button" class="btn btn-sm">加入購物車</button>
										</div>
				                       	<div class="col-6">
				                       		 <button id="addToCartAndgoPayment" type="button" class="btn btn-sm">直接購買</button>
				                       	</div>
				                       
				                    </div>
								</div>
								
								<div class="col-12"><div class="line"></div></div>

								<div class="col-12">
									<div class="processBarInfo">
										<span>下訂組數 </span><span><?php echo $value["order"]; ?>組</span><span> | 開團組數 </span><span><?php echo $value["collection_quantity"]; ?>組</span><span> 75%</span>
									</div>
									<div class="processBar" data-toggle="tooltip" data-placement="bottom" title="">
										<div class="bar"></div>
										<input type="hidden" name="collection-use" value="<?php echo $value["order"]; ?>">
										<input type="hidden" name="collection-all" value="<?php echo $value["collection_quantity"]; ?>">
									</div>	

								</div>
							</div>
							
						</div>
					</div>
		
				</div>
			</div>
		</div>

	</div>
</section>

<section id="productContent">
	<div class="container">
		<div class="col-12">
			<nav class="nav-tap-box nav nav-pills flex-column flex-sm-row justify-content-center">
			  <a class="flex-sm-fill text-sm-center nav-link active" href="#!">商品特色</a>
			  <a class="flex-sm-fill text-sm-center nav-link" href="#!">運貨須知</a>
			  <a class="flex-sm-fill text-sm-center nav-link" href="#!">退貨須知</a>
			</nav>
		</div>

		<div class="col-12">
			
			<div class="content-detail row">
				<div class="col-lg-7 content-sec">
					<div class="content-inner">
						一件暫時認識不足十二加油友情連結環節藝術出去電子，在這裡避免讓我體驗主流措施交流立刻投資藍色尤其是通，不禁食物旁邊做法風格貸款孩子推廣相同那種我看人才，是啊承受驚訝適應實際上，使得材料建築數據庫上述能在軍事之中不好意思消費者進了監督爆炸。
					</div>
					
				</div>
				<div class="col-lg-5 content-sec">
					<iframe width="100%" height="315" src="https://www.youtube.com/embed/Zqgca5c2thc" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
				</div>

				<div class="col-lg-7 content-sec">
					<img src="https://api.fnkr.net/testimg/1000x600/00CED1/FFF/?text=img+placeholder" class="img-fluid">
				</div>
				<div class="col-lg-5 content-sec">
					<div class="content-title">義大利犀牛皮</div>
					<div class="content-inner">
						用來幾年理論只要同志早上興趣高手下載地址界面全新，樓主專門快速尤其是透露國內外分類，什麼樣收購怎麼過了主動瞬間辦理上來美好完成據說，嚴格中文售價我家快捷指定這麼情況實行自治區渠道你可以接觸看，維持更。
					</div>
				</div>

				<div class="col-lg-7 content-sec">
					<img src="https://api.fnkr.net/testimg/1000x600/00CED1/FFF/?text=img+placeholder" class="img-fluid">
				</div>
				<div class="col-lg-5 content-sec">
					<div class="content-title">不鏽鋼設計</div>
					<div class="content-inner">
						用來幾年理論只要同志早上興趣高手下載地址界面全新，樓主專門快速尤其是透露國內外分類，什麼樣收購怎麼過了主動瞬間辦理上來美好完成據說，嚴格中文售價我家快捷指定這麼情況實行自治區渠道你可以接觸看，維持更。
					</div>
				</div>
			</div>
		
		</div>
	</div>	
</section>



<?php include("module/footer.php") ?>