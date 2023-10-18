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

          <form name="form1" action="course_add-api.php" method="post">
            <div class="mb-3">
              <label for="name" class="form-label">課程名稱</label>
              <input type="text" class="form-control" id="name" name="name">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">分類</label>
              <input type="text" class="form-control" id="email" name="email">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="mobile" class="form-label">星期</label>
              <input type="text" class="form-control" id="mobile" name="mobile">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="birthday" class="form-label">上課時間</label>
              <input type="time" class="form-control" id="birthday" name="birthday">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">課程描述</label>
              <textarea class="form-control" name="address" id="address" cols="30" rows="3"></textarea>
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">上架狀態</label>
              <textarea class="form-control" name="address" id="address" cols="30" rows="3"></textarea>
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


<?php include './parts/html-foot.php' ?>