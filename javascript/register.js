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
				//memNo,memMail,psw,tel,lastName,firstname,note,memToken,loginTime,loginIp
				if( memUpdate(newMemNo,userMail,null,null,null,null,null,true,null,null) ){ //更新mem_token 
					//儲存cookie 和session 
                	if(memSessionAndCookie( userMail , userPsw )){
						location.reload();
					}else{
						alert("登入失敗");
					}
				}else{
					alert("更新失敗");
				}
				
                //發信
                // newMemSendMail( userMail , userLastName , userFirstName , userTel ); //公司內部通知 and userEDM
                
                //reload to index
                // location.reload();
            }
			
		}
    });
});