<?php
require './parts/connect_db.php';
$pageName = 'course_add';
$title = '課程新增';
?>

<?php include './parts/html-head.php' ?>
<?php include './parts/sidebar.php' ?>
<?php include './parts/topbar.php' ?>


<!-- Begin Page Content -->
<div class="container-fluid">


</div>
<!-- /.container-fluid -->
<div class="row">
  <div class="col">
    <div class="card">

      <div class="card-body">
        <h5 class="card-title">新增資料</h5>

        <form name="form1" onsubmit="sendData(event)">
          <div class="mb-3">
            <label for="course_name" class="form-label">課程名稱</label>
            <input type="text" class="form-control" id="course_name" name="course_name">
            <div class="form-text"></div>
          </div>
          <div class="mb-3">
            <label for="category" class="form-label">分類</label>
            <input type="text" class="form-control" id="category" name="category">
            <div class="form-text"></div>
          </div>
          <div class="mb-3">
            <label for="day_of_week" class="form-label">星期</label>
            <input type="text" class="form-control" id="day_of_week" name="day_of_week">
            <div class="form-text"></div>
          </div>
          <div class="mb-3">
            <label for="time_period" class="form-label">上課時間</label>
            <input type="time" class="form-control" id="time_period" name="time_period">
            <div class="form-text"></div>
          </div>
          <div class="mb-3">
            <label for="course_description" class="form-label">課程描述</label>
            <textarea class="form-control" name="course_description" id="course_description" cols="30"
              rows="3"></textarea>
            <div class="form-text"></div>
          </div>
          <div class="mb-3">
            <label for="is_published" class="form-label">上架狀態</label>
            <input type="text" class="form-control" id="is_published" name="is_published">
            <div class="form-text"></div>
          </div>
          <div class="mb-3">
            <label for="course_id" class="form-label">course_id</label>
            <textarea class="form-control" name="course_id" id="course_id" cols="30"
              rows="3"></textarea>
            <div class="form-text"></div>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; Your Website 2020</span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php include './parts/scripts.php' ?>

<script>
  function sendData(e) {
    e.preventDefault(); // 不要讓表單以傳統的方式送出
    // TODO: 資料在送出之前, 要檢查格式
    // 建立只有資料的表單
    const fd = new FormData(document.form1);
    fetch('course_add-api.php', {
      method: 'POST',
      body: fd, // 送出的格式會自動是 multipart/form-data
    }).then(r => r.json())
      .then(data => {
        console.log({
          data
        });
      })
      .catch(ex => console.log(ex))
  }
</script>
<?php include './parts/html-foot.php' ?>