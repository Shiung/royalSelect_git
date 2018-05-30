<?php 
include("module/header.php") ;



// 測試

// echo "<pre>";
// print_r($oList);
// echo "</pre>";

// 測試
?>
<section id="cartShow">
	<nav aria-label="breadcrumb" class="breadcrumb-area">
		<button type="button" class="btn btn-sm return-btn" onclick="history.back();"><i class="fas fa-angle-left mr-2"></i>BACK</button>
		<div class="container">
			<ol class="breadcrumb">
				  <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
				  <li class="breadcrumb-item active">購物車</li>
			</ol>
		</div>
	</nav>

	<div class="container my-5">
		<div class="col-12">
			<div class="row cartMenu">
				<div class="col-4 step active">
					<li><span>1.</span> 購物清單</li>
				</div>
				<div class="col-4 step">
					<li><span>2.</span> 填寫訂購資料</li>
				</div>
				<div class="col-4 step">
					<li><span>3.</span> 完成訂購</li>
				</div>			
			</div>
		</div>

		<div class="col-12">
			<div class="row">
				<div class="cart-title">購物車</div>
			</div>
		</div>
		
		<div class="col-12">
		<?php
		if( count($oList) != 0) {
			foreach ($oList as $key => $value) {	
		?>
			<div class="cart-area row">
				<div class="col-2">
					<div class="img-box">
						<div class="img-box-area"  style="background-image: url('<?php echo "img/product/".$value['img1']; ?>');">
						</div>
					</div>
				</div>	

				<div class="col-6">
					<div class="product-title">
						<?php echo $value['product_name']; ?><span class="productStatusTag">團購中</span>
					</div>
					<div class="product-content">
						<?php echo $value['product_describe']; ?>
					</div>
				</div>	

				<div class="col-4">
					<select class="custom-select col-12" id="product-spec-select">
					<?php foreach ($value["specList"] as $skey => $svalue) { 
						$specSelected = "";
						if( $svalue["product_spec_no"] == $value["product_spec_no"] ){ $specSelected  = "selected" ;}
					?>
						<option value="<?php echo $svalue['product_spec_no']; ?>" <?php echo $specSelected; ?>><?php echo $svalue["product_spec_info"]; ?></option>
					<?php } ?>	
					</select> 
					<div class="input-group ">
						<div class="input-group-prepend">
							<span class="input-group-addon plus-quantity-btn"><i class="fas fa-plus"></i></span>
						</div>
							<input type="number" class="form-control product-quantity-select" value="<?php echo $value['quanty']; ?>">
						<div class="input-group-append">
							<span class="input-group-addon minus-quantity-btn"><i class="fas fa-minus"></i></span>
						</div>
					</div>
					
				</div>
				<div class="col-12 cart-option">
					<div class="line row"></div>
					<div class="row">
						<div class="col-6">
							<button type="button" class="btn delete-btn" data-toggle="tooltip" data-placement="bottom" title="刪除商品清單"><i class="fas fa-trash-alt"></i>刪除</button>
						</div>

						<div class="col-6 price-area">
							<div class="price">NT$ <span class="priceFormate"><?php echo number_format($value['price']*$value['quanty']); ?></span></div>
							<input type="hidden" name="origin_price" value="<?php echo $value['price']; ?>">
							<input type="hidden" name="origin_price_status" value="<?php echo $value['price_status']; ?>">
						</div>
					</div>
					<input type="hidden" name="product_no" value="<?php echo $value['product_no']; ?>">
					<input type="hidden" name="product_spec_no" value="<?php echo $value['product_spec_no']; ?>">
				</div>
			</div>	 <!-- end cart-area -->
			<?php 
				 } //end foreach 
			}else{ //end if
			?>
			<!-- <div class="cartWithoutList row">沒有購物清單</div>	 -->
			<div class="cartWithoutList row alert alert-warning" role="alert">
			  <strong class="mr-2">沒有購物清單!</strong> 請前往商品頁面選購
			</div>
		
			<?php } ?>

			<?php if( count($oList) != 0) { ?>
			<div class="checkOutCart row d-flex justify-content-center">
				<button type="button" class="btn" id="checkOutBtn">前往結帳</button>
			</div>
			<?php } ?>
		</div>
	</div>
</section>




<?php include("module/footer.php") ?>