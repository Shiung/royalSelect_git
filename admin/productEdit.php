<?php require_once("module/header.php"); 
//導入程式
include("../config.php");
include("../model/DB.php");
include("../class/productClass.php");
$pid = $_REQUEST["product_no"];
$p = new productObj($pid);
$pro = $p->brief();
// echo "<pre>";
// print_r($pro);
// echo "</pre>";
$price1 = isset( $pro["price"]["price1"] ) ? $pro["price"]["price1"] : null  ;
$price2 = isset( $pro["price"]["price2"] ) ? $pro["price"]["price2"] : null  ;
$price3 = isset( $pro["price"]["price3"] ) ? $pro["price"]["price3"] : null  ;

// 集貨區間字串重整
$csArr = explode("-",$pro["collection_start"]);
$csStr = $csArr[1]."/".$csArr[2]."/".$csArr[0];
$ceArr = explode("-",$pro["collection_end"]);
$ceStr = $ceArr[1]."/".$ceArr[2]."/".$ceArr[0];
?>

      <div class="breadcrumb-holder">   
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo $productLink; ?>">商品管理</a></li>
            <li class="breadcrumb-item active">編輯商品</li>
          </ul>
        </div>
      </div>
      <section class="forms">
        <div class="container-fluid">
          <header> 
            <h1 class="h3">商品編輯</h1>
          </header>
          <div class="row">
            <!-- ======form ===== -->
            <div class="col-lg-12">
              <div class="card">
                <div class="card-block">
                  <!-- <form class="form-horizontal"> -->
                    <div class="form-group row">
                      <label class="col-sm-2 form-control-label" for="productEditModelId"><span class="text-danger">*</span>商品編號</label>
                      <div class="col-sm-10">
                        <input id="productEditModelId" type="text" name="model_id" class="form-control" value="<?php echo $pro['model_id'] ;?>">
                        <input type="hidden" name="product_no" value="<?php echo $pro['product_no'] ; ?>">
                      </div>
                    </div>
                    <div class="line"></div>
                    <div class="form-group row">
                      <label class="col-sm-2 form-control-label" for="productEditProductName"><span class="text-danger">*</span>商品名稱</label>
                      <div class="col-sm-10">
                        <input id="productEditProductName" type="text" name="product_name" class="form-control" value="<?php echo $pro['product_name'] ;?>">
                      </div>
                    </div>
                    <div class="line"></div>
                    <div class="form-group row">
                      <label class="col-sm-2 form-control-label" for="productEditProductSubtitle">商品副標</label>
                      <div class="col-sm-10">
                        <input id="productEditProductSubtitle" type="text" name="product_subtitle" class="form-control" placeholder="請輸入商品副標" value="<?php echo $pro['product_subtitle'] ;?>">
                      </div>
                    </div>
                    <div class="line"></div>
                    <div class="form-group row">
                      <label class="col-sm-2 form-control-label" for="productEditProductPromote">促銷文字</label>
                      <div class="col-sm-10">
                        <input id="productEditProductPromote" type="text" name="product_promote" placeholder="促銷文字顯示於標題下方,紅色文字說明折扣或促銷資訊" class="form-control" value="<?php echo $pro['product_promote'] ;?>">
                      </div>
                    </div>
                    <div class="line"></div>
                    <div class="form-group row">
                      <label class="col-sm-2 form-control-label" for="productEditProductDescribe">商品描述</label>
                      <div class="col-sm-10">
                        <input id="productEditProductDescribe" type="text" name="product_describe" placeholder="輸入簡短商品說明文字 (30字以內)" class="form-control" value="<?php echo $pro['product_describe'] ;?>">
                      </div>
                    </div>
                    <div class="line"></div>
                    <div class="form-group row">
                      <label class="col-sm-2 form-control-label" for="">商品圖片</label>
                      <div class="col-sm-10">
                        <div class="row">
                            <div class="col text-center">
                              <p>main</p>
                              <div class="col">
                                <button id="img1Upload" class="btn-sm btn-outline-secondary imgUpload">檔案上傳</button>
                              </div>
                              <input id="fileImg1" type="file" name="product_img" style="display:none;" class="form-control">
                              <div class="col imgInfo my-1">
                                <div style="color:rgba(0,0,0,.4);transform: scale(.9);transform-origin:center;">*圖片尺寸*</div>
                                <div style="color:rgba(0,0,0,.4);transform: scale(.9);transform-origin:center;">800x800</div>
                              </div>
                              <img id="img1" src="<?php 
                                    if(isset($pro['product_img']['img1'])){
                                      echo sprintf('../%s',trim($pro['product_img']['img1']));
                                    }
                              ?>" class="imgShow img-fluid"> 
                              <div class="col imgdeletebutton">
                                <button id="img1delete" style="<?php if(!isset($pro['product_img']['img1'])){echo 'display: none;';}?>" class="btn-sm btn-outline-danger imgdelete">刪除</button>
                              </div>
                            </div>
                            <div class="col text-center">
                              <p>2nd</p>
                              <div class="col">
                                <button id="img2Upload" class="btn-sm btn-outline-secondary imgUpload">檔案上傳</button>
                              </div>
                              <input id="fileImg2" type="file" name="product_img" style="display:none;" class="form-control">
                              <div class="col imgInfo my-1">
                                <div style="color:rgba(0,0,0,.4);transform: scale(.9);transform-origin:center;">*圖片尺寸*</div>
                                <div style="color:rgba(0,0,0,.4);transform: scale(.9);transform-origin:center;">800x800</div>
                              </div>
                              <img id="img2" src="<?php 
                                   if(isset($pro['product_img']['img2'])){
                                      echo sprintf('../%s',trim($pro['product_img']['img2']));
                                    }
                              ?>" class="imgShow img-fluid">
                              <div class="col imgdeletebutton">
                                <button id="img2delete" style="<?php if(!isset($pro['product_img']['img2'])){echo 'display: none;';}?>" class="btn-sm btn-outline-danger imgdelete">刪除</button>
                              </div>   
                            </div>
                            <div class="col text-center">
                              <p>3th</p>
                              <div class="col">
                                <button id="img3Upload" class="btn-sm btn-outline-secondary imgUpload">檔案上傳</button>
                              </div>
                              <input id="fileImg3" type="file" name="product_img" style="display:none;" class="form-control">
                              <div class="col imgInfo my-1">
                                <div style="color:rgba(0,0,0,.4);transform: scale(.9);transform-origin:center;">*圖片尺寸*</div>
                                <div style="color:rgba(0,0,0,.4);transform: scale(.9);transform-origin:center;">800x800</div>
                              </div>
                              <img id="img3" src="<?php 
                                    if(isset($pro['product_img']['img3'])){
                                      echo sprintf('../%s',trim($pro['product_img']['img3']));
                                    }
                              ?>" class="imgShow img-fluid">    
                              <div class="col imgdeletebutton">
                                <button id="img3delete" style="<?php if(!isset($pro['product_img']['img3'])){echo 'display: none;';}?>" class="btn-sm btn-outline-danger imgdelete">刪除</button>
                              </div>   
                            </div>
                            <div class="col text-center">
                              <p>4th</p>
                              <div class="col">
                                <button id="img4Upload" class="btn-sm btn-outline-secondary imgUpload">檔案上傳</button>
                              </div>
                              <input id="fileImg4" type="file" name="product_img" style="display:none;" class="form-control">
                              <div class="col imgInfo my-1">
                                <div style="color:rgba(0,0,0,.4);transform: scale(.9);transform-origin:center;">*圖片尺寸*</div>
                                <div style="color:rgba(0,0,0,.4);transform: scale(.9);transform-origin:center;">800x800</div>
                              </div>
                              <img id="img4" src="<?php 
                                    if(isset($pro['product_img']['img4'])){
                                      echo sprintf('../%s',trim($pro['product_img']['img4']));
                                    }
                              ?>" class="imgShow img-fluid">
                              <div class="col imgdeletebutton">
                                <button id="img4delete" style="<?php if(!isset($pro['product_img']['img4'])){echo 'display: none;';}?>" class="btn-sm btn-outline-danger imgdelete">刪除</button>
                              </div>   
                            </div>
                            <div class="col text-center">
                              <p>5th</p>
                              <div class="col">
                                <button id="img5Upload" class="btn-sm btn-outline-secondary imgUpload">檔案上傳</button>
                              </div>
                              <input id="fileImg5" type="file" name="product_img" style="display:none;" class="form-control">
                              <div class="col imgInfo my-1">
                                <div style="color:rgba(0,0,0,.4);transform: scale(.9);transform-origin:center;">*圖片尺寸*</div>
                                <div style="color:rgba(0,0,0,.4);transform: scale(.9);transform-origin:center;">800x800</div>
                              </div>
                              <img id="img5" src="<?php 
                                    if(isset($pro['product_img']['img5'])){
                                      echo sprintf('../%s',trim($pro['product_img']['img5']));
                                    }
                              ?>" class="imgShow img-fluid">
                              <div class="col imgdeletebutton">
                                <button id="img5delete" style="<?php if(!isset($pro['product_img']['img5'])){echo 'display: none;';}?>" class="btn-sm btn-outline-danger imgdelete">刪除</button>
                              </div>   
                            </div>
                        </div> 
                      <!--   <div class="col-12 text-right" style="margin-top: 40px;">
                            <button type="button" class="btn-sm btn-outline-success">上傳</button>
                        </div> -->
                      </div>  
                    </div>
                    <div class="line"></div>
                    <div class="form-group row">
                      <label class="col-sm-2 form-control-label" for="productEditProductNote">商品備註</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" id="productEditProductNote" name="product_note" rows="5" placeholder="純文字(此處前台不會顯示，僅後台管理員檢視)" ><?php echo $pro['product_note'] ;?></textarea>
                      </div>
                    </div>
                    <div class="line"></div>
                    <div class="form-group row">
                         <label for="" class="col-sm-2 col-form-label">商品內容</label>
                         <div class="col-sm-10">
                              <div id="summernote"></div>
                         </div>
                    </div>
                    <div class="line"></div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                              <label class="col-sm-4 col-form-label" for="productPrice1"><span class="text-danger">*</span>定價</label>
                                <div class="col-sm-6">
                                  <div class="input-group"><span class="input-group-addon">$</span>
                                    <input type="number" class="form-control" id="productPrice1" value="<?php echo $price1; ?>"><span class="input-group-addon">.00</span>
                                  </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="productPrice2">售價</label>
                                <div class="col-sm-6">
                                  <div class="input-group"><span class="input-group-addon">$</span>
                                    <input type="number" class="form-control" id="productPrice2" value="<?php echo $price2; ?>"><span class="input-group-addon">.00</span>
                                  </div>
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="productPrice3">優惠</label>
                                <div class="col-sm-6">
                                  <div class="input-group"><span class="input-group-addon">$</span>
                                    <input type="number" class="form-control" id="productPrice3" value="<?php echo $price3; ?>"><span class="input-group-addon">.00</span>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                 <label class="col-sm-6 col-form-label"><span class="text-danger">*</span>商品規格</label>
                                 <div class="col-sm-6 text-right">
                                    <button type="button" class="btn-sm btn-outline-success" data-toggle="modal" data-target="#producrSpecCreate">新增規格</button>
                                 </div>
                            </div>
                            <div class="row">
                                <div class="card-block productSpecTable" style="padding-top: 0;">
                                  <table id="specTable" class="table table-bordered table-sm">
                                    <thead>
                                      <tr style="background-color:#eee;">
                                        <th>規格名稱</th>
                                        <th  style="width:150px;"></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                     <?php 
                                    if( count($pro["spec"]) ){ //有規格
                                        foreach ($pro["spec"] as $key => $value) {
                                    ?>
                                      <tr class="specCount">
                                        <td class="spec-area">
                                        <?php echo $value["product_spec_info"]; ?>
                                            <input type="hidden" name="product_spec_no" value="<?php echo $value['product_spec_no']; ?>">
                                        </td>
                                        <td class="text-center" >
                                          <input type="hidden" name="product_spec_no" value="<?php echo $value["product_spec_no"] ; ?>">
                                          <span class="edit"><button class="productSpecEdit" data-toggle="modal" data-target="#producrSpecEdit">編輯</button></span><span>|</span>
                                          <span class="edit"><button class="productSpecDelete">刪除</button>
                                        </td>
                                      </tr>
                                   <?php 
                                        }    
                                    }else{
                                    ?>
                                      <tr id="specNone"><td class="text-center" colspan="8"><div class="alert alert-danger" role="alert"><strong>此商品無任何規格設定!</strong> 請新增商品規格</div></td></tr>
                                    <?php } ?>  
                                    </tbody>
                                  </table>
                                </div>
                            </div>          
                         </div>
                      </div>
                      <div class="line"></div>
                      
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label" for="collection-quantity">商品集貨數量設定</label>
                        <div class="col-sm-2">
                           <input type="number" class="form-control" id="collection-quantity" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $pro['collection_quantity']; ?>">
                        </div>
                      </div>
                      <div class="line"></div>
                      <div class="form-group row">
                        <label class="col-sm-2 form-control-label" for="collection-from">集貨開始時間</label>
                        <div class="col-sm-10">
                          <input type="text" id="collection-from" name="from" value="<?php echo $csStr; ?>" >
                        </div>
                      </div>
                      <div class="line"></div>
                       <div class="form-group row">
                        <label class="col-sm-2 form-control-label" for="collection-to">集貨結束時間</label>
                        <div class="col-sm-10">
                          <input type="text" id="collection-to" name="to" value="<?php echo $ceStr; ?>"> 
                        </div>
                      </div>
                      <div class="line"></div>
                      <div class="form-group row">
                           <label for="productEditProductStatus" class="col-sm-2 col-form-label">商品狀態<br>(上架/下架)</label>
                           <div class="col-sm-10">
                              <div class="row">
                                <div class="col-12 col-form-label switchButtonColor"><input id="productEditProductStatus" class="product_status" type="checkbox" name="my-checkbox" <?php if($pro['product_status'] == 1){
                                   echo "checked"; } ?> ></div>
                              </div>          
                           </div>
                      </div>
                    
                    <div class="line"></div>
              
                    
                    <div class="form-group row">
                      <div class="col-12 text-right">
                        <button id="productEditCancel" type="button" class="btn-sm btn-secondary">取消</button>
                        <button id="productEditConfirm" type="button" class="btn-sm btn-success">儲存編輯</button>
                      </div>
                    </div>
                  <!-- </form> -->
                </div>
              </div>
            </div>
            <!-- ======form======== -->
          </div>
        </div>
      </section>

        <!-- ========modal========== -->

            <!-- Modal 新增規格 -->
            <div class="modal fade" id="producrSpecCreate" tabindex="-1" role="dialog" aria-labelledby="specNew" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="specNew">新增商品規格</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                      <label for="specInfo" class="col-2 col-form-label">規格</label>
                      <div class="col-10">
                          <input class="form-control" type="text" id="specInfo" name="product_spec_info" placeholder="輸入產品規格">
                      </div>
                    </div>                  
                  </div>  <!-- end modal-body -->
                  <div class="modal-footer">
                    <button type="button" class="btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button id="specCreateConfirm" type="button" class="btn-sm btn-primary">確認新增</button>
                  </div>
                </div>   <!-- end modal-content -->
              </div>
            </div>
              <!-- Modal 編輯規格 -->
            <div class="modal fade" id="producrSpecEdit" tabindex="-1" role="dialog" aria-labelledby="specNew" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="specEdit">修改商品規格</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                      <label for="specInfoEdit" class="col-2 col-form-label">規格</label>
                      <div class="col-10">
                          <input class="form-control" type="text" id="specInfoEdit" name="product_spec_info" placeholder="輸入產品規格">
                      </div>
                    </div>                  
                  </div>  <!-- end modal-body -->
                  <div class="modal-footer">
                    <button type="button" class="btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button id="specEditConfirm" type="button" class="btn-sm btn-primary">確認新增</button>
                  </div>
                </div>   <!-- end modal-content -->
              </div>
            </div>



        <!-- ========modal========== -->

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

  <script type="text/javascript">
    $(document).ready(function(){
        // var content = '<?php //echo $pro["product_content"]; ?>' ;
        var content='<?php //echo $jsonContent; ?>';
        if(content != "" ){
          $("div.note-editable").html(content);  
          $("div.note-placeholder").css("display","none");
        }else{
          // console.log("跑錯邊");
        }
        
        // JSON.parse(res)
        // console.log(content);

        //行事曆
        $( "#collection-from" ).datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1,
          onClose: function( selectedDate ) {
            $( "#collection-to" ).datepicker( "option", "minDate", selectedDate );
          }
        });
        $( "#collection-to" ).datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1,
          onClose: function( selectedDate ) {
            $( "#collection-from" ).datepicker( "option", "maxDate", selectedDate );
          }
        });
    });
     
  </script>

<?php require_once("module/footer.php"); ?>