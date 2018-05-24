<?php require_once("module/header.php"); ?>

      <div class="breadcrumb-holder">   
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $homeLink; ?>">Home</a></li>
            <li class="breadcrumb-item active">商品管理</li>
          </ul>
        </div>
      </div>
      <section class="charts">
        <div class="container-fluid">
          <header> 
            <h1 class="h3">商品管理</h1>
          </header>
          <div class="row">
            <div class="col-lg-12">
            	<div class="card product">
				

             <!-- =====dataTable====== -->
			             <div class="dataTable-area">
			             	<div class="row" style="margin-bottom:30px;">
			             		<div class="col-6 productSelectBox">
			             			<button id="productSelectAll" class="btn-sm btn-outline-info">全選</button>
				             		<button id="productSelectNone" class="btn-sm btn-outline-info">全不選</button>
				             		<select id="productSelects" class="form-control form-control-sm">
				             			<option value disabled selected>批次處理動作</option>
				             			<option value="1" >上架</option>
				             			<option value="2" >下架</option>
				             		</select>
				             		<button id="productSelectConfirm" class="btn-sm btn-outline-success">確認</button>
								
				             	</div>
				             	<div class="col-6 text-right">
                        <span>商品狀態</span>
                        <select id="productStatus" class="form-control form-control-sm mr-1">
                          <option value="2" selected>所有商品</option>
                          <option value="1">銷售中</option>
                          <option value="0">下架</option>
                        </select>  
				             		<button id="productCreatebutton" class="btn-sm btn-outline-success" data-toggle="modal" data-target="#producrCreateNew">新增商品</button>
				             	</div>
			             	</div>
			             	

			             			             	
							<table id="dataTableServer-product" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>系統編號</th>
										<th>產品編號</th>
		                <th>產品名稱</th>
		                <th>狀態</th>
		                <th>建立時間</th>	
                    <th>更新時間</th> 
		                <th></th>					               
									</tr>
								</thead>
								
						    	<tbody>
						    	</tbody>
							</table>
							
						</div>	
             <!-- =====/dataTable====== -->
             	</div>
            </div> 
          </div>
        </div>
		

    <!-- Modal 新增 -->
            <div class="modal fade" id="producrCreateNew" tabindex="-1" role="dialog" aria-labelledby="productNew" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="productNew">新增商品</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                      <label for="modelIdNew" class="col-sm-3 col-form-label">產品編號</label>
                      <div class="col-sm-9">
                          <input class="form-control" type="text" id="modelIdNew" name="product_no" placeholder="輸入產品編號">
                      </div>
                    </div>
                    <div class="form-group row">
                        <label for="productNameNew" class="col-sm-3 col-form-label">產品名稱</label>
                        <div class="col-sm-9">
                          <input class="form-control" type="text" id="productNameNew" name="product_name" placeholder="輸入產品名稱">
                        </div>
                    </div>
                    
                    
                  </div>  <!-- end modal-body -->
                  <div class="modal-footer">
                    <button type="button" class="btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button id="productCreateConfirm" type="button" class="btn-sm btn-primary">確認新增</button>
                  </div>
                </div>   <!-- end modal-content -->
              </div>
            </div>



      </section>
      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p>ROYAL-SELECT &copy; 2017-2019</p>
            </div>
            <div class="col-sm-6 text-right">
              <p>Design by <a href="" class="external">Ne-Plus</a></p>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </body>


<?php require_once("module/footer.php"); ?>