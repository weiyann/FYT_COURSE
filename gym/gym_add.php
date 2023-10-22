<?php
require './parts/connect_db.php';

$sql_d = 'SELECT * FROM district';
$option_d = $pdo->query($sql_d)->fetchAll();
?>
<?php include './parts/html-head.php' ?>
<?php include './parts/sidebar.php' ?>
<?php include './parts/topbar.php' ?>
<div class="container">
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">新增健身房資料</h5>
          <form action="course_add-api.php" method="post" name="form1">
            <div class="mb-3">
              <label for="gym_name" class="form-label">健身房名稱</label>
              <input type="text" class="form-control" id="gym_name" name="gym_name">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="gym_description" class="form-label">介紹</label>
              <textarea class="form-control" name="gym_description" id="gym_description" cols="30" rows="5"></textarea>
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="business_time" class="form-label">營業時間</label>
              <input type="text" class="form-control" id="business_time" name="business_time">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
            <div>地址</div>
              <div class="input-group mb-3">               
                <label for="district_name"></label>
                <select class="form-select form-control" id="district_name" name="district_name" style="width:140px">
                  <option>--請選擇縣市--</option>
                  <?php foreach ($option_d as $o): ?>
                    <option value="<?= $o['district_id'] ?>">
                      <?= $o['district_name'] ?>
                    </option>
                  <?php endforeach ?>
                </select>
                <span class="input-group-text">縣/市</span>
                <label for="gym_address" class="form-label"></label>
                <input type="text" class="form-control w-75" id="gym_address" name="gym_address">
                <div class="form-text"></div>
              </div>
              <!--
              <div class="form-floating">
                <label for="district_name">地址</label>
                <select class="form-select form-control" id="district_name" name="district_name">
                  <option>--請選擇縣市--</option>
                  <?php foreach ($option_d as $o): ?>
                    <option value="<?= $o['district_id'] ?>">
                      <?= $o['district_name'] ?>
                    </option>
                  <?php endforeach ?>
                </select>
                <div class="form-text"></div><span>縣/市</span>
              </div>
              <label for="gym_address" class="form-label"></label>
              <input type="text" class="form-control" id="gym_address" name="gym_address">
              <div class="form-text"></div>
            </div>
                  -->
            <button type="submit" class="btn btn-primary">送出</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- End of Main Content -->

<!-- Footer -->
<!--
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; Your Website 2020</span>
    </div>
  </div>
</footer>
-->
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php include './parts/scripts.php' ?>


<?php include './parts/html-foot.php' ?>