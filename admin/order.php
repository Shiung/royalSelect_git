<?php require_once("module/header.php"); ?>

      <div class="breadcrumb-holder">   
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">訂單管理</li>
          </ul>
        </div>
      </div>
      <section class="charts">
        <div class="container-fluid">
          <header> 
            <h1 class="h3">訂單管理</h1>
          </header>
          <div class="row">
            <div class="col-lg-12">
            	<div class="card product">
				

             <!-- =====dataTable====== -->
	             <div class="demo">
	             	<div class="row" style="margin-bottom:30px;"> 			             	
    							<table id="dataTableServer" class="table table-striped table-bordered" cellspacing="0" width="100%">
    								<thead>
    									<tr>
    										<th>編號</th>
    										<th>產品編號</th>
    		                <th>產品名稱</th>
    		                <th>品牌</th>
    		                <th  style="width:100px;">標籤</th>
                        <!-- <th  style="width: 60px;">本月推薦</th> -->
                        <th  style="width: 100px;">行銷活動</th>
                        <!-- <th  style="width: 60px;">優惠劵</th> -->
    		                <th  style="width: 25px;">狀態</th>
    		                <th  style="width: 60px;">更新時間</th>	
    		                <th  style="width: 90px;"></th>					               
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
		

      </section>
      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p>Your company &copy; 2017-2019</p>
            </div>
            <div class="col-sm-6 text-right">
              <p>Design by <a href="" class="external">Ne-Plus</a></p>
              <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
            </div>
          </div>
        </div>
      </footer>
    </div>
  </body>


<?php require_once("module/footer.php"); ?>