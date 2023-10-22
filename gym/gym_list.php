<?php
require './parts/connect_db.php';
$pageName = 'gym_list';
$title = '健身房管理列表';

$sql = 'SELECT * FROM gym JOIN district on gym.district_id = district.district_id
 ORDER BY gym_id desc';
$rows=$pdo ->query($sql)->fetchAll();


?>

<?php include './parts/html-head.php' ?>
<?php include './parts/sidebar.php' ?>
<?php include './parts/topbar.php' ?>


<!-- Begin Page Content -->
<div class="container-fluid">

<div class="row">
    <div class="col">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th scope="col">
              <i class="fa-solid fa-trash-can"></i>
            </th>
            <th scope="col">#</th>
            <th scope="col">健身房名稱</th>
            <th scope="col">圖片</th>
            <th scope="col">介紹</th>
            <th scope="col">營業時間</th>
            <th scope="col">地址</th>
            <th scope="col">資料建立時間</th>
            <th scope="col">
              <i class="fa-solid fa-file-pen"></i>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td><a href="javascript: deleteItem(<?= $r['gym_id'] ?>)">
                  <i class="fa-solid fa-trash-can"></i>
                </a></td>
              <td>
                <?= $r['gym_id'] ?>
              </td>
              <td>
                <?= $r['gym_name'] ?>
              </td>
              <td>
                <?= $r['gym_photo'] ?>
              </td>
              <td>
                <?= $r['gym_description'] ?>
              </td>
              <td>
                <?= $r['business_time'] ?>
              </td>
              <td>
                <?= $r['district_name'] .$r['gym_address'] ?>
              </td>
              <td>
                <?= $r['created_at'] ?>
              </td>
              <td><a href="edit.php?gym_id=<?= $r['gym_id'] ?>">
                  <i class="fa-solid fa-file-pen"></i>
                </a></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
<!-- /.container-fluid -->



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