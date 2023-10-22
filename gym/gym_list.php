<?php
require './parts/connect_db.php';
$pageName = 'gym_list';
$title = '健身房管理列表';

$perPage = 10;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1'); #頁面轉向
  exit; # 直接結束這支 php
}

$t_sql = "SELECT COUNT(1) FROM gym";
# 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

# 預設值
$totalPages = 0;
$rows = [];

// 有資料時
if ($totalRows > 0) {
  # 總頁數
  $totalPages = ceil($totalRows / $perPage); # 無條件進位，不足20筆也算一頁
  if ($page > $totalPages) {
    header('Location: ?page=' . $totalPages); #頁面轉向最後一頁
    exit;
  }
}
$sql = sprintf('SELECT * FROM gym JOIN district on gym.district_id = district.district_id
 ORDER BY gym_id desc
 limit %s,%s',
 ($page - 1) * $perPage,
$perPage);
$rows = $pdo->query($sql)->fetchAll();
?>

<?php include './parts/html-head.php' ?>
<?php include './parts/sidebar.php' ?>
<?php include './parts/topbar.php' ?>


<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=1">
              <i class="fa-solid fa-angles-left"></i>
            </a>
          </li>
          <?php for ($i = $page - 3; $i <= $page + 3; $i++):
            if ($i >= 1 and $i <= $totalPages): ?>
              <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>">
                  <?= $i ?>
                </a>
              </li>
              <?php
            endif;
          endfor; ?>
          <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $totalPages ?>">
              <i class="fa-solid fa-angles-right"></i></a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
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
                <?= $r['district_name'] . $r['gym_address'] ?>
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

<script>
  function deleteItem(gym_id) {
    if (confirm(`確定要刪除編號為 ${gym_id} 的資料嗎?`)) {
      location.href = 'delete.php?gym_id=' + gym_id;
    }
  }
</script>
<?php include './parts/html-foot.php' ?>