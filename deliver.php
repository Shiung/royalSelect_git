<?php 
include("module/header.php") ;
	// // -----購物車資訊----
	$orderTempList = [];
	if(isset($_SESSION["ordersCheckOut"]) && isset($_SESSION["checkSessionKey"])){ //有存在購物清單
		//刪除checkSessionKey
		unset($_SESSION["checkSessionKey"]);

		foreach ($_SESSION["ordersCheckOut"] as $orderskey => $ordersvalue) {
			foreach ($ordersvalue as $key => $value) {
				array_push($orderTempList,$value);
			}		
		}
	}else{ //沒有購物清單
		header("location:cart.php");
	}	
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

	<div class="container my-5 cart-list">
		<div class="col-12">
			<div class="row cartMenu">
				<div class="col-4 step">
					<li><span>1.</span> 購物清單</li>
				</div>
				<div class="col-4 step active">
					<li><span>2.</span> 填寫訂購資料</li>
				</div>
				<div class="col-4 step">
					<li><span>3.</span> 完成訂購</li>
				</div>			
			</div>
		</div>
		

		<div class="col-12">
			<div class="cart-title">填寫訂購資料</div>
		</div>
		
		<div class="col-lg-4 order-list">
		<?php 
		$totalPrice = 0;
		foreach ($orderTempList as $key => $value) { 
			$totalPrice += 	(int)$value["quanty"]*(int)$value['price'] ;		 
		?>
			<div class="card-group productZone">
			  <div class="card">
			  	<div class="card-header"><?php echo $value["product_name"]; ?></div>
			    <div class="card-body">
			      <div class="row">
			      	<div class="col-4"><div class="ct">規格</div></div>
			      	<div class="col-8"><div class="cc"><?php echo $value["product_spec_info"]; ?></div></div>
			      </div>
			      <div class="row">
			      	<div class="col-4"><div class="ct">數量</div></div>
			      	<div class="col-8"><div class="cc"><?php echo $value["quanty"]; ?></div></div>
			      	<input type="hidden" name="product_price" value="<?php echo $value['price']; ?>">
			      	<input type="hidden" name="model_id" value="<?php echo $value['model_id']; ?>">
			      </div>
			    </div>
			  </div>
			</div>
		<?php } ?>
			<div class="card-group priceZone">
			  <div class="card">
			    <div class="card-body">
			      <div class="row">
			      	<div class="col-4"><div class="ct">付款金額</div></div>
			      	<div class="col-8"><div class="cp">NT <?php echo number_format($totalPrice); ?></div></div>
			      	<input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
			      </div>
			    </div>
			  </div>
			</div>
		</div>
		
		<div class="col-lg-8">
			<from>
				<div class="form-group row">
				    <label for="memberEmail" class="col-sm-3 col-form-label col-form-label-sm">Email 信箱:</label>
				    <div class="col-sm-9">
				      <input type="email" class="form-control form-control-sm" id="memberEmail" placeholder="請輸入您的Email" value="">
				    </div>
				</div>
			  	<div class="form-group row">
			    	<label  class="col-sm-3 col-form-label col-form-label-sm">收件人姓名:</label>
			    	<div class="col-sm-4">
			      	<input type="text" class="form-control form-control-sm" id="memberLastName" placeholder="收件人姓氏" value="">
			    </div>
			    <div class="col-sm-5">
			      <input type="text" class="form-control form-control-sm" id="memberFirstName" placeholder="收件人名字" value="">
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="memberPhone" class="col-sm-3 col-form-label col-form-label-sm">聯絡電話:</label>
			    <div class="col-sm-9">
			      <input type="tel" class="form-control form-control-sm" id="memberPhone" placeholder="聯絡電話" value="">
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="memberAddress" class="col-sm-3 col-form-label col-form-label-sm">收件地址:</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control form-control-sm" id="memberAddress" placeholder="收件地址" value="">
			    </div>
			  </div>
			  <div class="form-group row">
				  <div class="col-12">
				  <label for="purchaseMemo" class="col-form-label col-form-label-sm">備註:</label>
				  <textarea class="form-control form-control-sm" id="purchaseMemo" rows="3"></textarea>
				  </div>				   
			  </div>
		 	</from>
			
			<div class="cart-title">付款資料</div>
			<div id="payment" class="row">
				<div class="col-12">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label col-form-label-sm">請選擇付款方式：</label>
						<div class="col-sm-9">
							<div class="form-check form-check-inline">
							  <label class="form-check-label">
							    <input class="form-check-input" type="radio" name="payway" id="payway1" value="0" checked> 信用卡
							  </label>
							</div>
							<div class="form-check form-check-inline">
							  <label class="form-check-label">
							    <input class="form-check-input" type="radio" name="payway" id="payway2" value="1"> ATM
							  </label>
							</div>
						</div>	
					</div> <!-- .form-group  -->
				</div><!-- .col-12 -->
			</div>	<!-- .row -->

			<div class="row">
				<div class="col-12">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label col-form-label-sm">請選擇發票種類：</label>
						<div class="col-sm-9">
							<div class="form-check form-check-inline">
							  <label class="form-check-label ">
							    <input class="form-check-input" type="radio" name="invoiceSelect" id="person_invoice" value="0" checked> 電子發票
							  </label>
							</div>
							<div class="form-check form-check-inline">
							  <label class="form-check-label">
							    <input class="form-check-input" type="radio" name="invoiceSelect" id="company_invoice" value="1"> 公司發票
							  </label>
							</div>
						</div>
					</div>	
					
					<div class="col-lg-12 col invoiceInfo">
						<div class="form-group row companyInvoice" style="display: none;">
							<label for="orderUniNo" class="col-12 col-form-label col-form-label-sm">統一編號:</label>
						    <div class="col-12">
						      <input type="text" class="form-control form-control-sm" id="orderUniNo" placeholder="" value="">
						    </div>
						</div>
						<div class="form-group row companyInvoice" style="display: none;">
							<label for="orderInvoiceTitle" class="col-12 col-form-label col-form-label-sm">發票抬頭:</label>
						    <div class="col-12">
						      <input type="text" class="form-control form-control-sm" id="orderInvoiceTitle" placeholder="" value="">
						    </div>
						</div>
						<div class="form-group row invoice">
							<label for="orderInvoiceAddress" class="col-12 col-form-label col-form-label-sm">中獎發票寄送地址:</label>
						    <div class="col-12">
						      <input type="text" class="form-control form-control-sm" id="orderInvoiceAddress" placeholder="" value="">
						    </div>
						    <div class="col-12" style="padding-left: 35px;padding-top: 5px;">
						    	<input class="form-check-input" type="checkbox" id="invoiceCheck">
					       		<label class="form-check-label" for="invoiceCheck">發票寄送地址同商品配送地址</label>
						    </div>	
						</div>
					</div>
				</div><!-- .col-12 -->
			</div><!-- .row-->

		</div>

		<div class="col-12">
			<div class="checkOutFinal row d-flex justify-content-center">
				<button type="button" class="btn" id="checkOutBtn">確認購買</button>
			</div>
			<form id="checkoutForm" action="payment-test.php" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="total_price" value="">
				<input type="hidden" name="order_no" value="">
				<input type="hidden" name="order_member_name" value="">
				<input type="hidden" name="order_member_tel" value="">
				<input type="hidden" name="order_member_email" value="">
			</form>
		</div>
		
	</div>
</section>




<?php include("module/footer.php") ?>