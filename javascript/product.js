$(document).ready(function(){
	$('.slider-for').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: false,
	  fade: true,
	  asNavFor: '.slider-nav'
	});
	$('.slider-nav').slick({
	  slidesToShow: 3,
	  slidesToScroll: 1,
	  asNavFor: '.slider-for',
	  dots: false,
	  centerMode: true,
	  focusOnSelect: true,
	  autoplay: true,
	  autoplaySpeed: 2000,
	  nextArrow: '<button type="button" class="slick-next"><i class="fas fa-caret-right"></i></button>',
	  prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-caret-left"></i></button>'
	});
	$('.slider-for').hover(function(){
		$('.slider-nav').slick('slickPause');
	},function(){
		$('.slider-nav').slick('slickPlay');
	});

	//產品內頁分頁
	$("#productContent .nav-link").click(function(){
		if( $(this).attr("class").search("active") == -1 ){ 
			$("#productContent .nav-link").removeClass("active");
			$(this).addClass("active");
		}else{

		}
	});

	//商品數量選單鈕
	$("#plus-quantity").click(function(){
		calcOrderQuantity(1);
	});
	$("#minus-quantity").click(function(){
		calcOrderQuantity(-1);
	});

	//計算數量
	function calcOrderQuantity(a){
		var productQuantity = $("input#product-quantity-select").val();
		var productQuantityChange =  parseInt(productQuantity) + parseInt(a);
		var prodcutStock =10;
		if( productQuantityChange > prodcutStock ){ //大於庫存
			productQuantityChange = prodcutStock;
		}else if( productQuantityChange < 1 ){
			productQuantityChange = 1;
		}

		$("input#product-quantity-select").val(productQuantityChange);
	}


	//加入購物車
	$("#addToCart").click(function(){
		addToCart($(this),true);
	});
	//直接購物車
	$("#addToCartAndgoPayment").click(function(){
		addToCart($(this),true);
	});

	function addToCart(obj,goCart){
		var pid = $("input[name='product_no']").val();
		var pQuan = $("input#product-quantity-select").val();
		var pSpec = $("select#product-spec-select").val();
		var pPrice = $("input[name='product_price']").val();
		var pPrice_status = $("input[name='pPrice_status']").val();
		var status = "addCartOnly";
		$.ajax({
			url : "api/cartAjax.php",
			data : {product_no : pid,status : status ,product_spec_no :pSpec,quanty : pQuan, price: pPrice,price_status : pPrice_status },
			type : "get",
		    cache : false,
		    success : function(result){
			    if (goCart){
				    location.replace("cart.php");
			    }else{
				  	if(result){ 
			    		swal({
						  title: "已加入購物車",
						  icon: "success",
						}).then( function(confrim) {
						  checkOrderCookie();
						  location.reload();
						});
			    	}else{ 
			    		alert("section");
			    	} 	
			    }
		    },
		    error : function(error){
			    // if (goCart){
			    // 	location.replace("cart.php");
			    // }else{
				   // alert("傳送失敗"); 
			    // }
			    console.log(error);
		    } 
		});
	}
});