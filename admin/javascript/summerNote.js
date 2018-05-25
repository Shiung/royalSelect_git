$(document).ready(function() {
        // 商品
        var summernote = $('#summernote').summernote({
          placeholder: '商品內容/圖片/影片',
          // popover: {
          //    image: [
          //       ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
          //       ['float', ['floatLeft', 'floatRight', 'floatNone']],
          //       ['remove', ['removeMedia']]
          //    ],
          //    link: [],
          //    air: []
          //  },
          tabsize: 3,
          height: 300,
          callbacks: {
              onImageUpload: function(files){
                for(var i=files.length-1 ;i >= 0 ; i--){
                  sendFile(files[i],summernote);
                }
              },
              onMediaDelete : function(target) {
                // alert(target[0].src) ;
                deleteFile(target[0].src);
              }
          }
        });
        

        function sendFile(file,editor,welEditable){
          var modelId = $("input[name='model_id']").val();
          var productNo = $("input[name='product_no']").val();
          var status = "product";
          // console.log(productNo);
          var formData = new FormData();
          formData.append("file",file);
          formData.append("model_id",modelId); 
          formData.append("product_no",productNo);  
          formData.append("status",status);         
          $.ajax({
            url:  "framwork/summerNoteImageUpload.php",
            data : formData,
            type : "POST",
            cache : false,
            contentType : false,
            processData: false,
            success: function(result) {
                summernote.summernote('insertImage',result,function(image){
                  image.attr('src',result);
                });
                console.log(result);
            },
            error : function(error){
                alert("圖片上傳失敗");
                // console.log(error);
            },
            complete : function(result){}

          });
        }

        // 文章
        var summernoteArticle = $('#summernoteArticle').summernote({
          placeholder: '文章內容/圖片/影片',
          // popover: {
          //    image: [
          //       ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
          //       ['float', ['floatLeft', 'floatRight', 'floatNone']],
          //       ['remove', ['removeMedia']]
          //    ],
          //    link: [],
          //    air: []
          //  },
          tabsize: 3,
          height: 300,
          callbacks: {
              onImageUpload: function(files){
                for(var i=files.length-1 ;i >= 0 ; i--){
                  sendFileArticle(files[i],summernoteArticle);
                }
              },
              onMediaDelete : function(target) {
                // alert(target[0].src) ;
                deleteFile(target[0].src);
              }
          }
          });
        

        function sendFileArticle(file,editor,welEditable){
          var status = "article";
          // console.log(productNo);
          var formData = new FormData();
          formData.append("file",file);
          formData.append("status",status);           
          $.ajax({
            url:  "framwork/summerNoteImageUpload.php",
            data : formData,
            type : "POST",
            cache : false,
            contentType : false,
            processData: false,
            success: function(result) {
                summernoteArticle.summernote('insertImage',result,function(image){
                  image.attr('src',result);
                });
                // console.log(result);
            },
            error : function(error){
                alert("圖片上傳失敗");
                // console.log(error);
            },
            complete : function(result){}

          });
        }


        //文章 and product 共用
        function deleteFile(src){
          var status = "summernote";
            $.ajax({
                data: {status , status,src : src},
                type: "POST",
                url: "framwork/imgDelete.php", 
                cache: false,
                success: function(resp) {
                  console.log(resp);
                    if(resp){ //true
                      //儲存DB 內容
                    }else{ //false

                    }
                }
            });
        }


    });