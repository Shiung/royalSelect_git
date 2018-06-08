$(document).ready(function(){

	//訂單修改
	//1.商品數量選單鈕
	$(".plus-quantity-btn").click(function(){
		var g = $(this).parents(".input-group");
		calcOrderQuantity(1, g);
	});
	$(".minus-quantity-btn").click(function(){
		var g = $(this).parents(".input-group");
		calcOrderQuantity(-1,g);
	});

	//1.計算數量
	function calcOrderQuantity(a,g){
		var productQuantity = g.find("input.product-quantity-select").val();
		var productQuantityChange =  parseInt(productQuantity) + parseInt(a);
		if( productQuantityChange < 1 ){
			productQuantityChange = 1;
		}
		g.find("input.product-quantity-select").val(productQuantityChange);
		var pid = g.parents(".cart-area").find("input[name='product_no']").val();
		var spec = g.parents(".cart-area").find("#product-spec-select").val();
		editOrder( spec , productQuantityChange , pid );
	}

	// 2. 規格變更 
	var specNoOrigin = $("#product-spec-select").val();
	$("#product-spec-select").change(function(){
		var pid = $(this).parents(".cart-area").find("input[name='product_no']").val();
		var quantity = $(this).parents(".cart-area").find("input.product-quantity-select").val();

		var priceStatusOrigin = $(this).parents(".cart-area").find("input[name='origin_price_status']").val();
		//1. 刪除舊的訂單資訊
		deleteOrder( pid , specNoOrigin , false );
		// 2. 薪增訂單資訊
		createOrder( pid ,  quantity , $(this).val() , priceStatusOrigin);
	});

	// 3.ajax
	function editOrder( spec , quantity , pid){
		var productNo = pid;
		var productSpecNo = spec ;
		var quanty = quantity ;
		var status = "editCartDetail";
		$.ajax({
			url : "api/cartAjax.php",
			data : {product_no : productNo,status : status ,product_spec_no : productSpecNo,quanty : quanty},
			type : "get",
		    cache : false,
		    success : function(result){
		    	if(result){  
		    		location.reload();
		    	}else{ 
		    		alert("section");
		    	}
		    },
		    error : function(error){
		    	alert("傳送失敗");
		    } 
		});
	}

	//刪除訂單
	$('.delete-btn').click(function(){
		var pid = $(this).parents(".cart-area").find("input[name='product_no']").val();
		var psid = $(this).parents(".cart-area").find("input[name='product_spec_no']").val();
		deleteOrder( pid , psid , true );
	});

	function deleteOrder( pid , psid , s ){
		var productNo =  pid;
		var productSpecNo = psid ;
		var status = "deleteCartDetail";
		$.ajax({
			url : "api/cartAjax.php",
			data : {product_no : productNo,status : status ,product_spec_no : productSpecNo},
			type : "get",
		    cache : false,
		    success : function(result){
		    	if( s ){ //狀態確認
		    		if(result){  
			    		location.reload();
			    	}else{ 
			    		alert("section");
			    	}
		    	}else{

		    	}
		    	
		    },
		    error : function(error){
		    	alert("傳送失敗");
		    } 
			});
	}

	//create new order list
	function createOrder( pid , quant , spec , priceStatus ){
		var pid = pid;
		var pQuan = quant;
		var pSpec = spec;
		var pPrice_status = priceStatus;
		var status = "addCartOnly";
		$.ajax({
			url : "api/cartAjax.php",
			data : {product_no : pid,status : status ,product_spec_no :pSpec,quanty : pQuan,price_status : pPrice_status },
			type : "get",
		    cache : false,
		    success : function(result){
		    	if(result){  
		    		location.reload();
		    	}else{ 
		    		alert("section");
		    	}
		    },
		    error : function(error){
		    	alert("傳送失敗");
		    } 
			});
	}

	//前往結帳
	$(".checkOutCart #checkOutBtn").click(function(){
		//紀錄 session狀態儲存 會在資訊頁面刪除
		var checkStatus ="checkSessionKey";
		$.ajax({
			url : "api/cartAjax.php",
			type : "get",
			data : {status : checkStatus },
		    cache : false,
		    success : function(result){
		    	
		    },
		    error : function(error){
		    	// alert("傳送失敗");
		    	alert("key失敗");
		    } 
		});

		// 刪除舊的暫存訂單資訊
		var status ="clearOldcartBeforeCheckOut";
		$.ajax({
			url : "api/cartAjax.php",
			type : "get",
			data : {status : status },
		    cache : false,
		    success : function(result){
		    	if(result){  
		    		cartSession();
		    	}else{ 
		    		alert("clear error");
		    	}
		    },
		    error : function(error){
		    	// alert("傳送失敗");
		    	alert(error);
		    } 
		});
	});

	function cartSession(){
	
		var status ="cartBeforeCheckOut";
		$.ajax({
			url : "api/cartAjax.php",
			data : {status : status},
			type : "get",
		    cache : false,
		    async: false,
		    success : function(result){
		    	
		    },
		    error : function(error){	
		    	alert("傳送失敗");
		    } 
		}).done(function(){
			location.href = "deliver.php";
		});

	}

	// deliver.php

	// 登入按鈕
	$("#shopLoginBtn").click(function(){
		var emailReg = /^\w+((-\w+)|(\.\w+))*\@[\w]+((\.|-)[\w]+)*\.[A-Za-z]+$/; 
		var pswReg = /^(?=^.{6,}$)((?=.*\w)(?=.*\d)(?=.*[A-Za-z]))^.*$/;
		var mail = $("#LoginEmail").val().trim();
		var psw = $("#LoginPassword").val().trim();
		//1.會員帳號確認是否存在
		var memCheck ;
		if( registerMemCheck(mail) ){
			memCheck = 1 ; //無此會員帳號
		}else{
			memCheck = 2 ; //有此會員帳號
		}

		if( emailReg.test(mail) === false ){
			swal({
			  title: "請輸入有效E-Mail",
			  icon: "error",
			}).then( function(confrim) {
				$("#loginBox .modal-body form #login-username").siblings(".label-custom").addClass("active");
				$("#loginBox .modal-body form #login-username").select();
			});
		}else if( memCheck == 1 ){
			swal({
				title: "查無此會員帳號",
				icon: "error",
			  }).then( function(confrim) {
				  $("#loginBox .modal-body form #login-username").siblings(".label-custom").addClass("active");
				  $("#loginBox .modal-body form #login-username").select();
			  });
		}else if( pswReg.test(psw) === false  ){
			swal({
				title: "請輸入英數碼六位數以上",
				icon: "error",
			}).then( function(confrim) {
				$("#loginBox .modal-body form #login-password").siblings(".label-custom").addClass("active");
				$("#loginBox .modal-body form #login-password").select();
			});
		}else{
			//紀錄 session狀態儲存 會在資訊頁面刪除
			var checkStatus ="checkSessionKey";
			$.ajax({
				url : "api/cartAjax.php",
				type : "get",
				data : {status : checkStatus },
				cache : false,
				success : function(result){	
				},
				error : function(error){
					alert("key失敗");
				} 
			});
			login( mail , psw );
		}
	});
	
	// 首購
	$("#firstShopBtn").click(function(){
		$(".infoBox").css("opacity","0");
		$(".infoBox").show(0);
		$(".checkMember").hide(0);
		$(".infoBox").animate({opacity:'1'},500);
	});

	//公司發票內容
	$("input[name='invoiceSelect']").click(function(){
		$("div.invoiceInfo").show();
		$("input#orderUniNo").val("");
		$("input#orderInvoiceTitle").val("");
		$("input#orderInvoiceAddress").val("");
		$("input#person_invoice").prop("checked");
		if($("input#person_invoice").prop("checked") === true){
			$("div.companyInvoice").hide();
			$("div.invoice").show(300);
		}else{
			$("div.companyInvoice").show(300);
			$("div.invoice").show(300);
		};
	});
	$("input#invoiceCheck").click(function(){
		if($(this).prop("checked") === true){
			$("input#orderInvoiceAddress").val("");
			$("input#orderInvoiceAddress").css("backgroundColor","");
			$("input#orderInvoiceAddress").attr("disabled",true);
		}else{
			$("input#orderInvoiceAddress").attr("disabled",false);
		}
	});


	$(".checkOutFinal #checkOutBtn").click(function(e){
		e.preventDefault();
	var emailReg = /^\w+((-\w+)|(\.\w+))*\@[\w]+((\.|-)[\w]+)*\.[A-Za-z]+$/; 
	var pswReg =  /^(?=^.{6,}$)((?=.*[0-9])(?=.*[a-z|A-Z]))^.*$/; //password
	var memNOcheck = $("input#memberNo").val();
	var modelId = $("input[name='model_id']").val().trim();
	var orderEmail = $("input#memberEmail").val().trim();
	
	var orderLastName = $("input#memberLastName").val().trim();
	var orderFirstName = $("input#memberFirstName").val().trim();
	var orderAddress = $("input#memberAddress").val().trim();
	var orderTel = $("input#memberPhone").val().trim();
	var orderMemo = $("textarea#purchaseMemo").val().trim() == '' ? null : $("textarea#purchaseMemo").val().trim();

	var paywaySelect = $("input[name='payway']"); //付款方式
	var pay = "" ;
	paywaySelect.each(function(){
		if($(this).prop("checked") == true){
			pay = $(this).val();
		}	
	});
	var personInvoiceCheckBtn = $("input#person_invoice"); //發票勾選個人發票
	var companyInvoiceCheckBtn = $("input#company_invoice"); //發票勾選公司發票
	var orderUniNo = $("input#orderUniNo").val().trim() ; //統一編號
	var orderUniTitle = $("input#orderInvoiceTitle").val().trim();//統編抬頭
	var orderInvoiceAddress = $("input#orderInvoiceAddress").val().trim(); //發票寄送位置

	var totalPrice = $("input[name='total_price']").val();

	//提示匡預設
	$("input#orderUniNo").css("backgroundColor","");
	$("input#orderInvoiceTitle").css("backgroundColor","");
	$("input#orderInvoiceAddress").css("backgroundColor","");
	$("input#memberLastName").css("backgroundColor","");
	$("input#memberFirstName").css("backgroundColor","");
	$("input#memberAddress").css("backgroundColor","");
	$("input#memberPhone").css("backgroundColor","");

	if( emailReg.test(orderEmail) === false ){
		swal({
		  title: "請輸入有效E-Mail",
		  icon: "error",
		}).then( function(confrim) {
			$("input#memberEmail").select();
		});
	}else if(orderLastName == '' || orderFirstName == '' || orderAddress =='' || orderTel == ''){
		swal({
		  title: "請填妥資訊",
		  icon: "error",
		}).then( function(confrim) {
			if(orderLastName == ''){$("input#memberLastName").css("backgroundColor","#f45042");}
			if(orderFirstName == ''){$("input#memberFirstName").css("backgroundColor","#f45042");}
			if(orderAddress == ''){$("input#memberAddress").css("backgroundColor","#f45042");}
			if(orderTel == ''){$("input#memberPhone").css("backgroundColor","#f45042");}
		});
	}else if(paywaySelect.prop("checked") == false){
		swal({
		  title: "請勾選付款方式",
		  icon: "error",
		}).then( function(confrim) {
			paywaySelect.focus();
		});
	}else if( personInvoiceCheckBtn.prop("checked") ===false && companyInvoiceCheckBtn.prop("checked") === false){
		swal({
		  title: "請勾選發票種類",
		  icon: "error",
		}).then( function(confrim) {
			personInvoiceCheckBtn.focus();
		});
	}else if( personInvoiceCheckBtn.prop("checked") ===true && ( orderInvoiceAddress == "" && $("input#invoiceCheck").prop("checked") === false )){
		swal({
		  title: "請選擇發票發送地址",
		  icon: "error",
		}).then( function(confrim) {
			$("input#orderInvoiceAddress").focus();
		});
	}else if( companyInvoiceCheckBtn.prop("checked") === true && (( orderInvoiceAddress == "" && $("input#invoiceCheck").prop("checked") === false )  || orderUniNo =="" || orderUniTitle == "" ) ){
		swal({
		  title: "請填妥發票資訊",
		  icon: "error",
		}).then( function(confrim) {
			if(orderUniNo == "" ){$("input#orderUniNo").css("backgroundColor","#f45042");}
			if(orderUniTitle == "" ){$("input#orderInvoiceTitle").css("backgroundColor","#f45042");}
			if(orderInvoiceAddress == "" && $("input#invoiceCheck").prop("checked") === false){$("input#orderInvoiceAddress").css("backgroundColor","#f45042");}
		});
	}else{
		//=====確認首購=====		
		if( memNOcheck == undefined ){ //首購 進行帳密確認並新增會員
			//帳號重複確認
			var memCheck = '';
			if( registerMemCheck(orderEmail) ){
				memCheck = 1 ; //新會員
			}else{
				memCheck = 2 ; //會員帳號重複
			}
			var psw = $("input#memberPassword").val().trim();
			var pswRecheck = $("input#memberPasswordAgain").val().trim();
			if( memCheck == 2 ){
				swal({
					title: "帳號已經使用，請再次確認",
					icon: "error",
				  }).then( function(confrim) {
					  $("input#memberEmail").select();
				  });
				  return;
			}else if( pswReg.test(psw) === false ){
				swal({
				  title: "請輸入英數碼六位數以上",
				  icon: "error",
				}).then( function(confrim) {
					$("input#memberPassword").select();
				});
				return;
			}else if( psw != pswRecheck){
				swal({
				  title: "請確認輸入的'確認密碼'與'密碼'相同",
				  icon: "error",
				}).then( function(confrim) {
					$("input#memberPasswordAgain").select();
				});
				return;
			}else{
				//新增會員
				var newMemNo = registerMemCreate( orderEmail , psw , orderLastName , orderFirstName ,  orderTel );
				if( !newMemNo ){
					swal({
						title: "帳號建立失敗",
						icon: "error",
					}).then( function(confrim) {                           
					});
					return 
				}else{
					//memNo,memMail,psw,tel,lastName,firstname,note,memToken,loginTime,loginIp
					if( memUpdate(newMemNo,orderEmail,null,null,null,null,null,true,null,null) ){ //更新mem_token 
						//儲存cookie 和session 
						if(memSessionAndCookie( orderEmail , psw )){
						}else{
							alert("登入失敗");
						}
					}else{
						alert("更新失敗");
					}
					
					//發信
					// newMemSendMail( userMail , userLastName , userFirstName , userTel ); //公司內部通知 and userEDM
					memNO = newMemNo ;
				}
			}

		}else{
			memNO = memNOcheck.trim();
		} 	
		// ====個人資訊=====
		var orderRecipient = orderLastName + orderFirstName;
		var purchaseInfo = [];
		purchaseInfo.push(memNO); //0  memNO
		purchaseInfo.push(orderEmail); //1
	 	purchaseInfo.push(orderRecipient); //2
		purchaseInfo.push(orderAddress); //3
		purchaseInfo.push(orderTel); //4
		purchaseInfo.push(orderMemo); //5
		purchaseInfo.push(pay); //6
		// =====發票狀態=====
		var orderUniStatus ="";
		if(personInvoiceCheckBtn.prop("checked") ===true){
			orderUniStatus = 0;
		}else if(companyInvoiceCheckBtn.prop("checked") === true){
			orderUniStatus = 1;
		}
		if( orderUniNo == "" ){
			 orderUniNo = null;
		}
		if( orderUniTitle == "" ){
			orderUniTitle = null ;
		}
		if( orderInvoiceAddress == "" ){
			orderInvoiceAddress = "同商品配送地址";
		}
		 
		var status = "createOrderItem";	
		$.ajax({
			url:"api/orderAjax.php",
			data : {status : status,info : purchaseInfo,order_uni_status : orderUniStatus,order_uni_no : orderUniNo,order_uni_title : orderUniTitle,order_invoice_address : orderInvoiceAddress , model_id : modelId},
			type : "get",
		    cache : false,
		    success : function(result){
			    	if(result){ //true 
			    		orderNo = result; //回傳訂單編號傳給弘揚
			    	}else{ //false
			    		swal({
						  title: "訂單傳送異常",
						  icon: "error",
						}).then( function(confrim) {
						 
						});
			    	}
	    		},
		    error : function(error){
			    	alert("傳送失敗");
			    } 
		}).done(function() {

			// // =====發送mail=====
    		var mailStatus = "sendOrderMail";
    		$.ajax({
    			url:"api/memAjax.php",
				data : {status : mailStatus,order_email : orderEmail,order_name : orderRecipient,order_tel : orderTel ,order_pay : pay,order_address : orderAddress,order_no : orderNo},
				type : "get",
			    cache : false,
			    success : function(mailResult){
			    		console.log(mailResult);
			    		// console.log(totalPrice);		    	
		    		},
			    error : function(error){
				    	alert("傳送失敗");
				    } 
    		}).done(function(){	    		
				// ====完成儲存後====
				  // 1.刪除session暫存
				  // 2.刪除cookie清單
				  var status = "clearAll";
				  $.ajax({
					url:"api/cartAjax.php",
					data : {status : status},
					type : "get",
				    cache : false,
				    success : function(result){
				    		// console.log(orderNo);
				    		// console.log(totalPrice);		    	
			    		},
				    error : function(error){
					    	alert("傳送失敗");
					    } 
					}).done(function(){
						$("input[name='total_price']").val(totalPrice);
						$("input[name='order_no']").val(orderNo);
						$("input[name='order_member_name']").val(orderRecipient);
						$("input[name='order_member_tel']").val(orderTel);
						$("input[name='order_member_email']").val(orderEmail);
						// $("form#checkoutForm").submit();
						
						//test
						location.reload();
						//test
					});			
	   		});
			
		});
	}
	

		// alert("要送出");
	});


});