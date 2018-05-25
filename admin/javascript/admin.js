$(document).ready(function(){

	//productEdit.php
	//產品更新內容
	$("#productEditConfirm").click(function(){
		var pId = $("input[name='product_no']").val();
		var modelId = $("input[name='model_id']").val().trim();
		var pName = $("input[name='product_name']").val().trim();
		var pSubtitle = $("input[name='product_subtitle']").val();
		var pPromote = $("input[name='product_promote']").val();
		var pDescribe = $("input[name='product_describe']").val();
		var pNote = $("textarea[name='product_note']").val();
		var pContent = $("div.note-editable").html();
		var price1 = $("#productPrice1").val();
		var price2 = $("#productPrice2").val();
		var price3 = $("#productPrice3").val();
		if($("input[id='productEditProductStatus']").prop("checked")){//true
			var productStatus = 1 ; 
		}else{
			var productStatus = 0 ;
		}
		//集貨
		var cQuantity = $("#collection-quantity").val();
		var startZone = $("#collection-from").val();
		var startZoneArr =  startZone.split("/");
		var startZoneReStr = startZoneArr[2]+"-"+startZoneArr[0]+"-"+startZoneArr[1];
		var endZone = $("#collection-to").val();
		var endZoneArr =  endZone.split("/");
		var endZoneReStr = endZoneArr[2]+"-"+endZoneArr[0]+"-"+endZoneArr[1];

		//商品規格
		// var
		//商品圖片
	});

	// //產品新增規格
	// $("#specCreateConfirm").click(function(){
	// 	var productNo = $("input[name='product_no']").val();
	// 	var info = $("input[id='specInfo']").val();
	// 	if( info.trim() == "" || info.trim() == null ){
	// 		alert("請填寫產品規格");
	// 		$("input[id='specInfo']").focus();
	// 	}else{
	// 		var statusWrite = "updateSpec";
	// 		$.ajax({
	// 			url:"api/productAjax.php",
	// 			data : {status : statusWrite,product_no : productNo,product_spec_info : info},
	//  			type : "POST",
	//  			dataType : "json",
	// 		    cache : false,
	// 		    success : function(result){
	// 		    	if(result){ //true 
	// 		    		$("#specTable").append("<tr class='specCount'><td scope='row' class='text-center'><label class='checkbox-inline'><input id='inlineCheckbox1' type='checkbox' class='productSpecStatus' value='option1'></label></td><td>"+result[0]['product_spec_info']+"</td><td>"+result[0]['product_spec_describe']+"</td><td>"+result[0]['product_stock']+"</td><td>"+result[0]['product_spec_price1']+"</td><td>"+result[0]['product_spec_price2']+"</td><td>"+result[0]['product_spec_price3']+"</td><td class='text-center' ><input type='hidden' name='product_spec_no' value='"+result[0]['product_spec_no']+"'><span class='edit'><button class='productSpecEdit' data-toggle='modal' data-target='#producrSpecEdit'>編輯</button></span><span>|</span><span class='edit'><button class='productSpecDelete'>刪除</button></td></tr>");
	// 		    		$('#producrSpecCreate').modal('hide');
	// 		    		// specFeedback();
	// 		    		// specCheck();
	// 		    		console.log(result);
	// 		    	}else{ //false
	// 		    		// alert("找不到相同標籤");
	// 		    	}
	// 		    },
	// 		    error : function(error){
	// 		    	alert("傳送失敗");
	// 		    } 
	// 		});
	// 	}
	// });

	// //產品編輯規格
	// $(".productSpecEdit").click(function(){
	// 	var pSpecNo = $(this).parent().siblings("input[name='product_spec_no']").val();
	// 	var pSpecInfo = $()
	// 	$("#specInfoEdit").val("");
	// });

	// ======bootsrap switch=====
 	$("[name='my-checkbox']").bootstrapSwitch(
 		"size","mini"
 	);
});