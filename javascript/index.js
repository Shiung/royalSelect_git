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
});