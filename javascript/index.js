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

	//1.login nav光箱呼叫
	$(".nav-user.unactive").click(function(){
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
	// 2.login nav光箱內操作
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

	// 3.點擊註冊
	$("#registerButton").click(function(){
		location.replace('register.php');
	});
	// 3.點擊登入
	$("#loginButton").click(function(){
		var emailReg = /^\w+((-\w+)|(\.\w+))*\@[\w]+((\.|-)[\w]+)*\.[A-Za-z]+$/; 
		var pswReg = /^(?=^.{6,}$)((?=.*\w)(?=.*\d)(?=.*[A-Za-z]))^.*$/;
		var mail = $("#login-username").val().trim();
		var psw = $("#login-password").val().trim();
		
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
			login( mail , psw );
		}
		
	});


	//登出 測試
	$(".nav-user.active").click(function(){
		logout();
	});

});


//共用程式

function login( mail , psw ){
	var login , memObj;

	// 1 .帳密確認	
	var statusCheck = "memLoginFirstCheck";
	$.ajax({
		url:"api/memAjax.php",
		data : {status : statusCheck,mem_email : mail , mem_password : psw},
		type : "get",
		async : false,
		cache : false,
		success : function(result){
				if(result){ //true 帳密無誤
					login =  1; 
					memObj = JSON.parse(result);	
				}else{ // false 帳密錯誤
					login =  2;
				}
			},
		error : function(error){
				alert("傳送失敗");
			} 
	}).done(function(){
	// 3. 儲存會員登入資料
		if(login == 1){
		// 2. 如帳密無誤進行 session cookie儲存	
			//帳號被停權
			if( memObj[0].mem_status == 0 ){
				swal({
					title: "帳號已被停權",
					icon: "error",
				});
			}else{
				if(memSessionAndCookie( mail , psw )){
					location.reload();
				}else{
					alert("登入失敗");
				}
			}		
		}else{
			swal({
				title: "密碼錯誤",
				icon: "error",
			}).then( function(confrim) {
				$("#loginBox .modal-body form #login-password").siblings(".label-custom").addClass("active");
				$("#loginBox .modal-body form #login-password").select();
			});
		}
	});
} 

function registerMemCheck( mail ){
	var memCheck ;

	var statusCheck = "memMailCheck"; 
	// =====檢查是否有重複帳號=====
	$.ajax({
		url:"api/memAjax.php",
		data : {status : statusCheck,mem_email : mail},
		type : "get",
		async : false,
		cache : false,
		success : function(result){
				if(result){ //true 有重複帳號
					memCheck =  false; //帳號重複
				}else{ // false 新用戶
					memCheck =  true; //新用戶
				}
			},
		error : function(error){
				alert("傳送失敗");
			} 
	});
	return memCheck;
}

function registerMemCreate( mail , psw , lastName , firstName , tel ){
	var memNo ;

	var statusCreate = "memCreate";
	$.ajax({
		url:"api/memAjax.php",
		data : {status : statusCreate,mem_email : mail,mem_password : psw,mem_lastname : lastName, mem_firstname : firstName,mem_tel : tel},
		type : "get",
		async : false,
		cache : false,
		success : function(result){
				var member = JSON.parse(result);
				if( member == 'exist' ){
					memNo = false;
				}else if( member == 'createfail' ){ 
					memNo = false;
				}else if( member == 'existAllready' ){
					memNo = false;
				}else{
					memNo = member;
				}	
			},
		error : function(error){
				alert("傳送失敗");
			} 
	});	
	return memNo;
}


function memSessionAndCookie( memMail , psw ){
	var memStatus ;
	// ======儲存cookie 和 session=====
	var statusWrite = "memLogin" ;
	var memMail = memMail;
	var memPsw = psw;
	$.ajax({
		url : "api/memAjax.php",
		data : {status : statusWrite,mem_email : memMail , mem_password : memPsw },
		type : "POST",
		cache : false,
		async : false,
		success : function(result){	
			if(result){ //登入成功
				var success = JSON.parse(result);
				if(success == "denied"){
					swal({
					title: "帳號已停權",
					icon: "error",
					});
					memStatus = false ; 
				}else{   			
					memStatus = true ; 
				}
				
			}
		},
		error : function(error){
			alert("傳送失敗");
		} 
	});
	return memStatus;
}

//memNo,memMail,psw,tel,lastName,firstname,note,memToken,loginTime,loginIp
function memUpdate( memNo , memMail ,psw = null ,  tel= null , lastName = null , firstname = null , note = null , memToken = null , loginTime = null , loginIp = null ){
	var updateReturn ;	

	var statusWrite = "memUpdate" ;
	var memNo = memNo;
	var memMail = memMail;
	var psw = psw;
	var tel = tel;
	var lastName = lastName;
	var firstname = firstname;
	var note = note ;
	var memToken = memToken;
	var loginTime = loginTime ;
	var loginIp = loginIp ;
	
	var formData = new FormData();
	formData.append('status', statusWrite);
	formData.append('mem_no', memNo);
	formData.append('mem_email', memMail);
	!psw ? null : formData.append('mem_password', psw );
	!tel ? null : formData.append('mem_tel', tel );
	!lastName ? null : formData.append('mem_lastname', lastName );
	!firstname ? null : formData.append('mem_firstname', firstname );
	!note ? null : formData.append('mem_note', note );
	!loginTime ? null : formData.append('mem_LoginTime', loginTime );
	!loginIp ? null : formData.append('mem_LoginIp', loginIp );
	!memToken ? null : formData.append('rs_token', memToken );
	
	$.ajax({
		url : "api/memAjax.php",
		data : formData,
		type : "POST",
		processData: false,  // tell jQuery not to process the data
		contentType: false,  // tell jQuery not to set contentType
		cache : false,
		async : false,
		success : function(result){
			updateReturn = result ; 
		},
		error : function(error){
			alert("傳送失敗");
		} 
	});
	
	return updateReturn; //true flase
}

function logout(){
	var statusWrite = "memLogout" ;
	$.ajax({
		url : "api/memAjax.php",
		data : { status : statusWrite},
		type : "POST",
		cache : false,
		success : function(result){
			 
		},
		error : function(error){
			alert("傳送失敗");
		} 
	}).done(function(){
		location.reload();
	});
}