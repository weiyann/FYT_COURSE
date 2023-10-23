<div class="mb-3" >
              <label for="BlogArticle_photo" class="form-label" >請上傳文章首圖</label><br>
              <input id="BlogArticle_photo" name="BlogArticle_photo" style="width: 200px;" hidden >
              <div class="form-text"></div>

              <span style="cursor: pointer;"  onclick="triggerUpload('BlogArticle_photo')">
                <i class="fa-solid fa-circle-plus" style="color: #580dc9;"></i>
              </span>
              <div style="width: 300px">
                <img src="" alt="" id="BlogArticle_photo_img" width="100%" />
              </div>
<!-- 
              <input id="pic2" name="pic2" style="width: 600px;" >
              <div style="cursor: pointer;" onclick="triggerUpload('pic2')">點選上傳第2張圖</div>
              <div style="width: 300px">
                <img src="" alt="" id="pic2_img" width="100%" />
              </div>


              <input id="pic3" name="pic3" style="width: 600px;" >
              <div style="cursor: pointer;" onclick="triggerUpload('pic3')">點選上傳第3張圖</div>
              <div style="width: 300px">
                <img src="" alt="" id="pic3_img" width="100%" />
              </div> -->
            </div>
<form name="formuploadphoto" hidden>
  <input type="file" name="avatar" onchange="uploadFile()" />
</form>


<script>
  let uploadFieldId; // 欄位 Id

  function triggerUpload(fid) {
    uploadFieldId = fid;
    document.formuploadphoto.avatar.click();
  }

  function uploadFile() {
    const fd = new FormData(document.formuploadphoto);

    fetch("upload-img-api圖片上傳_存資料夾.php", {
        method: "POST",
        body: fd, // enctype="multipart/form-data"
      })
      .then((r) => r.json())
      .then((data) => {
        if (data.success) {
          if (uploadFieldId) {
            document.form1[uploadFieldId].value = data.file
            document.querySelector(#${uploadFieldId}_img).src = "/mf43/期中BS/FreeFyt-01/uploads/" + data.file;
          }



        }
        uploadFieldId = null;
      });
  }
</script>
﻿
Leo李歐
leo999777