<?php  
ob_start();
session_start();
date_default_timezone_set("Asia/Taipei");

// db
include("config.php");
include("model/DB.php");
include("class/productClass.php");
include("class/orderClass.php");
include("class/memClass.php");

// ===檢查客戶端是否有關閉cookie=====
// 先儲存cookie確認碼
setcookie("CookieCheck","OK",time()+3600,"/");
//購物車清單
if( isset($_COOKIE["CookieCheck"]) ){ //有cookie可用
	$order = new orderObj(1);
	$oList = $order->brief();
}else{  //cookie關閉
	$order = new orderObj(2);
	$oList = $order->brief();
}

//memToken check
$userStatus = 'unactive' ;
if(isset($_SESSION["rs_memNo"]) === false){
	if (isset($_COOKIE["rs_token"])) {
		$_SESSION["where"] = $_SERVER["PHP_SELF"];

		header('Location: memTokenCheck.php');
	}	
}else{
	$userStatus = 'active';
	$rs_memNo = $_SESSION["rs_memNo"];
	$user = new userObj($rs_memNo);
	$userObj = $user -> brief();
}

?>

<!doctype html>
<html lang="en">
  <head>
    <title>ROYAL SELECT</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- jquery -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
	
	<!-- sweetalert.js -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<!-- user -->
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<script src="javascript/index.js"></script>
	<?php include("module/cssJsSelector.php"); ?>

	<!-- slick -->
	<link rel="stylesheet" type="text/css" href="plugIn/slick/css/slick.css">
  	<link rel="stylesheet" type="text/css" href="plugIn/slick/css/slick-theme.css">
	<script src="plugIn/slick/js/slick.js"></script>


	<!-- fontawesome	 -->
	<link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="plugIn/fontawesome/fa-svg-with-js.css">
	<script defer src="plugIn/fontawesome/fontawesome-all.js"></script>	
	
	<!-- short-icon -->
	<link rel="Shortcut Icon" type="image/x-icon" href="img/favicon-20180424010417982.ico">

  </head>
<body>
<header>
	<div class="d-flex justify-content-center">
		<div class="nav-logo">
			<a href="index.php">
				<img src="img/frontEnd/logo.png" class="img-fluid">
			</a>
		</div>
	</div>
	<div class="nav-selection d-flex justify-content-end align-items-center">
		<div class="nav-user fa-lg <?php echo $userStatus;?>">
			<svg  viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1600 1405q0 120-73 189.5t-194 69.5h-874q-121 0-194-69.5t-73-189.5q0-53 3.5-103.5t14-109 26.5-108.5 43-97.5 62-81 85.5-53.5 111.5-20q9 0 42 21.5t74.5 48 108 48 133.5 21.5 133.5-21.5 108-48 74.5-48 42-21.5q61 0 111.5 20t85.5 53.5 62 81 43 97.5 26.5 108.5 14 109 3.5 103.5zm-320-893q0 159-112.5 271.5t-271.5 112.5-271.5-112.5-112.5-271.5 112.5-271.5 271.5-112.5 271.5 112.5 112.5 271.5z"/></svg>
		</div>
		<div class="nav-cart fa-lg"><!-- <i class="fas fa-shopping-bag"></i> -->
			<svg style="enable-background:new 0 0 128 128;" version="1.1" viewBox="0 0 128 128" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Layer_1"/><g id="refrigerator"/><g id="washer"/><g id="tv"/><g id="microwawe"/><g id="vacuum_cleaner"/><g id="Gift"/><g id="umbrella"/><g id="rocket"/><g id="basket"/><g id="shopping"/><g id="email"/><g id="message"/><g id="delivery"/><g id="store"/><g id="label"/><g id="phone"/><g id="imac"/><g id="laptop"/><g id="heart_like"/><g id="game"/><g id="wallet"/><g id="camera"/><g id="battery"/><g id="shoes"/><g id="t-shirt"/><g id="pencil"/><g id="people"/><g id="statistics"/><g id="blog"/><g id="rock"/><g id="like"/><g id="dislike"/><g id="speaker"/><g id="pc"/><g id="glasses"/><g id="headphones"/><g id="player"/><g id="book"/><g id="transfer"/><g id="mouse"/><g id="package"><g><g><path d="M106.456,120H21.544c-2.756,0-5.417-1.153-7.3-3.165c-1.884-2.012-2.86-4.742-2.68-7.491l3.947-60     C15.857,44.104,20.241,40,25.491,40h77.018c5.25,0,9.634,4.104,9.979,9.343l3.947,60.001c0.181,2.749-0.796,5.479-2.68,7.491     C111.873,118.847,109.212,120,106.456,120z M25.491,44c-3.15,0-5.78,2.463-5.987,5.606l-3.947,59.999     c-0.11,1.675,0.46,3.271,1.606,4.495c1.147,1.225,2.703,1.899,4.381,1.899h84.912c1.678,0,3.233-0.675,4.381-1.899     c1.146-1.225,1.717-2.82,1.606-4.495l-3.947-60c-0.207-3.143-2.837-5.605-5.987-5.605H25.491z" style="fill:#505070;"/></g><g><path d="M97,56c-1.104,0-2-0.896-2-2v-4.5C95,28.271,81.094,11,64,11S33,28.271,33,49.5V54     c0,1.104-0.896,2-2,2s-2-0.896-2-2v-4.5C29,26.065,44.701,7,64,7s35,19.065,35,42.5V54C99,55.104,98.104,56,97,56z" style="fill:#505070;"/></g></g></g><g id="exellent"/><g id="card"/><g id="induction"/><g id="revers_camera"/><g id="flesh_drive"/><g id="time"/><g id="sale"/><g id="tablet"/><g id="search"/></svg>
		</div>
		<div class="nav-search fa-lg"><!-- <i class="fas fa-search"></i> -->
			<svg version="1.1" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink"><title/><desc/><defs/><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="#505070" id="icon-111-search"><path d="M19.4271164,20.4271164 C18.0372495,21.4174803 16.3366522,22 14.5,22 C9.80557939,22 6,18.1944206 6,13.5 C6,8.80557939 9.80557939,5 14.5,5 C19.1944206,5 23,8.80557939 23,13.5 C23,15.8472103 22.0486052,17.9722103 20.5104077,19.5104077 L26.5077736,25.5077736 C26.782828,25.782828 26.7761424,26.2238576 26.5,26.5 C26.2219324,26.7780676 25.7796227,26.7796227 25.5077736,26.5077736 L19.4271164,20.4271164 L19.4271164,20.4271164 Z M14.5,21 C18.6421358,21 22,17.6421358 22,13.5 C22,9.35786417 18.6421358,6 14.5,6 C10.3578642,6 7,9.35786417 7,13.5 C7,17.6421358 10.3578642,21 14.5,21 L14.5,21 Z" id="search"/></g></g></svg>
		</div>
	</div>
	
</header>

<!-- Modal (登入)-->
<div class="modal fade" id="loginBox" tabindex="-1" role="dialog" aria-labelledby="exampleModal3Label" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	         <div class="loginTitle"><img src="img/frontEnd/logo-w.png" class="img-fluid" style="width:100px;"></div>
	      </div>
	      <div class="modal-body text-center">
            	<form id="login-form" method="post">
	              <div class="form-group">
	                <label for="login-username" class="label-custom">帳號  <small>Account</small></label>
	                <input id="login-username" type="text" name="loginUsername" required="">
	                <div class="login-username-describe" style="display: none;">請輸入E-mail</div>
	              </div>
	              <div class="form-group">
	                <label for="login-password" class="label-custom">密碼  <small>Password</small></label>
	                <input id="login-password" type="password" name="loginPassword" required="">
	              </div> 
	            </form>
	            <button id="loginButton" href="#" class="btn btn-primary mb-2" style="display: block; width:100%;">登入</button>
	            <button id="registerButton" href="#" class="btn btn-primary mb-4" style="display: block; width:100%;" >註冊</button>
	            <a href="#" id="forgot-pass" >Forgot Password?</a>
	      </div>
	    </div>
	  </div>
	</div>