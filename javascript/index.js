$(document).ready(function(){
	// tooltip
	$(".favor").tooltip();
	$(".addCart").tooltip();
	$(".delete-btn").tooltip();

	//process bar
	$(".processBar").each(function(){
		var processBar =  parseInt($(this).find("input[name='collection-use']").val());
		var processAllBar =  parseInt($(this).find("input[name='collection-all']").val());
		var processPersent =Math.round((processBar/processAllBar)*100)+"%";

		$(this).find(".bar").animate({"width":processPersent},500);

		// $(this).attr("data-original-title",processPersent);
		$(this).tooltip({
			 animation : true,
			 placement : "bottom", 
			 html : true,
			 title : "<small>下訂 "+processBar+" 組 | 開團 "+processAllBar+" 組 "+processPersent+"</small>",
			 container : "#s2"
		});
	});

	// slide
	$(".slide-index").slick({
	  slidesToShow: 4,
	  slidesToScroll: 1,
	  dots: false,
	  // centerMode: true,
	  focusOnSelect: true,
	  autoplay: false,
	  autoplaySpeed: 2000,
	  nextArrow: '<button type="button" class="slick-next"><i class="fas fa-caret-right"></i></button>',
	  prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-caret-left"></i></button>'
	});

	//產品轉址
	$(".product-area .img-box").click(function(){
		$(this).find(".productForm").submit();
	});

	//login nav
	$(".nav-user").click(function(){
		$(this).attr("data-toggle","modal");
		$(this).attr("data-target","#loginBox");

		$("#loginBox .label-custom").removeClass("active");
		if($("#loginBox .modal-body form #login-username").val().trim().length != 0 ){ //有輸入值(帳號)
			$("#loginBox .modal-body form #login-username").siblings(".label-custom").addClass("active");
			$("#loginBox .modal-body form .login-username-describe").show(300);
		}

		if($("#loginBox .modal-body form #login-password").val().trim().length != 0){ //有輸入值(密碼)
			$("#loginBox .modal-body form #login-password").siblings(".label-custom").addClass("active");
			$("#loginBox .modal-body form .login-password-describe").show(300);
		}
	});
	$("#loginBox .modal-body form input").click(function(){
		$("#loginBox .label-custom").removeClass("active");
		var loginLabel = $(this).siblings(".label-custom");
		if(loginLabel.attr("class").search("active") != -1){
			loginLabel.removeClass("active");
		}else{			
			loginLabel.addClass("active");
		}

		if($("#loginBox .modal-body form #login-username").val().trim().length != 0 ){ //有輸入值(帳號)
			$("#loginBox .modal-body form #login-username").siblings(".label-custom").addClass("active");
		}

		if($("#loginBox .modal-body form #login-password").val().trim().length != 0){ //有輸入值(密碼)
			$("#loginBox .modal-body form #login-password").siblings(".label-custom").addClass("active");
		}
	});

	$("#loginBox .modal-body form #login-username").keyup(function(){
		if($("#loginBox .modal-body form #login-username").val().trim().length != 0 ){ //有輸入值(帳號)
			$("#loginBox .modal-body form .login-username-describe").show(300);
			$("#loginBox .modal-body form #login-username").siblings(".label-custom").addClass("active");
		}
	});	
	$("#loginBox .modal-body form #login-password").keyup(function(){
		if($("#loginBox .modal-body form #login-password").val().trim().length != 0){ //有輸入值(密碼)
			$("#loginBox .modal-body form .login-password-describe").show(300);
			$("#loginBox .modal-body form #login-password").siblings(".label-custom").addClass("active");
		}
	});	
});