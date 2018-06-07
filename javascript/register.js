$(document).ready(function(){
    $("#registerConfirmButton").click(function(e){
        e.preventDefault();
        var emailReg = /^\w+((-\w+)|(\.\w+))*\@[\w]+((\.|-)[\w]+)*\.[A-Za-z]+$/; 
		var pswReg = /^(?=^.{6,}$)((?=.*\w)(?=.*\d)(?=.*[A-Za-z]))^.*$/;
		var userMail = $("input#userAcountCreate").val().trim();
		var userLastName = $("input#userLastNameCreate").val().trim();
		var userFirstName = $("input#userFirstNameCreate").val().trim();
		var userTel = $("input#userPhoneCreate").val().trim();
		var userPsw = $("input#userPswCreate").val().trim();
		var userRePsw = $("input#userPswConfrimCreate").val().trim();

		$("input#userLastNameCreate").css("backgroundColor","");
		$("input#userFirstNameCreate").css("backgroundColor","");
		$("input#userPhoneCreate").css("backgroundColor","");	
		//帳號重複確認
		var memCheck = '';
		if( registerMemCheck(userMail) ){
			memCheck = 1 ; //新會員
		}else{
			memCheck = 2 ; //會員帳號重複
		}

		if( emailReg.test(userMail) === false ){
			swal({
			  title: "請輸入有效E-Mail",
			  icon: "error",
			}).then( function(confrim) {
				$("input#userAcountCreate").select();
			});
		}else if( memCheck == 2 ){
			swal({
				title: "帳號已經使用，請再次確認",
				icon: "error",
			}).then( function(confrim) {
				$("input#userAcountCreate").select();
			});
		}else if( pswReg.test(userPsw) === false  ){
			swal({
				title: "請輸入英數碼六位數以上",
				icon: "error",
			}).then( function(confrim) {
				$("input#userPswCreate").select();
			});
			return ;
		}else if( userPsw != userRePsw ){
			swal({
				title: "請確認輸入的'確認密碼'與'密碼'相同",
				icon: "error",
			}).then( function(confrim) {
				$("input#userPswConfrimCreate").select();
			});
			return;
		}else if( userLastName == '' || userFirstName == '' || userTel == '' ){
			swal({
				title: "請填妥必填資訊",
				icon: "error",
			  }).then( function(confrim) {
				  if(userLastName == ''){$("input#userLastNameCreate").css("backgroundColor","rgba(255, 0, 0,0.5)");}
				  if(userFirstName == ''){$("input#userFirstNameCreate").css("backgroundColor","rgba(255, 0, 0,0.5)");}
				  if(userTel == ''){$("input#userPhoneCreate").css("backgroundColor","rgba(255, 0, 0,0.5)");}
			  });
		}else{
			//新增會員
            var newMemNo = registerMemCreate( userMail , userPsw , userLastName , userFirstName ,  userTel );
            if( !newMemNo ){
                swal({
                    title: "帳號建立失敗",
                    icon: "error",
                }).then( function(confrim) {                           
                });
            }else{
                //發信
                // newMemSendMail( userMail , userLastName , userFirstName , userTel ); //公司內部通知 and userEDM
                //儲存cookie 和session 
                memSessionAndCookie( newMemNo );
                //reload to index
                // location.reload();
            }
			
		}
    });

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
    
    function memSessionAndCookie( newMemNo ){
		// ======儲存cookie 和 session=====
		var statusWrite = "memLogin" ;
		var memNo = newMemNo;
		$.ajax({
			url : "api/memAjax.php",
			data : {status : statusWrite,mem_no : memNo },
			type : "POST",
			cache : false,
			success : function(result){
				// if(result){ //登入成功
				// 	var success = JSON.parse(result);
				// 	if(success == "denied"){
				// 		swal({
				// 		title: "帳號已停權",
				// 		icon: "error",
				// 		});
				// 	}else{   			
				// 		// location.reload();
				// 	}
					
				// }else{ //false 找不到帳號
				// 	swal({
				// 	title: "帳號/密碼錯誤",
				// 	icon: "error",
				// 	});
                // }
                console.log(result);
			},
			error : function(error){
				alert("傳送失敗");
			} 
		});
	}

});