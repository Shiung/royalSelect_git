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
});