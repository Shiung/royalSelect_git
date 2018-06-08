<?php include("module/header.php"); 
if(isset($_SESSION["rs_memNo"]) === true){
	header('Location: index.php');
}
?>

<section id="registerShow">
	<nav aria-label="breadcrumb" class="breadcrumb-area">
		<button type="button" class="btn btn-sm return-btn" onclick="history.back();"><i class="fas fa-angle-left mr-2"></i>BACK</button>
		<div class="container">
			<ol class="breadcrumb">
				  <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
				  <li class="breadcrumb-item active">註冊會員</li>
			</ol>
		</div>
    </nav>
    
    <div class="container registerBox my-5">
        <div class="row">
			<div class="col-lg-6 offset-lg-3">
				<form>
				  <div class="form-group">
				    <label for="userAcountCreate"><span class="text-danger">*</span>帳號(E-mail)</label>
				    <input type="text" class="form-control form-control-sm" id="userAcountCreate" placeholder="Example@mail.com" autocomplete="off">
					</div>
					<div class="form-group">
				    <label for="userPswCreate"><span class="text-danger">*</span>密碼</label>
				    <input type="password" class="form-control form-control-sm" id="userPswCreate" placeholder="請輸入英數六碼">
				  </div>
				  <div class="form-group">
				    <label for="userPswConfrimCreate"><span class="text-danger">*</span>密碼確認</label>
				    <input type="password" class="form-control form-control-sm" id="userPswConfrimCreate" placeholder="再一次輸入密碼確認">
				  </div>
				  <div class="row">
				  	<div class="col-12 col-md">
				  		<div class="form-group">
						    <label for="userLastNameCreate"><span class="text-danger">*</span>姓氏</label>
						    <input type="text" class="form-control form-control-sm" id="userLastNameCreate" placeholder="姓氏">
						</div>
				  	</div>
				  	<div class="col-12 col-md">
				  		<div class="form-group">
						    <label for="userFirstNameCreate"><span class="text-danger">*</span>名字</label>
						    <input type="text" class="form-control form-control-sm" id="userFirstNameCreate" placeholder="名字">
						</div>
				  	</div>
				  </div>
				  <div class="form-group">
				    <label for="userPhoneCreate"><span class="text-danger">*</span>電話</label>
				    <input type="tel" class="form-control form-control-sm" id="userPhoneCreate" placeholder="請輸入電話號碼">
                  </div>
                  <div class="form-group text-center mt-4">
                      <button id="registerConfirmButton"  class="btn btn-primary d-block w-100" >註冊</button>
                  </div>
				</form>
			</div>
		</div>
    </div>
	
</section>



<?php include("module/footer.php"); ?>