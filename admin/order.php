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
                <div class="dataTable-area">
                    <table id="dataTableServer-order" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>no</th>
                          <th>訂單編號</th>
                          <th>付款狀態</th>
                          <th>訂單狀態</th>
                          <th>買家</th>
                          <th>下單時間</th>
                          <th>下單金額</th>
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