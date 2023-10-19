<?php
require './parts/connect_db.php';
$pageName = 'course_list';
$title = '課程管理列表';


$sql = "SELECT 
c.course_id, 
c.course_name, 
c.course_description, 
m.member_name, 
c.creation_date, 
c.is_published, 
ct.day_of_week, 
ct.time_period, 
cat.category
FROM course c
INNER JOIN course_time ct ON c.course_id = ct.course_id
INNER JOIN course_category_relation ccr ON c.course_id = ccr.course_id
INNER JOIN category cat ON ccr.category_id = cat.category_id
INNER JOIN coach co ON c.coach_id = co.coach_id
INNER JOIN member m ON co.member_id = m.member_id
GROUP BY c.course_id
ORDER BY c.course_id DESC"
;
$rows = $pdo->query($sql)->fetchAll();

$sql_t = "SELECT 
ct.time_period, 
ct.day_of_week,
ct.course_id
FROM course_time ct
ORDER BY ct.course_id";
$rows_t = $pdo->query($sql_t)->fetchAll();

$sql_cat = "SELECT cat.category, ccr.course_id 
FROM category cat 
INNER JOIN course_category_relation ccr ON cat.category_id = ccr.category_id
ORDER BY ccr.course_id";

$rows_cat = $pdo->query($sql_cat)->fetchAll();
?>

<?php include './parts/html-head.php' ?>
<?php include './parts/sidebar.php' ?>
<?php include './parts/topbar.php' ?>

<style>
  .tbwidth {
    width: 150px;
  }
</style>
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
            <th scope="col">課程名稱</th>
            <th scope="col">課程描述</th>
            <th scope="col">教練姓名</th>
            <th scope="col">日期</th>
            <th scope="col">上架狀態</th>
            <th scope="col">星期</th>
            <th scope="col">時間</th>
            <th scope="col">分類</th>
            <th scope="col">
              <i class="fa-solid fa-file-pen"></i>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
            <td><a href="javascript: deleteItem(<?= $r['course_id'] ?>)">
                  <i class="fa-solid fa-trash-can"></i>
                </a></td>
              <td>
                <?= $r['course_id'] ?>
              </td>
              <td>
                <?= $r['course_name'] ?>
              </td>
              <td>
                <?= $r['course_description'] ?>
              </td>
              <td>
                <?= $r['member_name'] ?>
              </td>
              <td>
                <?= $r['creation_date'] ?>
              </td>
              <td>
                <?= $r['is_published'] ?>
              </td>
              <td style="width:100px">
                <?php
                foreach ($rows_t as $r_t) {
                  if ($r_t['course_id'] == $r['course_id']) {
                    echo $r_t['day_of_week'];
                    echo '<br>';
                  }
                }
                ?>
              </td>
              <td>
                <?php
                foreach ($rows_t as $r_t) {
                  if ($r_t['course_id'] == $r['course_id']) {
                    echo $r_t['time_period'];
                    echo '<br>';
                  }
                }
                ?>
              </td>
              <td>
                <?php
                foreach ($rows_cat as $r_cat) {
                  if ($r_cat['course_id'] == $r['course_id']) {
                    echo $r_cat['category'];
                    echo '<br>';
                  }
                }
                ?>
              </td>
              <td><a href="edit.php?course_id=<?= $r['course_id'] ?>">
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
  function deleteItem(course_id) {
    if (confirm(`確定要刪除編號為 ${course_id} 的資料嗎?`)) {
      location.href = 'delete.php?course_id=' + course_id;
    }
  }
</script>
<?php include './parts/html-foot.php' ?>