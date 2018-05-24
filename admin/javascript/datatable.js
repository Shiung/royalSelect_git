$(document).ready(function(){
	// ------product.php-------
	productTableServer = $("#dataTableServer-product").DataTable({
		"lengthMenu": [[10, 20, 30, -1], [10, 20, 30, "All"]],
		"responsive": true,
		"order": [[ 0, "desc" ]],
        "dom": 'lBfrtip',
        "buttons": [
            {
                "extend": 'copyHtml5',
                "exportOptions": {
                    "columns": [ 0, ':visible' ]
                }
            },
            {
                "extend": 'excelHtml5',
                "exportOptions": {
                    "columns": ':visible'
                }
            },
            'colvis'
        ]   ,  
        "processing": true,
        "serverSide": true,
        "ajax": "api/datatableProductAjaxServer.php",
         "columns": [
            { "data": "product_no" },
            { "data": "model_id" },
            { "data": function(source, type, val){
                // return '<a target="_blank" href="../product-detail.php?product_no='+source.product_no+'">'+source.product_name+'</a>';
                return source.product_name;
            }},
            { "data": function(source, type, val){
            	var status = "<input type='hidden' name='product_status' value='"+source.product_status+"'>"
            	if(source.product_status == 0){
            		var b = "已下架";
            	}else if(source.product_status == 1){
            		var b = "銷售中";
            	}

            	return b+status;
            }},
            { "data": "product_createtime" },
            { "data": "product_updatetime" },
            { "data": function(source, type, val){
            	var span = '';
            	var button ='';
            	if(source.product_status == 1){
            		var status = "下架" ;
            		return '<span class="edit"><form action="productEdit.php" method="get"><input type="hidden" name="product_no" value="'+source.product_no+'"><button class="productEditButton">編輯</button></form></span><span class="edit"><button class="productStatusButton">'+status+'</button></span>';
            	}else if(source.product_status == 0){
        			var status = "上架" ;
        			return '<span class="edit"><form action="productEdit.php" method="get"><input type="hidden" name="product_no" value="'+source.product_no+'"><button class="productEditButton">編輯</button></form></span><span class="edit"><button class="productStatusButton">'+status+'</button></span>';
    			}
            }}

        ],
        "fnDrawCallback" : function(oSettings){
        	$("#dataTableServer-product").find("tbody tr").addClass("product");
        	callback();
        }
	});

	$("#dataTableServer-product tbody").on("click","tr",function(){
		$(this).toggleClass('selected');
	});
	// ===全選====
	$("#productSelectAll").click(function(){
		$(this).parents(".dataTable-area").find("tbody tr").addClass("selected");
	});
	// ====全不選=====
	$("#productSelectNone").click(function(){
		$(this).parents(".dataTable-area").find("tbody tr").removeClass("selected");
	});

	$("#productStatus").change(function(){
        var productStatus = $("#productStatus").val();
        // console.log(productStatus);
        if(productStatus == 2){ //全部商品
            productTableServer.column(3).search('').draw();
        }else{
            productTableServer.column(3).search(productStatus).draw();
        }
    });

	 // ======serverside 生成後建立callback 註冊======
	function callback(){
		$(".productEditButton").click(function(e){
			e.stopPropagation(); // =====取消====bubble or capture
		});

		$(".productStatusButton").click(function(e){
			e.stopPropagation(); // =====取消====bubble or capture
			
			var statusWrite = "updateProductStatusOnly";
			var productId = $(this).parents("tr.product").find("td").eq(0).text();
			if($(this).text() == "上架"){
				var productStatus = "1" ;
			}else{
				var productStatus = "0" ;
			}
			$.ajax({
				url:"api/productAjax.php",
				data : {status : statusWrite,product_no : productId,product_status : productStatus},
	 			type : "POST",
	 			dataType : "json",
			    cache : false,
			    success : function(result){
				    	if(result){ //true 
				    		// ======server reload======
							productTableServer.ajax.reload( null, false ); 	//datatable reload 不跳回初始第一頁
				    	}else{ //false
				    		// alert("找無分類");
				    	}
		    		},
			    error : function(error){
				    	alert("傳送失敗");
				    } 
			});
		});

	} //-----end callback


});